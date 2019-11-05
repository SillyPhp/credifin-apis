<?php
use yii\helpers\Url;
use yii\widgets\Pjax;

echo $this->render('/widgets/header/secondary-header', [
'for' => 'Trainings',
]);
?>
 <div class="row widget-row">
        <?=
        $this->render('/widgets/training-program/stats', [
            'applications' => $applications,
            'total_applied' => $total_applied,
        ]);
        ?>
    </div>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Training Programs'); ?></span>
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute('/training-program/create'); ?>"
                       class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                    <?php if ($applications['total'] > 8): ?>
                        <a href="<?= Url::toRoute('/training-program'); ?>" title=""
                           class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <?php
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
                            <div class="">No active Training Program</div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <?php
        echo $this->render('/widgets/applied-applications/training-users-card', [
            'applied_applications' => $applied_applications,
        ]); ?>
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