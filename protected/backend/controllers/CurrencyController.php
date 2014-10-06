<?php
class CurrencyController extends SController{
	
	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView;
			echo $criteria->execute($this,'Currency',array('uws'=>Jii::param('uws')),'list');
		}else{
			$this->pageTitle = Jii::t('Currencies');
			$this->render('index');
		}
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add New Currency');
		$model = new CurrencyForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = new Currency;
				$c->cur_name = $model->name;
				$c->cur_sign = $model->sign;
				$c->cur_locations =  implode(',',$model->locations);
				$res = $c->save();
				Log::trace('Save new currency record');
				if($res){
					Log::success('The currency has been added successfully');	
				}else{
					Log::success('The currency hasnt been added');	
				}
				$this->redirect(array('currency/index','uws'=>Jii::param('uws')));	
			}else{
				Log::warning('Currency form inputs error');
				$this->render('add',array('model'=>$model));		
			}
		}else{
			Log::trace('Access currency form');
			$this->render('add',array('model'=>$model));	
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit Currency');
		$model = new CurrencyForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = Currency::model()->findByPk($model->id);
				$c->cur_name = $model->name;
				$c->cur_sign = $model->sign;
				$c->cur_locations = implode(',',$model->locations);
				$res = $c->save();
				Log::trace('Save currency record');
				if($res){
					Log::success('The currency has been edited successfully');	
				}else{
					Log::success('The currency hasnt been edited');	
				}
				$this->redirect(array('currency/index','uws'=>Jii::param('uws')));	
			}else{
				Log::warning('Currency form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				$c = Currency::model()->findByPk(Jii::param('id'));
				$model->id = $c->cur_id;
				$model->name = $c->cur_name;
				$model->sign = $c->cur_sign;
				$model->locations = explode(',',$c->cur_locations);
				Log::trace('Access currency form');
				$this->render('edit',array('model'=>$model));	
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('currency/index','uws'=>Jii::param('uws')));	
			}
		}
	}
	
	public function actionDelete(){
		Log::trace('Access delete currency');
		$this->pageTitle = Jii::t('Delete Currency');
		$c = Currency::model()->findByPk(Jii::param('id'));
		if(isset($c->cur_id)){
			$res = $c->delete();
			if($res){
				Log::success('The currency has been deleted successfully');	
			}else{
				Log::error('The currency hasnt been deleted');	
			}	
		}else{
			Log::warning('Currency not found');	
		}
		$this->redirect(array('currency/index','uws'=>Jii::param('uws')));	
	}
	
}
?>