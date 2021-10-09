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
                            <span class="caption-subject font-dark bold uppercase">Saved Jobs</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <?php
                            Pjax::begin(['id' => 'pjax_shortlist']);
                            $total_applications = count($shortlisted);
                            if (!empty($shortlisted)) {
                                foreach ($shortlisted as $shortlist) {
                                    ?>
                                    <div class="col-md-3 hr-j-box">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <div class="hr-com-icon">
                                                    <?php
                                                    if($shortlist['unclaimed_organization_enc_id'] != null){
                                                        if ($shortlist['unclaim_org_logo']) {
                                                            $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $shortlist['unclaim_org_logo_location'] . DIRECTORY_SEPARATOR . $shortlist['unclaim_org_logo'];
                                                        } else {
                                                            $organizationLogo = "https://ui-avatars.com/api/?name=" . $shortlist['unclaim_org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $shortlist['unclaim_org_initials_color']) . "&color=ffffff";
                                                        }
                                                    }else {
                                                        if ($shortlist['logo']) {
                                                            $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $shortlist['logo_location'] . DIRECTORY_SEPARATOR . $shortlist['logo'];
                                                        } else {
                                                            $organizationLogo = "https://ui-avatars.com/api/?name=" . $shortlist['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $shortlist['initials_color']) . "&color=ffffff";
                                                        }
                                                    }
                                                    ?>
                                                    <img src="<?= $organizationLogo ?>" class="img-responsive ">
                                                </div>
                                                <div class="hr-com-name job-title-name">
                                                    <?= (($shortlist['org_name']) ? $shortlist['org_name'] : $shortlist['unclaim_org_name']); ?>
                                                </div>
                                                <div class="merge-name-icon">
                                                    <div class="cat-icon">
                                                        <img src="<?= Url::to('@commonAssets/categories/' . $shortlist["icon"]); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-field">
                                                        <?= $shortlist['name']; ?>
                                                    </div>
                                                </div>
                                                <div class="opening-txt">
                                                    <?php
                                                    if($shortlist['positions'] || $shortlist['unclaim_positions']){
                                                        ?>
                                                        <?= (($shortlist["positions"]) ? $shortlist['positions'] : $shortlist['unclaim_positions']); ?> Openings
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="overlay2">
                                                    <div class="text-o">
<!--                                                        <a class="over-bttn ob2 hover_short" href="/job/--><?//= $shortlist['slug']; ?><!--">Apply</a>-->
                                                        <?php if($shortlist['applied_application_enc_id']){?>
                                                            <a class="over-bttn ob2" disabled="disabled">Applied</a>
                                                        <?php }else{?>
                                                            <a href="/job/<?= $shortlist['slug']; ?>" class="over-bttn ob2 hover_short apply-btn">Apply</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="hr-com-jobs">
                                                    <div class="row ">
                                                        <div class="col-md-12 col-sm-12 minus-15-pad">
                                                            <div class=" j-cross">
                                                                <button class="rmv_list"
                                                                        value="<?= $shortlist['application_enc_id']; ?>">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                            <div class=" j-grid">
                                                                <a href="/job/<?= $shortlist['slug']; ?>" title="">VIEW
                                                                    JOB</a>
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
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>"
                                                 class="img-responsive" alt=""/>
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
    width:100%;
    border-radius:2px;
    text-align: center;
    font-size:18px;     
    color:#fff;
    text-transform: uppercase;
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
.text-o {
    color:#fff ;
    font-size: 15px;
    line-height:280px;
    left: 0%;
    white-space: nowrap;
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
.hr-com-jobs {
    padding: 20px 0px 0px 0px !important;
    text-align: center;
}
.opening-txt {
    padding-top: 2px;
    padding-bottom: 10px;
    font-size: 14px;
    color: #080808;
    height:31px;
}
');
$script = <<<JS
   
         $(document).on("click", ".rmv_list", function() {
                var rmv_id = $(this).val();
                $.ajax({
                url : '/account/jobs/shortlist-delete',
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
