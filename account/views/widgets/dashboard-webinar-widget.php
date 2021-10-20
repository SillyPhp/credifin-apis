<?php

use Yii\helpers\Url;
?>

<section class="webinar-banner">
  <img src="https://user-images.githubusercontent.com/72601463/136373680-e55a74a7-30df-4519-97cc-d7d6fdfc4ebc.png" class="left-bottom">
  <img src="https://user-images.githubusercontent.com/72601463/138056538-d1315d68-ce92-4d30-a68b-589838662d9d.png" class="right-top">
  <span class="on-zoom">On Zoom</span>
  <div class="row">
    <div class="col-md-4">
      <div class="banner-img">
        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/dashboard-webinar-img.png') ?>" alt="">
      </div>
    </div>
    <div class="col-md-8">
      <div class="banner-right-side">
        <h1>UPCOMING WEBINAR</h1>
        <h6>
          Oct 23, 2021 | 4:00 PM - 5:00 PM
        </h6>
        <div class="banner-text">
          <h1>
            <?= $webinar['title'] ?>
          </h1>
          <p><span><?= $webinar['speaker_name'] ?></span></p>
        </div>
        <div class="banner-btn">
          <a href="<?= $webinar['unique_access_link'] ?>" class="join-link">View Detail</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$this->registerCSS('
.webinar-banner{
  background: linear-gradient(95.59deg, #232526 -62.16%, #414345 106.45%);
  border-radius: 0px;
  color: #fff;
  padding: 50px;
  position: relative;
  margin-bottom: 20px
}
.webinar-banner .row{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.banner-text{
  border-left: 2px solid #84BEFF;
  padding-left: 10px;  
}
.banner-text{
  margin-top: 10px;
}
.webinar-banner h6 {
    color: #84BEFF;
    font-weight: 700;
    font-family: roboto;
    font-size: 18px;
    margin: 0;
}
.banner-right-side > h1 {
  font-size: 28px;
  font-weight: 700;
  opacity: 0.3;
}
.banner-text h1{
  font-size: 30px;
  font-weight: 700;
  font-family: Roboto;
  margin: 0;
  letter-spacing: 1.3px;
}
.banner-text p img{
  width: 70px;
  height: 70px;
  display: inline-block;
  margin-right: 10px;
  border-radius: 50%;
}
.banner-text p{
  margin-top: 10px !important;
  }
  .banner-text p span {
    color: #FFE477;
    font-family: roboto;
    font-weight: 500;
    font-size: 16px;
    border-radius: 17px;
    background: rgba(53, 130, 216, 0.5);
    padding: 2px 14px;
    margin-right: 10px;
}
.join-link{
  background: #fff;
  text-decoration: none;
  color: #3582D8;
  padding: 10px 30px;
  border-radius: 3px;
  display: inline-block;
  font-weight: 700;
}
.banner-btn {
  margin-top: 25px;
}
.webinar-banner .left-bottom, .webinar-banner .right-top{
  position: absolute;
  width: 50px;
}
.left-bottom{
  left: -2px;
  bottom: 0;
}
.right-top{
  right: 0;
  top: -2px;
}
.on-zoom{
  position: absolute;
  right: 20px;
  bottom: 10px;
  color: #FFE477;
  font-weight: 700;
}
.banner-img img {
  width: 100%;
}
.banner-img {
  width: 190px;
  display: block;
  margin: auto;
}
@media only screen and (max-width: 576px){
  .webinar-banner .row{
    flex-direction: column;
  }
  .banner-btn{
    margin-top: 50px;
  }
}
');
