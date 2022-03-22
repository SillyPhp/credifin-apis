<?php 
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12"> 
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Job Templates'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="mt-actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="padding-left">
                                        <div class="manage-jobs-sec">
                                            <?php
                                            if (count($jobs) > 0) {
                                                echo $this->render('/widgets/employer-applications/template-card', [
                                                    'processes' => $jobs,
                                                    'type'=> "Jobs",
                                                    'col_width' => 'col-lg-3 col-md-3 col-sm-6',
                                                ]);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!$jobs){ ?>
                <div class="tab-empty">
                    <div class="tab-empty-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/process.png'); ?>"
                                class="img-responsive" alt=""/>
                    </div>
                    <div class="tab-empty-text">
                        <div class="">No process to display</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
$this->registerCss('
.p-category > a > .temp-type {
    display: inline-block;
    background: #00a0e3;
    width: fit-content;
    position: absolute;
    right: 0;
    top: 0;
    margin: 0;
    padding: 4px 0;
    width: 120px;
    color: #fff;
    border-bottom-left-radius: 5px;
    text-transform: capitalize;
    transition: .2s all;
}
.p-category:hover > a > .temp-type{
    border-radius: 5px;
    transition: .2s all;
}
.p-category > a{
    position: relative;
    transition: .2s all;
}
.p-category > a img{
    height:85px;
    width:85px;  
}
.actions > a {
    margin-right: 15px;
}
.actions > a:hover > img{
    -ms-transform: scale(1.2);
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
}
.actions > a > img {
    height:25px;
//    margin-top:7px;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    height:170px;
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
');