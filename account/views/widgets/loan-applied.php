<?php

use yii\helpers\Url;

?>

    <div class="col-md-12">
        <div class="loan-app-main">
            <div class="loan-mail-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/loan-complete.png') ?>">
            </div>
            <div class="loan-text-data">
                <div class="upper-loan">
                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/party.png') ?>">
                    <h3>Congratulations</h3>
                    <p>Your previous loan has been completed.</p>
                </div>
                <div class="bottom-loan">
                    <p>APPLY LOAN FOR NEXT SEMESTER</p>
                    <a href="">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.loan-app-main {
    background: linear-gradient(99.55deg, #36A8C0 -25.33%, #81C72E 122.85%);
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 30px;
    padding: 30px 10px;
}
.loan-mail-logo {
    flex-basis: 35%;
}
.loan-mail-logo img {
    width: 100%;
}
.loan-text-data {
    flex-basis: 65%;
    margin-left: 50px;
}
.upper-loan img {
    width: 70px;
}
.upper-loan h3 {
    margin: 0 0 5px;
    font-family: lora;
    font-weight: bold;
    font-size:30px;
}
.upper-loan p {
    font-family: roboto;
    font-size: 18px;
    font-weight: 500;
}
.bottom-loan p {
    margin: 15px 0 5px !important;
    font-family: roboto;
    color: #fff;
    font-size: 18px;
}
.bottom-loan a {
    background-color: #ff7803;
    color: #fff;
    padding: 6px 25px;
    display: inline-block;
    border-radius: 2px;
    font-family: roboto;
    font-weight: 500;
    font-size: 18px;
}
@media screen and (max-width: 768px) {
    .loan-app-main{
        flex-direction: column;
        text-align: center;
    }
    .loan-mail-logo{
        order: 2;
        margin-top: 20px;
    }
    .loan-mail-logo img{
        max-width: 200px;
    }
    .loan-text-data{
        margin-left: 0px; 
    }
}
');