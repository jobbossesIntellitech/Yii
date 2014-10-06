<?php
class AdsController extends SController{
	public function init(){
		parent::init();
	}

	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView();
			echo $criteria->execute($this,'Ads',array(),'list');
		}else{
			$this->pageTitle = Jii::t('Ads');
			Log::trace('Access Ads');
			$this->render('index');
		}
	}

	public function actionPreview(){
		$this->pageTitle = Jii::t('Preview Ad');
		$model = new AdsForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			
			$c = Ads::model()->findByPk($model->id);
			$c->ads_status = $model->status;
			if($model->status == Ads::status()->getItem('enable')->getValue()){
				//Ads::model()->adsconfirmation($model->id);
			}
			$res = $c->save();
			Log::trace('Save ad record');
			if($res){
				Log::success('The ad has been edited successfully');	
			}else{
				Log::success('The ad hasnt been edited');	
			}
			$this->redirect(array('ads/index'));	
		}else{
			if(Jii::param('id')){
				Log::trace('Access item form');
				$ads = Ads::model()->findByPk(Jii::param('id'));
				$model->id = $ads->ads_id;
				$model->name = $ads->ads_name;
				$model->status = $ads->ads_status;
				$model->locationid = $ads->ads_locationid;
				$model->reference = $ads->ads_reference;
				$model->memberid = $ads->ads_memberid;
				$model->itemid = $ads->ads_itemid;
				$model->gallery = $ads->ads_gallery;
				
				$this->render('preview',array('model'=>$model,'ads'=>$ads));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('ads/index'));		
			}	
		}
	}
	
	public function actionFacebookposting(){
		
		//$app_id = '1417538588493224'; //codendot
		//$app_secret = '2516d648b6023f94acf2ccc1821b662e';//codendot
		
		$app_id = '324865007656035'; //sochivi
		$app_secret = '329533a5085ac2cf6dae3e59877beff3';//sochivi
		
		$config = array(
					'appId'      => $app_id,
					'secret'     => $app_secret,
					'cookie'     => true,
					'fileUpload' => false,
				);
		$facebook = new Facebook($config);
		// define your POST parameters (replace with your own values)
		if(Jii::param('id')){
			$c = Ads::model()->findByPk(Jii::param('id'));
			
			//$gallery = json_decode($c->con_gallery);
			$gallery = explode(',',$c->ads_gallery);
			if(!empty($gallery[0]) && isset($gallery[0])){
				$img = Jii::app()->getBaseUrl(true).'/assets/uploads/ads/'.$c->ads_id.'/'.$gallery[0];
			}else{
				$img = Jii::app()->getBaseUrl(true).'/assets/notfound.jpg';
				//$img = '';
			}
			//$img = Jii::app()->getBaseUrl(true).'/assets/notfound.jpg';
			//http://f-news.net/beta/assets/finder/images/0_1392285797.jpg;
			$excerpt = '';
			$link = '';
			$title = '';
			$text = '';
			if(!empty($c->ads_description)) $excerpt = strip_tags($c->ads_description);
			$link = Jii::app()->createAbsoluteUrl('item/preview',array('adsid'=>$c->ads_id,'itemid'=>$c->ads_itemid));
			$link = str_replace('/admin.php','',$link);
			if(!empty($c->ads_name)) $title = $c->ads_name;
			if(!empty($c->ads_description)) $text = strip_tags($c->ads_description);
			
			
			$ACCESS_TOKEN ="CAAEndodhnGMBAGQJYaSMZCyktzaL4dRIheNzy8X7ERRU9FWCTWeCxeOsUIjKWGu8qwNKPR5qCU5hAA0dJTHZB8hMjSDZBzGTSIof8Av6oWM6C5ZB8SmONpbEAUN9Y9gJlA1MDKBwEDZCoU2T1q5a0pZCwFupifUI9qW4xdTqKtuhrZC6fplWWZAUjyZAbjezwVQcZD";//fnews
			
			// post to Facebook
			// see: https://developers.facebook.com/docs/reference/php/facebook-api/
			$PAGE_ID = '587603057993935';
			////////$PAGE_ID = '506481876128645';
			$post = array('access_token' => $ACCESS_TOKEN);
			try {
			  $res = $facebook->api('/me/accounts','GET',$post);

			   if (isset($res['data'])) {
				  foreach ($res['data'] as $account) {
					 if ($PAGE_ID == $account['id']) {
						$PAGE_TOKEN = $account['access_token'];
						break;
					 }
				  }
			   }
			} catch (Exception $e){
			   echo $e->getMessage();
			}
			//echo $PAGE_TOKEN.'<br>';
			
			$params = array(
			  "access_token" => $PAGE_TOKEN, //see: https://developers.facebook.com/docs/facebook-login/access-tokens/
			  "message" => $excerpt,
			  "link" => $link,
			  "picture" => $img,
			  "name" => $title,
			  "caption" => "www.sochivi.com",
			  "description" => $text,
			  'published' => true
			);
			try {
			  //$ret = $facebook->api('/YOUR_FACEBOOK_ID/feed', 'POST', $params);
			  ////////////$ret = $facebook->api('/506481876128645/feed', 'POST', $params);//codendot
			  $ret = $facebook->api('/587603057993935/feed', 'POST', $params);//f-news personal
			  //$ret = $facebook->api('/587328207981898/feed', 'POST', $params);//f-news page
			  
			  echo 'Successfully posted to Facebook';
			} catch(Exception $e) {
			  echo $e->getMessage();
			}
		}
		$this->redirect(array('ads/index'));
	}
	
	public function actionDelete(){
		Log::trace('Access delete ads');
		$this->pageTitle = Jii::t('Delete Ads');
		$c = Ads::model()->findByPk(Jii::param('id'));
		if(isset($c->ads_id)){
			$res = $c->delete();
			if($res){
				Log::success('The ads has been deleted successfully');	
			}else{
				Log::error('The ads hasnt been deleted');	
			}	
		}else{
			Log::warning('Ads not found');	
		}
		$this->redirect(array('ads/index'));	
	}

	public function actionStatus(){
		Log::trace('Access change status of ads');
		$this->pageTitle = Jii::t('Change status of ads');
		$c = Ads::model()->findByPk(Jii::param('id'));
		if(isset($c->ads_id)){
			$c->ads_status = Jii::param('status');
			if(Jii::param('status') == Ads::status()->getItem('enable')->getValue()){
				//Ads::model()->adsconfirmation($c->ads_id);
			}
			$res = $c->save();
			if($res){
				Log::success('The ads has been changed status successfully');	
			}else{
				Log::error('The ads hasnt been changed status');	
			}	
		}else{
			Log::warning('Ads not found');	
		}
		$this->redirect(array('ads/index'));	
	}
	
}
?>