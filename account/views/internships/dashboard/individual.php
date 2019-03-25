<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="loader"><img src='https://image.ibb.co/c0WrEK/check1.gif'/></div>
<div class="row">
    <?php
        Pjax::begin(['id' => 'widgets']);
    ?>
    <div class="widget-row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="<?= Url::to('/account/internships/reviewed') ?>">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1349"><?= $total_reviews; ?></span>
                    </div>
                    <div class="desc">Applications Reviewed </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="<?= Url::to('/account/internships/shortlisted') ?>">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="12,5"><?= $total_shortlist; ?></span>
                    </div>
                    <div class="desc">Applications Shortlisted </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="<?= Url::to('/account/internships/applied') ?>">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="549"><?= $total_applied; ?></span>
                    </div>
                    <div class="desc"> Applications Applied </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="<?= Url::to('/account/internships/accepted') ?>">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number"> 
                        <span data-counter="counterup" data-value="89"><?= $total_accepted; ?></span> </div>
                    <div class="desc"> Applications Accepted</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow" href="<?= Url::to('/account/internships/pending') ?>">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number"> 
                        <span data-counter="counterup" data-value="89"><?= $total_pending; ?></span> </div>
                    <div class="desc">Applications Pending</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 pink" href="<?= Url::to('/account/organization/shortlisted') ?>">
                <div class="visual">
                    <i class="fa fa-building"></i>
                </div>
                <div class="details">
                    <div class="number"> 
                        <span data-counter="counterup" data-value="89"><?= $total_shortlist_org; ?></span> </div>
                    <div class="desc">Companies Shortlisted</div>
                </div>
            </a>
        </div>
