<?php
use yii\helpers\Url;
?>

<input type="hidden" value="<?= Yii::$app->user->identity->organization->organization_enc_id ? Yii::$app->user->identity->user_enc_id : null ?>" id="current-organization-user">
<input type="hidden" value="<?= Yii::$app->user->identity->organization->organization_enc_id ? Yii::$app->user->identity->organization->organization_enc_id : Yii::$app->user->identity->user_enc_id ?>" id="current-user">
<input type="hidden" value="<?= Yii::$app->user->identity->organization->organization_enc_id ? Yii::$app->user->identity->organization->name : Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name ?>" id="current-name">

<div id="chat-icon">
    <button type="button" id="trigger"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/chat-button-blue.png')?>"></button>
</div>

<div class="fadeout" id="chat-list">
    <div id="chat-list-heading">Conversations</div>
    <div class="srch-form">
            <input type="text" id="search-user" placeholder="Search">
    </div>
    <ul id="users-list">

    </ul>
</div>


<div id="chat-box">

</div>

<?php
$this->registerCss("
*:focus{
    outline:none;
}
#chat-icon{
    position:fixed;
    bottom:10px;
    right:30px;
}
#chat-icon button{
    background:none;
    border:none;
}
.fadein, .fadeout {
    display:none;
    opacity: 0;
    -moz-transition: opacity 0.4s ease-in-out;
    -o-transition: opacity 0.4s ease-in-out;
    -webkit-transition: opacity 0.4s ease-in-out;
    transition: opacity 0.4s ease-in-out;
}
.fadein {
    display:block;
    opacity: 1;
}
.c-icon img{
    max-width:30px;
    border-radius:50%;
}
.c-name{
    color:#000;
    padding:5px 5px 0 5px;
}
.chat-person{
    display:flex;
}
#chat-list ul li{
    padding:5px 0px ;
    list-style-type:none;
    border-bottom:1px solid #eee;
}
#chat-list ul li button{
    background:none;
    border: none;
    width:100%;
}
.chats.message-list{margin-bottom:50px}
#chat-list ul{
    padding-inline-start:0px !important;
}
#chat-list ul li:last-child{
    border-bottom:none;
}
#chat-list{
    background:#fff;
    padding:0px 0px;
    border:1px solid #eee;
    border-radius:10px;
    position:fixed;
    z-index:9999;
    bottom:70px;
    right:20px;
}
#chat-list-heading{
    background:#eee;
    padding:10px 5px;
    font-size:16px;
    border-radius:10px 10px 0 0 ;
}
.srch-form{
    padding:0px 0px 5px 0px;
}
.srch-form input{
    width:100%;
    padding:8px 5px;
    border:1px solid #eee;
    font-size:13px;
}
#chat-box{
    max-width:1000px;
    max-height:300px !important; 
     position:fixed;
    bottom:70px;
    right:342px;
    z-index:99999;
}
#chat-box .portlet.light.dynamic-chat{
    float:left;
}
.dynamic-chat{position:relative;min-height:300px;}
.chat-form{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}
.chats li.in .message{
    margin-left: 10px !important;
}
.chats li.out .message{
    margin-right: 10px !important;
}
.slimScrollDiv{
    position: relative;
    overflow: hidden;
    width: auto;
    max-height: 250px !important;
}
.scroller{
    max-width:350px;
    min-width:250px;
    max-height: 250px !important;
    overflow: hidden;
    width: auto;
    bottom:100px;
    right:50px;
//    padding-bottom:50px;
}
.closeBtn{
    position:absolute;
    top:0;
    right:0
}
.closeBtn button{
    background:none;
    color:#ddd;
    border-width:1px  ;
    border-style:solid;
    border-color:#fff #fff #eee #eee;
    border-radius:0 0 0 8px;
    padding:5px 10px;
    font-weight:bold;
}
.closeBtn button:hover{
    background:#00a0e3;
    color:#fff;
     border-color:#00a0e3;
     transition:.3s all;
}
.portlet.light{
    padding:12px 10px 15px !important;
}

