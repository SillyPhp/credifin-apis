<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

<section>
    <div class="">
        <div class="row">
            <div class="col-md-7">
                <div class="row" id="categories">
                    <div class="hideDiv showDiv" id="enter">
                        <div class="col-md-3">
                            <div class="small-img">
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/hand-shake.png') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="covid-main">
                                <div class="main-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/hand-shake.png') ?>"
                                         class="mainImg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hideDiv" id="unwell">
                        <div class="col-md-3">
                            <div class="small-img">
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/hand-shake.png') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-9">
                            <div class="covid-main">
                                <div class="main-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>" class="mainImg">
                                </div>
                            </div>
                            <div class="customize">
                                Customize poster with your own company's name and logo
                                <div class="cus-btns">
                                    <button onclick="chnageLink()">See Example</button>
                                    <button class="">Customize</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hideDiv" id="sanitizer">
                        <div class="col-md-3">
                            <div class="small-img">
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="covid-main">
                                <div class="main-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>" class="mainImg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hideDiv" id="distance">
                        <div class="col-md-3">
                            <div class="small-img">
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>">
                                </div>
                                <div class="small-icons">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="covid-main">
                                <div class="main-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>" class="mainImg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="covid-list">
                    <div class="covid-heading">Warnings <span>Designs</span></div>
                    <ul class="topicLists">
                        <li class="liClick" id="enter">Do not enter if unwell<span>2</span></li>
                        <li class="liClick" id="unwell">Stay home if you feel unwell<span>2</span></li>
                        <li class="liClick" id="sanitizer">Please use hand sanitizer before entering<span>2</span></li>
                        <li class="liClick" id="distance">Please maintain physical distance<span>2</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="quick-review">
            <div class="row quick-review-inner">
                <div class="col-md-3 quick-review-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/blog/DSB-law-group.png');?>"></div>
                <div class="col-md-7 overflow-hidden set-heading-c">
                    <h2>Customize Posters With Your Own Company's Name And Logo</h2>
                    <div class="quick-review-action" id="review_btn">
                        <a href="javascript:;">Sign Up & Download For Free</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registercss('
.set-heading-c > h2{
    font-family: lora;
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
.customize{
    text-align: center;
    padding: 10px 0;
    color: #333;
    font-family: lora;
    font-size: 20px;
    max-width: 350px;
    margin: 0 auto;
    line-height: 25px;
}
.cus-btns button{
    padding: 10px 15px;
    color: #fff;
    border: none;
    background: #00a0e3;
    margin: 10px 15px; 
    font-size: 13px;
}
.cus-btns button:hover{
    box-shadow: 0 6px 10px rgba(0,0,0,.3);
    transition: .3s ease;
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
    background: #f7f7f7;
}
.main-img {
    margin-bottom: 20px;
    width: auto;
    height: calc(100vh - 100px);
    text-align: center;
}
.main-img img{
    width: auto;
    height: 100%;
}
.small-img {
//    margin-left: 12px;
//    display: flex;
    
}
.small-icons {
    width: 90px;
    height: 110px;
    cursor: pointer;
    margin: 5px auto;
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
    box-shadow: 0 5px 8px rgba(0, 0, 0, .3);
}
.small-icons img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.covid-heading {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 8px;
    padding:10px 20px;
}
.covid-heading span{
    float:right;
}
.covid-list {
	border: 1px solid #eee;
	box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
	border-radius: 4px;
//	padding: 20px;
//	margin-top:16px;
}
.covid-list li {
	font-size: 16px;
	font-family: roboto;
	text-transform: full-size-kana;
//	margin-bottom: 5px;
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
.hideDiv{
    display: none;
}
.showDiv{
    display: block;
}
');
?>

<script>
    let smallIcons = document.getElementsByClassName('small-icons');
    console.log(smallIcons)
    for (let i = 0; i < smallIcons.length; i++) {
        smallIcons[i].addEventListener('click', function () {
            let smallImg = event.currentTarget;
            let Simg = smallImg.getElementsByTagName('img');
            let imgPath = Simg[0].getAttribute('src');

            let smallicons = smallImg.parentElement;
            let mainImgParent = smallicons.parentElement.nextElementSibling;
            let mainImg = mainImgParent.querySelector('.mainImg');
            let mainImgSrc = mainImg.getAttribute('src');
            mainImgSrc = "";
            mainImg.setAttribute('src', imgPath);
        })
    }

    let infoTopcis = document.getElementsByClassName('liClick');
    for (let i = 0; i < infoTopcis.length; i++) {
        infoTopcis[i].addEventListener('click', function () {
            let clickedLi = event.currentTarget;
            let clickCate = clickedLi.getAttribute('id')

            let showDiv = document.getElementsByClassName('showDiv');
            if (showDiv.length > 0) {
                showDiv[0].classList.remove('showDiv');
            }
            let parentCate = document.getElementById('categories');
            let dispalyCate = parentCate.querySelector('#' + clickCate);
            dispalyCate.classList.add('showDiv');
        })
    }
    
    function changeLink() {

    }
</script>
