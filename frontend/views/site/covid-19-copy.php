<?php

use yii\helpers\Url;

?>
<section class="safety-header">
    <div class="container">
        <h3>Empower Your Workspace With Safety Signs</h3>
    </div>
</section>
<section class="safety-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row" id="categories">
                    <div class="hideDiv showDiv">
                        <div class="safety-flex">
                            <div class="bg-shadow">
                                <div class="small-img" id="posterThumb">
                                    <div class="small-icons">
                                        <img src="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizer.png') ?>">
                                    </div>
                                    <div class="small-icons">
                                        <img src="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizerOne.png') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mainPoster">
                                <div class="covid-main">
                                    <div class="main-img">
                                        <img src="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizer.png') ?>"
                                             id="bigPoster" class="mainImg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <span class="covid-list" id="safetyList">
                    <div class="covid-heading">Warnings <span>Designs</span></div>
                    <ul class="topicLists">
                        <li class="liClick activeLi" id="sanitizer">
                            Please use hand sanitizer before entering
                            <span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/responsibly.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizerOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="distance">Please maintain physical distance<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/physicalDistance.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/physicalDistanceOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="masksRequired">Masks required beyond this point<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/masksRequired.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/masksRequiredOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="glovesMasks">Gloves & masks required beyond this point<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/glovesMasks.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/glovesMasksOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="social">Thanks for practicing social distancing<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/socialDistance.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/socialDistanceOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="tissue">Cover mouth & nose with flexed elbow or tissue when
                            sneezing/coughing<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/coverMouth.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/coverMouthOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="throwTissues">Throw used tissues into closed bins
                            immediately<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/throwTissues.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/throwTissuesOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="cleanHands">Clean hands save lives<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/cleanHand.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/cleanHandOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="seconds">Wash your hands for atleast 20 seconds<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/20seconds.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/20secondsOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="avoidTouching">Avoid touching eyes, nose & mouth<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/avoidTouching.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/avoidTouchingOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="practiceSocial">Please practice social distancing<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/practiceSocial.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick " id="unwell">Do not enter if unwell<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/unwell.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="stayHome">Stay home if you feel unwell<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/stayHome.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="spitting">Spitting could be dangerous<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/spitting.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="healthHazard">Spitting in public is a health hazard<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/healthHazard.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="work">Clean your hands before getting back to work<span>1</span>
                             <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/work.png') ?>" class="data-img"></span>
                         </li>
                        <li class="liClick" id="virus">Virus outbreak. Proceed with caution<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/virusCaution.png') ?>" class="data-img"></span>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="share-heading">Share With Your Friends And Create Awareness</h1>
            <div class="share-social">
                <div class="whatsapp-share basis">
                    <a href="#!"
                       onclick="window.open('https://api.whatsapp.com/send?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')"
                       class="share-elem-main">
                        <span><i class="fab fa-whatsapp"></i> Whatsapp</span>
                    </a>
                </div>
                <div class="teleg-share basis">
                    <a href="#!"
                       onclick="window.open('https://telegram.me/share/url?url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')"
                       class="share-elem-main">
                        <span><i class="fab fa-telegram-plane"></i> Telegram</span>
                    </a>
                </div>
                <div class="twi-share basis">
                    <a href="#!"
                       onclick="window.open('https://twitter.com/intent/tweet?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')"
                       class="share-elem-main">
                        <span><i class="fab fa-twitter marg"></i> Twitter</span>
                    </a>
                </div>
                <div class="link-share basis">
                    <a href="#!"
                       onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                       class="share-elem-main">
                        <span><i class="fab fa-linkedin-in marg"></i> LinkedIn</span>
                    </a>
                </div>
                <div class="download basis">
                    <button class="share-elem-main"><span><i class="fas fa-download"></i></span>Download All</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="quick-review">
            <div class="row quick-review-inner">
                <div class="col-md-3 quick-review-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/blog/DSB-law-group.png'); ?>"></div>
                <div class="col-md-7 overflow-hidden set-heading-c">
                    <h2>Customize Posters With Your Own Company's Name And Logo</h2>
                    <div class="quick-review-action" id="review_btn">
                        <a href="javascript:;">Login or Sign Up & Download For Free</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <?= $this->render('/widgets/our-services') ?>
        <?= $this->render('/widgets/e-campus-safety-posters') ?>
    </div>
