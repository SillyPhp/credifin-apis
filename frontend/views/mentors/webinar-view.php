<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
$basePath = Url::base("https");

if (Yii::$app->user->identity->image) {
    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
} else {
    $image = 'https://ui-avatars.com/api/?name=' . Yii::$app->user->identity->first_name . '+' . Yii::$app->user->identity->last_name . '&background=' . ltrim(Yii::$app->user->identity->initials_color, '#') . '&color=fff"';
}
$time = date('Y/m/d H:i:s', strtotime($upcomingDateTime));
?>
<input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id ?>" id="current-user-id">
<input type="hidden" value="<?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name; ?>"
       id="current-user-name">
<input type="hidden" value="<?= $image; ?>" id="current-user-image">

<section class="reload-strip">
    <div class="reload-text">If you are having trouble while watching webinar, please Reload the page.</div>
    <div class="reload">
        <a onClick="window.location.reload()" class="reload-btn">Relaod</a>
    </div>
</section>

<section>
    <div class="videoFlex">
        <div class="video-section">
            <iframe src="<?= Url::to('/live-stream/' . $type . '?id=' . $_GET['id']) ?>"></iframe>
            <div class="slide-close-btn">X</div>
        </div>
        <div class="slide-section">

            <div id="scroll-chat">
                <div class="chat">

                </div>
            </div>
            <div class="msg-input">
                <form class="form-flex">
                    <textarea class="send-msg" placeholder="Message"></textarea>
                    <button type="button" class="sendMessage"><i class="fas fa-comment"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="video-details">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="video-action">
                        <div class="webinar-video-title"><?= $webinarDetail['title'] ?></div>
                        <div class="webinar-speakers">
                            <p><span>Speakers:</span>
                                <?php
                                if ($webinarDetail['webinarEvents'][0]['webinarSpeakers']) {
                                    $speakerCount = count($webinarDetail['webinarEvents'][0]['webinarSpeakers']) - 1;
                                    foreach ($webinarDetail['webinarEvents'][0]['webinarSpeakers'] as $key => $speaker) {
                                        ?>
                                        <?= $speaker['fullname'] ?>
                                        <?php
                                        if ($key < $speakerCount) {
                                            echo ", ";
                                        }
                                    }
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </p>
                        </div>
                        <?php
                        if ($upcomingDateTime) {
                            ?>
                            <div class="upcoming-event-link">
                                <div id="counter">
                                    <span class="nxt-e">Next Event:</span>
                                    <div id="timepart" style="display: none">
                                        <div class="time-part">
                                            <div class="counter-item">
                                                <span class="days" id="days"></span><b>d</b>
                                            </div>
                                            <div class="counter-item">
                                                <span class="hours" id="hours"></span><b>h</b>
                                            </div>
                                            <div class="counter-item">
                                                <span class="minutes" id="minutes"></span><b>m</b>
                                            </div>
                                            <div class="counter-item">
                                                <span class="seconds" id="seconds"></span><b>s</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="join-bb" id="join-upcoming" style="display: none">
                                        <a href="<?= Url::to('/mentors/webinar-view?id=' . $upcomingEvent['session_enc_id']) ?>" target="_blank">Join Now</a>
                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="live-count">
                        <i class="fas fa-circle"></i> Viewers: <span id="viewers"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="chat-box-toggler">
    <i class="far fa-comments"></i>
</div>
<section class="similar-webinars">
    <div class="container">
        <?php
        if (!empty($webinars)) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="mentor-heading">Similar Webinars</div>
                </div>
            </div>
            <div class="row">
                <?= $this->render('/widgets/mentorships/webinar-card', [
                    'webinars' => $webinars,
                ]) ?>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<script type="text/javascript">
    // Variables defined
    //var sendMessagesUrl = '<?//= Yii::$app->params->fireabse->modules->realtimeChat->config->functions->sendMessages; ?>//';
    var specialKey = '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->specialKey; ?>';
    let params = (new URL(document.location)).searchParams;
    let webinarId = params.get('id');
    let userId = document.getElementById('current-user-id').value;
    let userName = document.getElementById('current-user-name').value;
    let userImage = document.getElementById('current-user-image').value;
</script>
<?php
$this->registerCss('
.chat-box-toggler{
    display: none;
}
.reload-strip{
    width: 100%;
    display: flex;
    justify-content: space-between;
    background: #2980b9;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #2c3e50, #2980b9);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #2c3e50, #2980b9); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    padding: 15px 25px;
    align-items: center;
}
.reload-text{
    color: #fff;
    font-family: roboto;
}
.reload-btn {
    padding: 6px 20px;
    text-decoration: none;
    background: #2c4054;
    color: #fff;
    font-family: roboto;
    font-weight: 500;
    border-radius: 4px;
    letter-spacing: 0.3px;
    border:none;
    cursor: pointer;
    transition:all .3s;
}
.reload-btn:hover {
    color: #2c4054 !important;
    background: #fff;
}
.time-part {
    display: flex !important;
}
.webinar-speakers p{margin-bottom:5px;}
div#counter {
    display: flex !important;
}
.nxt-e{font-weight:600;margin-right:10px;color:#333;}
.counter-item {
    color: #f00;
    margin:0 5px
}
.join-bb a {
    color: #fff;
    background-color: #00a0e3;
    padding: 2px 11px;
    text-transform: uppercase;
    font-weight: 600;
}
.msg-input{
    border:1px solid #eee;
    width: 100%;
    height: 80px;
    background: #fff;
    position: fixed; 
    z-index:9;
}
#scroll-chat{
    position:relative;
    height: calc(100% - 90px);
}
.form-flex{
    display: flex;
    align-items: center;
    justify-content: space-between;
     width: 100%;
    height: 80px;

}
.msg-input .form-flex textarea{
    padding: 15px 20px;
    border: none;
    width: 86%;
    height: 100%;

}
.msg-input button{
    font-size: 25px;
    background: transparent;
    border: none;
    height: 100%;
    padding: 5px 10px;
}
.msg-input button:hover{
    color:#00a0e3;
}
.video-action .webinar-video-title{
    text-align: left;
    font-size: 20px;
    color: #333;
    font-family: roboto;
}
.webinar-speakers p span{
    font-weight: bold;
    color:#333;
}
.webinar-speakers p a{
    color:#000;
}
.webinar-speakers p a:hover{
    color:#00a0e3;
}
.mentor-heading {
    font-size: 25px;
    font-family: lora;
    color: #000;
    text-transform: capitalize;
}
.msg-input{
    position: absolute;
    bottom: 0;
}

.video-section iframe{
    width: 100%;
    height:100%;
    object-fit: contain;
}
.chat-box{
    display: flex;
    padding: 10px 15px;
    width: 100%;
}
.user-icon{
    width: 50px;
    height: 50px;
    z-index: 1
}
.user-icon img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    object-position: top center;
}
.username-msg{
    background: #fff;
    padding:10px 10px 10px 15px;
    margin-left: -25px;
    z-index:0;
    margin-top: 15px;
    width: 100%;
    border-radius: 10px;
}
.us-name{
    font-size: 14px;
    font-weight: bold;
    font-family: roboto; 
    padding-left:20px;
}
.us-msg{
    font-size: 14px;
    font-family: roboto;
}
.fullwidth-page > #wrapper.clearfix > .main-content{
   padding-top: 0px !important;
}
.videoFlex{
    display: flex;
}
.video-section{
    width: 70vw;
    height: calc(100vh - 65px);
    background: #000; 
    position: relative;
}
.slide-section{
    width:30vw;
    height: calc(100vh - 65px);
    background: #eee;
    position: relative;
    overflow: hidden;
 }