<!--        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 lightpink" href="<?= Url::to('/account/shortlist-jobs') ?>">
                <div class="visual">
                    <i class="fa fa-building"></i>
                </div>
                <div class="details">
                    <div class="number"> 
                        <span data-counter="counterup" data-value="89">0</span> </div>
                    <div class="desc">Suggested Jobs</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 claygreen" href="#">
                <div class="visual">
                    <i class="fa fa-building"></i>
                </div>
                <div class="details">
                    <div class="number"> 
                        <span data-counter="counterup" data-value="89">0</span> </div>
                    <div class="desc">Alerts</div>
                </div>
            </a>
        </div>-->
    </div>
    <?php
        Pjax::end();
    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line text-center">
                <div class="caption col-lg-11">
                    <ul class="tabs" id="head-tabs">
                        <li data-tab="tab-1" data-url="/account/internships/reviewed" class="tab-link current caption-subject font-dark uppercase" >Review List</li>
                        |
                        <li data-tab="tab-2" data-url="/account/internships/shortlisted" class="tab-link caption-subject font-dark  uppercase">Shortlisted</li>
                        |
                        <li data-tab="tab-3" data-url="/account/internships/applied" class="tab-link caption-subject font-dark uppercase">Applications Applied</li>
                        |
                        <li data-tab="tab-4" data-url="/account/internships/accepted" class="tab-link caption-subject font-dark uppercase">Accepted Applications</li>
                        |
                        <li data-tab="tab-5" data-url="/account/jobs/shortlisted1" class="tab-link caption-subject font-dark uppercase">Shorlisted Resume</li>
                    </ul>
                </div>
                <div class="actions col-lg-1">
                    <a href="/account/internships/reviewed" class="viewall-jobs" id="view-all">View All</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <div class="row">
                            <div class="mt-actions">
                                <div id="tab-1" class="tab-con current">
                                    <?php
                                    Pjax::begin(['id' => 'pjax_review']);
                                    if ($reviewlist) {

                                        foreach ($reviewlist as $review) {
                                            ?>
                                            <div class="col-md-3 col-sm-6 hr-j-box">
                                                <div class="topic-con" data-key="<?= $review['application_enc_id']; ?>"> 
                                                    <div class="hr-company-box">
                                                        <div class="hr-com-icon">
                                                            <img src="<?= Url::to('@commonAssets/categories/' . $review["icon"]); ?>" class="img-responsive ">
                                                        </div>
                                                        <div class="hr-com-name">
                                                            <?= $review['title']; ?>
                                                        </div>
                                                        <div class="opening-txt">
                                                            <?= $review['positions']; ?> Openings
                                                        </div>
                                                        <div class="overlay">
                                                            <div class="col-md-12">
                                                                <div class="text-o col-md-5"><a class="over-bttn ob1">Apply</a></div>
                                                                <div class="text-o col-md-7">
                                                                    <a class="over-bttn ob2 shortlist" id="<?= $review['slug'];?>" data-key="<?= $review['application_enc_id']; ?>" >
                                                                        <span class="hover-change"><i class="fa fa-heart-o"></i> Shortlist</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="hr-com-jobs">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 minus-15-pad">
                                                                    <div class="j-cross">
                                                                        <button value="<?= $review['application_enc_id']; ?>" class="rmv_review">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="j-grid"> 
                                                                        <a  href="/job/<?= $review['slug']; ?>" title="">VIEW JOB</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-md-12">
                                            <div class="tab-empty"> 
                                                <div class="tab-empty-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                                </div>
                                                <div class="tab-empty-text">
                                                    <div class="">There are no Jobs to show.</div>
                                                    <div class="">You haven't Select any jobs for review.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    Pjax::end();
                                    ?>
                                </div>
                                <div id="tab-2" class="tab-con" > 
                                    <?php
                                    Pjax::begin(['id' => 'pjax_shortlist']);
                                    if ($shortlisted) {
                                        foreach ($shortlisted as $shortlist) {
                                            ?>
                                            <div class="col-md-3 hr-j-box">
                                                <div class="topic-con"> 
                                                    <div class="hr-company-box">
                                                        <div class="hr-com-icon">
                                                            <img src="<?= Url::to('@commonAssets/categories/' . $shortlist["icon"]); ?>" class="img-responsive ">
                                                        </div>
                                                        <div class="hr-com-name">
                                                            <?= $shortlist['name']; ?>
                                                        </div>
                                                        <div class="opening-txt">
                                                            <?= $shortlist["positions"]; ?> Openings
                                                        </div>
                                                        <div class="overlay2">
                                                            <div class="text-o"><a class="over-bttn ob2 shortlist hover_short" href="/job/<?= $shortlist['slug']; ?>">Apply</a></div>
                                                        </div>
                                                        <div class="hr-com-jobs">
                                                            <div class="row ">
                                                                <div class="col-md-12 col-sm-12 minus-15-pad">
                                                                    <div class=" j-cross">
                                                                        <button class="rmv_list" value="<?= $shortlist['application_enc_id']; ?>">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                    </div> 
                                                                    <div class=" j-grid"> 
                                                                        <a  href="/job/<?= $shortlist['slug']; ?>" title="">VIEW JOB</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-md-12">
                                            <div class="tab-empty"> 
                                                <div class="tab-empty-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                                </div>
                                                <div class="tab-empty-text">
                                                    <div class="">There are no Jobs to show.</div>
                                                    <div class="">You haven't Shortlisted any jobs.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    Pjax::end();
                                    ?>
                                </div>
                                <div id="tab-3" class="tab-con" > 
                                    <?php
                                    if ($applied) {
                                        foreach ($applied as $apply) {
                                            ?>  
                                            <div class="col-md-3">
                                                <div class="topic-con"> 
                                                    <div class="hr-company-box">
                                                        <div class="hr-com-icon">
                                                            <img src="<?= Url::to('@commonAssets/categories/' . $apply["icon"]); ?>" class="img-responsive ">
                                                        </div>
                                                        <div class="hr-com-name">
                                                            <?= $apply['title']; ?>
                                                        </div>
                                                        <div class="opening-txt">
                                                            <?= $apply['positions']; ?> Openings
                                                        </div>
                                                        <div class="overlay1">
                                                            <div class="text-o">
                                                                <a class="over-bttn ob1">View Application</a>
                                                            </div>
                                                        </div>
                                                        <div class="hr-com-jobs">
                                                            <div class="row minus-15-pad">
                                                                <div class="j-grid"> <a  href="/job/<?= $apply['slug']; ?>" title="">VIEW JOB</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>  
                                        <div class="col-md-12">
                                            <div class="tab-empty"> 
                                                <div class="tab-empty-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                                </div>
                                                <div class="tab-empty-text">
                                                    <div class="">There are no Jobs to show.</div>
                                                    <div class="">You haven't Applied any jobs.</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div id="tab-4" class="tab-con" > 
                                    <?php
                                    if ($accepted_jobs) {
                                        foreach ($accepted_jobs as $accept) {
                                            ?>  
                                            <div class="col-md-3">
                                                <div class="topic-con"> 
                                                    <div class="hr-company-box">
                                                        <div class="hr-com-icon">
                                                            <img src="<?= Url::to('@commonAssets/categories/' . $accept["job_icon"]); ?>" class="img-responsive ">
                                                        </div>
                                                        <div class="hr-com-name">
                                                            <?= $accept['org_name']; ?>
                                                        </div>
                                                        <div class="hr-com-field">
                                                            <?= $accept['title']; ?>
                                                        </div>
                                                        <div class="opening-txt">
                                                            <?= $accept['positions']; ?> Openings
                                                        </div>
                                                        <div class="overlay1">
                                                            <div class="text-o"><a class="over-bttn ob2">View Application</a></div>
                                                        </div>
                                                        <div class="hr-com-jobs">
                                                            <div class="row minus-15-pad">
                                                                <div class="j-grid"> <a  href="/job/<?= $accept['slug']; ?>" title="">VIEW JOB</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>  
                                        <div class="col-md-12">
                                            <div class="tab-empty"> 
                                                <div class="tab-empty-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                                </div>
                                                <div class="tab-empty-text">
                                                    <div class="">There are no Jobs to show.</div>
                                                    <div class="">You haven't any accepted jobs.</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div id="tab-5" class="tab-con">
                                    <?php
                                    if ($shortlist1) {
                                        foreach ($shortlist1 as $shortlist) {
                                            ?>
                                            <div class="col-md-3 hr-j-box">
                                                <div class="topic-con">
                                                    <div class="hr-company-box">
                                                        <div class="hr-com-icon">
                                                            <img src="<?= Url::to('@commonAssets/categories/' . $shortlist["icon"]); ?>" class="img-responsive ">
                                                        </div>
                                                        <div class="hr-com-name">
                                                            <?= $shortlist['org_name'] ?>
                                                        </div>
                                                        <div class="hr-com-field">
                                                            <?= $shortlist['name']?>
                                                        </div>
                                                        <div class="overlay2">
                                                            <div class="text-o">
                                                                <?php if($shortlist['appliedApplications']){?>
                                                                    <a class="over-bttn ob2 hover_short" disabled="disabled">
                                                                        <i class="fa fa-check"></i>Applied</a>
                                                                <?php }else{?>
                                                                    <a href="/job/<?= $shortlist['slug']; ?>" class="over-bttn ob2 hover_short apply-btn">Apply</a>
                                                                <?php } ?>
                                                            </div>

                                                        </div>
                                                        <div class="hr-com-jobs">
                                                            <div class="row ">
                                                                <div class="col-md-12 col-sm-12 minus-15-pad">
                                                                    <div class=" j-grid">
                                                                        <a  href="/job/<?= $shortlist['slug']; ?>" title="">VIEW JOB</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-md-12">
                                            <div class="tab-empty">
                                                <div class="tab-empty-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                                </div>
                                                <div class="tab-empty-text">
                                                    <div class="">There are no Jobs to show.</div>
                                                    <div class="">You haven't Shortlisted any jobs.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Companies shortlisted</span>
                </div>
                <div class="actions">
                    <a href="<?= Url::to('/account/shortlist-companies') ?>" title="" class="viewall-jobs">View All</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <?php
                    Pjax::begin(['id' => 'pjax_org']);
                    if ($shortlist_org) {
                        foreach ($shortlist_org as $shortlist) {
                            $logo = $shortlist['logo'];
                            ?>
                            <div class="col-md-3 hr-j-box">
                                <div class="topic-con"> 
                                    <div class="hr-company-box">
                                        <a href="/<?= $shortlist['slug']; ?>">
                                            <div class="hr-com-icon">
                                                <?php
                                                if (empty($shortlist['logo_location'])) {
                                                    ?>
                                                    <canvas class="user-icon" name="<?= $shortlist['org_name'] ?>" width="80" height="80" font="35px"></canvas>
                                                    <?php
                                                } else {
                                                    $logo_location = $shortlist['logo_location'];
                                                    $logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;
                                                    $logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;
                                                    if (!file_exists($logo_base_path)) {
                                                        $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
                                                    }
                                                    ?>
                                                    <img src="<?= Url::to($logo_image); ?>" class="img-responsive ">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="hr-com-name">
                                                <?= $shortlist['org_name']; ?>
                                            </div>
                                            <div class="hr-com-field">
                                                <?= $shortlist['industry']; ?>
                                            </div>
                                        </a>
                                        <div class="hr-com-jobs">
                                            <div class="row">
                                                <div class="col-md-1 j-cross"><button value="<?= $shortlist['shortlisted_enc_id']; ?>" class="rmv_org"><i class="fa fa-times"></i></button></div> 
                                                <div class="col-md-offset-3 col-md-6 minus-15-pad j-grid"> 
                                                    <a  href="/<?= $shortlist['slug']; ?>" title="">VIEW PROFILE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12">
                            <div class="tab-empty"> 
                                <div class="tab-empty-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                </div>
                                <div class="tab-empty-text">
                                    <div class="">There are no Jobs to show.</div>
                                    <div class="">You haven't Shortlisted any Company.</div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    Pjax::end();
                    ?>
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
    max-width:200px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
.topic-con{
    position:relative;
}
.overlay, .overlay1, .overlay2 {
  position: absolute;
  top: 0px;
  left: 0;
  right: 0;
  background: rgba(208, 208, 208, 0.5);
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
}
.loader{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
.topic-con:hover .overlay, .topic-con:hover .overlay1,.topic-con:hover .overlay2 {
  height: 78%;
  border-radius:10px 10px 0px 0px !important;
}
.topic-con:hover .opening-txt ~ .overlay, .topic-con:hover .opening-txt ~ .overlay1,.topic-con:hover .opening-txt ~ .overlay2 {
    height:80%;
}
button.over-bttn, .ob1, button.over-bttn, .ob2{
    background:#00a0e3 !important; 
    border:2px solid #00a0e3; 
    border-radius:5px !important;
    padding:6px 12px;
    color:#fff;
}
button.over-bttn, .ob2{
    background:#ff7803 !important; 
}                  
.ob1:hover{
    background:#fff !important;
    color:#00a0e3; 
    transition:.3s all;
}                 
.ob2:hover{
    background:#fff !important; 
    color:#ff7803; 
    transition:.3s all;
}
.text-o {
    font-size: 14px;
    line-height:280px;
}
ul.tabs{
    margin: 0px;
    padding: 0px;
    list-style: none;
}
ul.tabs li{
    background: none;
    color: #222;
    display: inline-block;
    padding: 10px 15px;
    cursor: pointer;
}
.caption > ul.tabs > li.tab-link:hover{
    color:#00a0e3 !important;
}
.tab-con{
    display:none
}
.tab-con.current{
    display:inherit
}
.current{
    color:#00a0e3 !important; 
    transition:2s ease-out;
}
.tab-con.current{
    animation: slide-down 1s ease-out;
}
@keyframes slide-down {
    0% { opacity: 0; transform: translateY(100%); }
    100% { opacity: 1; transform: translateY(0); }
}
li.current{ 
    border-bottom:1px solid #00a0e3;
    transition:2s ease-out;
}
.hr-company-box{
    border-radius:10px !important; 
}                      
.hr-com-icon{
    padding:10px 0;
}
.hr-com-name{
    padding-top:20px;
}
.hr-com-jobs{
    padding:20px 0px 0px 0px !important; 
    text-align:center;
}            
#view-all{
    margin-top:5px;
}
.opening-txt{
    padding-top: 2px;
    padding-bottom: 10px;
    font-size: 14px;
    color: #080808;
}
a:hover{
    text-decoration:none;
}
');
$script = <<<JS
$("ul[id*=head-tabs] li").click(function(){
    $('#view-all').attr('href',$(this).attr('data-url'));
})

$(document).on('click','#shortlist',function(){
   var app_id = $(this).attr('value');
    $.ajax({
        url:'/account/internships/shortlist-job',
        data: {app_id:app_id},
        method: 'post',
        success:function(data){
            console.log("in success");
            console.log(data);
        }

    });
});
            
function Ajax_call(rmv_id,url,pjax_refresh_id)
    {
        $.ajax({
                url:url,
                data:{rmv_id:rmv_id},
                method:'post',
                beforeSend: function()
                {
                    $(".loader").css("display", "block");
                },
                success:function(data)
                       {
                        if(data == true)
                          {
                            $(".loader").css("display", "none");
                            $.pjax.reload({container: pjax_refresh_id, async: false});
                            $.pjax.reload({container: '#widgets', async: false});
                           }
                       }
              })
    }
    
    function Ajax_call_two(rmv_id,url,pjax_refresh_id,pjax_refresh_idd,parent)
    {
        $.ajax({
                url : url,
                data : {rmv_id:rmv_id},
                method : 'POST',
                beforeSend: function()
                {   
                    parent.hide();
                    // $(".loader").css("display", "block");
                },
                success:function(data){
                        if(data.status == 'true')
                          {
                            // $(".loader").css("display", "none");
                            $.pjax.reload({container: pjax_refresh_id, async: false});
                            $.pjax.reload({container: pjax_refresh_idd, async: false});
                            toastr.success(data.message, data.title);
                           } 
                        else if(data.status == 'false') {
                            $.pjax.reload({container: pjax_refresh_id, async: false});
                            toastr.error(data.message, data.title);
                           }
                       }
              })
    }
        
$(document).on('click','.shortlist',function()
    {
      var  url = '/account/internships/review-shortlist';
      var rmv_id = $(this).attr('data-key');
      var  pjax_refresh_id = '#pjax_review';
      var  pjax_refresh_idd = '#pjax_shortlist';
      var parent = $(this).parents().eq(5);
      Ajax_call_two(rmv_id,url,pjax_refresh_id,pjax_refresh_idd,parent);
   }) 
   
$(document).on('click','.rmv_list',function()
    {
      var  url = '/account/internships/shortlist-delete';
      var rmv_id = $(this).val();
      var  pjax_refresh_id = '#pjax_shortlist';
      Ajax_call(rmv_id,url,pjax_refresh_id);
   })   
        
$(document).on('click','.rmv_review',function()
    {
      var  url = '/account/internships/review-delete';
      var rmv_id = $(this).val();
      var  pjax_refresh_id = '#pjax_review';
      Ajax_call(rmv_id,url,pjax_refresh_id);
   }) 
   
        
$(document).on('click','.rmv_org',function()
    {
      var  url = '/account/internships/org-delete';
      var rmv_id = $(this).val();
      var  pjax_refresh_id = '#pjax_org';
      Ajax_call(rmv_id,url,pjax_refresh_id);
   }) 
        
        
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-con').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

$(document).on('click', '#removejob', function(){
    $(this).closest('.hr-j-box').remove();
});   

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
