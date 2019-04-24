
<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="loader"><img src='https://image.ibb.co/c0WrEK/check1.gif'/></div>
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
                                                <img src="<?= Url::to('@commonAssets/categories/' . $review["icon"]); ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                <?= $review['org_name']; ?>
                                            </div>
                                            <div class="opening-txt">
                                                <?= $review["positions"]; ?> Openings
                                            </div>
                                            <div class="overlay2">
                                                <div class="text-o"><a class="over-bttn ob2 hover_short" href="/internship/<?= $review['slug']; ?>">Apply</a></div>
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
    margin:10px 0;
    padding: 6px 12px;  
}
.loader
{
    display:none;
//    width:100px;
//    height:100px;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
//.job-grid > a:hover {
//    background: #00a0e3 !important;
//    color: #ffffff;
//    transition: all 0.4s ease 0s;
//    text-decoration:none;
//}                                
//.dashboard-button a, .dashboard-button button{    
//    margin-left:10px !important;
//}
//.intl-tel-input {
//    width: 100%;
//}
.rmv_list {
    position: absolute;
    top: 0;
    left: 20px;
}
//.thumbnail{
//    padding: 0px !important;
//    margin: 20px auto 25px auto !important;
//}
//.thumbnail img{
//    width: 100%;
//    height: 100%;
//}
//.js-title-step span{
//    display:none;
//}
//.custom-buttons{
//    width:100%;
//    font-size: 10px !important;
//    padding: 8px 0px !important;
//    margin-bottom:20px;
//}
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:20px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; max-width:100px;  max-height:100px; }
.hr-com-name{color:#00a0e3; padding-top:10px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
//.hr-com-field{padding-top:2px; font-weight:bold;font-size:14px; color:#080808;}
.hr-com-jobs{font-size:13px; color:#080808; padding:10px 0 10px; 
              margin-top:10px; border-top:1px solid #eef1f5;}            
//.pad-top-10{padding-top:10px;}
.minus-15-pad{padding-left:0px !important; padding-right:0px !important;}
//.com-load-more-btn{text-align:center; padding-top:30px; }
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
  background: rgba(208, 208, 208, 0.5);
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
    background:#00a0e3 !important; 
    border:2px solid #00a0e3; 
    border-radius:5px !important;
    padding:6px 12px;
    color:#fff;
}
button.over-bttn, .ob2{
    background:#ff7803 !important; 
}
//.btn.btn-outline.orange {
//    border-color: #ff7803;
//    color: #ff7803;
//    background: 0 0;
//}
//.btn.btn-outline.orange.active, .btn.btn-outline.orange:active, .btn.btn-outline.orange:active:focus, .btn.btn-outline.orange:active:hover, .btn.btn-outline.orange:focus, .btn.btn-outline.orange:hover {
//    border-color: #ff7803;
//    color: #fff;
//    background-color: #ff7803;
//}
//.manage-jobs-sec > h3 {
//    float: left;
//    width: 100%;
//    margin-top: 40px;
//    font-size: 20px;
//    color: #202020;
//    font-weight: bold;
//    margin: 0;
//    margin-top: 0px;
//    padding-bottom: 20px;
//    padding-left: 30px;
//    margin-top: 40px;
//}
//.manage-jobs-sec {
//    float: left;
//    width: 100%;
//    padding:20px 10px;
//}
//.manage-jobs-sec .extra-job-info {
//    border: 2px solid #e8ecec;
//    padding: 20px 30px;
//    margin-left: 30px;
//    
//    -webkit-border-radius: 8px;
//    -moz-border-radius: 8px;
//    -ms-border-radius: 8px;
//    -o-border-radius: 8px;
//    border-radius: 8px;
//
//}
//.manage-jobs-sec .extra-job-info > span {
//    float: left;
//    width: 32.334%;
//    padding: 0;
//    border: none;
//    margin: 0;
//}
//.manage-jobs-sec > table {
//    float: left;
//    width: calc(100% - 30px);
//    margin-top: 50px;
//    margin-bottom: 60px;
//    margin-left: 30px
//}
//.manage-jobs-sec > table thead tr td {
//    font-size: 15px;
//    font-weight: bold;
//    color: #fb236a;
//    padding-bottom: 14px;
//}
//.manage-jobs-sec > table thead {
//    border-bottom: 1px solid #e8ecec;
//} 
//.cat-sec {
//    float: left;
//    width: 100%;
//}
//.p-category {
//    float: left;
//    width: 100%;
//    z-index: 1;
//    position: relative;
//}
//.p-category > a {
//    float: left;
//    width: 100%;
//    text-align: center;
//    padding-bottom: 30px;
//    border-bottom: 1px solid #e8ecec;
//    border-right: 1px solid #e8ecec;
//}
//.p-category > a i {
//    float: left;
//    width: 100%;
//    color: #00a0e3;
//    font-size: 40px;
//   margin:50px 0 0 0 !important;
//}
//.p-category > a span {
//    float: left;
//    width: 100%;
//    font-family: Open Sans;
//    font-size: 15px;
//    color: #202020;
//    margin-top: 18px;
//}
//.p-category > a p {
//    float: left;
//    width: 100%;
//    font-size: 13px;
//    margin: 0;
//        margin-top: 0px;
//    margin-top: 3px;
//}
//.cat-sec .row > div:last-child a {
//    border-right-color: #ffffff;
//}
//.cat-sec:last-child a {
//    border-bottom-color: #ffffff;
//}
//.p-category:hover a {
//    border-color: #ffffff;
//    transition: .3s all;
//    -webkit-transition: .3s all;
//    -moz-transition: .3s all;
//    -o-transition: .3s all;
//}
//.p-category:hover {
//    background: #ffffff;
//      transition: .2s all;
//    -webkit-transition: .2s all;
//    -moz-transition: .2s all;
//    -o-transition: .2s all;
//    
//    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
//    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
//    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
//    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
//    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
//
//    
//    -webkit-border-radius: 8px;
//    -moz-border-radius: 8px;
//    -ms-border-radius: 8px;
//    -o-border-radius: 8px;
//    border-radius: 8px;
//
//   width: 104%; 
//   margin-left: -2%;
//   height: 102%;
//   z-index: 10;
//
//}
//.row.no-gape{
//  margin: 0;
//}
//.row.no-gape > div{
//  padding: 0;
//}
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
//.viewall-jobs {
//    background: #00a0e3;
//    padding:5px 15px;
//    color: #ffffff !important;
//    font-family: Open Sans;
//    font-size: 13px;
//    
//    -webkit-border-radius: 40px !important;
//    -moz-border-radius: 40px !important;
//    -ms-border-radius: 40px !important;
//    -o-border-radius: 40px !important;
//    border-radius: 40px !important;
//}
//.viewall-jobs:hover {
//    -webkit-border-radius: 8px !important;
//    -moz-border-radius: 8px !important;
//    -ms-border-radius: 8px !important;
//    -o-border-radius: 8px !important;
//    border-radius: 8px !important;
//    color: #ffffff;
//   
//    transition:.3s all;
//    -webkit-transition:.3s all;
//    -moz-transition:.3s all;
//    -ms-transition:.3s all;
//    -o-transition:.3s all;
//    
//}
');
$script = <<<JS
                                    
//        $(document).on("click", "#uploadcv", function () {
//            $(".load-modal").load($(this).attr("url"));
//        });   
    
        $(document).on("click", ".rmv_list", function() {
        var rmv_id = $(this).val();
//        console.log(rmv_id);
        $.ajax({
        url : '/account/internships/review-delete',
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