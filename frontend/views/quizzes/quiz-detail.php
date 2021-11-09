<?php

use yii\helpers\Url;

$link = Url::to('quizzes/' . $slug, true);
?>

<section class="quiz-header">
    <div class="left-quiz">
        <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-l.png') ?>"/>
    </div>
    <div class="right-quiz">
        <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-r.png') ?>"/>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                <div class="quiz-header-heading">
                    <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6176c48e680e5_whatsapp_image_2021-10-25_at_8.16.08_pm.jpeg?d=340x195') ?>"/>
                    <p>Hero Campus Challenge Season 7 Hero MotoCorp Limited</p>
                    <p class="quiz-detail-cat">IT & MANAGEMENT </p>
                    <div class="quiz-timings-cover">
                        <div class="reg-deadline"><i class="fas fa-user-clock"></i> Registration Deadline : <span>27/OCT/2021 08:20 PM IST</span></div>
                        <div class="days-left2"><i class="fas fa-clock"></i> 5 Days Left</div>
                        <div class="both-btns">
                            <div class="register-detail-btn-2">
                                <a href="">Register Now</a>
                            </div>
                            <div class="addeventatc" title="Add to Calendar">
                                <span class="start">11/16/2021 08:00 AM</span>
                                <span class="end">11/16/2021 10:00 AM</span>
                                <span class="timezone">Asia/Kolkata</span>
                                <span class="title">Summary of the event</span>
                                <span class="description">Description of the event</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                <?= $this->render('/widgets/sharing-widget-new', [
                    'link' => $link,
                ]); ?>
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
                            <div class="register-dead block-span"><i class="fas fa-user-clock"></i> <span>Registration Deadline : <strong>27/OCT/2021 08:20 PM IST</strong></span></div>
                            <div class="register-fee block-span"><i class="fas fa-rupee-sign"></i> <span>Registration Fee : <strong>₹500</strong></span></div>
                            <div class="play-time block-span"><i class="far fa-play-circle"></i> <span>Play Within : <strong>29/OCT/2021 to 10/NOV/2021</strong></span></div>
                            <div class="total-question block-span"><i class="fas fa-print"></i> <span>Total Questions : <strong>20</strong></span></div>
                            <div class="total-time block-span"><i class="fas fa-clock"></i> <span>Total Time : <strong>20 minutes</strong></span></div>
                        </div>
                    </div>
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</Section>

<section class="rewards-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style">Rewards & Prizes</div>
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
</section>

