<?php
use yii\helpers\Url;
?>

<input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id ?>" id="current-user">
<input type="hidden" value="<?= Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name ?>" id="current-name">

<div class="chat-btn">
    <button type="button" id="trigger"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/chat-button-blue.png')?>"></button>
</div>

<div class="chat-list fadeout" id="fader">
    <div class="chat-list-heading">Conversations</div>
    <div class="srch-form">
        <form>
            <input type="text" id="search-user" placeholder="Search">
        </form>
    </div>
    <ul class="conversations-list">

    </ul>
</div>


<div class="chat-section" id="chat-box">

</div>
<?php
$this->registerCss("
*:focus{
    outline:none;
}
.chat-btn{
    position:fixed;
    bottom:10px;
    right:30px;
}
.chat-btn button{
    background:none;
    border:none;
}
.fadein, .fadeout {
    opacity: 0;
    -moz-transition: opacity 0.4s ease-in-out;
    -o-transition: opacity 0.4s ease-in-out;
    -webkit-transition: opacity 0.4s ease-in-out;
    transition: opacity 0.4s ease-in-out;
}
.fadein {
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
.chat-list ul li{
    padding:5px 0px ;
    list-style-type:none;
    border-bottom:1px solid #eee;
}
.chat-list ul li button{
    background:none;
    border: none;
    width:100%;
}
.chat-list ul{
    padding-inline-start:0px !important;
}
.chat-list ul li:last-child{
    border-bottom:none;
}
.chat-list{
    background:#fff;
    padding:0px 0px;
    border:1px solid #eee;
    border-radius:10px;
    position:fixed;
    z-index:9999;
    bottom:70px;
    right:20px;
}
.chat-list-heading{
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
.chat-section{
    max-width:400px;
    max-height:300px !important; 
     position:fixed;
    bottom:70px;
    right:342px;
    z-index:99999;
}
#msg-box{position:relative;min-height:300px;}
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
    padding-bottom:50px;
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
.conversations-list{
    max-height: 300px;
    overflow-y: scroll;
    width: 320px;
}
");
$script = <<<JS

    var db = firebase.database();

    $(document).on('keyup', '#search-user', function(e){
        if(e.keyCode >= 65 && e.keyCode <= 90){
            var data = {
                key : $(this).val() 
            };
            if(data["key"]){
                $.ajax({
                    type: 'POST',
                    url: '/account/chat/search-user',
                    data: data,
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.length > 0){
                          var template = $('#conversations').html();
                          var rendered = Mustache.render(template, response);
                          $('.conversations-list').html(rendered);
                          utilities.initials();
                        }
                    }
                });
            }
        }
    });
  
  //trigger chat list
 document.getElementById('trigger').addEventListener('click', showDiv);
	
 //function for triggering chat list
 function showDiv(){
    var a = document.getElementById('fader');
    if(a.classList.contains('fadeout')){
        a.classList.remove('fadeout');
        a.classList.add('fadein');
    }else{
        a.classList.remove('fadein');
        a.classList.add('fadeout');
        var msgbox = document.getElementById('msg-box');
        msgbox.remove();
        
    }
 }
 
 $(document).on('click','#close-btn', function(){
     var msgbox = document.getElementById('msg-box');
     msgbox.remove();
 });
 
 function getUniqueId(){
     var user_id = $('#msginput').parent().attr('id');
     var current_user = $('#current-user').val();
     if(user_id < current_user){
         return user_id + current_user
     }else{
         return current_user + user_id;
     }
 }
 
 function sendMessage(){
     
     var msginput = $('#msginput').val();
     var user_id = $('#msginput').parent().attr('id');
     var current_user = $('#current-user').val();
     var unique_id = getUniqueId();
     
     if(msginput){
        
         var converseRef = db.ref('/conversations/' + unique_id );
         
         var data = {
            sender : current_user,
            receiver : user_id,
            message : msginput,
         };
         var key = converseRef.push(data).key;
       
        // var converseRef = db.ref('/conversations/' + unique_id );
        // converseRef.on('child_added', function(data){
        //     if(data.val().sender == $('#current-user').val()){
        //         var res = {
        //             message : data.val().message,
        //             sender : $('#current-name').val()
        //         }
        //         var temp2 = $('#message-sent').html();
        //         var render2 = Mustache.render(temp2, res);
        //         $('.message-list').append(render2);
        //     }else{
        //         var res = {
        //             message : data.val().message,
        //             receiver : $('#msginput').parent().attr('data-name')
        //         }
        //         var temp2 = $('#message-received').html();
        //         var render2 = Mustache.render(temp2, res);
        //         $('.message-list').append(render2);
        //     }
        //  });
        $('#msginput').val('');
        $('#msginput').focus();
     }
 }
 
 $(document).on('click','#sendmsg', function(){
    sendMessage();    
 });
 $(document).on("keypress", "#msginput",function(event){
    if(event.which == '13'){
        sendMessage();
    }
});
 function showNewData(data){
        if(data.val().sender == $('#current-user').val()){
            var res = {
                message : data.val().message,
                sender : $('#current-name').val()
            }
            var temp2 = $('#message-sent').html();
            var render2 = Mustache.render(temp2, res);
            $('.message-list').append(render2);
        }else{
            var res = {
                message : data.val().message,
                receiver : $('#msginput').parent().attr('data-name')
            }
            var temp2 = $('#message-received').html();
            var render2 = Mustache.render(temp2, res);
            $('.message-list').append(render2);
        }
 }
    
 document.addEventListener('click',function(e) {
    var b = e.srcElement;
    if(b.className == "chat-person" || b.className == "c-name" || b.className == "chat-click" || b.className == "c-icon" ){
            var data = {
                id: b.closest("button").id
            };
            
            var result = {};
            $.ajax({
                    type: 'POST',
                    async: false,
                    url: '/account/chat/get-name',
                    data: data,
                    success: function(response) {
                        response = JSON.parse(response);
                        result['response'] = response;
                    }
            });
            
            var temp1 = $('#message-box').html();
            var render1 = Mustache.render(temp1, result['response']);
            $('#chat-box').html(render1);            
            
            firebase
                .database()
                .ref('/conversations/' + getUniqueId())
                .off();
            
            firebase
                .database()
                .ref('/conversations/' + getUniqueId())
                .on('child_added', showNewData);
            
            // var unique_id = getUniqueId();
            //
            // var converseRef = db.ref('/conversations/' + unique_id );
            // converseRef.once('value')
            //     .then(function(d){
            //             $.each(d.val(), function(key, data){
            //                 if(data.sender == $('#current-user').val()){
            //                     var res = {
            //                         message : data.message,
            //                         sender : $('#current-name').val()
            //                     };
            //                     var temp2 = $('#message-sent').html();
            //                     var render2 = Mustache.render(temp2, res);
            //                     $('.message-list').append(render2);
            //                 }else{
            //                     var resp = {
            //                         message : data.message,
            //                         receiver : $('#msginput').parent().attr('data-name')
            //                     };
            //                     var temp3 = $('#message-received').html();
            //                     var render3 = Mustache.render(temp3, resp);
            //                     $('.message-list').append(render3);
            //                 }
            //             })
            //     })
    }
  })
 
 function chats() {
    var e = $("#chats"),
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
<script id="conversations" type="text/template">
    {{#.}}
    <li>
    <button class="chat-click" type="button" id="{{user_enc_id}}">
        <div class="chat-person">
            {{#image}}
                <div class="c-icon"><img src="{{image}}"></div>
            {{/image}}
            {{^image}}
            <canvas class="user-icon" name="{{first_name}} {{last_name}}" width="30" height="30"
                    color="{{initials_color}}" font="18px"></canvas>
            {{/image}}
            <div class="c-name">{{first_name}} {{last_name}}</div>
    </div>
    </button>
    </li>
    {{/.}}
</script>

<script id="message-sent" type="text/template">
    <li class="out">
        <div class="message">
        <span class="arrow"> </span>
        <a href="javascript:;" class="name">{{sender}}</a>
    <span class="body">{{message}}</span>
    </div>
    </li>
</script>
<script id="message-received" type="text/template">
    <li class="in">
        <div class="message">
            <span class="arrow"> </span>
            <a href="javascript:;" class="name">{{receiver}}</a>
            <span class="body">{{message}}</span>
        </div>
    </li>
</script>
<script id="message-box" type="text/template">
    <div class="portlet light dynamic-chat" id="msg-box">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bubble font-hide hide"></i>
                <span class="caption-subject font-hide bold uppercase">{{first_name}} {{last_name}}</span>
            </div>
            <div class="closeBtn">
                <button type="button" id="close-btn">X</button>
            </div>
        </div>
        <div class="portlet-body" id="chats">
            <div class="scroller" data-always-visible="1" data-rail-visible1="1">
                <ul class="chats message-list">

                </ul>
            </div>
            <div class="chat-form">
                <div class="input-cont" id="{{user_enc_id}}" data-name="{{first_name}} {{last_name}}">
                    <input class="form-control" type="text" placeholder="Type a message here..." id="msginput"/>
                </div>
                <div class="btn-cont" id="sendmsg">
                    <span class="arrow"> </span>
                    <a href="#" class="btn blue icn-only">
                        <i class="fa fa-check icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</script>