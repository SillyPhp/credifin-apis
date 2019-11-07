<?php

use yii\helpers\Url;
?>
    <div class="portlet applied_app light portlet-fit nd-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-microphone font-dark hide"></i>
                <span class="caption-subject bold font-dark uppercase">Applied Application<span data-toggle="tooltip" title="Here you will find all applications you have applied on"><i class="fa fa-info-circle"></i></span>
                </span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="m-portlet__body">
                    <div class="m-widget4 m-widget4--progress">
                        <?php if ($applied) { ?>
                            <?php foreach ($applied as $apply) { ?>
                                <div class="m-widget4__item row">
                                    <div class="m-widget4__img m-widget4__img--pic col-md-1">
                                        <img src="<?= Url::to('@commonAssets/categories/' . $apply["icon"]); ?>" alt="">
                                    </div>
                                    <div class="m-widget4__info col-md-6">
                                            <span class="m-widget4__title">
                                                <?= $apply['title'].' ( '.$apply['type'].' ) '; ?>
                                            </span><br>
                                        <span class="m-widget4__sub">
                                                <?= $apply['org_name']; ?>
                                            </span>
                                    </div>
                                    <div class="m-widget4__ext col-md-1">
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
                                    <div class="m-widget4__progress col-md-4">
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

                                </div>
                            <?php } ?>
                        <?php } else {
                                ?>
                        <div class="col-md-12">
                            <div class="tab-empty">
                                <div class="tab-empty-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/applyingjob.png'); ?>" class="img-responsive" alt=""/>
                                </div>
                                <div class="tab-empty-text">
                                    <div class="">You haven't applied yet on any application</div>
                                </div>
                            </div>
                        </div>
                       <?php
                             }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light view_applications nd-shadow">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <i class=" icon-social-twitter font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Questionnaires<span data-toggle="tooltip" title="Here you will find all pending questionnaires that are to be filled"><i class="fa fa-info-circle"></i></span>
            </span>
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
                                    <td><a href="/account/questionnaire/fill-questionnaire/<?= $q['questionnaire_enc_id']; ?>/<?= $list['applied_application_enc_id'] ?>" class="btn btn-primary btn-sm" target="_blank"><?= $q['questionnaire_name'] ?></a></td>
                                    <td><?= $list['title']; ?></td>
                                    <td><?= $q['sequence']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php }  } else { ?>
                    <div class="col-md-12">
                        <div class="tab-empty">
                            <div class="tab-empty-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/questionnaires.png'); ?>" class="img-responsive" alt=""/>
                            </div>
                            <div class="tab-empty-text">
                                <div class="">No Questionnaires</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Followed Companies<span data-toggle="tooltip" title="Here you will find all companies that you are following"><i class="fa fa-info-circle"></i></span>
                        </span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::to('/account/organization/shortlisted') ?>" data-toggle="tooltip" title="View All">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <?=
                        $this->render('/widgets/organization/card', [
                            'organization_data' => $shortlist_org,
                            'column_size' => 'col-md-4',
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light portlet-fit nd-shadow">
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
.font-dark > span > i {
    font-size: 13px;
    margin-left: 5px;
    color:darkgray;
}
.portlet.light.portlet-fit > .portlet-title{
    padding:0px;
}
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
/* Application process css starts */
.m-widget4 .m-widget4__item {
    display: block;
    padding-top: 1.15rem;
    padding-bottom: 1.25rem;
}
.m-widget4__item {
    border-bottom: 0.07rem dashed #ebedf2;
}
.m-widget4 .m-widget4__item .m-widget4__img {
    display: block;
    float: left;
}
.m-widget4 .m-widget4__item .m-widget4__img.m-widget4__img--pic img {
    width: 4rem;
    border-radius: 50%;
}
.m-widget4 .m-widget4__item .m-widget4__info {
    display: block;
    float:left;
    padding-left: 1.2rem;
    padding-right: 1.2rem;
    font-size: 1rem;
}
.m-widget4 .m-widget4__item .m-widget4__info .m-widget4__title {
    font-size: 15px;
    font-weight: 600;
    color: #575962;
}
.m-widget4 .m-widget4__item .m-widget4__info .m-widget4__sub {
    font-size: 11px;
    color: #7b7e8a;
}
.m-widget4.m-widget4--progress .m-widget4__progress {
    padding-right: 2rem;
    width: 30%;
    display: block;
    position: relative;
}
.m-widget4.m-widget4--progress .m-widget4__progress .m-widget4__progress-wrapper .m-widget17__progress-number {
    font-size: 14px;
    font-weight: 600;
}
.m-widget4.m-widget4--progress .m-widget4__progress .m-widget4__progress-wrapper .m-widget17__progress-label {
    font-size: 11px;
    float: right;
    margin-top: 0.3rem;
}
.m-widget4.m-widget4--progress .m-widget4__progress .m-widget4__progress-wrapper .progress {
    display: block;
    margin-top: 0.8rem;
    height: 0.5rem;
}
.progress.m-progress--sm {
    height: 6px;
}
.progress {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: .25rem;
}
.progress-bar {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #5867dd;
    -webkit-transition: width 0.6s ease;
    transition: width 0.6s ease;
}
.progress.m-progress--sm .progress-bar {
    border-radius: 3px;
}
.progress .progress-bar {
    -webkit-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.bg-danger {
    background-color: #f4516c !important;
}
.m-widget4 .m-widget4__item .m-widget4__ext {
    display: block;
    float: right;
    padding:0px;
    width: 11%;
}
.btn.btn-secondary {
    background: white !important;
    border-color: #ebedf2 !important;
    box-shadow:none !important;
    color: #212529;
    -webkit-transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out !important;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out !important;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out !important;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out !important;
}
.btn.m-btn--pill {
    border-radius: 60px !important;
}
.m-portlet__body {
    color: #575962;
    padding: 0.0rem 2.2rem;
}
.m-widget4__item.m-widget4__item--last, .m-widget4__item:last-child {
    border-bottom: 0;
}
.btn.m-btn--hover-brand:hover, .btn.m-btn--hover-brand.active, .btn.m-btn--hover-brand:active, .btn.m-btn--hover-brand:focus, .show>.btn.m-btn--hover-brand.dropdown-toggle {
    border-color: #716aca !important;
    color: #fff !important;
    background-color: #716aca !important;
    box-shadow:none !important;
}
@media screen and (max-width: 991px){
    .m-widget4.m-widget4--progress .m-widget4__progress{
        clear: both;
        width: 100%;
    }
}
@media screen and (max-width: 991px){
    .m-widget4 .m-widget4__item .m-widget4__ext{
        width: 20%;
    }
}
@media screen and (max-width: 550px){
    .m-widget4 .m-widget4__item .m-widget4__ext{
        width: 100%;
        clear:both;
        text-align:right;
    }
}
@media screen and (max-width: 450px){
    .m-widget4 .m-widget4__item .m-widget4__img{
        clear: both;
        width: 100%;
        text-align: center;
    }
    .m-widget4 .m-widget4__item .m-widget4__info{
        width: 100%;
        text-align: center;
    }
    .m-widget4 .m-widget4__item .m-widget4__ext{
        text-align: center;
        margin-top: 10px;
    }
}
/* Application process css ends */
");
$script = <<< JS
$(document).on('click','.cancel-app',function(e)
       {
          e.preventDefault();
             if($(this).attr("disabled") == "disabled")
            {
               return false;
            }
           var btncancl = $(this);  
         if (window.confirm("Do you really want to Cancel the current Application?")) { 
            
            var data = $(this).attr('data');
            $.ajax({
                url:'/account/jobs/cancel-application',
                data:{data:data},
                method:'post',
                beforeSend:function()
                {
                    btncancl.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                },
                success:function(data)
                    {
                      if(data==true)
                        {
                    btncancl.addClass('reject_btn');
                    btncancl.prop('disabled',true);  
                    btncancl.html('Cancelled');
                    btncancl.removeClass('cancel-app');
                    btncancl.attr('style', 'background-color: #e43a45 !important');
                    btncancl.css("color", "#fdfbfb");
                        }
                      else {
                          alert('something went wrong');
                      }
                     }
              })
        }
       });
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
JS;
$this->registerJs($script);