<section class="related-quiz-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style">Related Quizzes</div>
            </div>
            <div class="col-md-4">
                <div class="card-main nd-shadow">
                    <div class="paid-webinar">Paid</div>
                    <div class="expired-btn">EXPIRED</div>
                    <div class="card-img">
                        <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6176c48e680e5_whatsapp_image_2021-10-25_at_8.16.08_pm.jpeg?d=340x195') ?>"/>
                    </div>
                    <div class="card-details">
                        <div class="about-first flex-container">
                            <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                            <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                            <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                        </div>
                        <div class="about-name">
                            <div class="quiz-name">Health Awareness Quiz</div>
                            <div class="quiz-category">marketing</div>
                        </div>
                        <div class="about-footer">
                            <div class="detail-btn">
                                <a href="" class="view-details">View Detail</a>
                            </div>
                            <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-main nd-shadow">
                    <div class="paid-webinar">Paid</div>
                    <div class="expired-btn">EXPIRED</div>
                    <div class="card-img">
                        <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6176c48e680e5_whatsapp_image_2021-10-25_at_8.16.08_pm.jpeg?d=340x195') ?>"/>
                    </div>
                    <div class="card-details">
                        <div class="about-first flex-container">
                            <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                            <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                            <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                        </div>
                        <div class="about-name">
                            <div class="quiz-name">Health Awareness Quiz</div>
                            <div class="quiz-category">marketing</div>
                        </div>
                        <div class="about-footer">
                            <div class="detail-btn">
                                <a href="" class="view-details">View Detail</a>
                            </div>
                            <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-main nd-shadow">
                    <div class="paid-webinar">Paid</div>
                    <div class="expired-btn">EXPIRED</div>
                    <div class="card-img">
                        <img src="<?= Url::to('https://d8it4huxumps7.cloudfront.net/uploads/images/opportunity/mobile_banner/6176c48e680e5_whatsapp_image_2021-10-25_at_8.16.08_pm.jpeg?d=340x195') ?>"/>
                    </div>
                    <div class="card-details">
                        <div class="about-first flex-container">
                            <div class="days-left" style="flex-grow: 1"><i class="far fa-clock"></i> 6 Days Left</div>
                            <div class="register-date" style="flex-grow: 1"><i class="far fa-user"></i> 5 Registered</div>
                            <div class="pricing-money" style="flex-grow: 8"><img src="<?= Url::to('@eyAssets/images/pages/quiz/PRIZE.png') ?>"/> ₹5,000 </div>
                        </div>
                        <div class="about-name">
                            <div class="quiz-name">Health Awareness Quiz</div>
                            <div class="quiz-category">marketing</div>
                        </div>
                        <div class="about-footer">
                            <div class="detail-btn">
                                <a href="" class="view-details">View Detail</a>
                            </div>
                            <div class="views-count"><i class="fa fa-eye"></i> 6 Views</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.addeventatc{
    height:32px;
    width:34px;
    padding:0 !important;
    margin-left:6px;
}
.addeventatc .addeventatc_icon {
    left: 50% !important;
    top: 50% !important;
    transform: translate(-50%, -50%) !important;
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.quiz-header {
    min-height: 500px;
    position: relative;
    background: linear-gradient(hsla(0,0%,100%,0),rgb(120 198 254 / 44%));
}
.left-quiz {
    position: absolute;
    left: 0;
    top: 0;
}
.right-quiz {
    position: absolute;
    right: 0;
    bottom: 0;
}
.quiz-header-heading p {
    font-size: 20px;
    font-family: "Roboto";
    color: #009ebe;
    margin:0;
}
.quiz-header-heading img {
    width: 100px;
    height: 100px;
    object-fit: fill;
    border: 2px solid #afddff;
    padding: 2px;
    border-radius: 4px;
    margin-bottom:20px;
}
.quiz-header-heading {
    text-align: center;
    margin-top: 100px;
}
.quiz-timings-cover {
    display: flex;
    align-items: center;
    border: 2px solid #009ebe;
    border-radius: 4px;
    flex-wrap: wrap;
    justify-content: center;
    background: #009ebe;
    padding: 8px 0;
    margin:15px 0;
}
.reg-deadline, .days-left2 {
    border-right: 2px solid #fff;
    padding-right: 15px;
    margin-right: 15px;
    font-family: "Roboto";
    color: #fff;
}
.reg-deadline i, .days-left2 i {
    color: #fbba00;
    margin-right:2px;
}
.register-detail-btn-2 a{
    display:block;
    text-align: center;
    font-family:"roboto";
    font-weight:500;
    font-size: 15px;
    width: 150px;
    border-radius: 4px;
    margin: 0;
    background-color: #fff;
    color: #009ebe;
    padding: 4px 0;
}
.both-btns {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}
.quiz-title {
    font-family: lora;
    font-weight: 600;
    font-size: 28px;
    margin-bottom: 0;
    color: #009ebe;
    line-height: 30px;
}
.quiz-detail-cat {
    font-family: "Roboto";
    color: #fbba00 !important;
    text-transform: capitalize;
    font-size: 16px !important;
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
    margin-bottom: 10px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    padding-bottom: 10px;
}
.block-span span {
    display: block;
    padding-left: 10px;
}
.block-span span strong{
    display:block;
    font-weight:500;
    margin-top:2px;
}
.block-span i {
    font-size: 20px;
    color: #009ebe;
    margin-right: 5px;
    width: 22px;
    text-align: center;
}
.block-span:last-child {
    margin: 0;
    border-bottom: 0;
    padding:0;
}
.reward-heading {
//    text-shadow: 0px 2px 2px black, 0px 0px 8px white;
    font-family: lora;
    font-size: 32px;
    margin: 0 0 15px 0;
    font-weight: 600;
}
.rewards-win {
    padding: 20px;
    margin-bottom: 15px;
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
    color:#00a0e3;
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
/* card css starts here */
.card-main {
    border-radius: 4px;
    overflow: hidden;
    margin-bottom:30px;
    position:relative;
}
.paid-webinar {
    position: absolute;
    right: -25px;
    background-color: #f80000;
    color: #fff;
    font-family: "Roboto";
    font-weight: 700;
    padding: 0px 28px;
    transform: rotate(45deg);
    top: 14px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.card-img img {
    width: 100%;
    height: 200px;
    object-fit: fill;
    border-radius:4px 0 0 0;
}
.card-details {
    padding: 10px;
    font-family: "Roboto";
}
.flex-container {
    display: flex;
    align-items: center;
    margin: 10px 0;
}
.days-left i, .register-date i {
    color: #00a0e3;
    font-size: 16px;
    margin-right: 2px;
}
.pricing-money {
    text-align: right;
    font-size: 16px;
    color: #e2bc0c;
}
.pricing-money i {
    font-size: 24px;
}
.quiz-name {
    font-size: 18px;
    font-family: "Roboto";
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.quiz-category {
    text-transform: capitalize;
    color: #b8b8b8;
    margin-bottom:10px;
}
.about-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.view-details {
    background: linear-gradient(346deg, rgb(189 234 255) 0%, rgba(23,148,190,1) 47%);
    color: #fff;
    padding: 4px 18px;
    display: inline-block;
    border-radius: 32px;
    margin-right:5px;
}
.view-details:focus, .view-details:hover{
    color:#fff;
    transform: scale(1.05);
    transition: all .3s;
}
.expired-btn {
    padding: 0px 10px;
    background-color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    font-family: "Roboto";
    font-weight:500;
}
.views-count {
    color: #018e01;
}
/* card css ends here */
@media screen and (max-width: 1200px) {
    .reg-deadline, .days-left2{
        border: none;
        margin-bottom: 5px;    
    }
    .quiz-timings-cover{
        flex-direction:column;
    }
    register-detail-btn-2{
        margin-bottom:5px;
    }
}
@media screen and (max-width: 992px) {
    .quiz-header .left-quiz img, .quiz-header .right-quiz img {
        width: 150px;
    }
}
@media screen and (max-width: 767px) {
    .quiz-header .left-quiz img, .quiz-header .right-quiz img {
        width: 85px;
    }
    .basis {
        flex-basis: 49%;
    }
}
');

$script = <<<JS
window.addeventasync = function(){
    addeventatc.settings({
        appleical  : {show:true, text:"Apple Calendar"},
        google     : {show:true, text:"Google <em>(online)</em>"},
        office365  : {show:true, text:"Office 365 <em>(online)</em>"},
        outlook    : {show:true, text:"Outlook"},
        outlookcom : {show:true, text:"Outlook.com <em>(online)</em>"},
        yahoo      : {show:true, text:"Yahoo <em>(online)</em>"}
    });
};
$('.addeventatc').attr('title','Add To Calendar');
JS;
$this->registerJS($script);
$this->registerJsFile('https://addevent.com/libs/atc/1.6.1/atc.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('https://platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    async function getDetails(){
        const slug = window.location.pathname;
        console.log(slug);
        let response = await fetch(`${baseUrl}/api/v3/quiz/detail`,{
            method: 'POST',
            body: ''
        })
    }
</script>

