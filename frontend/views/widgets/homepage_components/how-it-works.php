<?php
use yii\helpers\Url;
?>
<section class="how-it-works">
    <div class="container">
        <div class="hiw-heading">Take your career to the next level. <p>Join Empower Youth Today.</p></div>
        <div class="row ">
            <div class="col-md-3">
                <div class="fade-in one">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/create-profile.png') ?>"
                             title="Create your Exclusive Profile" alt="Create your Exclusive Profile"/>
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Create your Exclusive Profile</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in two">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/discover.png') ?>"
                             title="Get discovered by top employers" alt="Get discovered by top employers"/>
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading"> Get discovered by top employers</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in three">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/evaluate.png') ?>"
                             title="Evaluate Offer"
                             alt="Evaluate Offer"/>
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Evaluate Offer</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="fade-in four">
                    <div class="how-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/recive.png') ?>"
                             title="Receive Custom Job Notifications" alt="Receive Custom Job Notifications">
                    </div>
                    <div class="how-text-box">
                        <div class="how-heading">Receive Custom Job Notifications</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="signupbttns">
                <a href="/login" class="login-bttn" title="Login">Login</a>
                <a href="/signup/individual" class="sign-up" title="Sign Up">Sign Up</a>
            </div>
        </div>
    </div>
</section>
