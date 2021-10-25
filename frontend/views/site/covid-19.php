<?php

use yii\helpers\Url;

?>
<section class="safety-header">
    <div class="container">
        <h3>Empower And Protect Your Workspace <br> With These Safety Signs</h3>
    </div>
</section>
<section class="safety-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row" id="categories">
                    <div class="hideDiv showDiv">
                        <div class="safety-flex">
                            <div class="bg-shadow">
                                <div class="small-img" id="posterThumb">
                                    <div class="small-icons">
                                        <img src="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizer.png') ?>">
                                    </div>
                                    <div class="small-icons">
                                        <img src="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizerOne.png') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mainPoster">
                                <div class="covid-main">
                                    <div class="main-img">
                                        <img src="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizer.png') ?>"
                                             id="bigPoster" class="mainImg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="covid-list" id="safetyList">
                    <div class="covid-heading">Warnings <span>Designs</span></div>
                    <ul class="topicLists">
                        <li class="liClick activeLi" id="sanitizer">
                            Please use hand sanitizer before entering
                            <span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizer.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/handSanitizerOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="distance">Please maintain physical distance<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/physicalDistance.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/physicalDistanceOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="masksRequired">Masks required beyond this point<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/masksRequired.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/masksRequiredOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="glovesMasks">Gloves & masks required beyond this point<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/glovesMasks.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/glovesMasksOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="social">Thanks for practicing social distancing<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/socialDistance.png') ?>"
                                  class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/socialDistanceOne.png') ?>"
                                  class="data-img"></span>
                        </li>
                        <li class="liClick" id="tissue">Cover mouth & nose with flexed elbow or tissue when
                            sneezing/coughing<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/coverMouth.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/coverMouthOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="throwTissues">Throw used tissues into closed bins
                            immediately<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/throwTissues.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/throwTissuesOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="cleanHands">Clean hands save lives<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/cleanHand.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/cleanHandsOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="seconds">Wash your hands for atleast 20 seconds<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/20seconds.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/20secondsOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="avoidTouching">Avoid touching eyes, nose & mouth<span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/avoidTouching.png') ?>" class="data-img"></span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/avoidTouchingOne.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="practiceSocial">Please practice social distancing<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/practiceSocial.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick " id="unwell">Do not enter if unwell<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/unwell.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="stayHome">Stay home if you feel unwell<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/stayHome.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="spitting">Spitting could be dangerous<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/spitting.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="healthHazard">Spitting in public is a health hazard<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/healthHazard.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="work">Clean your hands before getting back to work<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/work.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="virus">Virus outbreak. Proceed with caution<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/virusCaution.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="proceed">Please proceed this way<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/proceed.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="workArea">Please sanitize your work area regularly<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/workArea.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="protectOthers">Protect others from getting sick<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/protectOthers.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="dropOff">Please drop off at this point<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/dropOff.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="personalItems">Do not share personal items<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/personalItems.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="extraCaution">Please exercise extra caution<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/extraCaution.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="handshake">Handshake-free zone<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/handshake.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="limitedEntry">Limited entry in lift<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/limitedEntry.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="liftWalls">Do not touch lift walls<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/liftWalls.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="lineStart">Line starts here<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/lineStart.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="sink">Sink is for hand washing only<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/sink.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="temperature">Temperature check mandatory<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/temperature.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="tempStation">Temperature check station<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/tempStation.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="disposing">This dustbin is for disposing medical gear<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/disposing.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="waitHere">Wait here until asked to step forward<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/waitHere.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="phoneEmail">We are open. Order by phone & email only<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/phoneEmail.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="takeAway">We are open. Take away & delivery only<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/takeAway.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="yourCar">We will bring your order to your car<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/yourCar.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="handrails">Do not touch the handrails<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/handrails.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="usingLift">Please clean your hands after using lift<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/usingLift.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="parking">Maintain distance while parking<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/parking.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="screening">Covid-19 Screening<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/screening.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="ringTheBell">Do not ring the bell call the concerned
                            person<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/ringTheBell.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="ppe">Proper PPE required beyond this point<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/ppe.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="visitors">No visitors allowed due to health safety<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/visitors.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="collectMasks">Please collect your masks here<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/collectMasks.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="temporarily">We are temporarily closed<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/temporarily.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="dining">Temporarily closed for dining<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/dining.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="permanently">We are permanently closed<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/permanently.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick" id="responsibly">Please act responsibly<span>1</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/responsibly.png') ?>" class="data-img"></span>
                        </li>
                        <li class="liClick activeLi" id="sanitizer">
                            Please wash hands before returning to work
                            <span>2</span>
                            <span data-img="<?= Url::to('@eyAssets/images/pages/safty-posters/pleaseWash.png') ?>"
                                  class="data-img"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="download">
            <h2>download these a4 signs for free </h2>
                <a href="<?= Url::to('@eyAssets/warning-posters-zip/warning-posters.zip')?>" download class="share-elem-main"><span><i class="fas fa-download"></i></span>Download All</a>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="share-heading">Share With Your Friends And Create Awareness</h1>
                <div class="share-social">
                    <div class="fb-share basis">
                        <a href="#!" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                            <span class="fb-btn"><i class="fab fa-facebook-f"></i> Facebook</span>
                        </a>
                    </div>
                    <div class="whatsapp-share basis">
                        <a href="#!" onclick="window.open('https://api.whatsapp.com/send?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                            <span><i class="fab fa-whatsapp"></i> Whatsapp</span>
                        </a>
                    </div>
                    <div class="teleg-share basis">
                        <a href="#!" onclick="window.open('https://telegram.me/share/url?url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                            <span><i class="fab fa-telegram-plane"></i> Telegram</span>
                        </a>
                    </div>
                    <div class="twi-share basis">
                        <a href="#!" onclick="window.open('https://twitter.com/intent/tweet?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                            <span><i class="fab fa-twitter marg"></i> Twitter</span>
                        </a>
                    </div>
                    <div class="link-share basis">
                        <a href="#!" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-elem-main">
                            <span><i class="fab fa-linkedin-in marg"></i> LinkedIn</span>
                        </a>
                    </div>

                </div>


            </div>
        </div>
        <div class="row">
            <div class="quick-review">
                <div class="row quick-review-inner">
                    <div class="col-md-3 quick-review-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/blog/DSB-law-group.png'); ?>"></div>
                    <div class="col-md-7 overflow-hidden set-heading-c">
                        <h2>Customize Posters With Your Own Company's Name And Logo</h2>
                        <div class="quick-review-action" id="review_btn">
                            <a href="javascript:;">Login or Sign Up & Download For Free</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <section class="great-bg">
            <div class="container">
                <div class="row">
                    <div class="head-about">
                        <h3>What's Great About Empower Youth?</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <a href="/candidates/features">
                            <div class="about-box">
                                <div class="bx-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/Efficiency.png') ?>">
                                </div>
                                <h4>Enhance your Efficiency and Effectiveness</h4>
                                <div class="about-text">Receive multiple offers from top-level organizations and properly
                                    recruited for joining an organization.
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="/candidates/features">
                            <div class="about-box">
                                <div class="bx-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/showcase-progress.png') ?>">
                                </div>
                                <h4>Showcase Your Employer Brand</h4>
                                <div class="about-text">Showcasing our unique cultural differentiators, and then working to
                                    amplify it so you can position yourself as a top place to work.
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="/candidates/features">
                            <div class="about-box">
                                <div class="bx-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/track-progress.png') ?>">
                                </div>
                                <h4>Track Progress</h4>
                                <div class="about-text">Track your application process in simple steps & stay up-to-date.
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="/candidates/features">
                            <div class="about-box">
                                <div class="bx-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/free4all.png') ?>">
                                </div>
                                <h4>Free For All</h4>
                                <div class="about-text">You can apply for jobs and have your learning courses without giving
                                    any
                                    penny.
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="/candidates/features">
                            <div class="about-box">
                                <div class="bx-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/live-interview.png') ?>">
                                </div>
                                <h4>Live Interview Schedule</h4>
                                <div class="about-text">Automates scheduling of live interactions between interviewer and
                                    interview.
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="/candidates/features">
                            <div class="about-box">
                                <div class="bx-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/livechat.png') ?>">
                                </div>
                                <h4>Live Chat</h4>
                                <div class="about-text">You can easily live chat with our Employers to get help & for more
                                    other
                                    queries.
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="great-red">
                    <a href="/candidates/features">View All Features</a>
                </div>
            </div>
        </section>
    </div>
    <div class="container mb3">
        <?= $this->render('/widgets/e-campus-safety-posters') ?>
    </div>
    <Section class="information">
            <div class="box-parent row">
                <div class="bolls">
                    <div class="boll1 bol2"></div>
                    <div class="boll2 bol2"></div>
                    <div class="boll3 bol"></div>
                    <div class="boll4 bol"></div>
                    <div class="boll5 bol2"></div>
                    <div class="boll6 bol2"></div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="jobs-content">
                        <div class="j-count">50 +</div>
                        <div class="j-name">Colleges</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="jobs-content">
                        <div class="j-count">10k +</div>
                        <div class="j-name">Freshers</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="jobs-content">
                        <div class="j-count">5k +</div>
                        <div class="j-name">Experienced candidates</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="jobs-content">
                        <div class="j-count">20k +</div>
                        <div class="j-name">Internship Candidates</div>
                    </div>
                </div>
            </div>
        </Section>

        <?= $this->render('/widgets/our-services') ?>
