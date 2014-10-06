<?php
/*
 * EImageFinder widget
 * Based on CKFinder (http://ckfinder.com/)
 *
 * @usage $this->widget('ext.finder.EImageFinder',array('fieldName'=>'my_field'));
 *
 * @author: Cassiano Surek <cass@surek.co.uk>
 */

class EImageFinder extends CInputWidget
{


	public $name;
	public $model = false;
	public $attribute;
	public $dimension = '200x100';
	public $only = -1;
	public $data = array();
	public $type = 'jpg,png,gif';
	
	
	private $uploadPath;
	private $uploadUrl;
    protected $path;
	private $id;

    public function init()
    {
		$cs=Jii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/ui.js');
	
		// Please change the config below to suit your needs
		$this->uploadPath = Jii::app()->params['rootPath'].'/assets/finder/';
		$this->uploadUrl = Jii::app()->baseUrl.'/assets/finder/';

	   	// We need to make the CKFinder accessible, let's publish it to the assets folder
		$lo_am = new CAssetManager;
		$this->path = Yii::app()->getAssetManager()->publish(Yii::app()->basePath . '/extensions/finder/ckfinder2.1',true);

		// And save the upload path to use with ckfinder's config file. Passing as js param did not work...
		$lo_session=new CHttpSession;
	  	$lo_session->open();
	  	$lo_session['auth']=true;
	  	$lo_session['upload_path'] = $this->uploadPath;
	  	$lo_session['upload_url'] = $this->uploadUrl;

        parent::init();
    }

    public function run()
    {
        $this->id = 'finder-'.time().'-'.rand(100,500);
		if($this->only == -1 || $this->only == 0){ $this->only = 9999999; }
		$this->render("ckfinder", array(
                //'fieldName'=>$this->fieldName,
                'path'=>$this->path,
            ));
    }
}