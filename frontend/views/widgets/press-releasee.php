<?php

use yii\helpers\Url;

?>
<section class="press-bg">
    <div class="container">
        <div class="row">
                <div class="col-md-6 col-sm-4 col-xs-12">
                <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'As Seen In'); ?></h2>
                </div>
            <div class="col-md-6 col-sm-4 col-xs-12">
<!--                <div class="type-1">-->
<!--                    <div>-->
<!--                        <a href="--><?//= Url::to('/jobs/international'); ?><!--" class="btn btn-3">-->
<!--                            <span class="txting">--><?//= Yii::t('frontend', 'View all'); ?><!--</span>-->
<!--                            <span class="round"><i class="fas fa-chevron-right"></i></span>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="press-release-hd">
                    <a href="https://www.nyoooz.com/news/chandigarh/1558601/empoweryouth-offers-education-loans-for-undergraduate-education-across-the-states-of-punjab-and-himachal-pradesh/" target="_blank">
                    <div class="press-release">
                        <div class="press-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/nyoooz.jpg'); ?>" alt=""/>
                        </div>
                    </div>
                    <div class="press-txt-hd">Nyoooz</div>
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="press-release-hd">
                    <a href="https://www.highereducationdigest.com/empoweryouth-com-offers-education-loans-for-undergraduate-education-across-the-states-of-punjab-and-himachal-pradesh/" target="_blank">
                        <div class="press-release">
                            <div class="press-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/HED_Trade-marked.png'); ?>" alt=""/>
                            </div>
                        </div>
                        <div class="press-txt-hd">Higher Education Digest</div>
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="press-release-hd">
                    <a href="http://www.univarta.com/news/punjab-haryana-himachal/story/2338208.html" target="_blank">
                        <div class="press-release">
                            <div class="press-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/unitednews.jpg'); ?>" alt=""/>
                            </div>
                        </div>
                        <div class="press-txt-hd">United News Of India</div>
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="press-release-hd">
                    <a href="https://www.newsnasha.com/empoweruth-com-tied-up-with-60-colleges-to-provide-loans/" target="_blank">
                        <div class="press-release">
                            <div class="press-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/newsnasha.png'); ?>" alt=""/>
                            </div>
                        </div>
                        <div class="press-txt-hd">News Nasha</div>
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="press-release-hd">
                    <a href="https://aavaj.com/national-news/12185/" target="_blank">
                        <div class="press-release">
                            <div class="press-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/aawaz.png'); ?>" alt=""/>
                            </div>
                        </div>
                        <div class="press-txt-hd">Aawaz News</div>
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="press-release-hd">
                    <a href="https://www.outlookhindi.com/newsscroll/%E0%A4%B8%E0%A5%8D%E0%A4%A8%E0%A4%BE%E0%A4%A4%E0%A4%95-%E0%A4%B6%E0%A4%BF%E0%A4%95%E0%A5%8D%E0%A4%B7%E0%A4%BE-%E0%A4%95%E0%A5%87-%E0%A4%B2%E0%A4%BF%E0%A4%8F-%E0%A4%8B%E0%A4%A3-%E0%A4%AA%E0%A5%8D%E0%A4%B0%E0%A4%A6%E0%A4%BE%E0%A4%A8-%E0%A4%95%E0%A4%B0%E0%A4%A8%E0%A5%87-%E0%A4%95%E0%A5%87-%E0%A4%B2%E0%A4%BF%E0%A4%8F-%E0%A4%87%E0%A4%AE%E0%A5%8D%E0%A4%AA%E0%A4%BE%E0%A4%B5%E0%A4%B0%E0%A4%AF%E0%A5%82%E0%A4%A5-%E0%A4%A1%E0%A5%89%E0%A4%9F%E0%A4%95%E0%A5%89%E0%A4%AE-%E0%A4%95%E0%A4%BE-60-%E0%A4%95%E0%A5%89%E0%A4%B2%E0%A5%87%E0%A4%9C%E0%A5%8B%E0%A4%82-%E0%A4%B8%E0%A5%87-%E0%A4%95%E0%A4%B0%E0%A4%BE%E0%A4%B0/45982?scroll" target="_blank">
                        <div class="press-release">
                            <div class="press-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/outlookhindi-logo.png'); ?>" alt=""/>
                            </div>
                        </div>
                        <div class="press-txt-hd">Outlook Hindi</div>
                    </a>
                </div>
            </div>
          </div>
        </div>
</section>
<?php
$this->registerCss('
.btn-3 {
    background-color: #424242;
}
.btn-3 .round {
    background-color: #737478;
}
.type-1{
    float:right;
    margin-top: 15px;
}
.type-1 div a {
    text-decoration: none;
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
    padding: 12px 53px 12px 23px;
    color: #fff;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: bold;
    position: relative;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    display: inline-block;
}
.type-1 div a span {
    position: relative;
    z-index: 3;
}
.type-1 div a .round {
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    position: absolute;
    right: 3px;
    top: 3px;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    z-index: 2;
}
.type-1 div a .round i {
    position: absolute;
    top: 50%;
    margin-top: -6px;
    left: 50%;
    margin-left: -4px;
    color: #333332;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}

.txting {
    font-size: 14px;
    line-height: 1.45;
}

.type-1 a:hover {
    padding-left: 48px;
    padding-right: 28px;
}
.type-1 a:hover .round {
    width: calc(100% - 6px);
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
}
.type-1 a:hover .round i {
    left: 12%;
    color: #FFF;
}
.press-bg {
    background-color: #f5f5f5;
    padding-bottom: 30px;
}
.press-release-hd {
    border: 1px solid #fff;
    background-color: #fff;
    box-shadow: 0 0 11px -4px rgba(0,0,0,0.2);
    margin-bottom: 10px;
}
.press-release-hd:hover {
    box-shadow: 0 0 15px 2px rgba(0,0,0,0.2);
}
.press-release {
    background-color: #fff;
    border-radius: 8px;
}
.press-img {
    text-align: center;
    padding: 10px 0px 0px;
}
.press-img img {
    width: 100px;
    height: 100px;
    object-fit: contain;
}
.press-txt-hd {
    font-size: 14px;
    font-family: lora;
    text-align: justify;
    color: #000;
    line-height: 20px;
    margin: 8px;
    margin-bottom: 10px;
    font-weight: 600;
    text-align: center;
    height: 46px;
}
');