element.style {
}
.scroller {
    overflow-y: scroll;
}
#users-list{
    max-height: 300px;
    overflow-y: scroll;
    width: 320px;
}
.chat-bounce {
  -webkit-animation-duration: 1.5s;
  animation-duration: 1.5s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation-timing-function: linear;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  -webkit-animation-iteration-count: infinite;
} 
@-webkit-keyframes bounce {
  0%, 20%, 40%, 60%, 80%, 100% {-webkit-transform: translateY(0);}
  50% {-webkit-transform: translateY(-10px);}
} 
@keyframes bounce { 
  0%, 20%, 40%, 60%, 80%, 100% {transform: translateY(0);}
  50% {transform: translateY(-10px);}
} 
.chat-bounce { 
  -webkit-animation-name: bounce;
  animation-name: bounce;
}
.chat-person span.badge{
    background-color: red;
    box-shadow: 0px 0px 6px 1px #ddd;
}
#red-btn{
    width: 20px;
    height: 20px;
    background-color: red;
    position: absolute;
    border-radius: 50%;
    right: 3px;
    z-index: 4;
}
.messagedate{
    text-align: center;
}
.messagedate span{
    min-width: 80px;
    background-color: #ddd;
    margin: auto;
    padding: 5px 20px;
    border-radius: 20px;
}
.name span{color:#666;font-size:11px;}
");
$script = <<<JS
    
    //all variables defined
    var current_user = $('#current-user').val(); //id of current user   
    var current_organization_user = $('#current-organization-user').val(); //id of current organization user   
    var current_user_name = $('#current-name').val(); // name of current user
    var chat_icon = document.getElementById('chat-icon'); // chat icon
    var chat_list = document.getElementById('chat-list');// main id of conversations list
    var specialKey = 'BnE3860mWdnBEZMLXlwkdjw9A2K5DJ';
    var search_user = document.getElementById('search-user'); // search user input id
    var users_list = document.getElementById('users-list'); // id of ul in conversations list
    var chat_icon_button = document.getElementById('trigger');
    var chat_box = document.getElementById('chat-box');
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
    var sender = {
        id: null
    };
    
     //utilities
     function random_users(){
        $.ajax({
                type: 'POST',
                url: '/account/chat/get-random-values',
                success: function(response) {
                    
                    response = JSON.parse(response);
                    
                    var template = $('#users').html();
                    var rendered = Mustache.render(template, response);
                    $('#users-list').html(rendered);
                    // utilities.initials();
                }
        });
    }
    
     function  recent_users() {
        var final_users = {};
        $.ajax({
            type: 'POST',
            url: '/account/chat/get-recent-users',
            success: function(response) {
                response = JSON.parse(response);
               
                if(response.code == 200){
                   
                    var recent_active_users = response.data;
                    
                    var listed_users_id = [];
                    for(var z=0; z<users_list.children.length; z++){
                        listed_users_id.push(users_list.children[z].firstElementChild.id);
                    }
                    
                    for(var o = 0; o < recent_active_users.length; o++){
                        if(listed_users_id.includes(recent_active_users[o]["user_enc_id"])){
                            delete recent_active_users[o];
                        }
                    }
                    var resultant = recent_active_users.filter(function(d){
                        return d['user_enc_id'] != undefined;
                    });
                    
                    var template = $('#users').html();
                    var rendered = Mustache.render(template, resultant);
                    $('#users-list').prepend(rendered);
                    // utilities.initials();
                }
            }
        });
     }
    
     function getUniqueId(user_id){
         if(user_id < current_user){
             return user_id + current_user
         }else{
             return current_user + user_id;
         }
     }
    
     function sendMessage(t){
         msginput = t.closest('.msginput').val() || t.siblings('.input-cont').find('.msginput').val();
         var user_id = t.parents('.dynamic-chat').attr('data-id');
         var unique_id = getUniqueId(user_id);
         
         if(msginput){
            msginput = msginput.trim();
         }
         
         if(msginput && msginput.length < 1500){
             var converseRef = db.ref(specialKey + '/conversations/' + unique_id );
             var currentDate = new Date();
             var senddate = currentDate.getDate() + " " + monthDict[currentDate.getMonth()];
             var sendtime = currentDate.getHours() + ":" + currentDate.getMinutes();
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
                url: '/account/chat/save-sender',
                data: data
             });
             
             $.ajax({
                type: 'GET',
                url: 'https://us-central1-empoweryouth-49c18.cloudfunctions.net/sendMessages',
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
    
    //event for chat icon click
    chat_icon_button.addEventListener('click', function(){
            if(chat_list.classList.contains('fadeout')){
                    chat_list.classList.remove('fadeout');
                    chat_list.classList.add('fadein');
                    if(chat_icon.classList.contains('chat-bounce')){
                            chat_icon.classList.remove('chat-bounce');
                    }
            }else{
                    chat_list.classList.remove('fadein');
                    chat_list.classList.add('fadeout');
                    while (chat_box.firstChild) {
                        if(chat_box.firstChild.innerText){
                            db
                             .ref(specialKey + '/conversations/' + getUniqueId(chat_box.firstChild.getAttribute('data-id')))
                             .off();
                        }
                        chat_box.removeChild(chat_box.firstChild);
                    }
                    if(chat_icon.classList.contains('chat-bounce')){
                        chat_icon.classList.remove('chat-bounce');
                    }
             }
    })
    
    //list users on chat icon
    random_users();
     recent_users();
    
    //search users on search
    $(document).on('keyup', '#search-user', function(e){
            var user = $(this).val();
            var data = {};
            data["user"] = user;
            if(data["user"]){
                $.ajax({
                    type: 'POST',
                    url: '/account/chat/search-user',
                    data: data,
                    success: function(response) {
                       
                        response = JSON.parse(response);
                       
                        if(response.length > 0){
                          var template = $('#users').html();
                          var rendered = Mustache.render(template, response);
                          $('#users-list').html(rendered);
                          // utilities.initials();
                        }
                        else{
                          var template = $('#no-user').html();
                          var rendered = Mustache.render(template);
                          $('#users-list').html(rendered);
                        }
                    }
                });
            }else{
                random_users();
                recent_users();
            }
    });
    
    //event triggered while clicking on listed users
    $(document).on('click', '.single-user', function(){
        
        //removing bounce
        if(chat_icon.classList.contains('chat-bounce')){
            chat_icon.classList.remove('chat-bounce');
        }
        
        //removing badge
        var badgeExists = $(this).find('.badge');
        if(badgeExists){
            badgeExists.remove();
        }
        var btnExists = document.getElementById('red-btn');
        if(btnExists){
            btnExists.remove();
        }
        
        var single_user_id = $(this).attr('id');
        var single_user_name = $(this).find('.c-name').text();
        
        var d = {
            user_enc_id: single_user_id,
            name: single_user_name
        };
    
        var template = $('#message-box').html();
        var render = Mustache.render(template, d);
        $('#chat-box').html(render);
        
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
                        $('.message-list').append(render);    
                    }
                    
                    var msgtime = res['time'];
                    var msgfinal = createTextLinks_(res['message']);
                    
                    var messageli = '<li class="out">'+
                                        '<div class="message">'+
                                            '<span class="arrow"> </span>'+
                                            '<a href="#" class="name">You <span>'+msgtime+'</span></a>'+
                                            '<span class="body">'+msgfinal+'</span>'+
                                        '</div>'+
                                     '</li>';
                    
                    var parentDiv = document.getElementById('msg-list');
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
                    
                    var msgdate = res['date'].split(' ')[0];
                    if(!existingDates[msgdate]){
                        existingDates[msgdate] = true;
                        var addedDate = {
                            date: res['date']                   
                        };
                        var temp = $('#date-badge').html();
                        var render = Mustache.render(temp, addedDate);
                        $('.message-list').append(render);    
                    }
                    
                    
                    var messageli = '<li class="in">'+
                                        '<div class="message">'+
                                            '<span class="arrow"> </span>'+
                                            '<a href="#" class="name">'+msgreceiver+' <span>'+msgtime+'</span></a>'+
                                            '<span class="body">'+msgfinal+'</span>'+
                                        '</div>'+
                                     '</li>';
                    
                    var parentDiv = document.getElementById('msg-list');
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
                        url: '/account/chat/save-receiver',
                        data: udata
                     });
                    
                    db
                    .ref(specialKey + '/notifications/' + current_user + '/' + data.val().sender)
                    .remove();
                }
                
                var chatWindow = document.querySelector('.scroller');
                var xH = chatWindow.scrollHeight;
                chatWindow.scrollTo(0, xH);
             });
    });
    
    //closing chat box
     $(document).on('click','.close-btn', function(){
         var single_user_id = $(this).parents('.dynamic-chat').attr('data-id');
         db
         .ref(specialKey + '/conversations/' + getUniqueId(single_user_id))
         .off();
         
         $(this).parents('.dynamic-chat').remove();
     });
    
    //sending messages
     $(document).on('click','.sendmsg', function(){
         var t = $(this);
         sendMessage(t);    
     });
     $(document).on("keypress", ".msginput",function(event){
        if(event.which == '13'){
            var t = $(this);
            sendMessage(t);
        }
     });   
    
    //listening messages
    db.
    ref(specialKey + '/notifications/' + current_user)
    .on('child_added', function(data){
        
        //add bounce
        if(! chat_icon.classList.contains('chat-bounce')){
                chat_icon.classList.add('chat-bounce');
        }
        
        //finding sender
        sender['id'] = data.key;
        
        //removing sender from list if already exists
        var already_exists = document.getElementsByClassName('single-user');
        for(var z=0; z<already_exists.length; z++){
            if(already_exists[z].id == sender['id']){
                  already_exists[z].parentNode.remove();
                  break;
            }
        }
        
        //adding sender at top with badge
        var result = {};
        $.ajax({
                type: 'POST',
                async: false,
                url: '/account/chat/get-name',
                data: sender,
                success: function(response) {
                    response = JSON.parse(response);
                    result['response'] = response;
                }
        });
        
        if(users_list.childElementCount <= 1){
            if(users_list.children[0]){
                users_list.children[0].remove();
            }
        }
        
        var template = $('#users').html();
        var rendered = Mustache.render(template, result['response']);
        $('#users-list').prepend(rendered);
        
        var userslist = document.querySelector('#users-list');
        
        //check if chat box is already opened
        var m = document.getElementById("dynamic-chat");
        if(m){
            var boxid = m.getAttribute("data-id");
            if(boxid == sender['id']){
                chat_icon.classList.remove('chat-bounce');
                
                //removing badge
                var findUser = $('.single-user ' + sender['id']);
                var badgeExists = findUser.find('.badge');
                if(badgeExists){
                    badgeExists.remove();
                }
                var btnExists = document.getElementById('red-btn');
                if(btnExists){
                    btnExists.remove();
                }
            }
        }else{
            var sp = document.createElement('span');
            sp.className = 'badge';
            sp.innerHTML = 'New';
            userslist.children[0].querySelector('.chat-person').appendChild(sp);
            var redbtn = '<span id="red-btn"></span>';
            document.getElementById('trigger').innerHTML += redbtn; 
        }
        // utilities.initials();
    })
    
 function chats() {
    var e = $(".chats-main"),
        t = $(".chats", e),
        a = $(".chat-form", e),
        i = $("input", a),
        l = $(".btn", a),
        o = function(a) {
            a.preventDefault();
            var l = i.val();
            if (0 != l.length) {
                var o = new Date,
                    n = o.getHours() + ":" + o.getMinutes(),
                    r = "";
                r += '<li class="out">', r += '<img class="avatar" alt="" src="/assets/themes/ey/images/pages/candidate-profile/Girls2.jpg"/>', r += '<div class="message">', r += '<span class="arrow"></span>', r += '<a href="#" class="name">Bob Nilson</a>&nbsp;', r += '<span class="datetime">at ' + n + "</span>", r += '<span class="body">', r += l, r += "</span>", r += "</div>", r += "</li>";
                t.append(r);
                i.val("");
                var s = function() {
                    var t = 0;
                    return e.find("li.out, li.in").each(function() {
                        t += $(this).outerHeight()
                    }), t
                };
                e.find(".scroller").slimScroll({
                    scrollTo: s()
                })
            }
        };
    $("body").on("click", ".message .name", function(e) {
        e.preventDefault();
        var t = $(this).text();
        i.val("@" + t + ":"), App.scrollTo(i)
    }), l.click(o), i.keypress(function(e) {
        if (13 == e.which) return o(e), !1
    })
 }
        
 chats();
 
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyDRQXJJP1rOOh8omclQ7146ME-oL9tNDAg",
        authDomain: "empoweryouth-49c18.firebaseapp.com",
        databaseURL: "https://empoweryouth-49c18.firebaseio.com",
        projectId: "empoweryouth-49c18",
        storageBucket: "empoweryouth-49c18.appspot.com",
        messagingSenderId: "173074095977"
    };
    firebase.initializeApp(config);
