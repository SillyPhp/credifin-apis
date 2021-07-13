<?php

use yii\helpers\Url;
?>

<div class="career-for-company">
    <div class="career-banner">
        <div class="blue-strip-img">
            <img src="<?= Url::to('@eyAssets/images/pages/career-blog/comp-strip.png'); ?>">
        </div>
        <div class="career-heading col-md-6">
            <div class="heading-text">
                <h1>Get Career Page</h1>
                <p>With our Career Page, you can expand your brand's visibility and increase conversions from potential job candidates right on your website</p>
            </div>
            <ul class="car-point">
                <?php if (!Yii::$app->user->identity->organization) { ?>
                    <li>Join EmpowerYouth.com by creating an account.</li>
                <?php }  ?>
                <li>Post jobs/internships that are available.</li>
                <li>To generate a link, simply click "Generate Link.". Your career page will be created.</li>
                <li>Your Website will get traffic when you place the link</li>
            </ul>
            <div class="btn-div">
                <button class="btn-start">Start Here</button>
                <div class="btn-top-circle"></div>
            </div>
        </div>
        <div class="career-image col-md-6">
            <img src="<?= Url::to('@eyAssets/images/pages/career-blog/comp-side.png'); ?>">
        </div>
        <div class="image-mobile">
            <img src="<?= Url::to('@eyAssets/images/pages/career-blog/comp-side.png'); ?>">
        </div>
    </div>
</div>

<?php
$this->registerCss('
.career-banner{
  box-shadow: 0px 1px 10px 2px #eee !important;
  background:  linear-gradient(98.17deg, #CBEAFF -35.49%, #FFFFFF 100%);
  display: flex;
  position: relative;
  align-items: center;
  margin-bottom:30px;
}
.heading-text h1 {
    font-family: lora;
    font-weight: bold;
    font-size:42px;
}
.heading-text p {
    font-family: roboto;
    color: #818181;
    font-size:16px;
}
ul.car-point {
    padding-left: 20px;
    margin-bottom: 20px;
}
ul.car-point li {
    list-style: disc;
    margin-bottom: 6px;
    font-family: roboto;
    color: #333;
    text-transform: capitalize;
    font-size: 14px;
}
.blue-strip-img{
  position: absolute;
  top: 2px;
  left: 0;
  width: 150px;
}

.blue-strip-img img{
  width: 100%;
}
.career-heading{
  padding: 70px 0 50px 60px !important;
}
.heading-text{
  margin-bottom: 15px;
}
.career-image img{
  width: 100%;
}
.btn-div{
  position: relative;
  z-index: 1;
}

.btn-start{
  padding: 12px 25px;
  border-radius: 50px;
  display: inline-block;
  border:none;
  background: #18A0FB;
box-shadow: inset 0px 0px 26px rgba(0, 0, 0, 0.43);
backdrop-filter: blur(21px);
  color: #fff;
  font-size: 100%;
  transition: all 100ms linear;
}
.btn-start:hover {
    padding: 12px 35px;
    transition: all 100ms linear;
    opacity: 0.8;
}
.btn-top-circle{
  position: absolute;
  width: 30px;
  height: 30px;
  left: 0;
  top: 0;
  transform: translate(-30%, -40%);
  border-radius: 50%;
  z-index: -1;
  background: linear-gradient(180deg, #8CC8F0 0%, #319EE7 100%);
}
.image-mobile{
  display: none;
}
@media only screen and (max-width: 600px) {
  .career-image{
    display: none;
  }
  .career-heading{
    width: 100%;
    font-size: 105%;
    padding: 70px 20px !important;
  }
  .image-mobile{
    position: absolute;
    display: block;
    width: 240px;
    bottom: 20px;
    right: 0;
  }
  .image-mobile img{
    width: 100%;
  }
  .blue-strip-img{
    width: 140px;
  }
}
');
