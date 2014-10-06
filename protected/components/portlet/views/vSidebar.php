<?php
$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';

$category = isset($_GET['category'])?$_GET['category']:'';
$criteria = new CDbCriteria;
$criteria->addCondition('itm_parentid = 0');
$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getvalue());
$cat = Item::model()->findAll($criteria);
$categories = CHtml::ListData($cat,'itm_id','itm_name');

$subcategory = isset($_GET['subcategory'])?$_GET['subcategory']:'';

$country = isset($_GET['country'])?$_GET['country']:'';
$criteria = new CDbCriteria;
$criteria->addCondition('loc_parentid = 0');
$criteria->addCondition('loc_status = '.Item::status()->getItem('enable')->getvalue());
$loc = Location::model()->findAll($criteria);
$countries = CHtml::ListData($loc,'loc_id','loc_name');

$city = isset($_GET['city'])?$_GET['city']:'';
?>
<div id="logo">
	<a href="<?php echo Jii::app()->getHomeUrl(); ?>"></a>
</div>
<div id="search-panel">
	<?php $this->widget('wSearchForm'); ?>
	<?php /* ?>
	<div class="find titillium"><?php echo Jii::t('Find a:');?></div>
	<?php echo CHtml::beginForm(Yii::app()->createUrl("item/search",array('type'=>'search')),'get',array('name'=>'searchForm')); ?>
	
	<div class="sp-field search-lot sep">
    	<div class="left input">
        	<?php echo UI::textField('keywords',$keywords,"170px"); ?>
            <span class="ex">eg. BMW, Appartment, Closet...</span>
        </div>
        <div class="clr"></div>
    </div>
		
	<div class="sp-field">
        <div class="input">
        	<?php echo UI::selectBox('category',$category,$categories,'All Category','170px'); ?>	
        </div>
    </div>
	
	<div class="sp-field sep" style="z-index:99;">
		<div class="input" id="subcat">
			<?php echo UI::selectBox('subcategory',$subcategory,array(),'Select Sub Category','170px'); ?>	
		</div>
	</div>
	
	<div class="sp-field">
        <div class="input">
        	<?php echo UI::selectBox('country',$country,$countries,'','170px'); ?>	
        </div>
    </div>
	
	<div class="sp-field sep">
        <div class="input" id="city">
        	<?php echo UI::selectBox('city',$city,array(),'Select City','170px'); ?>	
        </div>
    </div>
	
	<div class="submit">
    	<?php echo CHtml::link(Jii::t("Search Ads"),Jii::app()->createUrl("javascript://"),array('onclick'=>'document.searchForm.submit(); return false;')); ?>
    </div>
	
	 <?php echo CHtml::endForm();?>
	<div class="clear"></div>
	<?php */ ?>
</div>


<div class="left-ads"><?php //echo Jii::t('Ads 120x240 pixels');?>
<?php
/*if(isset($sidebar) && !empty($sidebar)){
	$image = json_decode($sidebar->con_gallery);
    $img = new ImageProcessor(Jii::app()->basePath.'/..'.$image[0]);
	$img->setIdentity('sidebar');
	$img->resizeInto(180,350,255,255,255);
	echo '<img src="'.$img->output(IMAGETYPE_PNG).'"/>';
}*/
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad dtd Feb18 leftside -->
<ins class="adsbygoogle"
     style="display:inline-block;width:120px;height:240px"
     data-ad-client="ca-pub-9290286960209263"
     data-ad-slot="7487526033"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function(e) {
    $('#selectbox_3 .list li a').each(function(i, e) {
        $(e).click(function(){
			var loadUrl = "<?php echo Yii::app()->createURL("item/searchsubcat")?>?id="+$(e).parent().val()+'&v=<?php echo Jii::param('subcategory');?>';
			$.ajax(loadUrl).done(function(data){
				$('#subcat').html(data);
				$('#subcat #subcategory').val('');
			});
		});
    });
	$('#selectbox_3 .list li.selected a').trigger('click');
	
	$('#selectbox_5 .list li a').each(function(i, e) {
        $(e).click(function(){
			var loadUrl = "<?php echo Yii::app()->createURL("item/searchcities")?>?id="+$(e).parent().val()+'&v=<?php echo Jii::param('city');?>';
			$.ajax(loadUrl).done(function(data){
				$('#city').html(data);
				$('#city').val('');
			});
		});
    });
	$('#selectbox_5 .list li.selected a').trigger('click');
});

</script>
<script type="text/javascript">
	var search_hold = '<?php echo Jii::t('Type to Search...'); ?>';
	var search_input = null;
	$(document).ready(function(){
		search_input = $('#search-panel .search-lot');
		search_action();
		search_input.focus(function(){
			search_action();	
		});	
		search_input.blur(function(){
			search_action();	
		});
	});

	function search_action(){
	if(search_input.val() == ""){
		search_input.val(search_hold);	
		search_input.css('color','#bbb');
	}else
	if(search_input.val() == search_hold){
		search_input.val("");
		search_input.css('color','#000');	
	}else{
		search_input.css('color','#000');	
	}		
	}
</script>