.slide-hide{
    width: 0vw;
    transition: .2s ease;
}
.slide-close-btn{
    position: absolute;
    top: 20px;
    right:0px;
    width: 30px;
    height: 30px;
    color: #000;
    background:#00a0e3;
    display: flex;
    justify-content: center;
    align-items: center; 
    cursor:pointer;
    color:#fff;
    z-index: 999;
    border-radius: 10px 0 0 10px;
    line-height: 0px;
}
.video-details{
    background: #f8f8f8;
    padding: 20px 0;
}
.live-count{
    text-align:center;
    flex:1;
}
.live-count span{
    font-weight: bold;
}
.live-count i{
    color: green;
}
.chat-box.right-aligned{
    flex-direction: row-reverse;
}
.chat-box.right-aligned .username-msg{
    margin-left: 0px;    
    margin-right: -25px;
    text-align:right;
}
.chat-box.right-aligned .username-msg .us-name {
    padding-left: 0px;
    padding-right: 20px;
    text-transform: capitalize;
}
@media screen and (max-width: 550px){
    .chat-box-toggler{
        display: block;
        position: fixed;
        bottom: 15px;
        right: 20px;
        font-size: 35px;
        background-color: #00a0e3;
        color: #fff;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        text-align: center;
        line-height: 68px;
        z-index:9;
        box-shadow: 0px 1px 15px 2px #ababab;
        cursor: pointer;
    }
    .slide-section{
        display: none;
        width: 90vw;
        height: 70vh;
        position: fixed;
        left: 5vw;
        bottom: 13vh;
        z-index: 99;
        border-radius: 20px;
        overflow: visible;
        box-shadow: 0px 1px 17px 2px #ababab;
    }
    
    .msg-input {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        overflow: hidden;
    }
    .slide-section:before {
        content: "";
        right: 14px;
        bottom: -16px;
        z-index: 999;
        position: absolute;
        border-left: 15px solid transparent;
        border-top: 20px solid #fff;
        border-right: 15px solid transparent;
    }
    .video-section{
        width: 100vw;
        height: 50vh;
    }
    .videoFlex{
        flex-direction: column;
    }
    .slide-close-btn{
        display: none;
    }
}
');
$script = <<<JS
const ps = new PerfectScrollbar('#scroll-chat');
var db = firebase.database();
db
            .ref(specialKey + '/conversations/' + webinarId)
            .on('value', gotData, errData);

            function gotData(data) {
                var result = [];
                for (var i in data.val()) {
                    result.push([i, data.val()[i], Date.parse(data.val()[i].full_date_time)]);
                }
                result.sort(function (a, b) {
                    return a[2] - b[2];
                });
                for (var z = 0; z < result.length; z++) {
                    if (!document.getElementById(result[z][0])) {
                        if(result[z][1].sender != userId){
                            showMessage(result[z][0], result[z][1].name, result[z][1].image, result[z][1].message,false);
                        } else {
                            showMessage(result[z][0], result[z][1].name, result[z][1].image, result[z][1].message, true);
                        }
                    }
                }
            }

            function errData(data) {
                console.log('err');
            }
            function showMessage(id,name,image,message,owner){
                let chat = document.querySelector('.chat');
                let chatBox = document.createElement('div');
                if(owner){
                    chatBox.setAttribute('class', 'chat-box right-aligned');
                } else{
                    chatBox.setAttribute('class', 'chat-box');
                }
                chatBox.setAttribute('id', id);
                chatBox.innerHTML = `<div class="user-icon">
                                    <img src="`+ image +`">
                                    </div>
                                    <div class="username-msg">
                                        <div class="us-name">`+ name +`</div>
                                        <div class="us-msg">` + message + `</div>
                                    </div>`;
                chat.appendChild(chatBox);
                var myElement = document.getElementsByClassName('chat')[0].offsetHeight - 80;
                document.getElementById('scroll-chat').scrollTop = myElement;
            }
            
