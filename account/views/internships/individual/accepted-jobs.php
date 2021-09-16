<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="loader"><!--<img src='https://image.ibb.co/c0WrEK/check1.gif'/>--></div>
<section>
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="col-md-4"> 
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">ACCEPTED INTERNSHIPS</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <?php
                        Pjax::begin(['id' => 'pjax_shortlist']);
                        $total_applications = count($accepted);
                        if (!empty($accepted)) {
                            foreach ($accepted as $accept) {
                                ?>

                                <div class="col-md-3 hr-j-box">
                                    <div class="topic-con"> 
                                        <div class="hr-company-box">
                                            <div class="hr-com-icon">
                                                <?php
                                                if ($accept['logo']) {
                                                    $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $accept['logo_location'] . DIRECTORY_SEPARATOR . $accept['logo'];
                                                } else {
                                                    $organizationLogo = "https://ui-avatars.com/api/?name=" . $accept['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $accept['initials_color']) . "&color=ffffff";
                                                }
                                                ?>
                                                <img src="<?= $organizationLogo ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name job-title-name">
                                                <?= $accept['org_name']; ?>
                                            </div>
                                            <div class="merge-name-icon">
                                                <div class="cat-icon">
                                                    <img src="<?= Url::to('@commonAssets/categories/' . $accept["job_icon"]); ?>"
                                                         class="img-responsive ">
                                                </div>
                                                <div class="hr-com-field">
                                                    <?= $accept['title']; ?>
                                                </div>
                                            </div>
                                            <div class="hr-com-field"></div>
                                            <div class="opening-txt">
                                                <?= $accept["positions"]; ?> Openings
                                            </div>
                                            <div class="overlay2">
                                                <div class="text-o">
                                                    <a href="/account/process-applications/<?= $accept['app_id']; ?>" class="over-bttn ob1">View Application</a>
                                                </div>
                                            </div>
                                            <div class="hr-com-jobs">
                                                <div class="row ">
                                                    <div class="col-md-12 col-sm-12 minus-15-pad">
                                                        <div class=" j-grid"> 
                                                            <a  href="/internship/<?= $accept['slug']; ?>" title="">VIEW INTERNSHIP</a>
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
                                        <div class="">There are no Internships to show.</div>
                                        <div class="">You haven't any accepted internship.</div>
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
</section>
<?php
$this->registerCss('
.merge-name-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding:0 10px;
}
.cat-icon img {
    width: 30px;
    min-width: 30px;
    height: 30px;
    object-fit: contain;
    margin-right:5px;
}
.hr-com-icon img {
//    border-radius: 50% !important;
    object-fit: contain;
    overflow: hidden;
}
.hr-com-name.job-title-name {
    padding: 0;
}
.j-grid > a {
    font-family: Open Sans;
    font-size: 11px;
    color: #00a0e3;
    border: 1px solid #00a0e3;
    -webkit-border-radius: 20px !important;
    -moz-border-radius: 20px !important;
    -ms-border-radius: 20px !important;
    -o-border-radius: 20px !important;
    border-radius: 20px !important;
    margin:0 0 10px 0;
    padding: 6px 12px;  
}
.topic-con{
    position:relative;
}
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
.hr-com-field{height:22px;}
.overlay2 {
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
.topic-con:hover .overlay2 {
  height: 79%;
  border-radius:10px 10px 0px 0px !important;
}
.text-o {
    font-size: 14px;
    line-height:280px;
}
button.over-bttn, .ob1, button.over-bttn, .ob2{
    background:#00a0e3 !important; 
    border:2px solid #00a0e3; 
    border-radius:5px !important;
    padding:6px 12px;
    color:#fff;
    font-family:roboto;
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
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; padding-bottom:0px; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:20px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; max-width:100px;  max-height:100px; }
.hr-com-name{color:#00a0e3; padding-top:10px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px; font-weight:bold;font-size:14px; color:#080808;}
.hr-com-jobs{font-size:13px; color:#080808; padding:10px 0 10px; 
              margin-top:10px; border-top:1px solid #eef1f5;}            
//.pad-top-10{padding-top:10px;}
.minus-15-pad{padding-left:0px !important; padding-right:0px !important;}
//.com-load-more-btn{text-align:center; padding-top:30px; }
a:hover{
    text-decoration:none;
}
');
$script = <<<JS

        $(document).on("click", ".rmv_list", function() {
        var data = $(this).val();
        $.ajax({
        url : '/account/internships/cancel-application',
        method : 'post',
        data : {data:data},
        beforeSend: function()
            {
                $(".loader").css("display", "block");
            },
        success : function(data){
                   if(data==true){
                        $(".loader").css("display", "none");
                        $.pjax.reload({container: '#pjax_shortlist', async: false});
                    }
                },
           });
        });
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

function used_for($n) {
    switch ($n) {
        case 1:
            $a = 'Jobs';
            break;
        case 2:
            $a = 'Internships';
            break;
        case 3:
            $a = 'Training Programs';
            break;
        default:
            $a = 'NA';
    }
    return $a;
}
