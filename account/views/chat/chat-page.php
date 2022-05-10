<?php
use yii\helpers\Url;

?>
<input type="hidden"
       value="<?= Yii::$app->user->identity->organization->organization_enc_id ? Yii::$app->user->identity->user_enc_id : null ?>"
       id="current-organization-user">
<input type="hidden"
       value="<?= Yii::$app->user->identity->organization->organization_enc_id ? Yii::$app->user->identity->organization->organization_enc_id : Yii::$app->user->identity->user_enc_id ?>"
       id="current-user">
<input type="hidden"
       value="<?= Yii::$app->user->identity->organization->organization_enc_id ? Yii::$app->user->identity->organization->name : Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name ?>"
       id="current-name">

<section>
    <div class="height-100VH">
        <div class="row">
            <div class="col-md-3 col-sm-3 padd-right-0">
                <div class="sec2">
                    <div class="user-list-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="fill-heading">
                                    Jobs
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <div class="dropdown text-left">
                                        <button class="dropbtn">Filters <i class="fa fa-chevron-down" aria-hidden="true"></i></button>
                                        <div class="dropdown-content" id="dc-btn">
                                            <div class="dc-btn filtertype" data-value="jobs" data-id="fil-jobs">Jobs</div>
                                            <div class="dc-btn filtertype" data-value="internships" data-id="fil-int">Internships</div>
<!--                                            <div class="dc-btn" data-value="Locations" data-id="fil-loc">Location</div>-->
<!--                                            <div class="dc-btn" data-value="Training Programs" data-id="fil-train">Training Programs</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="user-list" id="filterSectionScroll">
                    <div class="fill job-card active" id="fil-jobs">

                    </div>
                    <div class="fill location" id="fil-loc">
                        <div class="user-box">
                            <div class="user-detail">
                                <div class="user-name">Ludhiana</div>
                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-detail">
                                <div class="user-name">Ludhiana</div>
                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-detail">
                                <div class="user-name">Ludhiana</div>
                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-detail">
                                <div class="user-name">Ludhiana</div>
                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-detail">
                                <div class="user-name">Ludhiana</div>
                            </div>
                        </div>
                    </div>
                    <div class="fill internship-card" id="fil-int">
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Web Designer</div>
                                <div class="user-com">Information Technology</div>
                                <div class="user-com"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="user-com"><i class="fa fa-inr"></i> 150000 </div>

                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Web Designer</div>
                                <div class="user-com">Information Technology</div>
                                <div class="user-com"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="user-com"><i class="fa fa-inr"></i> 150000 </div>

                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Web Designer</div>
                                <div class="user-com">Information Technology</div>
                                <div class="user-com"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="user-com"><i class="fa fa-inr"></i> 150000 </div>

                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Web Designer</div>
                                <div class="user-com">Information Technology</div>
                                <div class="user-com"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="user-com"><i class="fa fa-inr"></i> 150000 </div>

                            </div>
                        </div>
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Web Designer</div>
                                <div class="user-com">Information Technology</div>
                                <div class="user-com"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="user-com"><i class="fa fa-inr"></i> 150000 </div>

                            </div>
                        </div>
                    </div>
                    <div class="fill training-prog" id="fil-train">
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Web Designer</div>
                                <div class="user-com">Information Technology</div>
                                <div class="user-com"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                <div class="user-com"><i class="fa fa-inr"></i> Paid </div>
                                <div class="user-com"><i class="fa fa-clock"></i> Morning </div>

                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 no-padd">
                <div class="sec2">
                    <div class="user-list-heading">Chats</div>
                    <div class="user-list" id="userSectionScroll">
                        <div class="user-box">
                            <div class="user-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="user-detail">
                                <div class="user-name">Mrs. Tarry</div>
                                <div class="user-com">DSB Edu tech</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 padd-left-0">
                <div class="chat-section">
                    <div class="chatEmpty">
                        <div>
                        <img src="<?= Url::to('@eyAssets/images/chatempty_1.png')?>" alt="">
                        <p>Message Alert! Click on the Applicant to Start the Chat.</p>
                        </div>
                    </div>
                    <div class="chatFull">
                        <div class="chating-user">
                            <div class="user-box">
                                <div class="user-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         id="chat_window_image" alt=""/>
                                </div>
                                <div class="user-detail">
                                    <div class="user-name" id="chat_window_name">Mrs. Tarry</div>
                                    <div class="user-com" id="chat_window_location">DSB Edu tech</div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-cont" id="chatSectionScroll">

                        </div>
                        <div class="chat-form-bttm">
                        <div class="chat-input-cs" data-id="" data-value="">
                            <input type="text" placeholder="Type a message..." class="msginput" id="chatMsg">
                            <button type="button" id="sendmsg"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    // Variables defined
    var sendMessagesUrl = '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->functions->sendMessages; ?>';
    var specialKey = '<?= Yii::$app->params->fireabse->modules->realtimeChat->config->specialKey; ?>';
