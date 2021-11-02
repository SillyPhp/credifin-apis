<?php
use yii\helpers\Url;
Yii::$app->view->registerJs('var tokenId = "' . $tokenId . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var uid = "' . $uid . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var base_url = "' . Url::base('https') . '"', \yii\web\View::POS_HEAD);
?>
    <style>
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
            margin-top: 5vh;
        }
        #full-screen-video.sp2 > div{
            width: 48% !Important;
            height: 80vh !important;
            margin-top: 10vh;
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

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            padding: 10px;
        }

        .grid-item {
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
        }

        #watch-live-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            z-index: 999;
        }

        #watch-live-overlay {
            background: #111; /* Old browsers */
            background: -moz-linear-gradient(-45deg, #111 0%, #111 50%, #000 63%, #000 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #111), color-stop(50%, #111), color-stop(63%, #000), color-stop(100%, #000)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(-45deg, #111 0%, #111 50%, #000 63%, #000 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(-45deg, #111 0%, #111 50%, #000 63%, #000 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(-45deg, #111 0%, #111 50%, #000 63%, #000 100%); /* IE10+ */
            background: linear-gradient(135deg, #111 0%, #111 50%, #000 63%, #000 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#111', endColorstr='#000', GradientType=1); /* IE6-9 fallback on horizontal gradient */
        }

        #watch-live-overlay #overlay-container {
            padding: 25px;
            border-radius: 5px;
            position: relative;
            margin: 0 auto;
            top: 35%;
            width: 70%;
        }

        #watch-live-overlay button {
            display: block;
            color: #fff;
            background: transparent;
            border-color: transparent;
        }

        #watch-live-overlay img {
            height: auto;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }

        #watch-live-overlay button i {
            padding: 0 10px;
            font-size: 5.2rem;
        }

        #watch-live-overlay button span {
            display: block;
        }

        .btn-xlg {
            padding: 20px 35px;
            font-size: 30px;
            line-height: normal;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
        }

        .fl-container {
            display: flex;
            position: relative;
            align-items: center;
            background-color: #000;
            height: 100vh;
        }

        #full-screen-video {
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
            flex: 1;
            margin: auto;
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
            display: none !important;
        }
        .sp1 > div .full-vid, .elem1 > div .full-vid{
            display: none;
        }
        #full-screen-video.expanded >div >div > video{
            object-fit: contain !Important;
        }
        .stream-uid
        {
            max-width: inherit !important;
        }
        /* Respomnsive design */
        @media only screen and (max-width: 500px) {
            #full-screen-video.elem1 > div{
                width: 100% !Important;
                height: 50vh !important;
                margin-top: 25vh;
            }
            #full-screen-video.elem2 > div{
                width: 100% !Important;
                height: 50vh !important;
                margin-top: 0%;
            }
            #full-screen-video.elem3 > div{
                width: 50% !Important;
                height: 50vh !important;
                margin-top: 0%;
            }
            #full-screen-video.elem3 > div:last-child{
                width: 100% !Important;
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

        @media only screen and (max-width: 795px) {
            #watch-live-overlay #overlay-container {
                width: 100%;
            }

            body {
                overflow-y: scroll;
            }
        }

        @media only screen and (max-height: 350px) {
            #watch-live-overlay img {
                height: auto;
                width: 80%;
            }

            #watch-live-overlay #overlay-container {
                top: 30%;
            }

            .btn-xlg {
                font-size: 1rem;
            }
        }

        @media only screen and (max-height: 400px) {
            .btn-xlg {
                font-size: 1.25rem;
            }
        }

        @media only screen and (max-width: 400px) {
            .btn-xlg {
                padding: 10px 17px;
            }

            #buttons-container {
                bottom: 0px;
            }

            .btn-group > .btn {
                padding: 5px;
            }

            #buttons-container div {
                max-width: 90px;
                min-width: 90px;
                margin: 5px;
                margin-bottom: 5px;
                padding: 0px 2px;
            }
        }

        @media only screen and (max-width: 310px) {
            #buttons-container .dropdown-toggle {
                display: none;
            }

            #buttons-container .btn-block {
                border-radius: .3rem;
            }

            #buttons-container .btn-group i {
                padding: 0;
            }

            #buttons-container div {
                max-width: 85px;
                min-width: 70px;
                margin: 2px;
                padding: 0px 5px;
            }

            .cover-media {
                min-width: 200px;
                min-height: 150px;
                background-color: #999;
                background-repeat: no-repeat;
                background-size: 70px 70px;
                background-position: 50%;
                border-radius: 2px;
                background-image: url(/agora-web-showcase/examples/17-Multistream/static/media/placeholder-audio-big.effcae22.png);
            }
        }
    </style>
    <div id="content_main">
        <div class="container-fluid p-0 fl-container">
            <div id="full-screen-video">

            </div>
            <div id="watch-live-overlay">
                <div id="overlay-container">
                    <div class="col-md text-center">
                        <button id="watch-live-btn" type="button" class="btn btn-block btn-xlg">
                            <i id="watch-live-icon" class="fa fa-play-circle"></i>
                            <span>Click here to Watch the Live Stream</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss("
#session_expired 
{
    width: 100%;
    text-align: center;
   display:none;
}
#session_expired h3
{
color:#fff;
}
");
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
        addScript("/assets/themes/ey/broadcast/js/multi-audience-script.js");
       }
       else
       {
        alert("Not yet started");
       }
      }
    })  
}
} 
');
$this->registerCssFile('https://webdemo.agora.io/agora-web-showcase/examples/17-Multistream/static/css/main.419b49bd.chunk.css');
//$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerCssFile('@eyAssets/fonts/fontawesome-5/css/all.css');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
//$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.1.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.agora.io/sdk/release/AgoraRTCSDK-3.6.5.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>