<?php
    use yii\helpers\Url;
?>
<section>
    <div class="row mt3">
        <div class="col-md-12">
           <div class="mentor-heading">My Webinars</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="my-webinar-box">
                <div class="join-webinar-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>">
                </div>
                <div class="webi-date"><span class="cont">12</span><br><span class="abs">july</span></div>
                <div class="invite-webinar-details">
                    <div class="invite-webinar-title">Business Conferences 2020</div>
                    <div class="invite-webinar-city"><i class="far fa-clock"></i> 12:00pm</div>
                </div>
                <div class="new-btns">
                    <div class="join-btn naam">
                        <button type="button">Edit</button>
                    </div>
                    <div class="detail-btn naam">
                        <button type="button">View</button>
                    </div>
                    <div class="sharing-btn naam">
                        <button type="button" class="ql-share" title="share with friend">Share <i class="fa fa-share-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="my-webinar-box">
                <div class="join-webinar-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>">
                </div>
                <div class="webi-date"><span class="cont">12</span><br><span class="abs">july</span></div>
                <div class="invite-webinar-details">
                    <div class="invite-webinar-title">Business Conferences 2020</div>
                    <div class="invite-webinar-city"><i class="far fa-clock"></i> 12:00pm</div>
                </div>
                <div class="new-btns">
                    <div class="join-btn naam">
                        <button type="button">Edit</button>
                    </div>
                    <div class="detail-btn naam">
                        <button type="button">View</button>
                    </div>
                    <div class="sharing-btn naam">
                        <button type="button" class="ql-share" title="share with friend">Share <i class="fa fa-share-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="my-webinar-box">
                <div class="join-webinar-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>">
                </div>
                <div class="webi-date"><span class="cont">12</span><br><span class="abs">july</span></div>
                <div class="invite-webinar-details">
                    <div class="invite-webinar-title">Business Conferences 2020</div>
                    <div class="invite-webinar-city"><i class="far fa-clock"></i> 12:00pm</div>
                </div>
                <div class="new-btns">
                    <div class="join-btn naam">
                        <button type="button">Edit</button>
                    </div>
                    <div class="detail-btn naam">
                        <button type="button">View</button>
                    </div>
                    <div class="sharing-btn naam">
                        <button type="button" class="ql-share" title="share with friend">Share <i class="fa fa-share-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="shareQuizModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="qModal">
            <h2>Share This Webinar</h2>
            <div class="qm-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>" alt="">
            </div>
            <p class="qm-name">Webinar on Business Conferences 2020</p>
            <div class="share-input">
                <form>
                    <input type="text" placeholder="" class="shareLinkInput">
                    <button type="button" onclick=""><i class="fa fa-copy"></i></button>
                </form>
            </div>
            <h4>Share on</h4>
            <ul class="qshare">
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank"
                       onclick="appendLink(this)">
                        <i class="fa fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href=" https://publish.twitter.com/" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/cws/share?url=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
                <li>
                    <a href="whatsapp://send?text=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </li>
                <li>
                    <a href="https://t.me/share/url?url=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-telegram"></i>
                    </a>
                </li>
                <li>
                    <a href="mailto:?subject=[SUBJECT]&body=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-envelope"></i>
                    </a>
                </li>
                <li>
                    <a href="" onclick="downloadImage(this)" target="_blank">
                        <i class="fa fa-download"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
$this->registerCSS('
.mt3{
    margin-top: 30px;
}
.webinar-widget{
    text-align: center;
    padding: 0 20px;
}
.new-btns{
    display: flex;
    flex-wrap: wrap; 
    margin-top: 20px;
    justify-content: center;
}
.naam button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	margin: 0 2px;
	padding: 7px 18px;
	font-size: 16px;
	border-radius: 4px;
	font-family: roboto;
}
.my-webinar-box{
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    background-color:#fff;
}
.join-webinar-icon {
    position: relative;
    z-index: 0; 
    height:150px;  
}
.join-webinar-icon img{
    max-height: 150px;
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: top center; 
    border-radius: 8px 8px 0 0;
}
.webi-date {
	border: 1px solid transparent;
	text-align: center;
	width: 80px;
	height: 80px;
	margin: auto;
	background-color: #00a0e3;
	color: #fff;
	padding: 21px 0;
	border-radius: 100px;
	margin-top: -40px;
    position: relative;
    z-index: 1;
}
.cont{
    font-size: 23px;
    line-height: 0px;
    font-family: roboto;
    font-weight: 600;
}
.abs{
    font-size: 16px;
    text-transform: uppercase;
    font-family: roboto;
}
.invite-webinar-title {
    font-size: 20px;
    text-align: center;
    font-family: roboto;
    font-weight: 600;
    line-height: 35px;
    padding-top: 10px;
    text-transform: capitalize;
}
.invite-webinar-city {
    text-align: center;
    font-size: 16px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
    padding-bottom: 10px;
}
.invite-webinar-desc {
    font-size: 16px;
    font-family: roboto;
    text-align: center;
}
.mentor-heading{
    font-size: 20px;
    margin: 0px 0 15px 0;
    line-height: 20px;
    font-family: lora;
    color: #333;
}
/*--*/
.qm-logo{
    width:100px;
    height: 100px;    
    margin: 0 auto;
}
.qm-name{
    margin-bottom: 10px;
    margin-top: 10px;
}
.qm-logo img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 10px;
}
.qModal h4{
    font-weight: bold;
    color: #333;
    font-family: roboto;
    font-size: 20px;
}
.qModal h2{
    font-weight: bold;
    color: #00a0e3;
    font-family: lora;
    font-size: 30px;
}
.qModal p{
    color: #333;
    font-family: roboto;
    font-size: 16px;
    font-weight: bold;
}
.qshare {
    padding-inline-start: 0;
}
.qshare li{
    list-style: none;
    display: inline;
   padding:10px 10px;
}
.qshare li a{
    font-size: 23px;
    color: #333; 
}
.qshare li a:hover{
    color: #00a0e3; 
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 10px; /* Location of the box */
  left: 0;
  top: 100px;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: scroll; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin:5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
  text-align: center;
}
/* The Close Button */
.close, .closeInfo {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 10px;
  right: 10px
}
.close:hover,
.closeInfo:hover,
.close:focus,
.closeInfo:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.share-input button{
    padding: 8px 14px;
    border: none;
    background: #00a0e3;
    color: #fff;
    float: right;
}
.share-input{
    max-width:500px;
    width: 100%;
    border:1px solid #eee;
    margin: 0 auto;
}
.shareLinkInput{
    width: 89%;
    padding:8px 10px;
//     border:1px solid #eee;
    border:transparent;
}
');
?>
<script>
    let qlBtn = document.getElementsByClassName('ql-share');
    for (let i = 0; i < qlBtn.length; i++){
        qlBtn[i].addEventListener('click', openInfoModal)
    }
    let qlModal = document.getElementById("shareQuizModal");

    function openInfoModal() {
        qlModal.style.display = 'block';
    }
    var closeInfo = document.querySelector(".close");
    closeInfo.onclick = function () {
        qlModal.style.display = 'none';
    }
    window.onclick = function (event) {
        if (event.target == qlModal) {
            qlModal.style.display = "none";
        }
    }

    function appendLink(e){
        let shareLink  = document.querySelector('.shareLinkInput').value;
        let attriBute = e.getAttribute('href');
        e.setAttribute('href', attriBute + shareLink)
    }
    function downloadImage(e) {
        let downImage = document.querySelector('.imagePath');
        let imagePath = downImage.getAttribute('src');
        e.setAttribute('href', imagePath);
        e.setAttribute('download', imagePath);
    }
</script>
