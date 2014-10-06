<?php
$dashboard = new Dashboard();
$this->widget('wTreeAdminUsers',array('dashboard'=>$dashboard));
$this->widget('wLatestLog',array('dashboard'=>$dashboard));
$this->widget('wDates',array('dashboard'=>$dashboard));
echo $dashboard->display();
?>