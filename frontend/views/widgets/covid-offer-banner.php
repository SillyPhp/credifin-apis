<?php

use yii\helpers\Url;

?>

<!-- <section class="covid-offer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-5">
                <div class="banner-text">
                    <div class="covid-offer-tag">
                        COVID RELIEF OFFER
                    </div>
                    <h1 class="banner-heading">
                        Enjoy <span>0</span> Processing Fee on Education Loans
                    </h1>
                    <p class="banner-description">
                        Offer valid till 5th of November
                    </p>
                    <a href="<?= $availUrl ?>" class="avail-btn">
                        <span>Avail Now</span>
                        <div class="arrows">
                            <i class="fas fa-chevron-right"></i>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="arrows">
                            <i class="fas fa-chevron-right"></i>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-7 banner-img-holder">
                <div class="banner-img">
                    <div class="bg-div">
                        <div class="loan-product">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/interest-free-icon.png') ?>">
                            <p>Interest Free Loan</p>
                        </div>
                        <div class="loan-product">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/annual-fee-icon.png') ?>">
                            <p>Annual Fee Finance</p>
                        </div>
                        <div class="loan-product">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/school-fee-icon.png') ?>">
                            <p>School Fee Finance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="covid-offer-banner">
  <img src="<?= Url::to('@eyAssets/images/pages/education-loans/covid-offer-banner-bg.png') ?>" class="covid-offer-bg">
  <img src="<?= Url::to('@eyAssets/images/pages/education-loans/covid-offer-banner-img.png') ?>" class="covid-offer-img">
  <div class="container">
    <div class="row">
      <div class="col-sm-5"></div>
      <div class="col-sm-6">
        <div class="covid-offer-text">
          <!-- <h4>godaddy academy offers</h4> -->
        <h1>50% OFF<br> Processing Fee</h1>
        <p>Pay half processing fee for School Fee Finance</p>
        <!-- <h6 class="offer-valid">Offer valid till 5th of November</h6> -->
        <a href="<?= ($availUrl) ? $availUrl : "/education-loans/school-fee-finance/apply" ?>" class="avail-btn">
                        <span>Avail Now</span>
                        <div class="arrows">
                            <i class="fas fa-chevron-right"></i>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="arrows">
                            <i class="fas fa-chevron-right"></i>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$this->registerCss('
/*New Covid Banner*/
.covid-offer-banner{
    background: #182848;
    width: 100%;
    height: 400px;
    position: relative;
    text-align: center;
    display: flex;
    align-items: center;
  }
  .covid-offer-banner .covid-offer-bg{
    position: absolute;
    right: 0;
    top:0;
    height: 100%;
  }
  .covid-offer-banner .covid-offer-img{
    position: absolute;
    left: 0;
    top:0;
    height: 100%;
  }
  .covid-offer-banner h4 {
      text-transform: uppercase;
  }
  .covid-offer-banner h4, .covid-offer-banner p{
      font-weight: 800;
    color: #FFFFFF;
    margin: 0;
    text-transform: capatalize;
  }
  .covid-offer-banner h1{
    color: #FFD65F;
      margin: 0;
      font-size: 50px;
      font-weight: 800;
    font-family: roboto;
    line-height: 1;
  }
  .avail-btn {
    width: 112px;
    height: 35px;
    border: 2px solid #fff;
    display: inline-block;
    color: #fff;
    font-weight: 900;
    line-height: 30px;
    position: relative;
    overflow: hidden;
    margin-top: 2px;
    margin-top: 15px;
}
.avail-btn span{
    margin-left: -20px;
}
.avail-btn:hover{
    color: #fff;
}
.arrows {
    transition: all linear 0.2s;
    position: absolute;
    display: inline-block;
}
.arrows:nth-child(2) {
    right: 33px;
    opacity: 0;
}
.arrows:nth-child(3) {
    right: 11px;
}
.arrows .fa-chevron-right {
    margin-right: -6px;
}
.avail-btn:hover .arrows:nth-child(3) {
    right: -25px;
    transition: all linear 0.2s;
}
.avail-btn:hover .arrows:nth-child(2) {
    right: 13px;
    opacity: 1;
    transition: all linear 0.2s;
}

  .offer-valid{
    margin-top: 20px;
    color: #fff;
  }
  @media only screen and (max-width: 991px){
    .covid-offer-banner h1{
      font-size: 44px;
    }
    .covid-offer-banner .covid-offer-img {
      position: absolute;
      left: -100px;
      top: 0;
      height: 100%;
  }
  }
  @media only screen and (max-width: 767px){
    .covid-offer-banner .covid-offer-img {
      display: none;
    }  
  }
  @media only screen and (max-width: 425px){
    .covid-offer-banner h1{
      font-size: 35px;
    }  
  }


/*
.covid-offer {
    max-height: 550px;
    font-family: Roboto;
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/covid-bg-img.png') . '), #fff5cf;
    background-repeat: no-repeat;
    background-position: right;
    height: 400px;
    margin: 15px 22px;
    border-radius: 12px;
    box-shadow: 0 0 17px 1px #e6e6e6;
    overflow: hidden;
}
.covid-offer .container{
    height: 100%;
    padding-top: 0 !important;
}
.covid-offer .row{
    height: 100%;
    display: flex;
    align-items: center;
}
.covid-offer-tag {
    padding: 1px 10px;
    background: #00a0e3;
    display: inline-block;
    border-radius: 3px;
    font-family: inherit;
    font-weight: 900;
    color: #fff;
}
.banner-img-holder{
    height: 100%;
}
.banner-heading {
    margin: 0;
    font-size: 30pt;
    font-family: inherit;
    line-height: 47px;
    margin-top: 16px;
}
.banner-description {
    font-size: 14px;
    font-weight: 600;
    color: #8c8c8c;
}
.avail-btn {
    width: 112px;
    height: 35px;
    background: #FCA630;
    display: inline-block;
    color: #fff;
    font-weight: 900;
    line-height: 35px;
    position: relative;
    overflow: hidden;
    margin-top: 15px;
}
.avail-btn span{
    margin-left: 13px;
}
.avail-btn:hover{
    color: #fff;
}
.arrows {
    transition: all linear 0.2s;
    position: absolute;
    display: inline-block;
}
.arrows:nth-child(2) {
    right: 33px;
    opacity: 0;
}
.arrows:nth-child(3) {
    right: 11px;
}
.arrows .fa-chevron-right {
    margin-right: -6px;
}
.avail-btn:hover .arrows:nth-child(3) {
    right: -25px;
    transition: all linear 0.2s;
}
.avail-btn:hover .arrows:nth-child(2) {
    right: 13px;
    opacity: 1;
    transition: all linear 0.2s;
}
.banner-img {
    background: #464646;
    width: 273px;
    transform: skewX(30deg);
    text-align: center;
    height: 100%;
    margin-left: 79px;
}
.bg-div{
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}
.loan-product {
    transform: skewX(-30deg);
}
.loan-product p {
    color: #fff;
    font-weight: 800;
    margin-top: 4px;
}
@media only screen and (max-width: 375px){
    div.banner-text h1{
        font-size: 20pt;
    }
}
@media only screen and (max-width: 750px){
    .banner-img-holder{
        display: none;
    }
    .banner-text h1{
        font-size: 25pt;
        line-height: 38px;
    }
}
@media only screen and (max-width: 992px){
    .banner-img{
        width: 225px;
        margin-left: 45px;
    }
    .avail-btn{
        background: #ff7803;
    }
}*/
');
