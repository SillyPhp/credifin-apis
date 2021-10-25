<?php

use yii\helpers\Url;
?>
    <div class="slideshow-container">
        <h4>Videos</h4>
        <div class="mySlides fadeVideo">
            <div class="numbertext">1 / 3</div>
            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail1.png')?>" style="width:100%">
            <div class="youtube-icon"><img src="<?= Url::to('@eyAssets/images/pages/mentorship/youtube-icon.png')?>"> </div>
            <div class="video-title">Digital marketing in a go.</div>
        </div>

        <div class="mySlides fadeVideo">
            <div class="numbertext">2 / 3</div>
            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail2.jpg')?>" style="width:100%">
            <div class="youtube-icon"><img src="<?= Url::to('@eyAssets/images/pages/mentorship/youtube-icon.png')?>"> </div>
            <div class="video-title">How to get thumbnails from any youtube videos.</div>
        </div>

        <div class="mySlides fadeVideo">
            <div class="numbertext">3 / 3</div>
            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail1.png')?>" style="width:100%">
            <div class="youtube-icon"><img src="<?= Url::to('@eyAssets/images/pages/mentorship/youtube-icon.png')?>"> </div>
            <div class="video-title">Digital marketing in a go.</div>
        </div>

<!--        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>-->
<!--        <a class="next" onclick="plusSlides(1)">&#10095;</a>-->

    </div>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

<?php
$this->registerCss('
.mySlides {
    display: none;
    position: relative;
    width: 100%;
}
.mySlides img {
    vertical-align: middle;
}
/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}
.youtube-icon{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.youtube-icon img{
    max-width: 50px;
}
/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 10px;
  width: 10px;
  margin: 0 2px;
  background-color: #ddd;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #00a0e3;
}

/* Fading animation */
.fadeVideo {
  -webkit-animation-name: fadeVideo;
  -webkit-animation-duration: 1.5s;
  animation-name: fadeVideo;
  animation-duration: 1.5s;
}

@-webkit-keyframes fadeVideo {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fadeVideo {
  from {opacity: .4} 
  to {opacity: 1}
}
.video-title {
    font-size: 16px;
    line-height: 25px;
    color: #333;
    font-family: roboto;
    // border-top: 1px solid #eee;
    padding: 10px 0 0 0;
    text-align: justify;
}

');
$script = <<<JS

JS;
$this->registerJS($script);
?>

<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
    }
</script>