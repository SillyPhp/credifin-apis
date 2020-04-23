<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="job-single-head style2 overlay-top bp-box">
            <div class="bp-box-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/custom/best-platform-icon.png') ?>" alt="">
            </div>
            <div class="bp-box-text">
                You're about 10 seconds away from joining the best career platform
            </div>
            <div class="bp-box-btn">
                <a href="<?= url::to('/signup/individual')?>">Sign Up</a>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.bp-box{
    margin-top:40px !important;
    padding-bottom: 30px !important;
    padding-top: 30px !important;
    background: #ea842a;
}
.bp-box-text{
    padding:30px 20px;
    color:#fff;
    font-size:18px;
    line-height: 25px;
    text-transform:capitalize;
    font-family:roboto;
//    font-weight:bold;
}
.bp-box-btn a{
   padding:7px 16px;
    background:linear-gradient(45deg, #000, #000, #fff);
    color: #fff;
    font-size: 13px;
    border-radius:5px;
}
.bp-box-btn a:hover{
    background:linear-gradient(45deg, #fff, #000, #000 );
}

')
?>
