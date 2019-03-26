<?php
use yii\helpers\Url;
?>
    <div id="fab-message-open" class="fab-message" style="">
        <img src="<?= Url::to('@eyAssets/images/pages/company-profile/CVbox2.png') ?>">
        <div class="fab-hover-message" style="">
            <div class="fab-hover-image">
                <img src="<?= Url::to('@eyAssets/images/pages/company-profile/cv.png') ?>">
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.fab-message{
    position:fixed;
    bottom: 20px;
    cursor:pointer;
    right:20px;
    z-index:9999;
    color: #fff;
    font-size: 20px;
    border-radius: 50%;
    width:100px;
    height:80px;
    line-height: 60px;
    text-align: center;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}
#fab-message-open:hover .fab-hover-message{
  -webkit-animation-name: example1; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
    -webkit-animation-iteration-count: infinite; /* Safari 4.0 - 8.0 */
    animation-name: example1;
    opacity:1;
    animation-duration: 2s;
    animation-iteration-count: 2;
}
@-webkit-keyframes example1 {
  0%   { right:6px; bottom:120px;}
  100%  { right:6px; bottom:55px;}
}
@keyframes example1{
  0%   {right:6px; bottom:120px;}
  100%  {right:6px; bottom:55px;}
}
.fab-hover-message{
    bottom: 120px;
    right: 6px;
    color:#222;
    opacity: 0; 
    position: absolute;
    font-size: 18px; 
    padding: 15px;
     border-radius: 3px;
     z-index:9; 
}

.fab-hover-image img{
    width:85px;
    height:85px;
}
.i-review-question-title{
    color:#fff;
}
.i-review-box{
    color:#fff;
}
.up-btn{
    color:#000000b3;
   border: solid 2px #212529;
   background-color: transparent;
   padding: 15px 30px;
   cursor: pointer;
   font-weight: bold;
   font-size: 16px;
   outline: none;
   font-family: inherit;
   position: relative;
   -webkit-transition: color 500ms linear;
   -moz-transition: color 500ms linear;
   -o-transition: color 500ms linear;
   transition: color 500ms linear;
}

.up-btn::after {
   content: \'\';
   position: absolute;
   left: 0;
   top: 0;
   bottom: 0;
   width: 0;
   z-index: 0;
   background-color: #212529;
   -webkit-transition: width .3s cubic-bezier(1, 0, 0, 1);
   -moz-transition: width .3s cubic-bezier(1, 0, 0, 1);
   -o-transition: width .3s cubic-bezier(1, 0, 0, 1);
   transition: width .3s cubic-bezier(1, 0, 0, 1);
}
.up-btn:hover{
    color:#fff;
}
.up-btn:hover:focus{
    width:100%;
}
');


$r = [
        'username' => $username
];
$result = json_encode($r);

\Yii::$app->view->registerJs('var result = '. $result ,  \yii\web\View::POS_HEAD);

$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_add_resume.js');
$this->registerJsFile('/assets/themes/dropresume/main.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);



