<div class="left" id="appName"><h1><?php echo Jii::app()->name; ?></h1></div>
<div class="right" id="headerNav">
    <ul>
        <li id="color">
            <a href="javascript://" style="background:#<?php echo Jii::app()->user->color; ?>"></a>
            <ul>
            <?php 
            $colors = Theme::color();
            shuffle($colors);
            foreach($colors AS $color){
                if($color != Jii::app()->user->color){
                ?>
                <li>
                    <a href="<?php echo Jii::app()->createUrl('dashboard/changecolor',array('color'=>$color)); ?>" style="background:#<?php echo $color; ?>"></a>
                </li>
                <?php
                }
            } 
            ?>
            </ul>
        </li>
        <li id="language">
            <a href="javascript://"><?php echo $this->language->lng_iso; ?></a>
            <?php
            $criteria = new CDbCriteria;
            $criteria->addCondition('lng_status = '.Language::status()->getItem('enable')->getValue());
            $languages = Language::model()->findAll($criteria);
            if(isset($languages) && is_array($languages) && !empty($languages)){
            ?>
            <ul>
                <?php
                foreach($languages AS $lang){
                    if($lang->lng_id != Jii::app()->language){
                    ?>
                        <li>
                            <a href="<?php echo Jii::app()->createUrl('dashboard/changelanguage',array('lang'=>$lang->lng_id)); ?>">
                                <?php echo $lang->lng_iso; ?>
                            </a>
                        </li>
                    <?php
                    }
                }
                ?>
            </ul>
            <?php
            }
            ?>
        </li>
        <li id="member">
            <a href="javascript://">
            	<img 
                	src="<?php echo Jii::app()->baseUrl.Jii::app()->user->image; ?>" 
                    onError = " this.src = '<?php echo Jii::app()->baseUrl.'/assets/images/b/admin/member.png'; ?>'; "
                />
            </a>
            <ul>
                <li>
                	<h3>
						<?php echo Jii::app()->user->fullname; ?>
                    </h3>
                </li>
                <li>
                    <a href="<?php echo Jii::app()->createUrl('profile/index'); ?>"><?php echo Jii::t('My Profile'); ?></a>
                </li>
                <li>
                    <a href="<?php echo Jii::app()->createUrl('user/index'); ?>"><?php echo Jii::t('My Users'); ?></a>
                </li>
                <li>
                    <a href="<?php echo Jii::app()->createUrl('log/index'); ?>"><?php echo Jii::t('Log'); ?></a>
                </li>
            </ul>
        </li>
        <li id="logout">
            <a href="<?php echo Jii::app()->createUrl('authentication/logout'); ?>"></a>
        </li>
    </ul>
</div>
<div class="clear"></div>