</script>
<?php
$this->registerCss('
.footer{
    margin-top: 0px !important;
}
.chatEmpty p{
    margin-top: 0px;
    font-size: 16px;
    text-align: center;
    font-weight: 700;
    color: #333;
}
.chatEmpty {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}


.chatEmpty img {
    width: 300px;
    margin: auto;
    display: block;
}
.chatFull{
    display: none
}
#fill-heading{
    text-transform: capitalize;
}
.dc-btn:hover{
    cursor:pointer;
}
.spinLoader{
    text-align: center;
    margin-top: 30px;
    font-size:25px;
}
.dc-btn{
    font-weight:normal;
}
.fill{
    display: none;
}
.dropbtn {
    font-size: 16px;
    border: none;
    border-radius: 3px;
    padding: 1px 10px;
    background: #00a0e315;
    color: #00a0e3;
    font-weight: 500;
}
.dropbtn i {
    font-size: 13px;
}
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {
    background-color: #f1f1f1;
}
.user-list-heading {
    padding: 10px 10px;
    background: #fff;
    font-family: roboto;
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #eee;
    font-weight: 500;
}
#chat-icon{
    display:none;
}
/*----chat section----*/
.chat-cont{
    position:relative;
    height:calc(100vh - 195px); 
}
.chating-user{
    background:#f2f2f2;
}
.cc-p{ 
    margin: 0px !important
}
.chat-container {
  background-color: #00a0e3;
  border-radius: 10px;
  padding: 10px;
  margin: 5px;
  max-width: 80%;
  float:left;
  word-break: break-all;
  color: #fff;
  border-bottom-left-radius: 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
  float:right;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 10px;
  color: #333;
}

.chat-container::after {
  content: "";
  clear: both;
  display: table;
}

.chat-container img {
  float: left;
  max-width: 40px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.chat-container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #eee;
  font-weight: 800;
}
.darker .time-left {
    float: right;
    color: #333;
    font-weight: 800;
    margin-top: 6px;
}

.time-left {
    font-size: 10px;
  float: left;
  color: #eee;
  font-weight: 800;
}

.chat-input-cs{
       display: flex;
    width: 100%;
}
.chat-input-cs button {
    width: 45px;
    border-radius: 50%;
    border: none;
    background: #00a0e3;
    color: #fff;
}
.chat-input-cs input {
    padding: 10px 15px;
    width: 100%;
    border-radius: 45px;
    margin-right: 8px;
    border: none;
}
.chat-form-bttm{
    width:100%;
    position:absolute;
    bottom: 65px;
}
.chat-form-bttm form{
    display: flex;
}
.height-100VH{
    height:calc(100vh - 65px);
    overflow:hidden; 
}
.chat-section{
    position:relative;
    background:#00a0e315;
    height:100vh;
    width:100%;
}

