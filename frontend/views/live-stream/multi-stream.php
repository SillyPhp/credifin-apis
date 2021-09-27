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
    #full-screen-video.sp1 > div{
        width: 90% !Important;
        height: 90vh !important;
        margin-top: 0vh;
    }
    #full-screen-video.sp2 > div{
        width: 48% !Important;
        height: 80vh !important;
        margin-top: 0vh;
    }
    #full-screen-video.sp3 > div{
        width: 48% !Important;
        height: 48vh !important;
        margin-top: 0%;
    }
    #full-screen-video.sp3 > div:last-child{
        width: 75% !Important;
    }
    #full-screen-video.sp4 > div{
        width: 48% !Important;
        height: 48vh !important;
        margin-top: 0%;
    }
    #full-screen-video.spmultiple > div{
        width: 250px !important;
        height: 250px !important;
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
        background-color: #000;
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
            margin-top: 6vh;
        }
        #full-screen-video.sp1 {
            margin-top: auto;
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
        height: 90px;
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
    .full-vid{
        cursor: pointer;
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 10;
        padding: 5px 10px;
        background-color: #00000078;
        color: #fff;
        border-top-left-radius: 5px;
    }
    .hidden{
        display: none;
    }
    .sp1 > div .full-vid, .elem1 > div .full-vid{
        display: none;
    }
    .exit_btn
    {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAQAAADa613fAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfkCRELBQWl/E6UAAACtElEQVR42u1bS3LbMAylNd1lU89kvM81nPgTXyC9rX0Ifexk1TRHyNjZdNvXRVRGTESXlAGS4uCtLcKPAJ4IEFJKIBAIBAKBQCAQCOJg8r8fwPcBIvja/ea0aqGu1ZV6UyelEIRKS2Oqvqvf6lX9IVkSBX6gwgk7zKHwZa84aEBBYY4dTqjwgAIki85Q4R0V7jHhptLSWHaszmiI3OCIf6ix4PVKS+NO0wCOuKEhMsUOH9jjlo9KS+MW+47FLaYgWnqOsrNwgzUPFR1Udcda/Z6ZdIubVBhyxWJpQ2ZJR23TMXDAktYrOqi63njEinTD+I2E2Sx2t4cLX1sikqS99kZpeOOeTRt1gDVGgC0v2zeeVYPvXbvi4pOfV+xHIdpoZhdcb33ZD9EXHVSVEVTrIDSsYvzkK8a9hxEOwXWK7NLwikeufDnhcgrugD/iKMaXbwT3OfXRJTR6BfeJWXAHJetZKtobTWDBpRXj3ifqCLnhtL972/72+vDAVd1QHDF6I94iuIskaLhrUK/O1Yl4w/2t0Eu2iSS4w9/TlsJsGT3F/U9ONKezuGK8SVRwB1UXnyuYdbLeOJsrv/BsBNVd8jSsVWQ3qFajoGHNlXQF18krPw0aL5zeKIIynKgx4WxobZKWXY9kb0YgvVb5fTbk9zAC+XV+IaatXdbqL1yDmvHQuIIa1aHxfPVH09KLVVgZ1V9SnSyGUjclMXa/3xje0ovVDmpsf25YSy+m4Po16GKL8bB2m19LL7rg0rT0khDcy3UuluA2o7vooWm3Rb96y+QyNJPr6UwGBjIZ4chkqCaTMadMBs8yGQXMZjgzp3HZ2APMO6oB5mxGymc6sOIM+ZdUQ/4FHlDiiG3wzy62OKJ0++zC7YuezocwKtKHMBMSIj4P0FIJblcgEAgEAoFAIBAIfPEXSb0a7PgMIq0AAAAldEVYdGRhdGU6Y3JlYXRlADIwMjAtMDktMTdUMTE6MDQ6NTUrMDA6MDD7KnFTAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIwLTA5LTE3VDExOjA0OjU1KzAwOjAwinfJ7wAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAASUVORK5CYII=');
    }
    .share-screen-on {
        background-image: url('data:image/png;base64,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')
    }
    .share-screen-off
    {
        background-image: url('data:image/png;base64,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');
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
    .new_sharing
    {
        display: block !important;
        width: 100% !Important;
        height: 100% !Important;
        position: absolute !important;
        z-index: 9 !important;
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
            </div>
            <div class="jss5">
                <div class="jss1">
                    <i class="jss2 margin-right-19 mute-video" id="video-btn" title="Turn Off Video"></i>
                    <i class="jss2 margin-right-19 mute-audio" id="mic-btn" title="mute-audio"></i>
                    <div class="dropdown">
                        <button type="button" class="jss2 btn cs_btn margin-right-19" data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu" id="camera-list">
                        </div>
                    </div>
                    <i class="jss2 margin-right-19 share-screen-off" id="share-sreen-btn" title="share-screen"></i>
                    <div class="jss2 margin-right-19 exit_btn" id="exit-btn" title="End Session"></div>
<!--                    <span class="jss2 share-link" title="share audience link">-->
<!--                    </span>-->
                </div>
            </div>
            <div class="flex-container">
                <div id="session_expired"></div>
                <div id="sharing_mode">
                    <h1 class="text-share"><i id="share-icon" class="fa fa-desktop"></i> Your Screen is in Sharing Mode</h1>
                </div>
                <div class="" id="full-screen-video">

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="share_link_aud" value="<?= Url::base('https').'/mentors/webinar-view?id='.$tokenId?>">
<?php
$this->registerCss("
#session_expired 
{
    width: 100%;
    text-align: center;
   display:none;
   z-index: 999;
}
#session_expired h3
{
color:#fff;
}
 #full-screen-video.sp1 > .adjust_sharing{
        position: absolute;
        z-index: 999;
        top: 8px;
        left: 16px;
        width: 16% !important;
        height: 20% !important;
    }
#sharing_mode {
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 100vh;
    background-color: #00a0e3;
    display:none;
}
.text-share {
    color: #fff;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
");
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
console.log(tokenId);
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
        $('#session_expired').html('<h3>Authentication Failed</h3>');
        $('#session_expired').css('display','block');
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
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('@eyAssets/fonts/fontawesome-5/css/all.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerCssFile('https://webdemo.agora.io/agora-web-showcase/examples/17-Multistream/static/css/main.419b49bd.chunk.css');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
//$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.1.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.6.5.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