</section>

<?php
$this->registercss('
.share-heading{
    font-size: 20px;
    font-family: lora;
    color: #333;
}
#categories, #safetyList{
    max-height: 600px;
}
.share-social {
	display: flex;
	align-items: stretch;
	margin:10px 0;
}
.basis{
    flex-basis:50%;
}
.whatsapp-share a, .teleg-share a, .twi-share a, .link-share a, .download button{
	display: block;
	color: #fff;
	padding: 8px 10px;
	font-size: 16px;
	font-family: roboto;
	font-weight: 500;
	margin-right: 10px;
	border: none;
}
.whatsapp-share a{
    background-color:#36dc54;
}
.teleg-share a{
    background-color:#2399d7;
}
.twi-share a{
    background-color:#1da1f2;
}
.link-share a{
    background-color:#0073b1;
}

.download button{
    background-color: #ffcc00;
    width: 100%;
    max-height: 43px;
    height: 100%;
    text-align: justify;
}
.download button i{
    padding-right: 5px; 
}
.safety-header{
    background: url(' . Url::to('@eyAssets/images/pages/safty-posters/safetyHeaderOne.png') . ');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 450px;
    display: flex;
    align-items: center;    
}
.safety-header h3{
    font-size: 40px;
    font-family: lora;
    max-width: 500px;
}
.safety-bg{
    background: url(' . Url::to('@eyAssets/images/pages/safty-posters/speakers-bg.png') . ');
    background-position: top;
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
}
.db-flex{
    display: flex;
    align-items: center;
    height: 100%;
    width: 100%;
    justify-content: center;
}
.safety-flex{
    display: flex;
    justify-content: center;    
}
.mainPoster, .bg-shadow{
    margin:0 10px;
}
.bg-shadow{
//    box-shadow: 0 5px 10px rgba(0,0,0,.1);  
    height: calc(100vh - 90px);
    padding: 0 0;
    text-align: center;  
    
}
.set-heading-c > h2{
    font-family: lora;
}
.liClick:hover, .activeLi{
    color: #00a0e3;
    transition: .3s ease;
}
.quick-review-action a{  
	text-align:center;
	display:inline-block; 
    padding:5px 15px; 
    background:#00a0e3; 
    border-radius:4px; 
    font-size:15px; 
    font-weight:500; 
    color:#fff;
    text-decoration: none;
    text-transform: capitalize;
    font-family: roboto;
}
.quick-review-action a:hover, .quick-review-action a:focus, .quick-review-action:active{
	outline: none;
	box-shadow: none;
} 
.overflow-hidden{
    overflow:hidden;
}
.quick-review{
	border:2px solid #eee;
	margin: 20px;
	background-color:  #fbfcfc ;
	border-radius: 5px;
}
.quick-review-inner{
    margin:15px;
    display: flex;
    align-items: center;
}
.quick-review-img img{
	max-width: 200px;
}

