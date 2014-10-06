<div class="paging">

    <div class="pageNumber">
    <select id="pages" name="pages">
        <option value="90000000000"><?php echo Jii::t('All'); ?></option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="40">40</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    </div>

<?php 
$pagingoption=array(
                'pages'=>$this->pages, "cssFile" => false,'maxButtonCount'=>5,"firstPageLabel"=>Jii::t("First"),"lastPageLabel"=>Jii::t("Last"),
                                    "nextPageLabel"=>Jii::t("Next")	,"prevPageLabel"=>Jii::t("Previous"),"header"=>"",
            );

$this->widget('CLinkPager',$pagingoption); ?>

</div>