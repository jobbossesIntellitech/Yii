<?php
class BackupController extends SController{
	public $menu = array();
	public $tables = array();
	public $fp ;
	public $file_name;
	public $_path = NULL;
	public $back_temp_file = 'db_backup_';
	public $content = '';
	
	public function init(){
		parent::init();	
	}
	
	public function actionIndex()
	{
		if(Jii::isAjax()){
			Log::trace('Access backup db list');
			$path = $this->path;
			$list = glob($path .'*.sql');
			$list = array_map('basename',$list);
			sort($list);
	
			$dataArray = array();
			foreach ( $list as $id=>$filename )
			{
				$columns = array();
				$columns['id'] = $id;
				$columns['name'] = basename ( $filename);
				$columns['size'] = Jii::file_size(filesize( $path. $filename));
				$columns['create_time'] = date( DATE_RFC822, filectime($path .$filename) );
				$dataArray[] = $columns;
			}
			$dataProvider = new CArrayDataProvider($dataArray);
			$pages = $dataProvider->getPagination();
			if(isset($_REQUEST['page']) && $_REQUEST['page'] > 0){
				$pages -> setCurrentPage($_REQUEST['page']-1);
			}
			$pages -> pageSize = $_POST['pageSize'];
			$list = $dataProvider->rawData;
			echo $this->renderPartial('data',array('list'=>$list,'pages'=>$pages, 'headers'=>$_POST['headers']),false,true);
		}else{
			Log::trace('Access backup db');
			$this->pageTitle = Jii::t("Backup Database");
			$this->render('index');
		}
		
		
	}
	
	public function actionCreate()
	{
		Log::trace('Access create db backup');
		$this->pageTitle = Jii::t('Manage Create Backup Db File');
		$tables = $this->getTables();

		if(!$this->StartBackup())
		{
			Log::warning("The backup cannot be started");
		}else{

			foreach($tables as $tableName)
			{
				$this->getColumns($tableName);
			}
			foreach($tables as $tableName)
			{
				$this->writeSeperator();
				$this->getData($tableName);
			}
			$this->EndBackup();
			
			Log::success("The backup db has been created successfully");
		}
		$this->redirect(array('backup/index'));
	}
	public function actionDelete($file = null)
	{
		$this->pageTitle = Jii::t('Manage Delete Backup Db File');
		if ( isset($file))
		{
			$sqlFile = $this->path . $file;
			if ( file_exists($sqlFile))
			unlink($sqlFile);
		}
		else throw new CHttpException(404, Jii::t('File not found'));
		Log::success("The backup db has been deleted successfully");
		$this->redirect(array('index'));
	}

	public function actionDownload($file = null)
	{
		$this->pageTitle = Jii::t('Manage Download Backup Db File');
		if ( isset($file))
		{
			$sqlFile = $this->path . $file;
			if ( file_exists($sqlFile))
			{
				Log::success("The backup db has been downloaded successfully");
				$request = Yii::app()->getRequest();
				$request->sendFile(basename($sqlFile),file_get_contents($sqlFile));
			}
		}
		throw new CHttpException(404, Yii::t('app', 'File not found'));
	}
	
	protected function getPath()
	{
		$this->_path = Yii::app()->basePath .'/../_backup/';
		
		if ( !file_exists($this->_path ))
		{
			mkdir($this->_path );
			chmod($this->_path, '777');
		}
		return $this->_path;
	}
	public function execSqlFile($sqlFile)
	{
		$message = "ok";

		if ( file_exists($sqlFile))
		{
			$sqlArray = explode($this->getSeperator(),file_get_contents($sqlFile));
			if(!empty($sqlArray)){
				foreach($sqlArray AS $sql){
					if(!empty($sql)){
						$cmd = Yii::app()->db->createCommand($sql);
						try	{
							$cmd->execute();
						}
						catch(CDbException $e)
						{
							$message = $e->getMessage();
						}
					}
				}	
			}

		}
		return $message;
	}
	public function getColumns($tableName)
	{
		$sql = 'SHOW CREATE TABLE '.$tableName;
		$cmd = Yii::app()->db->createCommand($sql);
		$table = $cmd->queryRow();

		$create_query = $table['Create Table'] . ';';

		$create_query  = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
		//$create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);
		if ( $this->fp)
		{
			$this->writeComment('TABLE '. addslashes ($tableName) );
			$final = 'DROP TABLE IF EXISTS ' .addslashes($tableName) . ';'.PHP_EOL. $create_query .PHP_EOL.PHP_EOL;
			$this->content.= $final ;
		}
		else
		{
			$this->tables[$tableName]['create'] = $create_query;
			return $create_query;
		}
	}

