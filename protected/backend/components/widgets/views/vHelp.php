<?php
$help = new Help($c,$a);
$help_text = $help->content();
if(trim($help_text) != '' || Jii::hasPermission('help','save')){
	?>
	<div id="helpContainer">
		<div class="help-panel">
			<div id="helpTitle"><?php echo $title.' '.Jii::t('Help'); ?></div>
			<ul>
				<?php
				if(Jii::hasPermission('help','save')){
				?>
					<li style="display:none;">
						<a href="javascript://" id="saveHelp"><?php echo Jii::t('Save'); ?></a>
					</li>
					<li>
						<a href="javascript://" id="editHelp"><?php echo Jii::t('Edit'); ?></a>
					</li>
				<?php
				}
				?>
				<li>
					<a href="javascript://" id="closeHelp"><?php echo Jii::t('Close'); ?></a>
				</li>
			</ul>
		</div>
		<div id="helpView" class="left"><?php echo $help_text; ?></div>
		<div id="helpEditor" class="left" style="display:none;">
			<div class="line-nums"><span>1</span></div>
			<textarea id="codeHelpEditor"><?php echo $help->read(); ?></textarea>
		</div>
		<div class="clr"></div>
	</div>
	<?php
?>
<script type="text/javascript">
var first_editor_opened = false;
$(document).ready(
  function() {
	$('#outerPageTitle #innerPageTitle ul').append('<li><a href="javascript://" id="help"><?php echo Jii::t('Help'); ?></a></li>');
	$('#help,#closeHelp').click(function(){
		if($('#helpContainer').is(':hidden')){
			$('#helpContainer').fadeIn('500');	
		}else{
			$('#helpContainer').fadeOut('500');
		}
	});
	$('#helpContainer .help-panel #editHelp').click(function(){
		if($('#helpContainer #helpEditor').is(':hidden')){
			$('#helpContainer #helpView').animate({width:'50%'},500,function(){
				$('#helpContainer #helpEditor').fadeIn(500);
				$('#helpContainer .help-panel #saveHelp').parent().show();
				$('#helpContainer #helpEditor textarea').width( parseInt($('#helpContainer #helpEditor').width()) - 30 )
				.css('padding-left','30px');
				if(!first_editor_opened){
					first_editor_opened = true;
					$('#helpContainer #helpEditor textarea').resize(function(){
						return false;
					});
					var r = $.countLines("#helpContainer #helpEditor textarea");
					var numLines = r.visual,
						house = document.getElementsByClassName('line-nums')[0],
						html = '',
						i;
					for(i=0; i<numLines; i++){
						html += '<div>'+(i+1)+'</div>';
					}
					house.innerHTML = html;
				}
			});
		}else{
			$('#helpContainer #helpEditor').hide();
			$('#helpContainer #helpView').animate({width:'100%'},500);
			$('#helpContainer .help-panel #saveHelp').parent().hide();
		}	
	});
	$('#helpContainer .help-panel #saveHelp').click(function(){
		$.ajax({
			type : 'post',
			url  : '<?php echo Jii::app()->createUrl('help/save'); ?>',
			data : {c:'<?php echo $c; ?>',a:'<?php echo $a; ?>',data:$('#helpContainer #helpEditor textarea').val()},
			success : function(msg){
				$('#helpContainer #helpView').html( msg );
				$('#helpContainer .helpLoader').fadeOut(500);					
			},
			beforeSend : function(){
				if($('#helpContainer .helpLoader').size() == 0){
					$('#helpContainer').append('<div class="helpLoader outer-help-loader"><div class="inner-help-loader"><div id="facebookG">'+
					'<div id="blockG_1" class="facebook_blockG">'+
					'</div>'+
					'<div id="blockG_2" class="facebook_blockG">'+
					'</div>'+
					'<div id="blockG_3" class="facebook_blockG">'+
					'</div>'+
					'</div></div></div>');
				}else{
					$('#helpContainer .helpLoader').show();
				}				
			},
			error : function(jqXHR, textStatus, errorThrown){
				$('#helpContainer #helpView').html( errorThrown );
				$('#helpContainer .helpLoader').fadeOut(500);
			}
		});
	});
	correctionHelpHeight();
	$(window).resize(function(){ correctionHelpHeight(); });
	
	
	var editor = new Behave({
		textarea: document.getElementById('codeHelpEditor')
	});
	BehaveHooks.add(['keydown'], function(data){
		var r = $.countLines("#helpContainer #helpEditor textarea");
		var numLines = r.visual,
			house = document.getElementsByClassName('line-nums')[0],
			html = '',
			i;	
		for(i=0; i<numLines; i++){
			html += '<div>'+(i+1)+'</div>';
		}
		house.innerHTML = html;
		$('#helpContainer #helpView').html( $('#codeHelpEditor').val() );
	});
	
	$('#codeHelpEditor').keypress(function(event) {
		if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
		$('#helpContainer .help-panel #saveHelp').trigger('click');
		event.preventDefault();
		return false;
	});
  }
);
function correctionHelpHeight(){
	var container = parseInt($('#helpContainer').height());
	var panel = parseInt($('#helpContainer  .help-panel').outerHeight());
	var view = container - panel;
	$('#helpContainer #helpView').height(view);	
	$('#helpContainer #helpEditor').height(view);
}
</script>
<?php
}
?>