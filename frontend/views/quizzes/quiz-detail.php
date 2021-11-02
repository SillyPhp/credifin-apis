<?php

use yii\helpers\Url;

$link = Url::to('quizzes/' . $slug, true);
?>

<section class="quiz-detail-header">
    <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/banner/6162e42ec9155__banners__1920_x_560_px_.png?d=1920x557') ?>"/>
</section>

<Section class="quiz-details">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="detail-side">
                    <h3 class="quiz-title">Hero Campus Challenge Season 7 Hero MotoCorp Limited</h3>
                    <p class="quiz-detail-cat">it & management</p>
                    <div class="quiz-description">
                        This opportunity has been listed by College of Engineering (COEP), Pune. Dare2Compete is not
                        liable for any content mentioned in this opportunity or the process followed by the organizers
                        for this opportunity. However, please raise a complaint if you want Dare2Compete to look into
                        the matter.This opportunity has been listed by College of Engineering (COEP), Pune. Dare2Compete
                        is not liable for any content mentioned in this opportunity or the process followed by the
                        organizers for this opportunity. However, please raise a complaint if you want Dare2Compete to
                        look into the matter.This opportunity has been listed by College of Engineering (COEP), Pune.
                        Dare2Compete is not liable for any content mentioned in this opportunity or the process followed
                        by the organizers for this opportunity. However, please raise a complaint if you want
                        Dare2Compete to look into the matter.This opportunity has been listed by College of Engineering
                        (COEP), Pune. Dare2Compete is not liable for any content mentioned in this opportunity or the
                        process followed by the organizers for this opportunity. However, please raise a complaint if
                        you want Dare2Compete to look into the matter.
                    </div>
                </div>
                <?= $this->render('/widgets/sharing-widget-new', [
                    'link' => $link,
                ]); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="reward-heading">Rewards & Prizes</div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="rewards-win nd-shadow">
                            <div class="certificate-set">Certificate</div>
                            <div class="reward-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/prize100.png') ?>"/>
                            </div>
                            <h3>First Prize</h3>
                            <p>1,500 Rs</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="rewards-win nd-shadow">
                            <div class="certificate-set">Certificate</div>
                            <div class="reward-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/prize100.png') ?>"/>
                            </div>
                            <h3>Second Prize</h3>
                            <p>1,000 Rs</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="rewards-win nd-shadow">
                            <div class="certificate-set">Certificate</div>
                            <div class="reward-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/prize100.png') ?>"/>
                            </div>
                            <h3>Third Prize</h3>
                            <p>500 Rs</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="register-detail-btn">
                            <a href="">Register Now</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="nd-shadow timings-cover">
                            <div class="register-dead block-span">Registration Deadline
                                :<span>27/OCT/2021 08:20 PM IST</span></div>
                            <div class="register-fee block-span">Registration Fee : <span>₹500</span></div>
                            <div class="play-time block-span">Play Within : <span>29/OCT/2021 to 10/NOV/2021</span>
                            </div>
                            <div class="total-question block-span">Total Questions : <span>20</span></div>
                            <div class="total-time block-span">Total Time : <span>20 minutes</span></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="register-count">
                            <div class="registered-c">
                                <div class="avatars">
                                    <ul class="ask-people">
                                        <li>
                                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg') ?>">
                                        </li>
                                        <li>
                                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                                        </li>
                                    </ul>
                                    <p><span>12</span> People Registered</p>
                                </div>
                            </div>
                            <div class="viewers"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="related-quiz nd-shadow">
                            <h3 class="heading-related">Related Quiz</h3>
                            <div class="relate-box">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                                <p>The event will solely be conducted on recent advancements in science and technology. The event will solely be conducted on recent advancements in science and technology</p>
                            </div>
                            <div class="relate-box">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg') ?>">
                                <p>The event will solely be conducted on recent advancements in science and technology</p>
                            </div>
                            <div class="relate-box">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                                <p>The event will solely be conducted on recent advancements in science and technology</p>
                            </div>
                            <div class="relate-box">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg') ?>">
                                <p>The event will solely be conducted on recent advancements in science and technology. The event will solely be conducted on recent advancements in science and technology</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</Section>


<?php
$this->registerCss('
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.quiz-detail-header{
     min-height:450px;
     position:relative;
}
.quiz-detail-header img{ 
    width:100%;
    height:100%;
    object-fit:fill;
    position:absolute;
    top:0;
    right: 0;
}
.quiz-title {
    font-family: lora;
    font-weight: 600;
    font-size: 32px;
    margin-bottom:0;
}
.quiz-detail-cat {
    font-family: "Roboto";
    color: #00a0e3;
    text-transform: capitalize;
    font-size: 16px;
}
.quiz-description {
    font-family: "Roboto";
    text-align: justify;
    line-height: 25px;
    font-size: 15px;
}
.register-detail-btn a {
    display: block;
    background-color: #00a0e3;
    color: #fff;
    width: 100%;
    text-align: center;
    padding: 8px;
    font-family: "Roboto";
    font-weight: 500;
    margin: 20px 0;
    font-size: 17px;
    border-radius: inherit;
}
.timings-cover {
    padding: 20px;
    font-family: "Roboto";
    margin-bottom:20px;
}
.block-span {
    margin-bottom: 8px;
    font-size:15px;
}
.block-span span {
    display: block;
    font-weight: 500;
    margin-top:2px;
}
.reward-heading {
    text-shadow: 0px 2px 2px black, 0px 0px 8px white;
    font-family: lora;
    font-size: 32px;
    margin: 20px 0;
    font-weight: 400;
}
.rewards-win {
    padding: 20px;
    margin-bottom: 30px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.certificate-set {
    position: absolute;
    left: -23px;
    top: 16px;
    background-color: #00a0e3;
    color: #fff;
    font-family: "Roboto";
    padding: 1px 22px;
    transform: rotate(-45deg);
    font-size: 12px;
}
.reward-img img {
    width: 60px;
}
.rewards-win h3 {
    font-size: 16px;
    font-family: "Roboto";
    font-weight: 500;
    margin-bottom:0;
}
.rewards-win p {
    font-family: "roboto";
    font-weight: 500;
    color: #949494;
    font-size: 16px;
    margin-bottom:0;
}
.avatars {
    display: flex;
    align-items: center;
    margin-left: -20px;
    margin-bottom: 30px;
}
.avatars p {
    font-size: 18px;
    padding-top: 10px;
    margin-left: 40px;
    margin-bottom: 0px;
}
.ask-people{
    margin-top: 10px;
    margin-left: 20px;
}
.sidebar h5{
    font-size: 16px;
}
.ask-people li{
    width: 50px;
    height: 50px;
    border: 2px solid #fff;
    border-radius: 50%;
    display: inline-block;
    margin-right: -28px;
}
.ask-people li img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.related-quiz {
    padding: 15px 20px 20px;
    font-family: "Roboto";
}
.heading-related {
    margin: 0px 0 20px;
    font-size: 20px;
    font-family: "Roboto";
    font-weight: 500;
}
.relate-box {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 10px;
}
.relate-box img {
    width: 60px;
    height: 60px;
    margin-right: 10px;
    border-radius: 4px;
    overflow: hidden;
}
.relate-box p {
    font-size: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 20px;
    max-width: 78%;
}
');

$script = <<<JS

JS;
$this->registerJS($script);
$this->registerJsFile('https://platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

