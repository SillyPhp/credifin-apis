<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

if (Yii::$app->user->identity->image) {
    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
} else {
    $image = 'https://ui-avatars.com/api/?name=' . Yii::$app->user->identity->first_name . '+' . Yii::$app->user->identity->last_name . '&background=' . ltrim(Yii::$app->user->identity->initials_color, '#') . '&color=fff"';
}
?>
<input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id ?>" id="current-user-id">
<input type="hidden" value="<?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name; ?>"
       id="current-user-name">
<input type="hidden" value="<?= $image; ?>" id="current-user-image">

<section>
    <div class="videoFlex">
        <div class="video-section">
            <iframe src="<?= Url::to( $type . '?id=' . $_GET['id']) ?>"></iframe>
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
                                if ($webinarDetail['webinarSpeakers']) {
                                    $speakerCount = count($webinarDetail['webinarSpeakers']) - 1;
                                    foreach ($webinarDetail['webinarSpeakers'] as $key => $speaker) {
                                        ?>
                                        <a target="_blank" href=""><?= $speaker['fullname'] ?></a>
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
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="live-count">
                        <i class="fas fa-circle"></i> Viewers: <span>700</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="similar-webinars">
    <div class="container">
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
}
@media screen and (max-width: 550px){
    .slide-section{
        width: 100vw;  
        height: 100vh;      
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
                    result.push([i, data.val()[i]]);
                }
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
