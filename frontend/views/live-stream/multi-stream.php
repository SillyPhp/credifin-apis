<?php
use yii\helpers\Url;
Yii::$app->view->registerJs('var tokenId = "' . $tokenId . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var uid = "' . $uid . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var base_url = "' . Url::base('https') . '"', \yii\web\View::POS_HEAD);
?>
<style data-jss="" data-meta="MuiTooltip">
    #full-screen-video > div {
        border: 2px solid #5e5e77;
        margin: 3px;
        width: 250px !important;
        height: 250px !important;
        float: left;
    }
    .cs_btn
    {
        background-image: url(data:image/png;base64,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);
        color: #fff;
    }
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
    #full-screen-video {
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-items: center;
        flex: 1;
        margin: auto;
    }
    .stream-player {
        display: inline-block;
        flex: initial;
    }
    .flex-container{
        display: flex;
        position: relative;
        align-items: center;
        background-color: #666;
        height: 100vh;
        width: 100%;
        margin-right: auto;
        margin-left: auto;
    }
    .stream-player {
        grid-area: unset !Important;
    }
    @media only screen and (max-width: 500px) {
        #full-screen-video.elem1 > div{
            width: 100% !Important;
            height: 50vh !important;
            margin-top: 25vh;
        }
        #full-screen-video.elem2 > div{
            width: 99% !Important;
            height: 50vh !important;
            margin-top: 0%;
        }
        #full-screen-video.elem3 > div{
            width: 48% !Important;
            height: 50vh !important;
            margin-top: 0%;
        }
        #full-screen-video.elem3 > div:last-child{
            width: 99% !Important;
        }
        #full-screen-video.multiple > div{
            width: 50% !Important;
            height: 50vh !important;
            margin-top: 0%;
        }
    }
    @media only screen and (min-width: 1200px) {
        #full-screen-video {
            max-width: 90%;
        }
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
                    <div class="dropdown">
                        <button type="button" class="jss2 btn cs_btn margin-right-19" data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu" id="camera-list">
                        </div>
                    </div>
                    <span class="jss2 share-link" title="share audience link">
                    </span>
                </div>
            </div>
            <div class="flex-container">
                <div class="" id="full-screen-video">

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="share_link_aud" value="<?= Url::base('https').'/mentors/webinar-view?id='.$tokenId?>">
<?php
$script = <<< JS
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
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
