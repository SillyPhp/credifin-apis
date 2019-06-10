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
                            <span class="caption-subject font-dark bold uppercase">Shortlisted Internships</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <?php
                            Pjax::begin(['id' => 'pjax_shortlist']);
                            $total_applications = count($shortlisted);
                            if(!empty($shortlisted)) {
                                foreach ($shortlisted as $shortlist) {
                                    ?>
                                    <div class="col-md-3 hr-j-box">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <div class="hr-com-icon">
                                                    <img src="<?= Url::to('@commonAssets/categories/' . $shortlist["icon"]); ?>" class="img-responsive ">
                                                </div>
                                                <div class="hr-com-name">
                                                    <?= $shortlist['org_name']; ?>
                                                </div>
                                                <div class="hr-com-field">
                                                    <?= $shortlist['name']; ?>
                                                </div>
                                                <div class="opening-txt">
                                                    <?= $shortlist["positions"]; ?> Openings
                                                </div>
                                                <div class="overlay2">
                                                    <div class="text-o"><a class="over-bttn ob2 hover_short" href="/internship/<?= $shortlist['slug']; ?>">Apply</a></div>
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
                                                                <a  href="/internship/<?= $shortlist['slug']; ?>" title="">VIEW INTERNSHIP</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else {
                                ?>
                                <div class="col-md-12">
                                    <div class="tab-empty">
                                        <div class="tab-empty-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                        </div>
                                        <div class="tab-empty-text">
                                            <div class="">There are no Internships to show.</div>
                                            <div class="">You haven't Select any internships for review.</div>
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
.loader{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
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
.j-grid > a {
    font-family: Open Sans;
    font-size: 11px;
    color: #00a0e3;
    border: 1px solid #00a0e3;
    -webkit-border-radius: 20px !important;
    -moz-border-radius: 20px !important;
    -ms-border-radius: 20px !important;
    -o-border-radius: 20px !important;
    border-radius: 4px !important;
    margin:15px 0;
    padding: 6px 12px;  
}
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:10px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; width:100px; height:100px; }
.hr-com-name{color:#00a0e3; padding-top:20px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px;font-size:14px; color:#080808;}
.hr-com-jobs {
    font-size: 13px;
    color: #080808;
    padding: 10px 0 10px;
    margin-top: 10px;
    border-top: 1px solid #eef1f5;
}       
a:hover{
    text-decoration:none;
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
.topic-con:hover .overlay, .topic-con:hover .overlay1,.topic-con:hover .overlay2 {
  height: 80%;
  border-radius:10px 10px 0px 0px !important;
}
button.over-bttn, .ob2{
    background:#ff7803 !important; 
    border:2px solid #ff7803; 
    border-radius:5px !important;
    padding:8px 13px; 
    text-tansform:uppercase;
    color:#fff;
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
.overlay2 {
  position: absolute;
  top: 0px;
  left: 0;
  right: 0;
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
  background: rgba(208, 208, 208, 0.5);
 
}
.j-cross{
    text-align: left;
    margin-bottom: -38px !important;
    padding-left: 0px !important;
    margin-left: -17px;
}
.j-cross button{
    padding: 7px 12px;
    border-radius: 0px 12px 0px 0px !important;;
    background: transparent;
    border-top: 2px solid #eef1f5;
    margin-left: 6px;
    border-right: 2px solid #eef1f5;
    border-bottom: none;
    color: #999999;
    font-size:16px;
    border-left: none; 
    transition:.1s ease-in-out;
     transition:.3s ease-in-out;
    -webkit-transition:.3s ease-in-out;
    -moz-transition:.3s ease-in-out;
    -o-transition:.3s ease-in-out;
}
.j-cross button:hover{
    border:1px solid transparent;
    color:#fff;
    margin-left:5px;
    border-radius:50px !important; 
    background:#00a0e3 !important; 
    transition:.3s ease-in-out;
    -webkit-transition:.3s ease-in-out;
    -moz-transition:.3s ease-in-out;
    -o-transition:.3s ease-in-out;
}
.j-cross button:focus{
    outline:none;
}
.opening-txt {
    padding-top: 2px;
    padding-bottom: 10px;
    font-size: 14px;
    color: #080808;
}
');
$script = <<<JS
       $(document).on("click", ".rmv_list", function() {
                var rmv_id = $(this).val();
                $.ajax({
                url : '/account/internships/shortlist-delete',
                method : 'post',
                data : {rmv_id:rmv_id},
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