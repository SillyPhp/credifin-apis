<?php
use yii\helpers\Url;
?>
<!-- <section class="interest-free-banner">
    <div class="container">
        
    <div class="interest-free-img">
      <div class="rotate-img"></div>
    </div>

        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="interest-free-text">
                    <h1>INTEREST FREE EDUCATION LOAN <br class="break-text"><span class="ten-lakh-text">UPTO 10 LAKH</span></h1>
                    <p>Our education loans aim at providing financial support to aspiring students for pursuing higher professional education in India and overseas.</p>
                    <a href="/education-loans/apply" class="btn-apply" target="_blank">APPLY NOW</a>
                  </div>
                </div>
              </div>
            </div>
</section> -->

<section class="interest-free-banner">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <div class="banner-text">
          <h1>INTEREST FREE EDUCATION LOAN <br class="break-text"><span class="ten-lakh-text">UPTO 10 LAKH</span></h1>
          <p>Our education loans aim at providing financial support to aspiring students for pursuing higher professional education in India and overseas.</p>
          <a href="/education-loans/apply" class="btn-apply" target="_blank">APPLY NOW</a>
        </div>
      </div>
      <div class="col-md-5">
        <div class="banner-img">
          <img src="<?= Url::to('@eyAssets/images/pages/education-loans/interest-free-img2.png') ?>">
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$this->registerCss('
/*
  .interest-free-banner{
    background: url('.Url::to('@eyAssets/images/pages/education-loans/interest-free-bg.png').');
    background-repeat: no-repeat;
    background-size: cover;
    font-family: roboto;
    width: 100%;
    display: flex;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    padding: 20px 0;
    min-height: 550px;
  }

  .interest-free-banner .container{
    display: flex;
    align-items: center;
    position: relative;  
  }

  .interest-free-text{
    padding-bottom: 30px;
    flex-basis: 50%;
  }

  .interest-free-text h1 {
      font-weight: 600;
      font-size: 36px;
      font-family: roboto;
      line-height: 48px;
      letter-spacing: 0.5px;
      color: #000;
  }

  .interest-free-text p {
      color: #6F6F6F;
      font-family: roboto;
      font-size: 17px;
      line-height: 26px;
      letter-spacing: 0.2px;
  }

  .interest-free-text p{
    color: #6F6F6F;
  }

  .interest-free-img{
    background-size: 300px;
    width: 340px;
    height: 340px;
    position: absolute;
    right: -15px;
    top: 0;
    transform: rotate(45deg);
    border-radius: 20px;
    background: #00a0e3;
  }
  .rotate-img{
    width: 100%;
    height: 100%;
    background: url('.Url::to('@eyAssets/images/pages/education-loans/interest-free-img-hat.png').');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 250px;
    transform: rotate(-45deg);
  }

  .ten-lakh-text{
    color: #00a0e3;
  }

  .btn-apply{
    padding: 15px 20px;
    border-radius: 3px;
    border: none;
    background-color: #00a0e3;
    color: #fff;
    font-weight: 700;
    letter-spacing: 1.3px;
    margin-top: 20px;
    display: inline-block;
    text-decoration: none;
    transition: 200ms all linear;
  }

  .rupee-img img{
    width: 200px;
  }
  .rupee-img{
    flex-basis: 40%;
    text-align: center;
  }

  .blur-rupee-img img{
    position: absolute;
    width: 100px;
    filter: blur(2px);
    z-index: -1;
  }

  .blur-rupee-img img:nth-child(1){
    top: 1px;
    left: -25px;
  }
  .blur-rupee-img img:nth-child(2){
    top: 6px;
    right: 0;
  }
  .blur-rupee-img img:nth-child(3){
    bottom: -50px;
    left: 30%;
  }
  .btn-apply:hover{
    color:  #ff7803;
    background-color: #fff;
    transition: 200ms all linear;
    position: relative;
  }

  .btn-apply:hover::before{
    content: "";
    display: inline-block;
    width: 3px; 
    height: 3px;
    background-color: #fff;
    position: absolute;
    top: -3px;
    left: -3px;
    animation: border-line-top 350ms linear forwards; 
    z-index: -1;
    border-radius: 3px;
  }
  @keyframes border-line-top{
    100%{
      width: 100%;
      height: 100%;
      background-color: #FB7D0D;
    }
  }
  .btn-apply:hover::after{
    content: "";
    display: inline-block;
    width: 3px; 
    height: 3px;
    background-color: #fff;
    position: absolute;
    bottom: -3px;
    right: -3px;
    animation: border-line-left 350ms linear forwards; 
    border-radius: 3px;
    z-index: -1;
  }
  @keyframes border-line-left{
    100%{
      height: 112%;
      width: 104%;
      background-color: #FB7D0D;
    }
  }


  @media screen and (max-width: 991px){
    .interest-free-img{
      width: 280px;
      height: 280px;
    }
  }
  @media screen and (max-width: 767px){
    .interest-free-img{
      display: none;
    }
  }
  @media screen and (max-width: 540px){
    .rupee-img{
      display: none;
    }
    .break-text{
      display: none;
    }
    .blur-rupee-img img:nth-child(2) {
      top: 259px;
      right: 0;
    }
    .blur-rupee-img img:nth-child(1) {
      top: -55px;
      left: -25px;
      }
  }
*/

.interest-free-banner{
  background: linear-gradient(262.97deg, #778DC2 -1.15%, #323E7D 100%);
  min-height: 425px;
  display: flex;
  align-items: center;
  z-index: 1;
}
.interest-free-banner .row{
  display: flex;
  align-items: center;
}
.banner-text h1 {
  font-weight: 600;
  font-size: 32px;
  line-height: 1.3;
  font-family: roboto;
  letter-spacing: 0.5px;
  color: #fff;
}
.banner-text p {
  color: #FFF;
  font-family: roboto;
  font-size: 17px;
  line-height: 26px;
  letter-spacing: 0.2px;
}
.banner-text p{
  color: #FFF;
}
.btn-apply{
  padding: 15px 20px;
  border-radius: 3px;
  border: none;
  background-color: #ff7803;
  color: #fff;
  font-weight: 700;
  letter-spacing: 1.3px;
  margin-top: 20px;
  display: inline-block;
  text-decoration: none;
  transition: 200ms all linear;
}
.btn-apply:hover{
  color:  #ff7803;
  background-color: #fff;
  transition: 200ms all linear;
  position: relative;
}
.btn-apply:hover::before{
  content: "";
  display: inline-block;
  width: 3px; 
  height: 3px;
  background-color: #fff;
  position: absolute;
  top: -3px;
  left: -3px;
  animation: border-line-top 350ms linear forwards; 
  z-index: -1;
  border-radius: 3px;
}
@keyframes border-line-top{
  100%{
    width: 100%;
    height: 100%;
    background-color: #FB7D0D;
  }
}
.btn-apply:hover::after{
  content: "";
  display: inline-block;
  width: 3px; 
  height: 3px;
  background-color: #fff;
  position: absolute;
  bottom: -3px;
  right: -3px;
  animation: border-line-left 350ms linear forwards; 
  border-radius: 3px;
  z-index: -1;
}
@keyframes border-line-left{
  100%{
    height: 112%;
    width: 104%;
    background-color: #FB7D0D;
  }
}
.banner-img {
  width: 288px;
  margin: auto;
}
.ten-lakh-text{
  color: #ff7803;
}
@media only screen and (max-width: 1024px){
  .banner-text h1 {
    font-size: 32px;
    line-height: 1.3;
  }
  .banner-img {
    width: 260px;
  }
  .interest-free-banner {
    min-height: 470px;
  }
}
@media screen and (max-width: 991px){
  .interest-free-img{
    width: 280px;
    height: 280px;
  }
}
@media screen and (max-width: 767px){
  .banner-img{
    display: none;
  }
}
@media screen and (max-width: 540px){
  .banner-text p {
    font-size: 14px;
    line-height: 1.3;
  }
  .banner-text h1 {
    font-size: 22px;
    line-height: 1.3;
  }
  .btn-apply{
    padding: 12px 15px;
  }
}
');