/*----chat section ends----*/
.sec2{
    height: 100vh
}
.user-list{
    height:calc(100vh - 100px);
}
.copyright{
    display:none;
}
.container, .container-fluid{
    padding-left:0px !important;
    padding-right:0px !important;
}
.no-padd{
    padding-right:0px !important;
    padding-left:0px !important;
    border:1px solid #eee;
    border-top: none;
    border-bottom: none;
}
.padd-right-0{
    padding-right:0px !important;
}
.padd-left-0{
    padding-left:0px !important;
}
.page-content{
  padding:0px !important;
  margin-top:0px !important;
  margin-bottom:0px !important; 
  height: calc(100vh - 60px); 
}
.job-icon{
    min-width:40px;
    min-height:40px;
}
.job-icon img{
    max-width:100%;
    max-height:100%;
}
.user-icon{
    width:50px;
    height:50px;
}
.user-icon img{
    max-width:100%;
    max-height:100%;
    border-radius:50%;
}
.user-detail{
    padding-left:15px;
}
.user-name{
    font-size: 13px;
    font-weight:500;
    color:#000;
    font-family: roboto;
    text-transform: capitalize;
}
.user-box{
    display:flex;
    padding:15px 10px;
    border-bottom:1px solid #eee;
    transition: .2s all linear;
}
.user-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.3);
    transition: .2s all linear;
}
.active{
    display:block !important;
}
.userError{
    text-align: center;
    font-weight: 500;
    font-family: roboto;
    font-size: 17px;
}
.user-com ul li{
    display: inline-block;
}
.user-com ul{
    margin-block-start: 5px;
    padding: 0px;
    margin-top: 0px;
}
.user-com i{
    padding-top: 4px;
    padding-right: 5px;
}
.user-detail .user-com {
    font-size: 11px;
}
.disFlex{
    display: flex;
}
.user-com ul li:after {
    content: ","; 
}
.user-com ul li:last-child:after{
    content: "";
}
.chat-section li {
    list-style: none;
    padding: 5px 0;
    margin: 10px auto;
    font-size: 12px;
}
.ps--active-x > .ps__rail-x{
    display: none !important;
}
.cc-name{
    color: #00a0e3;
    font-weight:bold;
    font-size: 12px;
    margin: 0px;
}
.messagedate{
    margin: 15px 0px;
}
.m0{
    margin-left: 0px !important;
    margin-right: 0px !important;
}
');
$script = <<<JS
var ps = new PerfectScrollbar('#chatSectionScroll');
var js = new PerfectScrollbar('#userSectionScroll');
var sh = new PerfectScrollbar('#filterSectionScroll');
// var ps = new PerfectScrollbar('#fil-jobs');


$(document).ready(function (){
      getApplications('jobs');
});

$('.filtertype').click(function (e){
    let type = e.currentTarget.getAttribute('data-value');
    getApplications(type);
});

function getApplications(type){
    $.ajax({
        url: "/account/messages/get-all-applications",
        method: "POST",
        data: {type: type},
        beforeSend:function(){
             $('.job-card').html('<div class="spinLoader"><i class="fas fa-circle-notch fa-spin"></i></div>');
        },
        success: function (response){
            if(response.status == 200){
                $('#fill-heading').html(type);
                let appCard = $('#applicationCard').html();
                let appRender = Mustache.render(appCard, response['allApplication']);
                $('.job-card').html(appRender);
                let job_id = response['allApplication'][0]['application_enc_id'];
                getApplicants(job_id)
            }
        }
    })
}
$(document).on('click', '.jobsBoxes', function(e){
    let job_id = e.currentTarget.getAttribute('data-id');
    getApplicants(job_id);
    
})

function getApplicants(job_id){
    $.ajax({
        url:'/account/messages/get-applied-candidates',
        method: 'POST',
        data: {job_id: job_id},
        beforeSend:function(){
             $('#userSectionScroll').html('<div class="spinLoader"><i class="fas fa-circle-notch fa-spin"></i></div>');
        },
        success: function (response){
             console.log(response);
            if(response.status == 200){
                if(response['applied_users'].length){
                    let user_card = $('#userCard').html();
                    let user_render = Mustache.render(user_card, response['applied_users']);
                    $('#userSectionScroll').html(user_render);
                }else {
                    $('#userSectionScroll').html('<p class="userError"> No candidates have applied on this job </p>');
                }
            }
        }
    })
}

function getUniqueId(user_id){
     if(user_id < current_user){
         return user_id + current_user
     }else{
         return current_user + user_id;
     }
}


