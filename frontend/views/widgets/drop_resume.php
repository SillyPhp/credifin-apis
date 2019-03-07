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

    <div class="empty-field">
        <input type="hidden" id="loggedIn" value="<?= (!Yii::$app->user->isGuest) ? 'yes' : '' ?>">
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p>Please Login to your empower youth profile or Sign Up </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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
');



//$resultantjs['job_profile'] = json_encode($jobProfile);
//$resultantjs['job_title'] = json_encode($jobTitle);
//$resultantjs['location']=json_encode($location);
//
//$result = json_encode($resultantjs);
//
//Yii::$app->view->registerJs('var result = '. $result ,  \yii\web\View::POS_HEAD);

$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_add_resume.js');
$this->registerJsFile('/assets/themes/dropresume/main.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');





