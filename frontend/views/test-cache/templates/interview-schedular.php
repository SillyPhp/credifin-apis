<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
$this->registerCss('
    body{
        margin:0 auto;
        padding:0;
        font-family: "Open Sans", sans-serif;
    }
    .wrapper-outer{
        max-width:600px	;
        margin:0 auto;
        background: #56698F;
        padding:30px 50px;
        display: flex;
    }
    .wrapper{
        background: #fff;
        float: left;
        border-radius: 10px;
    }
    .responsive{
        width:100%;
    }
    img + div {
        display:none;
    }
    .jboxs{
        margin:0 auto;
        padding:0 25px;
        float:left;
    }
    .wrapper-header{
        background:url(' . Url::to('@commonAssets/email_service/header-bg.png', 'https') . ');
        background-size:100%;
        background-repeat:no-repeat;
        padding:30px 0;
        text-align:center;
        float: left;
        width: 100%;
        border-radius:9px;
    }
    .header-logo{
        text-align:center;
    }
    .header-logo img{
        max-width:200px;
    }
    .header-icon{
        padding:50px 0;
    }
    .header-icon img{
        max-width:300px;
    }
    .text-center{
        float:left;
        text-align:center;
        padding:20px 0;
        width:100%;
    }
    .ey-team{
        padding:20px 0 0 0;
    }
    .ey-team img{
        max-width:220px;
    }
    .copyright{
        padding:0px 0 0 0;
        font-size:13px;
    }
    .last-list{
        padding: 0px 0 10px 0;
        font-size: 13px;
    }
    .last-list ul{
        padding-inline-start: 10px;
    }
    .last-list ul li{
        list-style-type:none;
        display:inline;
        padding:15px 5px;
    }
    .date-main{
        border:1px solid #ddd;
        width: 140px;
        margin: auto;
        text-align: center;
        border-radius: 6px;
        overflow: hidden;
    }
    .month-detail{
        width: 100%;
        padding: 7px 0px;
        background-color: #00a0e3;
        color: #fff;
        font-size: 20px;
        font-weight: 500;
    }
    .day-detail{
        height: 100px;
        line-height: 100px;
        font-size: 75px;
        font-weight: 700;
    }
    .last-list ul li a{
        color:#00a0e3;
        text-decoration:none;
    }
    .title{
        text-align: center;
    }
    .title h2{
        font-weight: 400;
    }
    .title h2 span{
        font-weight: 700;
    }
    .clear{
        clear: both;
        margin-bottom: 10px;
    }
    .head-main{
        width: 32%;
        padding-right: 15px;
        float: left;
        text-align: right;
    }
    .desc-main{
        width: 64%;
        display: inline-block;
    }
    .link{
        border-radius: 50px;
        color: #fff;
        margin: 0px 5px;
        padding: 10px 25px;
        display: inline-block;
    }
    .primary{
        background-color: #00a0e3;
    }
    .danger{
        background-color: #d62424;
    }
    .capitalize {
      text-transform: capitalize;
    }
', ['media' => 'screen']);
$this->registerCss('
@media only screen and (max-width:500px ){
    .wrapper-outer{
        padding:20px 10px;
    }
    .head-main{
        width: 30%;
        padding-right: 10px;
    }
    .last-list ul{
        margin:0px;
        padding:0px;
    }
}
', ['media' => 'only screen and (max-device-width: 500px)']);
?>
<div class="wrapper-outer">
    <div class="wrapper">
        <div class="wrapper-header">
            <div class="header-logo"><img src="<?= Url::to('@commonAssets/email_service/email-logo.png', 'https'); ?>" class="responsive"></div>
            <div class="header-icon"><img src="<?= Url::to('@commonAssets/email_service/header-icon.png', 'https'); ?>" class="responsive"></div>
        </div>
        <div class="jboxs">
            <div class="date-main">
<!--                <div class="month-detail">-->
<!--                    January-->
<!--                </div>-->
<!--                <div class="day-detail">-->
<!--                    5-->
<!--                </div>-->
            </div>
            <div class="title">
                <h2>Your Interview has been Scheduled for job <span>"<?= $data['data']['name']; ?>"</span></h2>
            </div>
            <div class="clear">
                <div class="head-main">
                    Job Title:
                </div>
                <div class="desc-main capitalize">
                    <?= $data['data']['name']; ?>
                </div>
            </div>
<!--            <div class="clear">-->
<!--                <div class="head-main">-->
<!--                    Salary:-->
<!--                </div>-->
<!--                <div class="desc-main">-->
<!--                    3,00,000 p.a.-->
<!--                </div>-->
<!--            </div>-->
            <div class="clear">
                <div class="head-main">
                    when:
                </div>
                <div class="desc-main">
                    <?php
                    foreach ($data['timing'] as $time => $val){
                        $slabs = ArrayHelper::map($val, 'from', 'to');
                        $t = "";
                        foreach ($slabs as $key => $sval){
                            $t .= $key . ' to ' . $sval . ',';
                        }

                        echo $time . ' :- ' . rtrim($t, ',') . '<br/>';
                    }
                    ?>
                </div>
            </div>
            <div class="clear text-center">
                <a class="link primary" href="<?= Url::to('/account/dashboard/calendar', 'https'); ?>">view</a>
            </div>
        </div>

        <div class="text-center">
            <div class="ey-team">
                <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', 'https'); ?>"/>
            </div>
            <div class="copyright">
                <div class="">Copyright © 2019 Empower Youth</div>
            </div>
            <div class="last-list">
                <ul>
                    <li><a href="">Contact Us</a></li> |
                    <li><a href="">Terms and Conditions</a></li> |
                    <li><a href="">Privacy Policies</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
