<?php
use yii\helpers\Url;
?>
<section class="us-background">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-7 col-xs-offset-5 text-center">
                <h2>Find your Desired US Government Job</h2>
                <div class="post-bttn">
                    <a href="/usa-jobs" class="hvr-float-shadow">Apply</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.us-background{
    background:url(' . Url::to('@eyAssets/images/pages/jobs/usa-jobs-section.png') . ');
    padding:130px 0px;
    margin:50px 0px;
    background-repeat:no-repeat;
    background-position:center;
}
.post-bttn a {
    display:block;
    background: #00a0e3;
    color: #fff;
    border-radius: 5px;
    text-transform: uppercase;
    padding: 10px 20px;
    font-size: 18px;
    box-shadow: 0 0 10px rgba(66, 63, 63, .5);
    -webkit-transition: .3s all;
    transition: .3s all;
    text-align: center;
    margin: 0 auto;
    max-width: 225px;
    font-weight: 400;
    font-family: Roboto;
}
@media only screen and (max-width: 1600px) {
    .us-background{
        background-size: 100% auto;
    }
}
@media only screen and (max-width: 575px) {
    .us-background{
        background-position: top;
    }
    .us-background .container .row .col-xs-7.col-xs-offset-5{
        width:100%;
        margin-left: 0;
    }
}
');