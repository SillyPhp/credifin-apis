<?php

use yii\helpers\Url;
?>
    <div class="portlet applied_app light portlet-fit">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-microphone font-dark hide"></i>
                <span class="caption-subject bold font-dark uppercase">Applied Application</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="m-portlet__body">
                    <div class="m-widget4 m-widget4--progress">
                        <?php if ($applied) { ?>
                            <?php foreach ($applied as $apply) { ?>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--pic">
                                        <img src="<?= Url::to('@commonAssets/categories/' . $apply["icon"]); ?>" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                <?= $apply['title']; ?>
                                            </span><br>
                                        <span class="m-widget4__sub">
                                                <?= $apply['org_name']; ?>
                                            </span>
                                    </div>
                                    <div class="m-widget4__progress">
                                        <div class="m-widget4__progress-wrapper">
                                            <span class="m-widget17__progress-number"><?= $apply['per']; ?>%</span>
                                            <span class="m-widget17__progress-label"><?= $apply['status']; ?></span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: <?= $apply['per']; ?>%;" aria-valuenow="25"
                                                     aria-valuemin="0" aria-valuemax="63"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <?php if ($apply['status'] == 'Cancelled') { ?>
                                            <a data="<?= $apply['applied_id']; ?>"
                                               class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm btn-secondary cancel-app"
                                               disabled>Cancel</a>
                                        <?php } else { ?>
                                            <a data="<?= $apply['applied_id']; ?>"
                                               class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm btn-secondary cancel-app">Cancel</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light view_applications">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <i class=" icon-social-twitter font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Pending Questionnaire</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <?php if(!empty($que_li)){ ?>
                    <div class="col-md-12">
                        <div class="mt-actions">
                            <div class="mt-action">
                                <div class="mt-action-body">
                                    <div class="mt-action-row mb-3">
                                        <div class="mt-action-info col-md-12">
                                            <div class="mt-action-details ">
                                                <p class="mt-action-author"><?= $que_li['applicationEnc']['name'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php foreach($que_li['applicationEnc']['applicationInterviewQuestionnaires'] as $q){ ?>
                                        <a href="/account/questionnaire/fill-questionnaire?qidk=<?= $q['questionnaire_enc_id']; ?>&aaid=<?= $que_li['applied_application_enc_id'] ?>" class="btn btn-primary btn-sm" target="_blank"><?= $q['questionnaire_name'] ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php  } else { ?>
                <h1>No Questionnaire Pending..!</h1>
            <?php } ?>
        </div>
    </div>
    </div>
    <div class="portlet light portlet-fit">
        <div class="portlet-title" style="border-bottom:none;">
            <div class="check-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/check.png') ?>">
            </div>
            <div class="caption-1" style="">
                <i class="icon-microphone font-dark hide"></i>
                <span class="caption-subject bold font-dark uppercase" style="font-size:16px;">Welcome Aboard</span><br>
                <span class="caption-helper">Empower Youth makes it easy to post jobs and manage your candidates</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="how-box">
                        <div class="how-icon"><img
                                    src="<?= Url::to('@eyAssets/images/pages/dashboard/create-profile.svg') ?>"></div>
                        <div class="how-heading">Create Profile</div>
                        <div class="how-text"><p>Create your profile, let companies know you better, fill your details,
                                set your preferences.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="how-box">
                        <div class="how-icon"><img
                                    src="<?= Url::to('@eyAssets/images/pages/dashboard/search-company.svg') ?>"></div>
                        <div class="how-heading">Search Companies</div>
                        <div class="how-text"><p>Search and shortlist the companies where you want to work and get
                                alerts regarding jobs and internships offered by that particular company.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="how-box">
                        <div class="how-icon"><img
                                    src="<?= Url::to('@eyAssets/images/pages/dashboard/search-job.svg') ?>"></div>
                        <div class="how-heading">Search Jobs & Internships</div>
                        <div class="how-text">
                            <p>Search and shortlist jobs and internships offered by various companies, add them to your
                                review list.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="how-box">
                        <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/apply.svg') ?>">
                        </div>
                        <div class="how-heading">Apply & Get Hired</div>
                        <div class="how-text">Compare shortlisted jobs or internships, apply for those jobs check your
                            application process status clear interview and get hired.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$script = <<< JS

// function dashboard_individual_guide(){
//         var intro = introJs();
//
//         intro.setOptions({
//             steps: [
//                 {
//                     element: document.querySelector('.applied_app'),
//                     intro: "application applied enables you to view the recruitment you’ve applied for.",
//                     disableInteraction: true
//                 },
//             ]
//         });
//
//         intro.start();
//     }

JS;
$this->registerJs($script);
$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('@vendorAssets/tutorials/js/intro.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('/assets/themes/dashboard/tutorials/dashboard_tutorial.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);

//$options = [
////    'where' => ['and',
////        ['a.name' => 'individual_dashboard_applied_applications'],
////        ['b.is_viewed' => 0],
////    ],
//    ['a.name' => 'individual_dashboard_applied_applications'],
//];

//$tutorials = Yii::$app->tutorials->getTutorialsByUser();
//print_r();
//print_r($tutorials);
if (!Yii::$app->session->has("tutorial_individual_dashboard")) {
    echo '<script>dashboard_individual_guide()</script>';
    Yii::$app->session->set("tutorial_individual_dashboard", "Yes");
}
?>