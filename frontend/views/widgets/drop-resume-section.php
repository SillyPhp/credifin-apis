<?php

use yii\helpers\Url;

?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-7">
                    <div class="drop-resume-text">
                        <h3>Drop Resume</h3>
                        <p>It is often the best hire that sets the tone for the company's culture. Pick the best
                            candidate
                            for your team, your vision and the company as a whole.</p>
                        <div class="drop-btn">
                            <a href="" class="activate-drop arrow">Activate</a>
                            <a href="" class="detail-drop">View Detail</a>
                        </div>
                    </div>
                    <div class="dr-how-it-works">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dr-how-text">
                                    <h3>How It Works</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="dr-box">
                                    <i class="fas fa-briefcase"></i>
                                    <p>Go to manage jobs/internships</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="dr-box">
                                    <i class="fas fa-copy"></i>
                                    <p>Go to Resume<br> Bank</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="dr-box">
                                    <i class="fas fa-user"></i>
                                    <p>Check profile for resumes</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="dr-box">
                                    <i class="fas fa-check"></i>
                                    <p>Review the<br> resumes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5">
                    <div class="drop-image">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/drop-res.png') ?>" alt="drop resume">
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.drop-resume-text h3 {
    color: #000;
    font-family: roboto;
    font-weight: 600;
    font-size: 30px;
    letter-spacing: 0.3px;
}
.drop-resume-text p {
    color: #000;
    font-family: roboto;
    letter-spacing: 0.5px;
    font-size: 18px;
    line-height: 30px;
    text-transform: capitalize;
}
.drop-btn {
    margin-top: 25px;
}
.activate-drop {
    color: #fff;
    background-color: #00a0e3;
    font-size: 16px;
    font-family: roboto;
    border: 2px solid #00a0e3;
    padding: 8px 15px;
    border-radius: 4px;
    display: inline-block;
    transition: ease-in-out .2s;
    width: 140px;
}
.arrow {
  color: #fff;
  background-color: #00a0e3;
  margin: 1em 0;
}
.arrow::after {
  display: inline-block;
  font-size: 18px;
  padding-left: 12px;
  content: "➞";
  transition: transform 0.3s ease-out;
}
.arrow:hover {
  color: #00a0e3;
  background-color: #fff;
}
.arrow:hover::after {
  transform: translateX(20px);
}
.detail-drop {
    font-size: 16px;
    font-family: roboto;
    padding: 8px 15px;
}
.detail-drop{
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.detail-drop:after {
    content: "»";
    position: absolute;
    font-size: 22px;
    opacity: 0;
    top: 1px;
    right: -26px;
    transition: 0.5s;
}

.detail-drop:hover{
  padding-right: 24px;
  padding-left:8px;
}

.detail-drop:hover:after {
  opacity: 1;
  right: 10px;
}
.dr-box {
    text-align: center;
    margin-bottom: 30px;
}
.dr-box i {
    background: linear-gradient(180deg, #93C7FF 0%, #298EF9 100%);
    font-size: 36px;
    color: #fff;
    padding: 12px 16px;
    border-radius: 16px;
}
.dr-how-text {
    margin-bottom: 20px;
}
.dr-box p{
    margin-top: 10px;
    font-family: roboto;
    letter-spacing: 0.3px;
    line-height: 20px;
    text-transform: capitalize;
    color: #000;
}
.dr-how-text h3:after {
    width: 60px;
    height: 2px;
    background-color: #00a0e3;
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
}
.dr-how-text {
    margin-bottom: 20px;
    position: relative;
}
.dr-how-text h3 {
    font-family: roboto;
    font-weight: 500;
}
@media screen and (max-width: 1200px) and (min-width: 1000px) {
    .drop-image {
        margin-top: 60px;
    }
}
@media screen and (max-width: 992px) and (min-width: 768px) {
    .drop-resume-text h3 {
        font-size: 24px;
    }
    .drop-resume-text p {
        font-size: 16px;
        line-height: 26px;
    }
    .dr-box i {
        font-size: 20px;
    }
    .dr-box p {
        font-size: 12px;
    }
    .drop-image {
        margin-top: 40px;
    }
}
@media screen and (max-width: 760px) and (min-width: 320px) {
    .drop-resume-text h3 {
        font-size: 22px;
    }
    .drop-resume-text p {
        font-size: 16px;
        line-height: 26px;
    }
    .drop-btn {
        margin-top: 0px;
    }
    .drop-image {
        display: none;
    }
}
');
