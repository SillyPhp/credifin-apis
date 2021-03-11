<?php

use yii\helpers\Url;

?>
<section class="press-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'As Seen In'); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-12">
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
            <div class="col-md-2 col-sm-4 col-xs-12">
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
            <div class="col-md-2 col-sm-4 col-xs-12">
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
            <div class="col-md-2 col-sm-4 col-xs-12">
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
            <div class="col-md-2 col-sm-4 col-xs-12">
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
            <div class="col-md-2 col-sm-4 col-xs-12">
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
.press-bg {
    background-color: #f5f5f5;
    padding-bottom: 30px;
}
.press-release-hd {
    border: 1px solid #fff;
    background-color: #fff;
    box-shadow: 0 0 11px -4px rgba(0,0,0,0.2);
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
    height: 40px;
}
');