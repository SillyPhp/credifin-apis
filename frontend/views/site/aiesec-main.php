<?php

use yii\helpers\Url;
$keywords = "Enigma 2021,  ";

$description = "Enigma'21 aims to give the delegates a much more culturally diverse and enriched experience";

$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/ey/images/pages/aiesec/enigma-sharing.jpg');

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

    <section class="aiesec-header">
        <div class="overlay-left"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="aiesec-txt">
                        <h1 class="cOrange">ENIGMA'21</h1>
                        <p>AIESEC in Ludhiana</p>
                        <p style="font-size: 14px;">Mark your calendars for <span class="colorOrange">August 6 to 8, 2021</span> and win exciting
                            cash prizes.</p>
                        <?php
                        if(Yii::$app->user->isGuest){
                            ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="reg-btn">REGISTER NOW</a>
                            <?php
                        }else{
                            ?>
                            <a href="https://pages.razorpay.com/pl_HQDv9kT7ZXSUBd/view" target="_blank" class="reg-btn">REGISTER NOW</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <Section class="mun-aiesec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="head-style">ABOUT EVENT</div>
                </div>
                <div class="col-md-12">
                    <div class="mun-txt">
                        <p>Enigma'21 is the first installation of series of MUNs brought to you by AIESEC in
                            LUDHIANA</p>
                        <p>Model United Nations (MUN) is a real time simulation of United Nations where delegates are
                            allotted a portfolio from a selected UN committee and they discuss and debated about real
                            life International/national issues, conflicts, laws, etc.You will be participating with
                            International delegation and you will be experiencing AIESEC culture like you never had ;
                            there will be benchmark AIESEC networking session like World cafe and an open mic session
                            where you can showcase your talent and/or be in the audience enjoying the show.</p>
                    </div>
                    <div class="venue-date">
                        <p>The event will be held on</p>
                        <p class="text-bold" style="margin-bottom: 15px;">ZOOM on 6th, 7th & 8th August 2021</p>
                        <?php
                        if(Yii::$app->user->isGuest){
                            ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="reg-btn2">REGISTER NOW</a>
                            <?php
                        }else{
                            ?>
                            <a href="https://pages.razorpay.com/pl_HQDv9kT7ZXSUBd/view" target="_blank" class="reg-btn2">REGISTER NOW</a>
                            <?php
                        }
                        ?>
                        </div>
                </div>
            </div>
        </div>
    </Section>

    <Section class="enigma21-aiesec">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="enigma-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/aiesec/blue-name1.png') ?>">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="enigma-txt">
                        <h3 class="head-style-enigma">ENIGMA'21</h3>
                        <p><span class="text-bold">Enigma'21</span> aims to give the delegates a much more culturally
                            diverse and enriched experience
                            than possible in any other MUNs currently being
                            conducted with delegations from all over the world. Our MUN provides them an opportunity to
                            expand their network globally and garner national recognition.</p>
                        <p>Besides this, we will also bring forth an element of physical MUNs, the absence of which from
                            its virtual counterparts has been keeping much of Ludhiana's former MUNing crowd
                            disinterested- the Socials.</p>
                    </div>
                    <div class="powered-by">
                        <p>Powered By :</p>
                        <img src="<?= Url::to('@eyAssets/images/logos/eycom.png') ?>">
                    </div>
                </div>
            </div>
        </div>
    </Section>

    <Section class="mun-aiesec2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="head-style">MUN (MODEL UNITED NATIONS)</div>
                </div>
                <div class="col-md-12">
                    <div class="mun-txt">Model United Nations is a popular activity for those interested in learning
                        more about how the UN operates. Hundreds of thousands of students worldwide take part every year
                        at all educational levels. Many of today's leaders in law, government, business and the arts -
                        including at the UN - participated in Model UN as students.
                    </div>
                </div>
            </div>
        </div>
    </Section>

    <Section class="about-aiesec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="head-style">ABOUT AIESEC</div>
                </div>
                <div class="col-md-12">
                    <p class="about-aiesec-content">AIESEC is a Global, Non-Political, Independent, Not-for-Profit,
                        United Nations organization run by students & recent graduates of institutions of higher
                        education.
                    </p>
                    <p class="about-aiesec-content">We provide an opportunity for young people to work or volunteer
                        abroad in non-familiar environments, alowing them to come out of their comfort zones and expand
                        their worldview while giving out to the community.
                    </p>
                </div>
            </div>
        </div>
    </Section>

<?php
$this->registerCss('
.powered-by {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
}
.powered-by p {
    font-size: 16px;
    font-family: Roboto;
    font-weight: 600;
    margin: 0;
}
.powered-by img {
    width: 200px;
    margin-left: 10px;
}
.text-bold{font-weight:600;}
.aiesec-header{
    background:url(' . Url::to('@eyAssets/images/pages/aiesec/enigma-header.png') . ');
    min-height:500px;
    background-size:cover;
    background-position: left;
    background-repeat: no-repeat;
    display: flex;
    justify-content: flex-start;
    align-items: center;
}
.colorOrange, .cOrange{
    color: #ff7803;
}
.colorOrange{
    font-size: 20px;
    font-weight: 500; 
}
.overlay-left {
  position: absolute;
  top: 0px;
  left: 0px;
  background-color: rgba(0,0,0,0.5);
  width: 100%;
  height: 100%;
}
.reg-btn {
    background-color: #FFE;
    color: #333;
    padding: 8px 20px;
    display: inline-block;
    font-family:roboto;
    font-weight:600;
    transition: all .3s;
}
.reg-btn:hover{
    box-shadow:2px 2px 10px 0px #fff;
    transform: scale(1.2);
}
.reg-btn2 {
    background-color: #00a0e3;
    color: #fff;
    padding: 8px 20px;
    display: inline-block;
    font-family:roboto;
    font-weight:600;
    transition: all .3s;
}
.reg-btn2:hover{
    box-shadow:2px 2px 10px 0px #000;
    color:#fff;
    transform: scale(1.2);
}
.reg-btn2:focus{
    color:#fff;
}
.about-aiesec {
    margin: 30px 0;
}
.aiesec-txt {
//    text-align: center;
}
.aiesec-txt h1 {
    font-size: 42px;
    font-family: lora;
    color: #ff7803;
    font-weight:600;
}
.aiesec-txt p{
    font-size:16px;
    font-family:roboto;
    color:#fff;
} 
p.about-aiesec-content, .mun-txt {
    font-family: Roboto;
//    text-align: center;
    font-size: 16px;
}
.mun-aiesec {
    margin: 40px 0;
    padding: 20px 0 50px;
//    background: linear-gradient(346deg, rgba(0,28,57,1) 0%, rgba(24,128,164,1) 41%);
//    color: #fff;
}
.mun-aiesec2 {
    margin: 40px 0;
    padding: 20px 0 50px;
    background:linear-gradient(346deg, rgba(0,28,57,1) 0%, rgb(4 76 105) 41%);
    color: #fff;
}
.venue-date {
//    text-align:center;
}
.head-style-enigma, .head-style{
    margin: 0 0 10px;
    font-family: lora;
    font-weight: 600;
    font-size: 28px;
}
.enigma-img{text-align:center;}
.enigma-img img {
    width: 250px;
    height: auto;
    object-fit: contain;
}
.venue-date p {
    margin-bottom: 0;
}
.enigma-txt p {
    font-size: 16px;
    font-family: Roboto;
    line-height: 30px;
}
@media only screen and (max-width: 992px){
    .aiesec-header{
        min-height:300px;
    }
    .aiesec-txt h1{
        font-size: 35px;
    }
}
');
