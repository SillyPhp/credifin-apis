<?php
use yii\helpers\Url;
?>

<div class="chat-btn">
    <button type="button" id="trigger"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/chat-button-blue.png')?>"></button>
</div>
<div class="chat-list fadeout" id="fader">
    <div class="chat-list-heading">Connections</div>
    <div class="srch-form">
        <form>
            <input type="text" placeholder="Search">
        </form>
    </div>
    <ul>
        <li>
            <button class="chat-click" type="button" id="1">
                <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Shshank Vasisht</div>
            </div>
            </button>
        </li>
        <li>
            <button class="chat-click" type="button" id="2">
            <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Shalya Gupta</div>
            </div>
            </button>
        </li>
        <li>
            <button class="chat-click" type="button" id="3">
            <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Ajay Juneja</div>
            </div>
            </button>
        </li>
        <li>
            <button class="chat-click" type="button" id="4">
            <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Shashank Bansal</div>
            </div>
            </button>
        </li>
        <li>
            <button class="chat-click" type="button" id="5">
            <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Nikhil Kumar</div>
            </div>
            </button>
        </li>
        <li>
            <button class="chat-click" type="button" id="6">
            <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Sourav Chayal</div>
            </div>
            </button>
        </li>
        <li>
            <button class="chat-click" type="button" id="7">
            <div class="chat-person">
                <div class="c-icon"><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>"></div>
                <div class="c-name">Tarandeep Singh Rakhra</div>
            </div>
            </button>
        </li>
    </ul>
</div>
<div class="chat-section fadeout" id="fader1">
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bubble font-hide hide"></i>
                <span class="caption-subject font-hide bold uppercase">Chat</span>
            </div>
<!--            <div class="actions">-->
<!--                <div class="portlet-input input-inline">-->
<!--                    <div class="input-icon right">-->
<!--                        <i class="icon-magnifier"></i>-->
<!--                        <input type="text" class="form-control input-circle" placeholder="search..."> </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="closeBtn">
                <button type="button" onclick="closeButton()">X</button>
            </div>
        </div>
        <div class="portlet-body" id="chats">
            <div class="scroller"data-always-visible="1" data-rail-visible1="1">
                <ul class="chats">
                    <li class="out">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Lisa Wong </a>
<!--                            <span class="datetime"> at 20:11 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="out">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Lisa Wong </a>
<!--                            <span class="datetime"> at 20:11 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="in">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Bob Nilson </a>
<!--                            <span class="datetime"> at 20:30 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="in">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Bob Nilson </a>
<!--                            <span class="datetime"> at 20:30 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="out">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Richard Doe </a>
<!--                            <span class="datetime"> at 20:33 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="in">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Richard Doe </a>
<!--                            <span class="datetime"> at 20:35 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="out">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Bob Nilson </a>
<!--                            <span class="datetime"> at 20:40 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="in">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Richard Doe </a>
<!--                            <span class="datetime"> at 20:40 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                        </div>
                    </li>
                    <li class="out">
<!--                        <img class="avatar" alt="" src="--><?//= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?><!--" />-->
                        <div class="message">
                            <span class="arrow"> </span>
                            <a href="javascript:;" class="name"> Bob Nilson </a>
<!--                            <span class="datetime"> at 20:54 </span>-->
                            <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet. </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="chat-form">
                <div class="input-cont">
                    <input class="form-control" type="text" placeholder="Type a message here..." /> </div>
                <div class="btn-cont">
                    <span class="arrow"> </span>
                    <a href="" class="btn blue icn-only">
                        <i class="fa fa-check icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss("
*:focus{
    outline:none;
}
.chat-btn{
    position:fixed;
    bottom:10px;
    right:20px;
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
    bottom:100px;
    right:250px;
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
    max-height: 250px !important;
    overflow: hidden;
    width: auto;
    bottom:100px;
    right:50px;
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
");
$script = <<<JS
document.getElementById('trigger').addEventListener('click', showDiv);
	
 function showDiv(){
    var a = document.getElementById('fader');
    if(a.classList.contains('fadeout')){
        a.classList.remove('fadeout');
        a.classList.add('fadein');
    }else{
        a.classList.remove('fadein');
        a.classList.add('fadeout');
    }
 }
 

    document.addEventListener('click',function(e) {
        var b = e.srcElement;
        if(b.className == "chat-person" || b.className == "c-name" || b.className == "chat-click" || b.className == "c-icon" ){
            console.log(b.closest("button").id);
            var a = document.getElementById('fader1');
                if(a.classList.contains('fadeout')){
                    a.classList.remove('fadeout');
                    a.classList.add('fadein');
                }else{
                    a.classList.remove('fadein');
                    a.classList.add('fadeout');
                }
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
//$this->registerJsFile('@eyAssets/js/chat.min.js');
?>
<script>
    function closeButton() {
        var fader1 = document.getElementById('fader1');
        if(fader1.classList.contains('fadein')){
            fader1.classList.remove('fadein');
            fader1.classList.add('fadeout');
        }
    }
</script>
