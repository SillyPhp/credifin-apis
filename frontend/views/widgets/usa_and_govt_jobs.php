<?php
use yii\helpers\Url;
?>
<section class="goven-jobs-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gov-heading">Find Latest Government Jobs</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="gov-job">
                    <a href="/usa-jobs">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/usa-govt.png')?>" alt="USA Jobs">
                        <div class="link-none">
                            USA Government Jobs
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="gov-job">
                    <a href="/govt-jobs">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/indian-govt.png')?>" alt="USA Jobs">
                        <div class="link-none">
                            Indian Government Jobs
                        </div>
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
.gov-job {
  overflow: hidden;
  margin: 10px;
  max-width: 500px;
  height: 300px;
  width: 100%;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
}
.gov-job img {
    max-width: inherit;
    height: 100%;
    position: absolute;
    right: 0;
    -webkit-transition: all 2s ease-out;
    transition: all 2s ease-out;
}
.gov-job:hover img {
  -webkit-transform: translateX(100px);
  transform: translateX(100px);
}
.gov-job{
    text-align:center;
    position:relative;
}
.gov-job, .gov-job img{
    border-radius: 10px;
}
.gov-job a:hover .link-none{
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
');