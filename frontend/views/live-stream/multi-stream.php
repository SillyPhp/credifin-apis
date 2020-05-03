<?php
use yii\helpers\Url;
Yii::$app->view->registerJs('var tokenId = "' . $tokenId . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var uid = "' . $uid . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var base_url = "' . Url::base('https') . '"', \yii\web\View::POS_HEAD);
?>
<style data-jss="" data-meta="MuiTooltip">
    .MuiTooltip-popper {
        top: 0;
        flip: false;
        left: 0;
        z-index: 1500;
        position: absolute;
        pointer-events: none;
    }
    .MuiTooltip-popperInteractive {
        pointer-events: auto;
    }
    .MuiTooltip-tooltip {
        color: #fff;
        padding: 4px 8px;
        font-size: 0.625rem;
        max-width: 300px;
        word-wrap: break-word;
        font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Roboto\", \"Oxygen\", \"Ubuntu\", \"Cantarell\", \"Fira Sans\", \"Droid Sans\", \"Helvetica Neue\", sans-serif;
        font-weight: 500;
        line-height: 1.4em;
        border-radius: 4px;
        background-color: rgba(97, 97, 97, 0.9);
    }
    .MuiTooltip-touch {
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.14286em;
    }
    .MuiTooltip-tooltipPlacementLeft {
        margin: 0 24px ;
        transform-origin: right center;
    }
    @media (min-width:600px) {
        .MuiTooltip-tooltipPlacementLeft {
            margin: 0 14px;
        }
    }
    .MuiTooltip-tooltipPlacementRight {
        margin: 0 24px;
        transform-origin: left center;
    }
    @media (min-width:600px) {
        .MuiTooltip-tooltipPlacementRight {
            margin: 0 14px;
        }
    }
    .MuiTooltip-tooltipPlacementTop {
        margin: 24px 0;
        transform-origin: center bottom;
    }
    @media (min-width:600px) {
        .MuiTooltip-tooltipPlacementTop {
            margin: 14px 0;
        }
    }
    .MuiTooltip-tooltipPlacementBottom {
        margin: 24px 0;
        transform-origin: center top;
    }
    @media (min-width:600px) {
        .MuiTooltip-tooltipPlacementBottom {
            margin: 14px 0;
        }
    }
</style>
<style data-jss="" data-meta="makeStyles">
    .jss1 {
        height: 150px;
        display: flex;
        z-index: 10;
        align-items: center;
        justify-content: center;
    }
    .jss2 {
        width: 50px;
        cursor: pointer;
        height: 50px;
        border-radius: 26px;
        background-size: 50px;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .jss3 {
        flex: 1;
        display: flex;
        justify-content: space-evenly;
    }
    .jss4 {
        flex: 1;
        display: flex;
        justify-content: center;
    }
    .jss5 {
        width: 100%;
        height: 100%;
        display: flex;
        position: absolute;
        flex-direction: column;
        justify-content: flex-end;
    }
    .stream-uid
    {
        padding: 0px !important;
    }

    #child_remote,#parent_remote {
        position: absolute;
        width: 100vw;
        height: 100vh;
    }

    .fade_red{background-color: #dc3545;}
        #notification {
        z-index: 999;
        position: absolute;
        top: 0;
        left: 0;
    }
        #loader
        {display: none}
    .toast-color {
        color: white;
        background-color: #33b5e5;
    }
</style>
<div class="toast toast-color" id="notification"
     data-delay="3000">
    <div class="toast-header toast-color">
        <strong class="mr-auto">Copied!</strong>
        <small>Just Now</small>
        <button type="button" class="ml-2 mb-1 close"
                data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="toast-body">
       Your Sharing Link Has Copied
    </div>
</div>
<div id="root">
    <div class="meeting">
        <div class="current-view">
            <div class="nav">
                <div></div>
                <div class="quit" id="exit-btn"></div>
            </div>
            <div class="jss5">
                <div class="jss1">
                    <i class="jss2 margin-right-19 mute-video" id="video-btn" title="mute-video"></i>
                    <i class="jss2 margin-right-19 mute-audio" id="mic-btn" title="mute-audio"></i>
                    <span class="jss2 share-link" title="share audience link">

                    </span>
                </div>
            </div>
            <div class="flex-container">
                <div class="grid-layout position-related">
                    <div class="stream-player cover-media grid-player " style="grid-area: 1 / 1 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 1 / 2 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 1 / 3 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 2 / 1 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 2 / 2 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 2 / 3 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 3 / 1 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 3 / 2 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 3 / 3 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 3 / 4 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 3 / 5 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 4 / 1 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 4 / 2 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 4 / 3 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 4 / 4 / auto / auto;"></div>
                    <div class="stream-player cover-media grid-player " style="grid-area: 4 / 5 / auto / auto;"></div>
                </div>
                <div class="grid-layout z-index-5" id="full-screen-video">

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="share_link_aud" value="<?= Url::base('https').'/live-stream/audience/'.$tokenId?>">
<?php
$script = <<< JS
executeAll();   
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
        console.log(channel_name);
        console.log(access_token);
        addScript("/assets/themes/ey/broadcast/js/multi-broadcast-script.js");
       }
       else 
       {
        alert("Authentication Failed");
       }
      },  
    })  
}
} 
  function copyToClipboard(element) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(element).val()).select();
        document.execCommand("copy");
        temp.remove();
        $('.toast').toast('show');
    }
    $(document).on("click",".share-link",function(e)
    {
        copyToClipboard("#share_link_aud");
    });
JS;
$this->registerJs($script);
$this->registerCssFile('https://webdemo.agora.io/agora-web-showcase/examples/17-Multistream/static/css/main.419b49bd.chunk.css');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.1.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
