<?php
use yii\widgets\Pjax;
use yii\helpers\Url;

echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Trainings',
]);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Training Programs'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                Pjax::begin(['id' => 'pjax_active_trainings']);
                if ($applications['total'] > 0) {
                    echo $this->render('/widgets/training-program/cards', [
                        'applications' => $applications['data'],
                        'per_row' => 4,
                    ]);
                } else {
                    ?>
                    <div class="tab-empty">
                        <div class="tab-empty-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/active-trainingp.png'); ?>"
                                 class="img-responsive" alt=""/>
                        </div>
                        <div class="tab-empty-text">
                            <div class="">There haven't created any active Training Program</div>
                        </div>
                    </div>
                <?php }
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss("
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:250px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
");