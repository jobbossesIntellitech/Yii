<?php
class AdsForm extends CFormModel{
	public $id;
	public $locationid;
	public $itemid;
	public $reference;
	public $name;
	public $memberid;
	public $status;
	public $gallery;
	public $price;
	public $phone;
	public $currencyid;
	public $description;
	
	public function rules()
	{
		return array(
			array('itemid,reference', 'required'),
			array('id,locationid,itemid,reference,name,memberid,status,gallery,price,phone,currencyid,description', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'locationid'=>Jii::t('Location Id'),
			'itemid'=>Jii::t('Item Type'),
			'reference'=>Jii::t('Reference'),
			'name'=>Jii::t('Name'),
			'memberid'=>Jii::t('Member Id'),
			'status'=>Jii::t('Status'),
			'gallery'=>Jii::t('Gallery'),
			'price'=>Jii::t('Price'),
			'phone'=>Jii::t('Phone'),
			'currencyid'=>Jii::t('Currency Id'),
			'description'=>Jii::t('Descritpion'),
		);
	}
}