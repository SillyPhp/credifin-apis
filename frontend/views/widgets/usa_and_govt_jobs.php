<?php

use yii\helpers\Url;

?>
    <section class="goven-jobs-sec">
        <div class="container">
            <div class="row">
                <div class="carousel-wrap">
                    <div class="owl-carousel">
                        <div class="item">
                            <div class="gov-job">
                                <a href="/usa-jobs">
                                    <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/usa-j.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>"
                                         alt="government job vacancies, government vacancies, gov job search, latest government jobs, govt job recruitment, government employment opportunities">
                                    <h3 class="link-none">
                                        USA Government Jobs
                                    </h3>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="gov-job">
                                <a href="/govt-jobs">
                                    <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/indian-jobs.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>"
                                         alt="government job vacancies, government vacancies, gov job search, latest government jobs, govt job recruitment, government employment opportunities">
                                    <h3 class="link-none">
                                        Indian Government Jobs
                                    </h3>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="gov-job">
                                <a href="/education-loans/study-in-india">
                                    <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/india-loan.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>"
                                         alt="education in india">
                                    <h3 class="link-none">
                                        Indian Education Loan
                                    </h3>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="gov-job">
                                <a class="load-later" data-href="/education-loans/study-abroad">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/abroad-loan.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>"
                                         alt="education in abroad">
                                    <h3 class="link-none">
                                        Abroad Education Loan
                                    </h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.goven-jobs-sec{
    background:url(' . Url::to('@eyAssets/images/pages/index2/gov-job-sec-bg.png') . ');
    background-repeat: no-repeat;
    background-size:cover;
    padding: 40px 0px 40px 0px;
}
.gov-heading {
    text-align: center;
    font-size: 30px;
    font-family: lobster;
    margin: 0px 0px 20px 0;
}
.gov-job {
  overflow: hidden;
  margin-bottom: 15px !important;
  max-width: 500px;
  height: 300px;
  width: 100%;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
  margin:auto;
}
.gov-job img {
    max-width: inherit;
    height: 100%;
    position: absolute;
    right: 0;
    -webkit-transition: all 2s ease-out;
    transition: all 2s ease-out;
}
.gov-job:hover img {
  -webkit-transform: translateX(100px);
  transform: translateX(100px);
}
.gov-job{
    text-align:center;
    position:relative;
}
.gov-job, .gov-job img{
    border-radius: 10px;
}
.gov-job a:hover .link-none{
    background: rgba(0,0,0,.8);
    transition:.3s ease;
    border-radius:5px;
}
.link-none{
    position:absolute;
    top:20px;
    left:20px;
    background: rgba(0,0,0,.3);
}
.link-none{
    color:#fff;
    font-size:20px;
    padding:5px 10px;
    margin:0;
}
.owl-carousel .owl-item img{width:auto !important;}
.owl-theme .owl-dots{display:none !important;}
.owl-controls .owl-nav > div{background:none;}
.owl-controls .owl-prev i, .owl-controls .owl-next i{
    font-size:35px !important;
}
@media (max-width:550px){
.gov-job {
    width: 85%;
    margin: 0 auto;
}
}
@media (max-width:415px){
.gov-heading{
    font-size:25px;
}
.gov-job{
    margin-bottom:10px;
}
}
');
$script = <<<JS
$('.owl-carousel').owlCarousel({
  loop: true,
  margin: 10,
  nav: true,
  navText: [
    "<i class='fa fa-caret-left'></i>",
    "<i class='fa fa-caret-right'></i>"
  ],
  autoplay: true,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 1
    },
    1000: {
      items: 2
    }
  }
})
$('.load-later').Lazy();
JS;
$this->registerjs($script);
$this->registerCssfile('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css');
$this->registerjsfile('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js');
