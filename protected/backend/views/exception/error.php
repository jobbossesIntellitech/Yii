<?php //print_r( Yii::app()->errorHandler->error); ?>

<?php 

$error = Yii::app()->errorHandler->error;

echo $error["type"].": <b>".$error["message"]."</b><br> On <b>".$error['file']."</b><br>";

$t = explode(":",$error['trace']);

echo '<ul>';

foreach($t AS $trace){
	echo '<li>'.$trace.'</li>';	
}

echo '</ul>';

?>