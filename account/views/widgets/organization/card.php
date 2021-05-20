<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

if (!$column_size) {
    $column_size = 'col-md-3';
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
                                        font="35px" color="<?= $shortlist['initials_color']; ?>"></canvas>
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

$this->registerCss('
//.hr-company-box {
//    padding: 20px 10px 20px;
//}
.user-icon {
    border-radius: 50%;
}
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
    margin-top: -4px;
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
.hr-com-field{min-height:21px;}
.hr-com-icon{height:120px;}
');
$script = <<<JS
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
JS;
$this->registerJs($script);