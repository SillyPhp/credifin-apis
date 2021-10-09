
<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
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
                        <span class="caption-subject font-dark bold uppercase">Reviewed Internships</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <?php
                        Pjax::begin(['id' => 'pjax_shortlist']);
                        $total_applications = count($reviewlist);
                        if (!empty($reviewlist)) {
                            foreach ($reviewlist as $review) {
                                ?>
                                <div class="col-md-3 hr-j-box">
                                    <div class="topic-con">
                                        <div class="hr-company-box">
                                            <div class="hr-com-icon">
                                                <?php
                                                if($review['unclaimed_organization_enc_id'] != null){
                                                    $unclaimed_organization_enc_id = \common\models\UnclaimedOrganizations::findOne(['organization_enc_id' => $review['unclaimed_organization_enc_id']]);
                                                    if ($unclaimed_organization_enc_id->logo) {
                                                        $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $unclaimed_organization_enc_id->logo_location . DIRECTORY_SEPARATOR . $unclaimed_organization_enc_id->logo;
                                                    } else {
                                                        $organizationLogo = "https://ui-avatars.com/api/?name=" . $unclaimed_organization_enc_id->name . "&size=200&rounded=false&background=" . str_replace("#", "", $unclaimed_organization_enc_id->initials_color) . "&color=ffffff";
                                                    }
                                                }else {
                                                    if ($review['logo']) {
                                                        $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $review['logo_location'] . DIRECTORY_SEPARATOR . $review['logo'];
                                                    } else {
                                                        $organizationLogo = "https://ui-avatars.com/api/?name=" . $review['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $review['initials_color']) . "&color=ffffff";
                                                    }
                                                }
                                                ?>
                                                <img src="<?= $organizationLogo ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name job-title-name">
                                                <?= ((!empty($review['org_name'])) ? $review['org_name'] : $review['unclaim_org_name']); ?>
                                            </div>
                                            <div class="merge-name-icon">
                                                <div class="cat-icon">
                                                    <img src="<?= Url::to('@commonAssets/categories/' . $review["icon"]); ?>"
                                                         class="img-responsive ">
                                                </div>
                                                <div class="hr-com-field">
                                                    <?= $review['title']; ?>
                                                </div>
                                            </div>
                                            <div class="opening-txt">
                                                <?php
                                                if($review['positions'] || $review['unclaim_positions']){
                                                    ?>
                                                    <?= (($review['positions']) ? $review['positions'] : $review['unclaim_positions']); ?> Openings
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="overlay2">
                                                <div class="text-o">
                                                    <?php if($review['applied_application_enc_id']){?>
                                                        <a class="over-bttn ob1" disabled="disabled">Applied</a>
                                                    <?php }else{?>
                                                        <a href="/internship/<?= $review['slug']; ?>" class="over-bttn ob1 hover_short apply-btn">Apply</a>
                                                    <?php } ?>
                                                    <a class="over-bttn ob2 shortlist"
                                                       id="<?= $review['slug']; ?>" data-key="<?= $review['application_enc_id']; ?>">
                                                        <span class="hover-change"><i class="fa fa-heart-o"></i> Shortlist</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="hr-com-jobs">
                                                <div class="row ">
                                                    <div class="col-md-12 col-sm-12 minus-15-pad">
                                                        <div class=" j-cross">
                                                            <button class="rmv_list" value="<?= $review['application_enc_id']; ?>">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <div class=" j-grid">
                                                            <a  href="/internship/<?= $review['slug']; ?>" title="">VIEW INTERNSHIP</a>
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
                                        <div class="">You haven't Select any internships  for review.</div>
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
.hr-com-field{height:22px;}
.opening-txt {
    padding-top: 2px;
    padding-bottom: 10px;
    font-size: 14px;
    color: #080808;
    height:31px;
}
.hr-company-box{padding: 20px 0px !Important;padding-bottom:0px !Important;}
.hr-com-jobs{margin-top:0px !important;padding: 10px 0 0px !Important;}
.j-cross button{margin-left:0px !Important;}
.rmv_list {
    position: absolute;
    top: 0;
    left: 20px;
}
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:20px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; max-width:100px;  max-height:100px; }
.hr-com-name{color:#00a0e3; padding-top:10px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-jobs{font-size:13px; color:#080808; padding:10px 0 10px; 
              margin-top:10px; border-top:1px solid #eef1f5;}
.minus-15-pad{padding-left:0px !important; padding-right:0px !important;}
a:hover{
    text-decoration:none;
}
.topic-con{
    position:relative;
}
.text-o {
    font-size: 14px;
    line-height:280px;
}
.overlay, .overlay1, .overlay2 {
  position: absolute;
  top: 0px;
  left: 0;
  right: 0;
  background: rgb(64 63 63 / 50%);;
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
}
.topic-con:hover .overlay, .topic-con:hover .overlay1,.topic-con:hover .overlay2 {
  height: 80%;
  border-radius:10px 10px 0px 0px !important;
}
button.over-bttn, .ob1, button.over-bttn, .ob2{
    background:#00a0e3; 
    border:1px solid #00a0e3; 
    border-radius:4px !important;
    padding:6px 12px;
    color:#fff;
    font-family:roboto;
}
button.over-bttn, .ob2{
    background:#ff7803 !important; 
    border: 1px solid #ff7803;
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
');
$script = <<<JS
    
        $(document).on("click", ".rmv_list", function() {
        var rmv_id = $(this).val();
        $.ajax({
        url : '/account/internships/review-delete',
        method : 'post',
        data : {rmv_id:rmv_id},
        beforeSend: function()
            {
                // $(".loader").css("display", "block");
            },
        success : function(data){
                   if(data==true){
                        // $(".loader").css("display", "none");
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