	public function getData($tableName)
	{
		$sql = 'SELECT * FROM '.$tableName;
		$cmd = Yii::app()->db->createCommand($sql);
		$dataReader = $cmd->query();

		$data_string = '';

		foreach($dataReader as $data)
		{
			$itemNames = array_keys($data);
			$itemNames = array_map("addslashes", $itemNames);
			$items = join('`,`', $itemNames);
			$itemValues = array_values($data);
			$itemValues = array_map("addslashes", $itemValues);
			$valueString = join("','", $itemValues);
			$valueString = "('" . $valueString . "'),";
			$values ="\n" . $valueString;
			if ($values != "")
			{
				$data_string .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . ";" . PHP_EOL;
			}
		}

		if ( $data_string == '')
		return null;
			
		if ( $this->fp)
		{
			$this->writeComment('TABLE DATA '.$tableName);
			$final = $data_string.PHP_EOL.PHP_EOL.PHP_EOL;
			$this->content.= $final ;
		}
		else
		{
			$this->tables[$tableName]['data'] = $data_string;
			return $data_string;
		}
	}
	public function getTables($dbName = null)
	{
		$sql = 'SHOW TABLES';
		$cmd = Yii::app()->db->createCommand($sql);
		$tables = $cmd->queryColumn();
		return $tables;
	}
	public function StartBackup($addcheck = true)
	{
		$this->file_name =  $this->path . $this->back_temp_file . date('Y.m.d_H.i.s') . '.sql';

		$this->fp = fopen( $this->file_name, 'w+');

		if ( $this->fp == null )
		return false;
		$this->content.= '-- -------------------------------------------'.PHP_EOL ;
		if ( $addcheck )
		{
			$this->content.=  'SET AUTOCOMMIT=0;' .PHP_EOL ;
			$this->content.=  'START TRANSACTION;' .PHP_EOL ;
			$this->content.=  'SET SQL_QUOTE_SHOW_CREATE = 1;'  .PHP_EOL ;
		}
		$this->content.= 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;'.PHP_EOL ;
		$this->content.= 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;'.PHP_EOL ;
		$this->content.= '-- -------------------------------------------'.PHP_EOL ;
		$this->writeComment('START BACKUP');
		return true;
	}
	public function EndBackup($addcheck = true)
	{
		$this->content.= '-- -------------------------------------------'.PHP_EOL ;
		$this->content.= 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;'.PHP_EOL ;
		$this->content.= 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;'.PHP_EOL ;

		if ( $addcheck )
		{
			$this->content.=  'COMMIT;' .PHP_EOL ;
		}
		$this->content.= '-- -------------------------------------------'.PHP_EOL ;
		$this->writeComment('END BACKUP');
		//$this->content = Card::encrypt($this->content);
		fwrite($this->fp,$this->content);
		fclose($this->fp);
		$this->fp = NULL;
	}
		
	public function writeComment($string)
	{
		$this->content.= '-- -------------------------------------------'.PHP_EOL ;
		$this->content.= '-- '.$string .PHP_EOL ;
		$this->content.= '-- -------------------------------------------'.PHP_EOL ;
	}
	
	public function writeSeperator(){
		$this->content .= '-- *JS* --'.PHP_EOL;	
	}
	
	public function getSeperator(){
		return '-- *JS* --'.PHP_EOL;	
	}		
}
?>