<?php

use yii\helpers\Url;

?>
    <section class="app-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="app-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/app-phone.png') ?>" alt="EZ Capital">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="appp-text">
                        <h2>World's First Integrated Career Development App</h2>
                        <p>Our app includes Companies, Jobs, Internships, Reviews, Learning Hub, Courses, Career Advice, Education loans</p>
                        <p><span class="mota">Download for free from PlayStore!</span></p>
                        <div class="appss">
                            <a href="https://play.google.com/store/apps/details?id=com.empoweryouth.app" title="Get it on Google Play" target="_blank">
                                <img alt="Get it on Google Play" src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png" title="Download Empower Youth App on Google Play">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php
$this->registerCss('
.mota {
    font-weight: 600;
}
.app-bg {
    background: url(/assets/themes/ey/images/pages/custom/download-app.png);
    background-position: center;
    background-size: cover;
    color: #fff;
    min-height: 450px;
    display: flex;
    align-items: center;
    position: relative;
    margin: 30px 0 30px;
}
.app-img {
    text-align: center;
    margin-top: 30px;
}
.app-img img {
    width: 100%;
    height: 100%;
    max-width: 130px;
    max-height: 250px;
}
.appss {
    margin-bottom: 30px;
}
.appss img {
    height: 70px;
    width: 160px;
}
.appp-text {
    padding-top: 10px;
    text-align: center;
}
.appp-text h2 {
    font-size: 22px;
    font-family: roboto;
    color: #fff;
    font-weight: 600;
    line-height: 34px;
    margin-bottom: 10px;
}
.appp-text p {
    font-size: 16px;
    font-family: roboto;
    color: #fff;
    padding: 5px;
}
@media screen and (max-width: 765px) and (min-width: 320px) {
    .appp-text h2 {
        font-size: 22px;
    }
    .appp-text {
        padding-top: 10px;
        text-align: center;
    }
    .app-img img {
        max-width: 100px;
        max-height: 200px;
    }
}
');
