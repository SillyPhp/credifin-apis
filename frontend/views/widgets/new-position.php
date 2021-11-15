<?php

use yii\helpers\Url;
if(!$company){
    $company = 'Empower Youth';
}
?>
<div class="new-position-box">
    <div class="drop-im">
        <div class="imm1">
            <img src="<?= Url::to('@eyAssets/images/pages/employers/send-application-s1.png') ?>">
        </div>
        <div class="imm2">
            <img src="<?= Url::to('@eyAssets/images/pages/employers/send-application-s2.png') ?>">
        </div>
    </div>
    <div class="npb-pos-abso">
        <div class="npb-main-heading">
            Don't see a position that strikes your <span>fancy</span> ?
        </div>
        <div class="npb-text">
            <strong><?= $company ?></strong> is always looking for great talent. Go ahead & drop your Resume.
        </div>
        <div class="npb-btn">
            <button type="button" class="fab-message-open">Apply Now</button>
        </div>
    </div>
</div>

<?php

$this->registerCss('
.new-position-box{
    min-height:300px;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    padding:15px;
    text-align:center;
    border-radius:5px;
    position:relative;
    overflow:hidden;
    margin-bottom:20px;
}
.imm1 {
	position: absolute;
	bottom: 0;
	right: 0;
	text-align: right;
}
.imm2 {
	position: absolute;
	top: 0;
	left: 0;
	text-align: left;
}
.imm1 img, .imm2 img {
	width: 80%;
}
//.new-position-box::before{
//    content:"";
//    position:absolute;
//    bottom:0px;
//    left:50%;
//    border:1px solid;
//    border-color:#00a0e3;
//    transform:translateX(-50%);
////    border-left:1px solid #00a0e3;
////    border-bottom:1px solid #00a0e3;
////    background:#00a0e3;
//    height:2px;
//    width:100px;
//}
.npb-pos-abso{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    width:100%;
}
.npb-main-heading{
    font-family:lora;
    font-weight:bold;
    font-size:24px;
    line-height:23px;
}
.npb-main-heading span{
    color:#00a0e3;
}
.npb-text{
    font-family: roboto;
    font-size:14px;
    line-height:20px;
    padding:20px 5px 0 5px;
    color:#000;
}
.npb-btn{
    padding-top:10px;
    
}
.npb-btn button{
    color:#fff;
    background:#0036b4;
    font-family:roboto;
    font-weight:500;
    border:none;
    padding:10px 24px;
    border-radius:5px;
    text-transform: uppercase;
    font-size:14px;
}
');

$r = [
    'username' => Yii::$app->user->identity->username,
    'type' => 'company'
];
$result = json_encode($r);

\Yii::$app->view->registerJs('var result = ' . $result, \yii\web\View::POS_HEAD);
$script = <<< JS
$(document).on('click', '.fab-message-open', function() {
    $('#fab-message-open').trigger('click');
});
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_drop_resume.js');
$this->registerJsFile('/assets/themes/dropresume/main.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');


?>