</section>

<?php
$this->registercss('
#footer{
    margin-top: 0px;
}
.mb3{
    margin-bottom:70px;
}
.share-heading{
    margin-top: 30px;
    font-size: 30px;
    font-family: lora;
    color: #333;
    text-align: center;
}
#categories, #safetyList{
    max-height: 600px;
}
.share-social {
	display: flex;
	align-items: stretch;
	margin:10px 0;
}
.basis{
    flex-basis:50%;
}
.fb-share a, .whatsapp-share a, .teleg-share a, .twi-share a, .link-share a, .download a{
	display: block;
	color: #fff;
	padding: 8px 10px;
	font-size: 16px;
	font-family: roboto;
	font-weight: 500;
	margin-right: 10px;
}
.fb-share a{background-color: #3b5998}
.whatsapp-share a{background-color:#36dc54;}
.teleg-share a{background-color:#2399d7;}
.twi-share a{background-color:#1da1f2;}
.link-share a{background-color:#0073b1;}

.sharing-pic{
    padding-bottom:10px;
    text-align:center;
}
.sharing-pic img{
    width:330px;
    height:180px;
}
.mail-share{
    text-align:center;
}   
@media only screen and (max-width: 768px){
.mail-share{
    display:inline-block;
    width:99%;
}
}
.download{
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(140deg, #00C0FF, #236CD7, #4218B8) ;
    border-radius: 5px;
    margin-top: 20px;
}
.download h2{
    text-transform: capitalize;
    padding-right: 20px;
    color: #fff; 
    font-family: roboto;
    font-size: 25px;
}
.download a{
    background-color: #fff;
    max-width: 280px;
    width: 100%;
    max-height: 43px;
    height: 100%;
    text-align: center;
    border: none;
    color:#00a0e3;
    border-radius: 4px;
}
.download a:hover, .quick-review-action a{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    transition: .3s ease;
    background: #ffca05;
    color:#fff;
}
.download a i{
    padding-right: 5px; 
}
.safety-header{
    background: url(' . Url::to('@eyAssets/images/pages/safty-posters/safetyHeaderOne.png') . ');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 450px;
    display: flex;
    align-items: center;    
}
.safety-header h3{
    font-size: 40px;
    font-family: lora;
    max-width: 500px;
    font-weight: bold;
}
.safety-bg{
    background: url(' . Url::to('@eyAssets/images/pages/safty-posters/speakers-bg.png') . ');
    background-position: top;
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
}
.db-flex{
    display: flex;
    align-items: center;
    height: 100%;
    width: 100%;
    justify-content: center;
}
.safety-flex{
    display: flex;
    justify-content: center;    
}
.mainPoster, .bg-shadow{
    margin:0 10px;
}
.bg-shadow{
//    box-shadow: 0 5px 10px rgba(0,0,0,.1);  
    height: calc(100vh - 90px);
    padding: 0 0;
    text-align: center;  
    
}
.set-heading-c > h2{
    font-family: lora;
    color: #fff;
}
.liClick:hover, .activeLi{
    color: #fff !important;
    background: #ffcc00 !important;
    transition: .3s ease;
}
.quick-review-action a{  
	text-align:center;
	display:inline-block; 
    padding:5px 15px; 
    background:#fff; 
    border-radius:4px; 
    font-size:15px; 
    font-weight:500; 
    color:#00a0e3;
    text-decoration: none;
    text-transform: capitalize;
    font-family: roboto;
}
.quick-review-action a:hover, .quick-review-action a:focus, .quick-review-action:active{
	outline: none;
	box-shadow: none;
} 
.overflow-hidden{
    overflow:hidden;
}
.quick-review{
	margin: 20px;
	background: linear-gradient(140deg, #00C0FF, #236CD7, #4218B8) ;
	border-radius: 5px;
	padding: 20px;
}
.quick-review-inner{
    margin:15px;
    display: flex;
    align-items: center;
}
.quick-review-img img{
	max-width: 200px;
}

.design-heading{
    padding: 10px 5px;
    background: #00a0e3;
    color: #fff;
}
.bg-light-black{
    text-align: center;
    padding: 0 0;
    box-shadow: 0 5px 10px rgba(0,0,0,.1); 
//    border-radius: 0 10px 10px 0;
}
.topicLists li:nth-child(even){
    background: #f9f9f9;
}
.topicLists li:nth-child(odd){
    background: #fff;
}
.main-img {
    margin-bottom: 20px;
    width: auto;
    max-height: 600px;
    height: calc(100vh - 90px);
    text-align: center;
    position: relative;
    display: flex;
    align-items: center;
}
.main-img:hover .downloadBtn{
    display: block;
    transition: .3s ease;
}
.main-img img{
    width: auto;
    height: 100%;
    box-shadow: 0 5px 10px rgba(0,0,0,.1); 
}
.small-img {
//    margin-left: 12px;
//    display: flex;
    
}
.small-icons {
    width: 90px;
    height: 130px;
    cursor: pointer;
    margin: 5px auto;
    box-shadow: 0 5px 10px rgba(0,0,0,.1); 
}
.icon-active{
    width: 100%;
    height: 100%;
    position: absolute;
    top:0;
    left:0;
    background: rgba(0, 0, 0, .3);
}
.small-icons:hover{
    box-shadow: 0 5px 8px rgba(0, 0, 0, .1);
}
.small-icons img{
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.covid-heading {
    font-size: 16px;
    font-weight: 600;
    padding:10px 20px;
    background: #f9f9f9;
    position: sticky;
    top: 0;
}
.covid-heading span{
    float:right;
}
.covid-list {
	box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
	border-radius: 0px;
    height:calc(100vh - 90px); 
    position: relative;
}
.covid-list li {
	font-size: 16px;
	font-family: roboto;
	text-transform: capitalize;
	padding: 5px 20px;
	cursor: pointer;

}
.covid-list li span {
    float: right;
    margin-right: 10px;
}
.hideDiv{
    display: none;
}
.showDiv{
    display: block;
}
.e-background, .our-backg{
    background: none;
    min-height: auto;
}
.e-background h2{
    color: #333;
    font-family: lora;
    padding-top: 0px;
}
.e-inner{
    top: 0px;
}
.our-backg{
    margin-top: 30px;

}
.our-backg h1{    
    font-family: lora;
    text-align: center;
}
.our-backg h1:before{
    display: none;
}

.box-parent {
    background:#ff7803;
    border-radius: 8px;
    padding: 90px 50px;
    overflow:hidden;
    margin: 20px;
}
.jobs-content {
    text-align: left;
    border-left: 4px solid #fff;
    padding-left: 20px;
}
.j-count{
    font-size:40px;
    color:#fff;
    font-weight: 700;
    font-family: roboto;
}
.j-name{
    font-size:23px;
    color:#fff;
    font-weight: 300;
    font-family: roboto;
}
@media (max-width:768px){
    .box-parent{padding:20px 50px !important;}
    .jobs-content{margin-bottom:10px;}
}
.bolls{position:relative;}
.bol{
    position: absolute;
    width: 85px;
    height: 85px;
    background: #ff8821;
    border-radius: 50%;
}
.bol2{
    position: absolute;
    width: 125px;
    height: 125px;
    background: #ff8821;
    border-radius: 50%;
}
.boll1 {
    top: -100px;
    left: -56px;
}
.boll2 {
    left: 171px;
    top: 164px;
}
.boll3 {
    left: 371px;
    top: -25px;
}
.boll4 {
    right: 1px;
    top: 76px;
}
.boll5 {
    right: 195px;
    top: 18px;
}
.boll6 {
    right: -69px;
    bottom: 12px;
}
@media (max-width:415px){
.boll5 {
    right: 159px;
    top: 305px;
}
.boll6 {
    left: 205px;
    top: 415px;
}
}

.great-bg{
    padding-bottom: 20px;
}
.head-about{
    text-align:center;
}
.head-about h3 {
    font-weight: 700;
    font-family: roboto;
    font-size: 30px;
}
.about-box {
    padding: 20px 10px;
    margin: 15px 0px;
    height: 200px;
    text-align:center;
    background:#fff;
    transition: ease-out .5s;
    cursor: pointer;
}
.about-box:hover{
    box-shadow: 0px 0px 15px 2px #eee;
}
@media(max-width:768px){
    .about-box {
        height:230px;
    }
}
.bx-img {
    width: 50px;
    height: 55px;
    margin: 0 auto;
}
.about-box h4{
    margin: 0px 0px 5px;
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
}
.about-text {
    font-size: 15px;
    font-family: roboto;
}
.great-red{
    text-align: center;
    position: relative;
    max-width: 175px;
    margin: 0 auto;
    margin-top: 15px;
    margin-bottom: 10px;
}
.great-red a{
    background:#00a0e3;
    color:#fff;
    font-size: 16px;
    border-radius: 4px;
    transition: 0.6s;
    overflow: hidden;
    padding: 10px 22px;
}
.great-red a:before {
  content: "";
  display: block;
  position: absolute;
  background: rgba(255, 255, 255, 0.5);
  width: 60px;
  height: 100%;
  left: 0;
  top: 0;
  opacity: 0.5;
  filter: blur(30px);
  transform: translateX(-100px) skewX(-15deg);
}
.great-red a:after {
  content: "";
  display: block;
  position: absolute;
  background: rgba(255, 255, 255, 0.2);
  width: 30px;
  height: 100%;
  left: 30px;
  top: 0;
  opacity: 0;
  filter: blur(5px);
  transform: translateX(-100px) skewX(-15deg);
}
.great-red a:hover {
  background: #00a0e3;
  cursor: pointer;
}
.great-red a:hover:before {
  transform: translateX(150px) skewX(-15deg);
  opacity: 0.6;
  transition: 0.5s;
}
.great-red a:hover:after {
  transform: translateX(150px) skewX(-15deg);
  opacity: 1;
  transition: 0.5s;
}
.great-red a:focus {
  outline: 0;
}
.tab-content{
    padding: 15px 25px;
}
');
$script = <<<JS
    var ps = new PerfectScrollbar('#safetyList');

$('.sharing-box div .share-elem-main').each(function() {
    var href = $(this).attr('href');
    var page_url = window.location.href;
    $(this).attr('href', href + page_url);
});

JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    let smallIcons = document.getElementsByClassName('small-icons');

    function initializeImgClick() {
        for (let i = 0; i < smallIcons.length; i++) {
            smallIcons[i].addEventListener('click', function () {
                //fetching small image src
                let smallImg = event.currentTarget;
                let Simg = smallImg.getElementsByTagName('img');
                let imgPath = Simg[0].getAttribute('src');

                //fatching and changing main image src
                let smallicons = smallImg.parentElement;
                let mainImgParent = smallicons.parentElement.nextElementSibling;
                let mainImg = mainImgParent.querySelector('.mainImg');
                let mainImgSrc = mainImg.getAttribute('src');
                mainImgSrc = "";
                mainImg.setAttribute('src', imgPath);
            })
        }
    }

    initializeImgClick();

    let infoTopcis = document.getElementsByClassName('liClick');
    for (let i = 0; i < infoTopcis.length; i++) {
        infoTopcis[i].addEventListener('click', function () {
            let clickedLi = event.currentTarget;
            let dImages = clickedLi.getElementsByClassName('data-img');
            let fElem = dImages[0].getAttribute('data-img')

            document.getElementById('bigPoster').setAttribute('src', fElem);

            //add and remove active class from li
            let activeli = document.getElementsByClassName('activeLi');
            if (activeli.length > 0) {
                activeli[0].classList.remove('activeLi')
            }
            clickedLi.classList.add('activeLi');
            let clickCate = clickedLi.getAttribute('id')

            //show hide images div on click
            let posterThumb = document.getElementById('posterThumb');
            posterThumb.innerHTML = "";
            for (let i = 0; i < dImages.length; i++) {
                let z = dImages[i].getAttribute('data-img');
                var div = document.createElement('div');
                div.setAttribute('class', 'small-icons');
                div.innerHTML = '<img src="' + z + '">';
                posterThumb.appendChild(div);
            }
            initializeImgClick();
        })
    }


</script>