function sendMes(t){
     msginput = $('.msginput').val();
     var user_id = t.parent().attr('data-id');
     var unique_id = getUniqueId(user_id);
         
     if(msginput){
        msginput = msginput.trim();
     }
         
     if(msginput && msginput.length < 1500){
         var converseRef = db.ref(specialKey + '/conversations/' + unique_id );
         var currentDate = new Date();
         var senddate = currentDate.getDate() + " " + monthDict[currentDate.getMonth()] + " " + currentDate.getFullYear();
         var getMins = currentDate.getMinutes();
         if (getMins < 10) {
            getMins = "0" + getMins;
        }
         var sendtime = currentDate.getHours() + ":" + getMins;
         var data = {
            sender : current_user,
            sender_organization_id : current_organization_user,
            receiver : user_id,
            message : msginput,
            hasSeen : false,
            date: senddate,
            time: sendtime
         };
         var key = converseRef.push(data).key;
         data['uniqueid'] = unique_id;
         data['key'] = key;
         
         $.ajax({
            type: 'POST',
            url: '/account/messages/save-sender',
            data: data
         });
         
         $.ajax({
            type: 'GET',
            url: sendMessagesUrl,
         });
    
        var messagetypeinp = t.closest('.msginput');
        if(messagetypeinp.length == 0){
            messagetypeinp = t.siblings('.input-cont').find('.msginput');
        }
        messagetypeinp.val('');
        messagetypeinp.focus();
        
        var chatWindow = document.querySelector('.scroller');
        var xH = chatWindow.scrollHeight;
        chatWindow.scrollTo(0, xH);
    }
}
//sending messages
 $(document).on('click','#sendmsg', function(){
     var t = $(this);
     sendMes(t);
 });
 $(document).on("keypress", ".msginput",function(event){
    if(event.which == '13'){
        var t = $(this);
        sendMes(t);
    }
 });  
var current_user = $('#current-user').val(); //id of current user   
var current_organization_user = $('#current-organization-user').val(); //id of current organization user   
var current_user_name = $('#current-name').val(); // name of current user   

 function createTextLinks_(text) {
    return (text || "").replace(
        /([^\S]|^)(((https?\:\/\/)|(www\.))(\S+))/gi,
        function(match, space, url){
            var hyperlink = url;
            if (!hyperlink.match('^https?:\/\/')) {
                hyperlink = 'http://' + hyperlink;
            }
            return space + '<a href="' + hyperlink + '" target="_blank">' + url + '</a>';
        }
    );
 };
 
$(document).on('click', '.chat-user', function(){   
  chatUser(this);
  $('.chatFull').show()
  $('.chatEmpty').hide()
});

