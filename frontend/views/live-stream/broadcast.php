<?php
use yii\helpers\Url;
Yii::$app->view->registerJs('var tokenId = "' . $tokenId . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var base_url = "' . Url::base('https') . '"', \yii\web\View::POS_HEAD);
?>
<div id="content_main">
    <div class="container-fluid p-0">
        <div id="main-container">
            <div id="buttons-container" class="row justify-content-center mt-3">
                <div id="audio-controls" class="col-md-2 text-center btn-group">
                    <button id="mic-btn" type="button" class="btn btn-block btn-dark btn-lg">
                        <i id="mic-icon" class="fas fa-microphone"></i>
                    </button>
                    <button id="mic-dropdown" type="button" class="btn btn-lg btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div id="mic-list" class="dropdown-menu dropdown-menu-right">
                    </div>
                </div>
                <div id="video-controls" class="col-md-2 text-center btn-group">
                    <button id="video-btn"  type="button" class="btn btn-block btn-dark btn-lg">
                        <i id="video-icon" class="fas fa-video"></i>
                    </button>
                    <button id="cam-dropdown" type="button" class="btn btn-lg btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div id="camera-list" class="dropdown-menu dropdown-menu-right">
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <button id="exit-btn"  type="button" class="btn btn-block btn-danger btn-lg">
                        <i id="exit-icon" class="fas fa-phone-slash"></i>
                    </button>
                </div>
            </div>
            <div id="full-screen-video"></div>
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
else{executeAll();}
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
        addScript("/assets/themes/ey/broadcast/js/broadcast-script.js");
        addCssFile("/assets/themes/ey/broadcast/css/style.css");
       }
       else 
       {
        alert("Authentication Failed");
       }
      },  
    })  
}
$("#mic-btn").prop("disabled", true);
$("#video-btn").prop("disabled", true);
$("#screen-share-btn").prop("disabled", true);
$("#exit-btn").prop("disabled", true);
$("#add-rtmp-btn").prop("disabled", true);
} 
');
$this->registerCssFile('https://use.fontawesome.com/releases/v5.7.0/css/all.css');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css');
//$this->registerJsFile('https://cdn.agora.io/sdk/web/AgoraRTCSDK-2.8.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.6.5.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
