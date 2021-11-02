<?php
use yii\helpers\Url;
?>
<section class="goven-jobs-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gov-heading">Competitions</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="evAndRedbull">
                    <a href="/site/edupreneur-page">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/ev.png')?>" alt="USA Jobs">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="evAndRedbull">
                    <a href="/site/redbull-basement">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/redbull.png')?>" alt="USA Jobs">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.goven-jobs-sec{
    background:url('. Url::to('@eyAssets/images/pages/index2/gov-job-sec-bg.png') .');
    background-repeat: no-repeat;
    background-size:cover;
    padding:0px 0px 40px 0px;
}
.gov-heading {
    text-align: center;
    font-size: 30px;
    font-family: lora;
    margin: 0px 0px 20px 0;
}
.evAndRedbull {
  overflow: hidden;
  margin-bottom: 15px !important;
  max-width: 500px;
  height: 385px;
  width: 100%;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
  margin:auto;
}
.evAndRedbull img {
    max-width: inherit;
    height: 100%;
    position: absolute;
    right: 0;
    -webkit-transition: all 2s ease-out;
    transition: all 2s ease-out;
}
.evAndRedbull{
    text-align:center;
    position:relative;
}
.evAndRedbull, .evAndRedbull img{
    border-radius: 10px;
}
.evAndRedbull a:hover .link-none{
    background: rgba(0,0,0,.3);
    transition:.3s ease;
    border-radius:5px;
}
.link-none{
    position:absolute;
    top:20px;
    left:20px;
}
.link-none{
    color:#fff;
    font-size:20px;
    padding:5px 10px;
}
@media (max-width:415px){
.gov-heading{
    font-size:25px;
}
.evAndRedbull{
    margin:0;
    margin-bottom:10px;
}
}
');