<?php

use yii\helpers\Url;

?>
<section>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="quiz-name">
                <div class="quiz-title">
                    <p>Name of the quiz</p>
                </div>
                <div class="qz-logo">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                </div>
                <div class="quiz-info">
                    <div class="qd">
                        <p><span>Questions:</span> 5</p>
                        <p><span>Group:</span> 9th</p>
                        <p><span>Subject:</span> GK</p>
                    </div>
                    <div class="qd">
                        <p><span>Plays:</span> 5</p>
                        <p><span>Earning:</span> <i class="fa fa-inr"></i> 500</p>
                    </div>
                </div>
                <div class="quiz-btn">
                    <div class="take-quiz-2">
                        <a href="quiz-view">View</a>
                        <a href="quiz-view">Edit</a>
                        <button>Delete</button>
                        <button  type="button" class="ql-share"><i class="fa fa-share-alt"></i> </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 ">
            <div class="qz-main">
                <div class="qz-logo">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                </div>
                <div class="qz-count">
                    <span class="qz-q">16 question</span>
                    <span class="qz-plays">200 plays</span>
                </div>
                <div class="qz-inner">
                    <div class="qz-name">type of insurance</div>
                    <div class="qz-creater">
                        <div class="creator-name">
                    <span class="creator-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                             alt="">
                    </span>
                            <span>Pooja</span>
                        </div>
                    </div>
                    <div class="qz-border"></div>
                    <div class="qz-cat"><span>Category :</span> Marketing</div>
                    <div class="qz-duration"><span>Duration :</span> 5min</div>
                    <div class="qz-price"><span>Price :</span> $12</div>
                    <div class="take-quiz">
                        <a href="quiz-view">View</a>
                        <a href="quiz-view">Edit</a>
                        <button>Delete</button>
                        <button type="button" class="ql-share"><i class="fa fa-share-alt"></i> </button>
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
            <h2>Share Quiz</h2>
            <div class="qm-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
            </div>
            <p class="qm-name">Quiz on human ethics</p>
            <div class="share-input">
                <form>
                    <input type="text" placeholder="" class="shareLinkInput">
                    <button type="button" onclick="nextStep()"><i class="fa fa-copy"></i></button>
                </form>
            </div>
            <p>If someone plays this quiz through this link, It will earn you 20 extra credits</p>
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
$this->registerCss('
.qm-logo{
    max-width:100px;
    max-height: 100px;    
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
/*---- modal-----*/

.qz-border{
    border-bottom:2px solid #eee;
    margin:8px 0;
}
.qz-main {
   box-shadow: 0 0 10px 1px #eee;
   border-radius: 8px;
   overflow: hidden;
   transition:all .3s;
   margin-top: 15px;
}
.qz-main:hover{
    box-shadow: 0 0 15px 7px #eee;
}
.qz-logo {
   width: 100%;
   height: 140px;
}
.qz-logo img{
    height: 100%;
    width: 100%;
    object-position: center;
    object-fit: cover;
}
.qz-count {
   margin-top: -15px;
   display: flex;
   justify-content: center;
}
.qz-q, .qz-plays {
   background-color: #00a0e3;
   padding: 2px 5px;
   color: #fff;
   font-family: roboto;
   font-size: 16px;
   border-radius: 4px;
   font-weight: 500;
   flex-basis:50%;
   text-align: center;
   margin: 0 15px;
}
.qz-inner {
   padding: 10px 15px 0 15px;
   font-family: roboto;
}
.qz-name {
   font-size: 22px;
   text-transform: capitalize;
   font-weight: 500;
   padding-bottom: 5px;
}
.qz-creater {
   display: flex;
   justify-content: space-between;
}
.creator-img img{
    width: 25px;
    border-radius: 50px;
    margin-right: 2px;
}
.creator-name {
   font-size: 16px;
   text-transform: capitalize;
}
.qz-cat, .qz-duration, .qz-price {
   font-size: 15px;
}
.qz-cat span, .qz-duration span, .qz-price span{
    font-size: 16px;
    font-weight: 500;
}
.take-quiz {
    margin-bottom: 0px;
    overflow: hidden;
    padding: 10px 0 6px 0;
    text-align: center;
    margin-top: 5px;
}
.take-quiz-2{
    padding: 0px 0 6px 0;
}
.take-quiz a,
.take-quiz-2 a,
.take-quiz button,
.take-quiz-2 button {
    border: 1px solid #eee;
    padding: 8px 15px;
    border-radius: 0px 0px 0 0;
    font-size: 15px;
    font-family: roboto;
    font-weight: 500;
    background: #fff;
    color: #333;
}
.take-quiz a:hover,
.take-quiz-2 a:hover,
.take-quiz button:hover,
.take-quiz-2 button:hover{
    background: #00a0e3;
    color: #fff;
    border-color: #00a0e3;
    transition: .3s ease;
}
/*----*/
.quiz-name{
    margin-top: 20px;
}
.quiz-title{
    background: #00a0e3;
    color: #fff;
    padding: 10px 15px;
    font-size: 18px;
    font-family: lora;
}
.quiz-details{
    padding: 10px 15px 0;
    align-content: center;
}
.quiz-name p, .quiz-info p{
    margin:10px 0;
}
.quiz-details p span, .quiz-info p span{
    font-weight: bold;
}
.quiz-info{
   padding: 10px 15px;
   display:flex;
   flex-wrap: wrap; 
}
.qd{
    flex:1;
}
.quiz-btn{
    text-align: center;
    padding: 10px 0;
    border-top: 1px solid #eee;
}
.questionbox, .quiz-name{
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    margin-bottom: 25px;
}
.btnview, .btnedit{
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 3px 8px;
    font-size: 12px;
}
.btndelete{
    background: #FF0000;
    color: #fff;
    border: none;
    padding: 3px 8px;
    font-size: 12px;
}
.btnview:hover{
    color: #fff;
}

/*-------modal ----------*/
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
$script = <<<JS

JS;
$this->registerJS($script);
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
