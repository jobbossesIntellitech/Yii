<?php
// Dashboard
$this->mainMenu(Jii::t('Dashboard'),$this->image('dashboard'),
	array(
		array('url'=>'dashboard/index','title'=>Jii::t('Dashboard')),
		array('url'=>'log/index','title'=>Jii::t('Logs')),	
	)
);
// contents - CMS
$this->mainMenu(Jii::t('CMS'),$this->image('cms'),
	array(
		array('url'=>'category/index','title'=>Jii::t('Categories')),
		array('url'=>'content/index' ,'title'=>Jii::t('Contents')),
		array('url'=>'comment/index' ,'title'=>Jii::t('Comments')),	
		array('url'=>'form/index' ,'title'=>Jii::t('Forms')),
		array('url'=>'menu/index','title'=>Jii::t('Menu')),	
	)
);
// settings
$this->mainMenu(Jii::t('Settings'),$this->image('settings'),
	array(
		array('url'=>'profile/index','title'=>Jii::t('Profile')),
		array('url'=>'user/index','title'=>Jii::t('Users')),
		array('url'=>'language/index','title'=>Jii::t('Languages')),
		array('url'=>'translation/index','title'=>Jii::t('Translations')),
		array('url'=>'controllertable/index','title'=>Jii::t('Controllers')),
		array('url'=>'setting/index','title'=>Jii::t('Settings')),	
		array('url'=>'backup/index','title'=>Jii::t('Backup DB')),	
	)
);

// sochivi
$this->mainMenu(Jii::t('Sochivi'),$this->image('sochivi'),
	array(
		array('url'=>'location/index','title'=>Jii::t('Locations')),
		array('url'=>'currency/index','title'=>Jii::t('Currencies')),
		array('url'=>'item/index','title'=>Jii::t('Items')),
		array('url'=>'ads/index','title'=>Jii::t('Ads')),
		array('url'=>'member/index','title'=>Jii::t('Members')),
		array('url'=>'searchformbuilder/index','title'=>Jii::t('Search Forms')),	
	)
);



$this->create();
?>