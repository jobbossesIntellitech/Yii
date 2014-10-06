<script type="text/javascript" src="<?php echo $path."/ckfinder.js"; ?>"></script>
<script type="text/javascript">
if (typeof String.prototype.ext !== 'function') {
    String.prototype.ext = function() {
		return (/[.]/.exec(this)) ? /[^.]+$/.exec(this) : undefined;
    };
}
if (typeof in_array !== 'function') {
	function in_array(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}
}
var selected_<?php echo $this->id; ?> = 0;
var counter_<?php echo $this->id; ?> = 0;
var only_<?php echo $this->id; ?> = parseInt(<?php echo $this->only; ?>);
var type = new Array();
<?php
$types = explode(',',$this->type);
if(!empty($types) && is_array($types)){
	foreach($types AS $type){
		?>
		type[type.length] = '<?php echo $type; ?>';
		<?php	
	}	
}
?>
function BrowseServer_<?php echo $this->id; ?>(){
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.selectActionFunction = SetFileField_<?php echo $this->id; ?>;
	finder.popup();
}
// This is a sample function which is called when a file is selected in CKFinder.
function SetFileField_<?php echo $this->id; ?>( fileUrl ){
	if(in_array(fileUrl.ext(),type)){
		fileUrl = fileUrl.replace('<?php echo Jii::app()->params['sub']; ?>','');
		var only = only_<?php echo $this->id; ?>;
		var li = '';
		li += '<li id="item_'+counter_<?php echo $this->id; ?>+'" class="sortableImage">';
			li += '<img src="<?php echo Jii::app()->getBaseUrl(true); ?>/'+fileUrl+'">';
			<?php if($this->model){
				?>
				li += '<input type="hidden" name="<?php echo get_class($this->model).'['.$this->name.'][]'; ?>" ';
				li += 'value="/'+fileUrl+'" id="<?php echo get_class($this->model).'_'.$this->name; ?>" />';
				<?php	
			}else{?>
				li += '<input type="hidden" name="<?php echo $this->attribute; ?>[]" value="'+fileUrl+'" id="<?php echo $this->attribute; ?>" />';
			<?php
			}
			?>
			li += '<a href="javascript://" class="remove">X</a>';
		li += '</li>';
		$('#<?php echo $this->id; ?> ul li.addnew').before(li);
		actionLi<?php echo $this->id; ?>( $('#item_'+counter_<?php echo $this->id; ?>+'') );
		selected_<?php echo $this->id; ?>++;
		counter_<?php echo $this->id; ?>++;
		if(selected_<?php echo $this->id; ?> >= only){
			$('#<?php echo $this->id; ?> ul li.addnew').hide();	
		}
	}else{
		alert('<?php echo Jii::t('File type unacceptable'); ?>');	
	}
	$('#<?php echo $this->id; ?> ul').sortable({connectWith: '#<?php echo $this->id; ?> ul',items: ".sortableImage"});	
}
$(document).ready(function() {
	$('#<?php echo $this->id; ?> li').each(function(i, e) {
		if(!$(e).hasClass('addnew')){
			selected_<?php echo $this->id; ?>++;
			counter_<?php echo $this->id; ?>++;
			if(selected_<?php echo $this->id; ?> >= only_<?php echo $this->id; ?>){
				$('#<?php echo $this->id; ?> ul li.addnew').hide();	
			}
    		actionLi<?php echo $this->id; ?>($(e));
		}
    }); 
	$('#<?php echo $this->id; ?> ul').sortable({connectWith: '#<?php echo $this->id; ?> ul',items: ".sortableImage"});	
});
function actionLi<?php echo $this->id; ?>(li){
	li.find('a.remove').click(function(){
		var conf = window.confirm('<?php echo Jii::t('Are You Sure?'); ?>');
		if(conf){
			$(this).parent().remove();
			selected_<?php echo $this->id; ?>--;
			if(selected_<?php echo $this->id; ?> < only_<?php echo $this->id; ?>){
				$('#<?php echo $this->id; ?> ul li.addnew').show();	
			}
		}
	});		
}
</script>

<div class="finder-image-list" id="<?php echo $this->id; ?>">
	<h3><?php echo Jii::t('Best Dimension').' : '.$this->dimension; ?>,<?php echo Jii::t('Type'); ?> : <?php echo $this->type; ?></h3>
    <ul>
    	<?php
		if(!empty($this->data) && is_array($this->data)){
			foreach($this->data AS $d){
				if(!empty($d)){
					?>
					<li class="sortableImage">
						<img src="<?php echo Jii::app()->baseUrl.$d; ?>">
						<?php
						if($this->model){
							?>
							<input type="hidden" name="<?php echo get_class($this->model).'['.$this->name.'][]'; ?>" 
							value="<?php echo $d; ?>" id="<?php echo get_class($this->model).'_'.$this->name; ?>" />
							<?php
						}else{
							?>
							<input type="hidden" name="<?php echo $this->attribute; ?>[]" value="<?php echo $d; ?>" id="<?php echo $this->attribute; ?>" />
							<?php		
						}
						?>
						<a href="javascript://" class="remove">X</a>
					</li>
					<?php
				}
			}	
		}
		?>
        <li class="addnew">
        	<a href="javascript://" onclick="BrowseServer_<?php echo $this->id; ?>();">+</a>
        </li>
    </ul>
</div>       