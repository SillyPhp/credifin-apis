<?php
use yii\helpers\Url;

?>
<section>
    <div class="height-100VH">
        <div class="row">
            <div class="col-md-3 col-sm-3 padd-right-0">
                <div class="sec2">
                    <div class="user-list-heading">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="fill-heading">
                                    Jobs
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-right">
                                    <div class="dropdown text-left">
                                        <button class="dropbtn">Filters</button>
                                        <div class="dropdown-content" id="dc-btn">
                                            <div class="dc-btn" onclick="showDetails(this)" data-value="Jobs" data-id="fil-jobs">Jobs</div>
                                            <div class="dc-btn" onclick="showDetails(this)" data-value="Internships" data-id="fil-int">Internships</div>
                                            <div class="dc-btn" onclick="showDetails(this)" data-value="Locations" data-id="fil-loc">Location</div>
                                            <div class="dc-btn" onclick="showDetails(this)" data-value="Training Programs" data-id="fil-train">Training Programs</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="user-list" id="filterSectionScroll">
                    <div class="fill job-card active" id="fil-jobs">
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
                                <div class="user-com"><i class="fa fa-inr"></i> 150000</div>

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
                                <div class="user-com"><i class="fa fa-inr"></i> 150000</div>

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
                                <div class="user-com"><i class="fa fa-inr"></i> 150000</div>

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
                                <div class="user-com"><i class="fa fa-inr"></i> 150000</div>

                            </div>
                        </div>
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
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Mrs. Tarry</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Kulwinder Singh Sohal</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Shshank Vasisht</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Mrs. Tarry</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Mrs. Tarry</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Mrs. Tarry</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Kulwinder Singh Sohal</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
                    <div class="user-box">
                        <div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="user-detail">
                            <div class="user-name">Shshank Vasisht</div>
                            <div class="user-com">DSB Edu tech</div>
                        </div>
                    </div>
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
                    <div class="chating-user">
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
                    <div class="chat-cont" id="chatSectionScroll">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" style="width:100%;">
                                    <p class="cc-p">Hello. How are you today?</p>
                                    <span class="time-right">11:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container darker">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" class="right" style="width:100%;">
                                    <p class="cc-p">Hey! I'm fine. Thanks for asking!</p>
                                    <span class="time-left">11:01</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" style="width:100%;">
                                    <p class="cc-p">Sweet! So, what do you wanna do today?</p>
                                    <span class="time-right">11:02</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container darker">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" class="right" style="width:100%;">
                                    <p class="cc-p">Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
                                    <span class="time-left">11:05</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container darker">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" class="right" style="width:100%;">
                                    <p class="cc-p">Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
                                    <span class="time-left">11:05</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container darker">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" class="right" style="width:100%;">
                                    <p class="cc-p">Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
                                    <span class="time-left">11:05</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chat-container darker">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                         alt="Avatar" class="right" style="width:100%;">
                                    <p class="cc-p">Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
                                    <span class="time-left">11:05</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-form-bttm">
                        <form action="">
                            <div class="chat-input-cs">
                                <input type="text" placeholder="Type Message" id="chatMsg">
                                <button type="button" id="sendMsg">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.footer{
    margin-top: 0px !important;
}
.dc-btn:hover{
    cursor:pointer;
}
.dc-btn{
    font-weight:normal;
}
.fill{
    display: none;
}
.dropbtn {
  color: #000;
  font-size: 16px;
  border: none;
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
.user-list-heading{
    padding:10px 10px;
    background: #f2f2f2;
    font-family: roboto;
    font-size:18px;
    font-weight:bold;
}
#chat-icon{
    display:none;
}
/*----chat section----*/
.chat-cont{
    position:relative;
    height:calc(100vh - 225px);   
}
.chating-user{
    background:#f2f2f2;
}
.cc-p{ 
    margin: 0px !important
}
.chat-container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 5px;
  max-width: 80%;
  float:left
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
  float:right;
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
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}

.chat-input-cs{
       display: flex;
    width: 100%;
}
.chat-input-cs button{
    width:20%;
}
.chat-input-cs input{
    padding:10px 5px;
    width:100%; 
}
.chat-form-bttm{
    width:100%;
    position:absolute;
    bottom: 95px;
}
.chat-form-bttm form{
    display: flex;
}
.height-100VH{
    height:calc(100vh - 90px);
    overflow:hidden; 
}
.chat-section{
    position:relative;
    background:#e4dcd3;
    height:100vh;
    width:100%;
}

/*----chat section ends----*/
.sec2{
    height: 100vh
}
.user-list{
    height:calc(100vh - 140px);
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
  margin-top:40px !important;
  margin-bottom:0px !important;  
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
    font-size: 16px;
    font-weight:bold;
    color:#000;
    font-family: roboto
}
.user-box{
    display:flex;
    padding:15px 10px;
    border-bottom:1px solid #eee
}
.user-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.3)
}
.active{
    display:block !important;
}
');
$script = <<<JS
var ps = new PerfectScrollbar('#chatSectionScroll');
var js = new PerfectScrollbar('#userSectionScroll');
var sh = new PerfectScrollbar('#filterSectionScroll');
// var ps = new PerfectScrollbar('#fil-jobs');
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


    document.getElementById('sendMsg').addEventListener("click", sendChat);
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
<script id="chatMarkup" type="template/javascript">
    <div class="col-md-12">
        <div class="chat-container darker">
            <img src="" alt="Avatar" class="right" style="width:100%;">
            <p class="cc-p">{{getMsg.mssg}}</p>
        </div>
    </div>
</script>