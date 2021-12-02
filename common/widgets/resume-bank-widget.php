<?php

use yii\helpers\Url;
?>

<div class="career-for-company">
    <div class="resume-banner">
        <div class="blue-strip-img">
            <img src="<?= Url::to('@eyAssets/images/pages/drop-resume/resume-bank-top-left-bg.png'); ?>">
        </div>
        <div class="blue-strip-img right-bg">
            <img src="<?= Url::to('@eyAssets/images/pages/drop-resume/resume-bank-top-right-bg.png'); ?>">
        </div>
        <div class="row">
          <div class="career-heading col-sm-6">
              <div class="heading-text">
                  <h1>RESUME BANK</h1>
                  <p>When you're looking for new employees, use the RESUME BANK feature to strategically manage your applicant pool.</p>
              </div>
              <ul class="car-point">
                  <li><i class="fa fa-chevron-right"></i>Faster identification of qualified applicants</li>
                  <li><i class="fa fa-chevron-right"></i>Good candidates won't be left behind</li>
                  <li><i class="fa fa-chevron-right"></i>Time and cost saving</li>
              </ul>
              <div class="btn-div">
                  <a href="/drop-resume" class="btn-generate-link">Learn More</a>
                  <div class="btn-top-circle"></div>
              </div>
          </div>
          <div class="career-image col-sm-6" style="padding: 40px 0">
            <div class="career-img">
              <img src="<?= URL::to('@eyAssets/images/pages/drop-resume/resume-bank-img.png') ?>">
            </div>
          </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
#careerPageLink{
//    visibility: hidden;
    position: absolute;
    opacity: 0
}
.resume-banner{
    box-shadow: 0px 1px 10px 2px #eee !important;
    display: flex;
    position: relative;
    align-items: center;
    margin-bottom:30px;
    justify-content: center;
}
.resume-banner .row{
  display: flex;
  align-items: center;
}
.heading-text h1 {
  margin: 0;
  font-family: Roboto;
  font-weight: 700;
  font-size: 30px;
}
.heading-text p {
  font-family: roboto;
  color: #333;
  font-size: 14px;
  margin: 0;
  line-height: 1.3;
}
.resume-banner ul.car-point {
  list-style: none;
  margin-bottom: 20px;
}
.resume-banner ul.car-point li i {
  margin-right: 8px;
  color: #00a0e3;
}
.resume-banner ul.car-point li {
  list-style: none;
  margin-bottom: 3px;
  font-family: roboto;
  color: #333;
  font-size: 14px;
}
.blue-strip-img{
  position: absolute;
  top: 0;
  left: 0;
  width: 80px;
}
.blue-strip-img.right-bg{
  right: 0;
  left: unset;
  width: 340px;
}

.blue-strip-img img{
  width: 100%;
}
.career-heading{
  padding: 70px 0 45px 60px !important;
}
.heading-text{
  margin-bottom: 15px;
}
.career-image{
  padding: 70px 45px 60px 0 !important;
}
.career-image img{
  width: 100%;
}
.career-img{
  max-width: 432px;
  margin: auto;
}
.btn-div{
  position: relative;
  z-index: 1;
}
.resume-banner .btn-generate-link{
    padding: 10px 20px;
    border-radius: 8px;
    display: inline-block;
    border:none;
    background: #00A0e3;
    color: #fff;
    font-size: 100%;
    transition: all .3s linear;
    box-shadow: none;
}
.resume-banner .btn-generate-link:hover {
    padding: 10px 35px;
    transition: all .3 linear;
    color: #fff;
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
  display: none;
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
}
@media only screen and (max-width: 767px){
  .career-image{
    display: none;
  }
  .blue-strip-img.right-bg{
    display: none;
  }
  .career-heading{
    padding: 70px 30px !important;
  }
  .career-heading h1{
    font-size: 28px;
  }
}
');
$this->registerJS($script);
?>
<script>
copyLink = () => {
    let careerLink = document.querySelector('#careerPageLink');
    careerLink.select();
    careerLink.setSelectionRange(0, 9999);
    document.execCommand("copy");
}
</script>
