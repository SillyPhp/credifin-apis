<?php
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Information & Technology Job Templates'); ?></span>
                </div>
                <div class="actions">
                    <?php if (count($jobs) > 4): ?>
                        <a href="<?= Url::toRoute('/jobs/view-templates'); ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (count($jobs) > 0) {
                            // $ITjobs=[];
                            // foreach($jobs as $job){
                            //     if($job['cat_name'] === 'Test TItle 2'){
                            //         array_push($ITjobs, $job);
                            //     }
                            // };
                            // // echo '<pre>';
                            // // print_r($ITjobs);die();
                            // // echo '</pre>';
                            echo $this->render('/widgets/employer-applications/template-card', [
                                'processes' => $jobs,
                                'limit' => 4,
                                'type' => "Jobs",
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
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Information & Technology Internship Templates'); ?></span>
                </div>
                <div class="actions">
                    <?php if (count($internships) > 4): ?>
                        <a href="<?= Url::toRoute('/internships/view-templates'); ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (count($internships) > 0) {
                            echo $this->render('/widgets/employer-applications/template-card', [
                                'processes' => $internships,
                                'limit' => 4,
                                'type' => "Internships",
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
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Other Job Templates'); ?></span>
                </div>
                <div class="actions">
                    <?php if (count($jobs) > 4): ?>
                        <a href="<?= Url::toRoute('/jobs/view-templates'); ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (count($jobs) > 0) {
                            echo $this->render('/widgets/employer-applications/template-card', [
                                'processes' => $jobs,
                                'limit' => 4,
                                'type' => "Jobs",
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
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Other Internship Templates'); ?></span>
                </div>
                <div class="actions">
                    <?php if (count($internships) > 4): ?>
                        <a href="<?= Url::toRoute('/internships/view-templates'); ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (count($internships) > 0) {
                            echo $this->render('/widgets/employer-applications/template-card', [
                                'processes' => $internships,
                                'limit' => 4,
                                'type' => "Internships",
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
                        <a href="<?= Url::toRoute('templates/questionnaire/index'); ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
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
                        <a href="<?= Url::toRoute('templates/hiring-process/index'); ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
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
$script = <<<JS
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
JS;
$this->registerJs($script);
?>