function countdown(e){
    var countDownDate = new Date(e).getTime();
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        $('#days').text(Math.floor(distance / (1000 * 60 * 60 * 24)));
        $('#hours').text(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        $('#minutes').text(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
        $('#seconds').text(Math.floor((distance % (1000 * 60)) / 1000));
        if (distance <= 0) {
            clearInterval(x);
            $('#join-upcoming').show();
            $('#timepart').hide();
        } else { 
            $('#timepart').show();
            $('#join').hide();
        }
    }, 1000);
}
if("$upcomingDateTime" != ""){
    countdown('$time');
}
$(document).on('click','.chat-box-toggler',function(){
   $('.slide-section').slideToggle(1000);  
});
JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script>

<script type="text/javascript">
    // Initialize Firebase
    var config = {
        apiKey: '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->apiKey; ?>',
        authDomain: '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->authDomain; ?>',
        databaseURL: '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->databaseURL; ?>',
        projectId: '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->projectId; ?>',
        storageBucket: '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->storageBucket; ?>',
        messagingSenderId: '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->messagingSenderId; ?>',
    };
    firebase.initializeApp(config);
</script>
<script>
    var db = firebase.database();
    var monthDict = {
        0: 'Jan',
        1: 'Feb',
        2: 'Mar',
        3: 'Apr',
        4: 'May',
        5: 'June',
        6: 'July',
        7: 'Aug',
        8: 'Sep',
        9: 'Oct',
        10: 'Nov',
        11: 'Dec',
    };
    document.querySelector('.slide-close-btn').addEventListener('click', hideSlide);

    function hideSlide() {
        let slideSec = document.querySelector('.slide-section');
        let videoSec = document.querySelector('.video-section');
        let chatBoxes = document.querySelector('.chat');
        if (slideSec.classList.contains('slide-hide')) {
            slideSec.classList.remove('slide-hide');
            videoSec.style.width = '80vw';
            chatBoxes.style.display = "block"

        } else {
            slideSec.classList.add('slide-hide');
            videoSec.style.width = '100vw';
            chatBoxes.style.display = "none";

        }
    }

    var refs = db.ref(specialKey + '/userStatus/' + webinarId + '/' + userId)
    refs.set({
        'status': 'online',
    });
    var userLastOnlineRef = db.ref(specialKey + '/userStatus/' + webinarId + '/' + userId);
    userLastOnlineRef.onDisconnect().remove();
    var usersCount = db.ref(specialKey + '/userStatus/' + webinarId);
    usersCount.on('value', function (data) {
        var tempData;
        var usersCount2 = db.ref(specialKey + '/userStatusAdd/');
        usersCount2.on('value', function (data2) {
            var resultData2 = [];
            for (var k in data2.val()) {
                resultData2.push([k, data2.val()[k]]);
            }
            tempData = data2.val();
        });
        var result2 = [];
        for (var i in data.val()) {
            result2.push([i, data.val()[i]]);
        }
        document.getElementById('viewers').innerText = result2.length + tempData;
    });
    var usersCount3 = db.ref(specialKey + '/userStatusAdd/');
    usersCount3.on('value', function (data2) {
        var tempData;
        var resultData2 = [];
        for (var k in data2.val()) {
            resultData2.push([k, data2.val()[k]]);
        }
        tempData = data2.val();
        var usersCountg = db.ref(specialKey + '/userStatus/' + webinarId);
        usersCountg.on('value', function (data) {
            var result2 = [];
            for (var i in data.val()) {
                result2.push([i, data.val()[i]]);
            }
            document.getElementById('viewers').innerText = result2.length + tempData;
        });
    });

    document.querySelector('.sendMessage').addEventListener('click', sendMessage);
    let messageText = document.querySelector('.send-msg')
    messageText.addEventListener('keyup', function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        let message = document.querySelector('.send-msg').value;
        if (message.trim() != "") {
            document.querySelector('.send-msg').value = "";
            var currentDate = new Date();
            var dateMain = currentDate.getDate() + " " + monthDict[currentDate.getMonth()] + " " + currentDate.getFullYear();
            var getMins = currentDate.getMinutes();
            if (getMins < 10) {
                getMins = "0" + getMins;
            }
            var timeMain = currentDate.getHours() + ":" + getMins;
            var ref = db.ref(specialKey + '/conversations/' + webinarId + '/' + uniqueId())
            ref.set({
                'name': userName,
                'sender': userId,
                'is_public': true,
                'reply_to': "",
                'message': message.trim(),
                'image': userImage,
                'date': dateMain,
                'time': timeMain,
                'full_date_time': String(currentDate),
            });
            var data = {
                'webinar_enc_id': webinarId,
                'message': message.trim(),
                'reply_to': ''
            }
            $.ajax({
                type: 'POST',
                url: '/mentors/save-conversation',
                data: data
            });
            var myElement = document.getElementsByClassName('chat')[0].offsetHeight - 80;
            document.getElementById('scroll-chat').scrollTop = myElement;
        }
    }

    function uniqueId() {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < 15; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return userId + result;
    }
</script>
