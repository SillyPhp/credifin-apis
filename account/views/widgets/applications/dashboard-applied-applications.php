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
                                                <?= $apply['title'].' ( '.$apply['type'].' ) '; ?>
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
                                        <?php switch ($apply['status']) {
                                            case 'Cancelled':
                                                echo '<a 
                                                class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm reject_btn">Cancelled</a>';
                                                break;
                                            case 'Pending':
                                                echo '<a data="'.$apply['applied_id'].'"
                                               class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm btn-secondary cancel-app">Cancel</a>';
                                                break;
                                            case 'Incomplete':
                                                echo '<a data="'.$apply['applied_id'].'"
                                                class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm btn-secondary cancel-app">Cancel</a>';
                                                break;
                                            case 'Hired':
                                                echo '<a
                                                class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm hired_btn">Hired</a>';
                                                break;
                                            case 'Rejected':
                                                echo '<a 
                                                class="m-btn m-btn--hover-brand m-btn--pill btn btn-sm reject_btn">Rejected</a>';
                                                break;
                                        }
                                            ?>
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
            <div class="col-md-12">
                <?php if(!empty($question_list)){
                    foreach ($question_list  as $list){  ?>
                        <table class="table table-bordered">
                            <thead>
                            <th>Questionnaire</th>
                            <th>For</th>
                            <th>Round</th>
                            </thead>
                            <?php foreach($list['question'] as $q){ ?>
                                <tr>
                                    <td><a href="/account/questionnaire/fill-questionnaire?qidk=<?= $q['questionnaire_enc_id']; ?>&aaid=<?= $list['applied_application_enc_id'] ?>" class="btn btn-primary btn-sm" target="_blank"><?= $q['questionnaire_name'] ?></a></td>
                                    <td><?= $list['title']; ?></td>
                                    <td><?= $q['sequence']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php }  } else { ?>
                    <h1>No Questionnaires Pending..!</h1>
                <?php } ?>
            </div>
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
$this->registerCss("
.hired_btn
{
 color: #fdfbfb;
 background: #26c281 !important;
}
.reject_btn
{
 color: #fdfbfb;
 background: #e43a45 !important;
}
");
$script = <<< JS
$(document).on('click','.cancel-app',function(e)
       {
          e.preventDefault();
             if($(this).attr("disabled") == "disabled")
            {
               return false;
            }
         if (window.confirm("Do you really want to Cancel the current Application?")) { 
            
            var data = $(this).attr('data');
            $.ajax({
                url:'/account/jobs/cancel-application',
                data:{data:data},
                method:'post',
                beforeSend:function()
                {
                    $('.cancel-app').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                },
                success:function(data)
                    {
                      if(data==true)
                        {
                          $('.cancel-app').addClass('reject_btn');
                          $('.cancel-app').prop('disabled',true);  
                          $('.cancel-app').html('Cancelled'); 
                          $('.cancel-app').removeClass('cancel-app');
                        }
                      else {
                          alert('something went wrong');
                      }
                     }
              })
        }
          
       })
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