#footer{
    margin-top: 0px;    
}
.design-heading{
    padding: 10px 5px;
    background: #00a0e3;
    color: #fff;
}
.bg-light-black{
    text-align: center;
    padding: 0 0;
    box-shadow: 0 5px 10px rgba(0,0,0,.1); 
//    border-radius: 0 10px 10px 0;
}
.topicLists li:nth-child(even){
    background: #f9f9f9;
}
.topicLists li:nth-child(odd){
    background: #fff;
}
.main-img {
    margin-bottom: 20px;
    width: auto;
    max-height: 600px;
    height: calc(100vh - 90px);
    text-align: center;
    position: relative;
    display: flex;
    align-items: center;
}
.main-img:hover .downloadBtn{
    display: block;
    transition: .3s ease;
}
.main-img img{
    width: auto;
    height: 100%;
    box-shadow: 0 5px 10px rgba(0,0,0,.1); 
}
.small-img {
//    margin-left: 12px;
//    display: flex;
    
}
.small-icons {
    width: 90px;
    height: 130px;
    cursor: pointer;
    margin: 5px auto;
    box-shadow: 0 5px 10px rgba(0,0,0,.1); 
}
.icon-active{
    width: 100%;
    height: 100%;
    position: absolute;
    top:0;
    left:0;
    background: rgba(0, 0, 0, .3);
}
.small-icons:hover{
    box-shadow: 0 5px 8px rgba(0, 0, 0, .1);
}
.small-icons img{
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.covid-heading {
    font-size: 16px;
    font-weight: 600;
    padding:10px 20px;
    background: #f9f9f9;
    position: sticky;
    top: 0;
}
.covid-heading span{
    float:right;
}
.covid-list {
	box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
	border-radius: 0px;
    height:calc(100vh - 90px); 
    position: relative;
}
.covid-list li {
	font-size: 16px;
	font-family: roboto;
	text-transform: capitalize;
	padding: 5px 20px;
	cursor: pointer;

}
.covid-list li span {
    float: right;
    margin-right: 10px;
}
.activeLi{
    color:#00a0e3;
}
.e-background, .our-backg{
    background: none;
    min-height: auto;
}
.e-background h2{
    color: #333;
    font-family: lora;
}
.e-inner{
    top: 0px;
}
.our-backg{
    margin-top: 30px;

}
.our-backg h1{    
    font-family: lora;
    text-align: center;
}
.our-backg h1:before{
    display: none;
}


');
$script = <<<JS
    var ps = new PerfectScrollbar('#safetyList');

$('.sharing-box div .share-elem-main').each(function() {
    var href = $(this).attr('href');
    var page_url = window.location.href;
    $(this).attr('href', href + page_url);
});

JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>


<script>
    let smallIcons = document.getElementsByClassName('small-icons');

    function initializeImgClick() {
        for (let i = 0; i < smallIcons.length; i++) {
            smallIcons[i].addEventListener('click', function () {
                //fetching small image src
                let smallImg = event.currentTarget;
                let Simg = smallImg.getElementsByTagName('img');
                let imgPath = Simg[0].getAttribute('src');

                //fatching and changing main image src
                let smallicons = smallImg.parentElement;
                let mainImgParent = smallicons.parentElement.nextElementSibling;
                let mainImg = mainImgParent.querySelector('.mainImg');
                let mainImgSrc = mainImg.getAttribute('src');
                mainImgSrc = "";
                mainImg.setAttribute('src', imgPath);
            })
        }
    }

    initializeImgClick();

    let infoTopcis = document.getElementsByClassName('liClick');
    for (let i = 0; i < infoTopcis.length; i++) {
        infoTopcis[i].addEventListener('click', function () {
            let clickedLi = event.currentTarget;
            let dImages = clickedLi.getElementsByClassName('data-img');
            let fElem = dImages[0].getAttribute('data-img')

            document.getElementById('bigPoster').setAttribute('src', fElem);

            //add and remove active class from li
            let activeli = document.getElementsByClassName('activeLi');
            if (activeli.length > 0) {
                activeli[0].classList.remove('activeLi')
            }
            clickedLi.classList.add('activeLi');
            let clickCate = clickedLi.getAttribute('id')

            //show hide images div on click
            let posterThumb = document.getElementById('posterThumb');
            posterThumb.innerHTML = "";
            for (let i = 0; i < dImages.length; i++) {
                let z = dImages[i].getAttribute('data-img');
                var div = document.createElement('div');
                div.setAttribute('class', 'small-icons');
                div.innerHTML = '<img src="' + z + '">';
                posterThumb.appendChild(div);
            }
            initializeImgClick();
        })
    }


</script>
