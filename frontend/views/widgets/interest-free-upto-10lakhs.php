<?php
use yii\helpers\Url;
?>
<section class="interest-free-banner">
    <div class="blur-rupee-img">
        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rupees.png') ?>" alt="">
        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rupees.png') ?>" alt="">
        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rupees.png') ?>" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="interest-free-text">
                    <h1>INTEREST FREE EDUCATION LOAN <br class="break-text"><span class="ten-lakh-text">UPTO 10 LAKH</span></h1>
                    <p>Our education loans aim at providing financial support to aspiring students for pursuing higher professional education in India and overseas.</p>
                    <a href="/education-loans/apply" class="btn-apply" target="_blank">APPLY NOW</a>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="rupee-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rupees.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.interest-free-banner{
  font-family: roboto;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
  overflow: hidden;
  padding: 20px 0;
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

.ten-lakh-text{
  color: #ff7803;
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


@media screen and (max-width: 1020px){
  .interest-free-text{
    flex-basis: 70%;
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
');