function chatUser(e) {
    $('#chatSectionScroll').html('');
    var single_user_id = $(e).attr('id');
    var single_user_name = $(e).find('.user-name').text();
    var single_user_city = $(e).find('.user-com').text();
    var single_user_image = $(e).find('.user_img').attr('src');
    
    var d = {
        user_enc_id: single_user_id,
        name: single_user_name
    };
    
    $('#chat_window_name').html(single_user_name);
    $('#chat_window_location').html(single_user_city);
    $('#chat_window_image').attr('src', single_user_image);
    $('.chat-input-cs').attr('data-id', single_user_id);
    $('.chat-input-cs').attr('data-value', single_user_name);
    
    //listening messages for specific users
      
        db
        .ref(specialKey + '/conversations/' + getUniqueId(single_user_id))
        .off();
        var existingDates = {};
        
        db
        .ref(specialKey + '/conversations/' + getUniqueId(single_user_id))
        .on('child_added', function(data){
            if(data.val().sender == current_user){
                var res = {
                    message : data.val().message,
                    time: data.val().time,
                    date: data.val().date,
                    sender : current_user_name
                };
                
                var msgdate = res['date'].split(' ')[0];
                if(!existingDates[msgdate]){
                    existingDates[msgdate] = true;
                    var addedDate = {
                        date: res['date']                   
                    };
                    var temp = $('#date-badge').html();
                    var render = Mustache.render(temp, addedDate);
                    $('#chatSectionScroll').append(render);    
                }
                
                var msgtime = res['time'];
                var msgfinal = createTextLinks_(res['message']);
                
                var messageli = ' <div class="row m0">'+
                                    '<div class="col-md-12">'+
                                        '<div class="chat-container darker">'+
                                        // '<p class="cc-name">You</p>'+
                                        '<p class="cc-p">'+msgfinal+'</p>'+
                                        '<span class="time-left">'+msgtime+'</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                
                var parentDiv = document.getElementById('chatSectionScroll');
                parentDiv.innerHTML += messageli;
            }else{
                var res = {
                    message : data.val().message,
                    time: data.val().time,
                    date: data.val().date,
                    receiver : single_user_name
                };
                
                var msgtime = res['time'];
                var msgreceiver = res['receiver'];
                var msgfinal = createTextLinks_(res['message']);
                var msgSender = res['receiver'];
                
                var msgdate = res['date'].split(' ')[0];
                if(!existingDates[msgdate]){
                    existingDates[msgdate] = true;
                    var addedDate = {
                        date: res['date']                   
                    };
                    var temp = $('#date-badge').html();
                    var render = Mustache.render(temp, addedDate);
                    $('#chatSectionScroll').append(render);    
                }
                
                var messageli = ' <div class="row m0">'+
                                    '<div class="col-md-12">'+
                                        '<div class="chat-container ">'+
                                        // '<p class="cc-name">'+msgSender+'</p>'+
                                        '<p class="cc-p">'+msgfinal+'</p>'+
                                        '<span class="time-left">'+msgtime+'</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    
                
                var parentDiv = document.getElementById('chatSectionScroll');
                parentDiv.innerHTML += messageli;
            }
            
            if(data.val().receiver == current_user){
                var udata = {
                    sender: data.val().sender,
                    receiver: data.val().receiver,
                    message: data.val().message,
                    hasSeen: true
                };
                
                
                db
                .ref(specialKey + '/conversations/' + getUniqueId(single_user_id) + '/' + data.key)
                .update(udata);
                
                udata['uniqueid'] = getUniqueId(single_user_id);
                
                $.ajax({
                    type: 'POST',
                    url: '/account/messages/save-receiver',
                    data: udata
                 });
                
                db
                .ref(specialKey + '/notifications/' + current_user + '/' + data.val().sender)
                .remove();
            }
            
            var chatWindow = document.querySelector('.chat-cont');
            var xH = chatWindow.scrollHeight;
            chatWindow.scrollTo(0, xH);
         });
}
JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<script>

    function showDetails(animal) {
        console.log(animal);
        var filterVal = animal.getAttribute("data-value");
        var filterType = animal.getAttribute("data-id");
        var divId = document.getElementById(filterType);
        var activeElements  = document.querySelector(".user-list.ps .active");
        if(activeElements) {
            activeElements.classList.remove("active");
        }
        divId.classList.add('active');
        document.getElementById('fill-heading').innerHTML = filterVal;
    }
    // document.getElementById('sendMsg').addEventListener("click", sendChat);
    let getMsg = {
        pic: '@eyAssets/images/pages/candidate-profile/Girls2.jpg',
        mssg: document.getElementById('chatMsg').value,
        time:'11:11',
    }
    function sendChat() {
        var chatMsg = document.getElementById('chatMarkup').innerHTML;
        var output = Mustache.render(chatMsg);
        var a = document.createElement("div");
        a.innerHTML = output;
        document.getElementById('chatSectionScroll').append(a);
    }

</script>
<script id="date-badge" type="text/template">
    <div class="messagedate">
        <span>
            {{date}}
        </span>
    </div>
</script>
<script id="userCard" type="template/javascript">
    {{#.}}
    <div class="user-box chat-user" id="{{created_by}}" data-value="{{name}}">
        <div class="user-icon">
            <img src="{{image}}" class="user_img" alt="">
        </div>
        <div class="user-detail">
            <div class="user-name">{{name}}</div>
            <div class="user-com">{{city}}</div>
        </div>
    </div>
    {{/.}}
</script>

<script id="applicationCard" type="template/javascript">
    {{#.}}
    <div class="user-box jobsBoxes" data-id="{{application_enc_id}}">
        <div class="job-icon">
            <img src="<?= Url::to('@commonAssets/categories/{{icon}}') ?>" alt="">
        </div>
        <div class="user-detail">
            <div class="user-name">{{job_title}}</div>
            <div class="user-com">{{name}}</div>
            <div class="user-com disFlex"> <i class="fa fa-map-marker"></i>
                <ul>
                {{#applicationPlacementLocations}}
                    <li>{{name}}</li>
                {{/applicationPlacementLocations}}
                </ul>
                {{^applicationPlacementLocations}}
                    No Locations Mentioned
                {{/applicationPlacementLocations}}
            </div>
            <!--                                <div class="user-com"><i class="fa fa-inr"></i> 150000 </div>-->
        </div>
    </div>
    {{/.}}
</script>

<script id="chatMarkup" type="template/javascript">
    <div class="col-md-12">
        <div class="chat-container darker">
            <img src="" alt="Avatar" class="right" style="width:100%;">
            <p class="cc-p">{{getMsg.mssg}}</p>
        </div>
    </div>
</script>