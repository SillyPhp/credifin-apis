<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire Templates'); ?></span>
                </div>
                <div class="actions">
                    <?php if ($questionnaire['total'] > 4): ?>
                        <a href="<?= Url::toRoute('templates/questionnaire/index'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if ($questionnaire['total'] > 0) {
                            echo $this->render('/widgets/questionnaire/template-card', [
                                'questionnaire' => $questionnaire['data'],
                                'per_row' => 2,
                                'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                            ]);
                        } else {
                            ?>
                            <div class="tab-empty">
                                <div class="tab-empty-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/questionnaires.png'); ?>"
                                         class="img-responsive" alt=""/>
                                </div>
                                <div class="tab-empty-text">
                                    <div class="">No Questionnaires</div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Hiring Process Templates'); ?></span>
                </div>
                <div class="actions">
                    <?php if ($interview_processes['total'] > 4): ?>
                        <a href="<?= Url::toRoute('templates/hiring-process/index'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if ($interview_processes['total'] > 0) {
                            echo $this->render('/widgets/processes/template-card', [
                                'processes' => $interview_processes['data'],
                                'per_row' => 2,
                                'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                            ]);
                        } else {
                            ?>
                            <div class="tab-empty">
                                <div class="tab-empty-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/process.png'); ?>"
                                         class="img-responsive" alt=""/>
                                </div>
                                <div class="tab-empty-text">
                                    <div class="">No process to display</div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
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