</script>
<script id="no-user" type="text/template">
    <li>
        No User Found
    </li>
</script>
<script id="users" type="text/template">
    {{#.}}
        <li>
            <button class="single-user" type="button" id="{{user_enc_id}}">
                <div class="chat-person">
                        {{#image}}
                            <div class="c-icon"><img src="{{image}}"></div>
                        {{/image}}
                        {{^image}}
                        <div class="c-icon"><img src="https://ui-avatars.com/api/?name={{first_name}}+{{last_name}}&background={{initials_color}}&color=fff&size=30&font-size=0.55"></div>
<!--                            <canvas class="user-icon" name="{{first_name}} {{last_name}}" width="30" height="30"-->
<!--                                color="{{initials_color}}" font="18px"></canvas>-->
                        {{/image}}
                        <div class="c-name">{{first_name}} {{last_name}}</div>
                </div>
            </button>
        </li>
    {{/.}}
</script>
<script id="date-badge" type="text/template">
    <li class="messagedate">
        <span>
            {{date}}
        </span>
    </li>
</script>
<script id="message-box" type="text/template">
    <div class="portlet light dynamic-chat" data-id="{{user_enc_id}}" data-value="{{name}}">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bubble font-hide hide"></i>
                <span class="caption-subject font-hide bold uppercase">{{name}}</span>
            </div>
            <div class="closeBtn">
                <button type="button" class="close-btn">X</button>
            </div>
        </div>
        <div class="portlet-body chats-main">
            <div class="scroller" data-always-visible="1" data-rail-visible1="1">
                <ul class="chats message-list" id="msg-list">

                </ul>
            </div>
            <div class="chat-form">
                <div class="input-cont">
                    <input class="form-control msginput" type="text" placeholder="Type a message here..."/>
                </div>
                <div class="btn-cont sendmsg">
                    <span class="arrow"> </span>
                    <a href="#" class="btn blue icn-only">
                        <i class="fa fa-check icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</script>