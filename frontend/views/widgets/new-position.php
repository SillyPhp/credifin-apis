<?php
use yii\helper\url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="new-position-box">
            <div class="npb-pos-abso">
                <div class="npb-main-heading">
                    Don't see a position that strikes your <span>fancy</span> ?
                </div>
                <div class="npb-text">
                    Empower Youth is always looking for great talent. Go ahead and send an application!
                </div>
                <div class="npb-btn">
                    <button type="button" class="fab-message-open">Apply</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$this->registerCss('
.new-position-box{
    min-height:300px;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    position:relative;
    padding:15px;
    text-align:center;
    border-radius:5px;
}
.new-position-box::before{
    content:"";
    position:absolute;
    bottom:0px;
    left:50%;
    border:1px solid;
    border-color:#00a0e3;
    transform:translateX(-50%);
//    border-left:1px solid #00a0e3;
//    border-bottom:1px solid #00a0e3;
//    background:#00a0e3;
    height:2px;
    width:100px;
}
.npb-pos-abso{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    width:100%;
}
.npb-main-heading{
    fort-family:lora;
    font-weight:bold;
    font-size:18px;
    line-height:23px;
}
.npb-main-heading span{
    color:#00a0e3;
}
.npb-text{
    font-family: roboto;
    font-size:15px;
    line-height:20px;
    padding-top:20px;
    color:#000;
}
.npb-btn{
    padding-top:10px;
    
}
.npb-btn button{
    color:#fff;
    background:#00a0e3;
    border:none;
    padding:10px 15px;
    border-radius:5px;
    text-transform: uppercase;
    font-size:14px;
}
');

$r = [
    'username' => Yii::$app->user->identity->username,
    'type'=> 'career'
];
$result = json_encode($r);

\Yii::$app->view->registerJs('var result = '. $result ,  \yii\web\View::POS_HEAD);
$script = <<< JS
$(document).on('click', '.fab-message-open', function() {
    $('#fab-message-open').trigger('click');
});
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_add_resume.js');
$this->registerJsFile('/assets/themes/dropresume/main.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');


?>
