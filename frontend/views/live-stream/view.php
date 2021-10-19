<?php
use yii\helpers\Url;
Yii::$app->view->registerJs('var tokenId = "' . $tokenId . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var base_url = "' . Url::base('https') . '"', \yii\web\View::POS_HEAD);
?>
<div id="content_main">
    <div class="container-fluid p-0">
        <div id="full-screen-video"></div>
        <div id="watch-live-overlay">
            <div id="overlay-container">
                <div class="col-md text-center">
                    <button id="watch-live-btn" type="button" class="btn btn-block btn-xlg">
                        <i id="watch-live-icon" class="far fa-play-circle"></i>
                        <span>Click here to Watch the Live Stream</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs('
browserAccess(); 
function browserAccess()
{
if (top === self) {
     $("body").html("Access Denied");
} 
else
    {
        executeAll();
    }
}   
function executeAll(){
$("#content_main").show();
function addScript(src) {
  var s = document.createElement( "script" );
  s.setAttribute( "src", src );
  document.body.appendChild(s);
}
function addHeadScript(src) {
  var s = document.createElement( "script" );
  s.setAttribute( "src", src );
  document.head.appendChild(s);
}
function addCssFile(src)
{
var link = document.createElement("link");
link.href = src;
link.type = "text/css";
link.rel = "stylesheet";
document.head.appendChild(link);
}
getTokenVarification(tokenId);
function getTokenVarification(tokenId)
{
   $.ajax({
    method: "POST",
    url : base_url+"/api/v3/video-session/validate-tokens",
    data:{"tokenId":tokenId},
    success: function(response) { 
       if(response.response.status===true)
       {
        app_id = response.response.app_id;
        channel_name = response.response.channel_name;
        access_token = response.response.token;
        addScript("/assets/themes/ey/broadcast/js/audience-script.js");
        addCssFile("/assets/themes/ey/broadcast/css/style.css");
       }
       else
       {
        alert("Authentication Failed");
       }
      }
    })  
}
} 
');
$this->registerCssFile('https://use.fontawesome.com/releases/v5.7.0/css/all.css');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
//$this->registerJsFile('https://cdn.agora.io/sdk/web/AgoraRTCSDK-2.8.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.6.5.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>