<div id="menu-manager">
	<div class="options">
		<div class="section form">
			<h3 class="title"><?php echo Jii::t('Add new / Edit'); ?></h3>
			<input type="hidden" id="item_belongto" value="new" />
			<table>
				<tr>
					<th><label for="item_label"><?php echo Jii::t('Label'); ?></label></th>	
					<td><input type="text" id="item_label" name="item_label" /></td>	
				</tr>
				<tr>
					<th><label for="item_link"><?php echo Jii::t('Url'); ?></label></th>	
					<td><input type="text" id="item_link" name="item_link" /></td>	
				</tr>
				<?php
				$targets = MenuField::target()->getList();
				if(!empty($targets) && is_array($targets)){
				?>
				<tr>
					<th><label for="item_target"><?php echo Jii::t('Target'); ?></label></th>	
					<td>
						<select id="item_target" name="item_target" >
						<?php
						foreach($targets AS $k=>$v){
							?>
							<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
							<?php
						}
						?>	
						</select>
					</td>
				</tr>
				<?php
				}
				?>	
				<tr>
					<td colspan="2" class="submit">
						<input type="button" value="<?php echo Jii::t('Save'); ?>" id="save" />
					</td>
				</tr>
			</table>
		</div>
		<?php
		$list = JMenuOption::get();
		if(is_array($list) && !empty($list)){
			foreach($list AS $l){
				?>
				<div class="section menu-options">
					<h3 class="title">
						<strong><?php echo $l['title']; ?></strong>
						&nbsp;&nbsp;<a href="javascript://" class="add-all"><?php echo Jii::t('add all'); ?></a>
					</h3>
					<?php
					if(isset($l['list']) && is_array($l['list']) && !empty($l['list'])){
						?>
						<ul>
						<?php
						foreach($l['list'] AS $item){
							$item['link'] = str_replace('/admin.php','',$item['link']);
							?>
							<li>
								<a data-href="<?php echo $item['link']; ?>">
									<?php echo $item['label']; ?>
								</a>
							</li>
							<?php
						}
						?>
						</ul>
						<?php
					}
					?>
				</div>
				<?php
			}
		}
		?>
	</div>
	<div class="canvas">
		<div id="saveMenu">
			<form method="post" action="<?php echo Jii::app()->createUrl('menu/save',array('id'=>Jii::param('id'))); ?>" name="saveMenu">
				<div class="data"></div>
				<input type="button" value="<?php echo Jii::t('Save Menu'); ?>"/>
			</form>
		</div>
		<ul id="identifier_0">
		
		</ul>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.menu-options').each(function(i,e){
		$(e).find('ul li').each(function(j,li){
			$(li).find('a').click(function(){
				addMenuItem($.trim($(this).clone().children().remove().end().text()),$(this).attr('data-href'));
				return false;
			});
		});
		$(e).find('h3.title a.add-all').click(function(){
			$(e).find('ul li').each(function(j,li){
				$(li).find('a').trigger('click');	
			});
		});
	});
	$('#menu-manager .form .submit input[type=button]').click(function(){
		if($('#menu-manager .form #item_belongto').val() == 'new'){
			addMenuItem(
				$('#menu-manager .form #item_label').val(),
				$('#menu-manager .form #item_link').val(),
				$('#menu-manager .form #item_target').val()
			)
		}else{
			var id = $('#menu-manager .form #item_belongto').val();
			$('#item_'+id).attr('data-target',$('#menu-manager .form #item_target').val());
			$('#item_'+id).find('> h4 strong').text( $('#menu-manager .form #item_label').val() );
			$('#item_'+id).find('> span').text( $('#menu-manager .form #item_link').val() );
		}	
		$('#menu-manager .form #item_belongto').val('new');
		$('#menu-manager .form #item_target').val('0');
		$('#menu-manager .form #item_label').val('');
		$('#menu-manager .form #item_link').val('');
	});
	$('#menu-manager .canvas #saveMenu input[type=button]').click(function(){
		var root = $('.canvas > ul > li');
		$('#menu-manager .canvas #saveMenu .data').html('');
		generateMenuItemsAsHidden(root,0);
		document.saveMenu.submit();	
	});
	<?php
	if(isset($menu->field) && is_array($menu->field) && !empty($menu->field)){
		foreach($menu->field AS $item){
			?>
			addMenuItem(
				'<?php echo $item->fld_label; ?>',
				'<?php echo $item->fld_link; ?>',
				'<?php echo $item->fld_target; ?>',
				'<?php echo $item->fld_parentid; ?>',
				'<?php echo $item->fld_id; ?>'
			);
			<?php
		}
	}
	?>
});
function addMenuItem(label,url,target,parent,identifier){
	target = target || 0;
	parent = parent || 0;
	identifier = identifier || new Date().getTime();
	var id = new Date().getTime();
	var li = $('<li/>');
	li.append(''+
		'<div class="item" data-target="'+target+'" id="item_'+id+'">'+
			'<h4>'+
				'<strong>'+label+'</strong>'+
				'&nbsp;&nbsp;<a href="javascript://" id="edit_'+id+'"><?php echo Jii::t('Edit'); ?></a>'+
				'&nbsp;&nbsp;<a href="javascript://" id="delete_'+id+'"><?php echo Jii::t('Delete'); ?></a>'+
			'</h4>'+
			'<span>'+
				url+
			'</span>'+
		'</div>'+
		'<ul id="identifier_'+identifier+'"></ul>'+
	'');
	$('.canvas ul#identifier_'+parent).append(li);
	$('.canvas ul').nestedSortable({
		handle: '.item',
		items: 'li',
		toleranceElement: '> .item',
		listType : 'ul',
		rtl : <?php echo (Jii::app()->user->direction == 'rtl')?'true':'false'; ?>,
		maxLevels: <?php echo Setting::get('menu','maxlevel'); ?>,
		axis: 'y',
		forcePlaceholderSize: true,
		opacity: .5,
		isTree: true,
		revert: 250
	});
	$('#delete_'+id).click(function(){ $(this).parent().parent().parent().remove(); });
	$('#edit_'+id).click(function(){ 
		var form = $('#menu-manager .form');
		form.find('#item_label').val( $(this).parent().find('strong').text() );	
		form.find('#item_link').val( $(this).parent().parent().find('> span').text() );	
		form.find('#item_target').val( $(this).parent().parent().attr('data-target') );	
		form.find('#item_belongto').val( id );
	});
}
function generateMenuItemsAsHidden(list,parent){
	var data = $('#menu-manager .canvas #saveMenu .data');
	var label = '';
	var url = '';
	var target = '';
	var id = '';
	list.each(function(i,e){
		id = parent+'_'+i;
		label = $(e).find('> .item h4 strong').text();
		url = $(e).find('> .item span').text();
		target = $(e).find('> .item').attr('data-target');
		data.append('<input type="hidden" name="menu_item['+id+'][label]" value="'+label+'" />');
		data.append('<input type="hidden" name="menu_item['+id+'][url]" value="'+url+'" />');
		data.append('<input type="hidden" name="menu_item['+id+'][target]" value="'+target+'" />');
		data.append('<input type="hidden" name="menu_item['+id+'][parent]" value="'+parent+'" />');	
		data.append('<input type="hidden" name="menu_item['+id+'][position]" value="'+i+'" />');	
		if($(e).find('> ul > li').length > 0){
			generateMenuItemsAsHidden($(e).find('> ul > li'),id);
		}	
	});	
}
</script>