<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

if (!$column_size) {
    $column_size = 'col-md-4';
}

Pjax::begin(['id' => 'pjax_org']);
if ($organization_data) {
    foreach ($organization_data as $shortlist) {
        $logo = $shortlist['logo'];
        ?>
        <div class="<?= $column_size; ?> hr-j-box">
            <div class="topic-con">
                <div class="hr-company-box">
                    <a href="/<?= $shortlist['slug']; ?>">
                        <div class="hr-com-name">
                            <?= $shortlist['org_name']; ?>
                        </div>
                        <div class="hr-com-icon">
                            <?php
                            if (empty($shortlist['logo_location'])) {
                                ?>
                                <canvas class="user-icon" name="<?= $shortlist['org_name'] ?>" width="100" height="100"
                                        font="40px" color="<?= $shortlist['initials_color']; ?>"></canvas>
                                <?php
                            } else {
                                $logo_location = $shortlist['logo_location'];
                                $logo_image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;
//                                $logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;
//                                if (!file_exists($logo_base_path)) {
//                                    $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
//                                }
                                ?>
                                <img src="<?= Url::to($logo_image); ?>" class="img-responsive ">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="hr-com-field">
                            <?= $shortlist['industry']; ?>
                        </div>
                        <div class="ji-set">
                            <?php
                            if ($shortlist['organizationEnc']['employerApplications']) {
                                $jobsCount = 0;
                                $internshipsCount = 0;
                                foreach ($shortlist['organizationEnc']['employerApplications'] as $c) {
                                    if ($c['name'] === 'Jobs') {
                                        $jobsCount += 1;
                                    } elseif ($c['name'] === 'Internships') {
                                        $internshipsCount += 1;
                                    }
                                }
                                if (($for == 'all' || $for == 'Jobs') && $jobsCount != 0) {
                                    echo '<a href="#" data-toggle="modal" data-url="Jobs" data-target="#myModal" data-type="all" data-id="' . $shortlist['organizationEnc']['employerApplications'][0]['organization_enc_id'] . '" class="job-pos getsJobsData">' . $jobsCount . ' Jobs</a>';
                                }
                                if (($for == 'all' || $for == 'Internships') && $internshipsCount != 0) {
                                    echo '<a href="#" data-toggle="modal" data-url="Internships" data-target="#myModal" data-type="all" data-id="' . $shortlist['organizationEnc']['employerApplications'][0]['organization_enc_id'] . '" class="job-pos getsJobsData">' . $internshipsCount . ' Internships</a>';
                                }
                            }
                            ?>
                        </div>
                    </a>
                    <div class="hr-com-jobs hr-unfollow j-grid">
                        <button value="<?= $shortlist['followed_enc_id']; ?>" class="rmv_org">UNFOLLOW</button>
                        <a href="/<?= $shortlist['slug']; ?>" title="">VIEW PROFILE</a>

                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="tab-empty">
        <div class="tab-empty-icon">
            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/followedcompanies.png'); ?>" class="img-responsive"
                 alt=""/>
        </div>
        <div class="tab-empty-text">
            <div class="">You haven't Followed any Company.</div>
        </div>
    </div>
    <?php
}
Pjax::end();
?>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-shadow">
                <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span id="modal-app-title"></span> List</h4>
                </div>
                <div class="modal-body modal-set-h">
                    <div class="list-main" id="all-apps">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="all-apps-template" type="text/template">
        {{#.}}
        <a href="/job/{{slug}}" class="list-card" target="_blank">
            <div class="cat-logo">
                {{#icon}}
                <img src="{{icon}}" class="img-responsive">
                {{/
                icon}}
                {{^
                icon}}
                <canvas class="user-icon" name="{{title}}" width="45" height="45"
                        color="{{color}}" font="22px"></canvas>
                {{/
                icon}}
            </div>
            <p class="job-title">{{title}}</p>
        </a>
        {{/.}}
    </script>

<?php
$this->registerCss('
.cat-logo {
    width: 45px;
    min-width: 45px;
    height: 45px;
//    border-radius: 50% !important;
    background-color: #fff;
    overflow:hidden;
}
.modal-shadow {
    border-radius: 4px !important;
    box-shadow: 0 0 50px 0px #8e8888;
}
.list-main {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
}
.list-card {
    flex-basis: 48%;
    display: flex;
    box-shadow: 0 0 6px 3px #eee;
    align-items: center;
    border-radius: 4px !important;
    padding: 6px;
    margin-bottom: 15px;
    transition: all .3s;
}
.list-card:hover p {
    color: #eee;
}
.list-card:hover {
    background-color: #00a0e3;
    cursor: pointer;
}
.list-card img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}
.list-card p {
    font-family: roboto;
    font-weight: 400;
    margin:0 !important;
    color:#333;
    padding-left:5px;
}
.modal-h {
//    border: none !important;
    text-align: center;
//    padding-bottom: 0;
}
.modal-h h4 {
    font-family: roboto;
    font-size: 20px;
}
.modal-set-h{
    max-height: 400px;
    overflow-y: scroll;
}
.modal-open {
    overflow-y: hidden !important;
}
.modal-dialog-centered {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
    transition: all .3s;
}
.job-pos {
    font-family: Roboto;
    color: #999;
    font-weight: 500;
    display: inline-block;
    margin: 0px 5px;
}
//.hr-company-box {
//    padding: 20px 10px 20px;
//}
//.user-icon {
//    border-radius: 50%;
//}
.j-grid > button {
    font-family: roboto;
    font-size: 11px;
    color: #00a0e3;
    border: 1px solid #00a0e3;
    -webkit-border-radius: 20px !important;
    -moz-border-radius: 20px !important;
    -ms-border-radius: 20px !important;
    -o-border-radius: 20px !important;
    border-radius: 4px !important;
    padding: 6px 12px;
    display: inline-block;
    background-color: #fff;
}
.j-grid > button:hover {
    background-color: #00a0e3;
    color: #fff;
}
.hr-unfollow {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    flex-wrap: wrap;
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
.hr-com-jobs {
    padding: 20px 0px 0px 0px !important;
    text-align: center;
}
.hr-com-icon img {
//    border-radius: 50% !important;
    object-fit: contain;
    overflow: hidden;
}
.hr-com-field, .ji-set{min-height:22px;}
.hr-com-icon{height:120px;}
@media only screen and (max-width: 600px) {
  .list-card{flex-basis:100%;}
}
');
$script = <<<JS
$('.getsJobsData').on('click', function (e){
    let elem = e.target;
    let orgId = elem.getAttribute('data-id');
    let appType = elem.getAttribute('data-url');
    $('#modal-app-title').text(appType);
    $.ajax({
        url: '/account/jobs/get-followed-companies-jobs',
        data:{organization_enc_id: orgId, type: appType},
        method: 'post',
        success:function(data){
            if (data['status']==200){
                var template = $('#all-apps-template').html();
                var rendered = Mustache.render(template,data.data);
                $('#all-apps').html(rendered);
                utilities.initials();
            }
        }
    })
})
$(document).on('click','.rmv_org',function(){
    var  url = '/account/jobs/org-delete';
    var rmv_id = $(this).val();
    var  pjax_refresh_id = '#pjax_org';
    $.ajax({
        url:url,
        data:{rmv_id:rmv_id},
        method:'post',
        beforeSend: function(){
            // $(".loader").css("display", "block");
        },
        success:function(data){
            $.pjax.reload({container: pjax_refresh_id, async: false});
            if(data == true) {
                toastr.success(data.message, 'Success');
                utilities.initials();
            } else{
                toastr.error('Something went wrong. Please try again.', 'Opps!!');
            }
        }
    });
});
var pa = new PerfectScrollbar('.modal-set-h');
JS;
$this->registerJs($script);
