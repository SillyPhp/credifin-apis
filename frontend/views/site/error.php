<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
$this->params['header_dark'] = true;
?>
<section id="home" class="fullscreen bg-lightest">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 pull-right">
                <div class="error-code">
                    <?= $exception->statusCode ?>
                </div>
                <img src="<?= Url::to('@eyAssets/images/pages/error/error.png'); ?>"/>
            </div>
            <div class="col-md-6 col-sm-6 error-description">
                <h2>Oops,</h2>
                <h2>nothing here..</h2>
                <h5><?= nl2br(Html::encode($message)); ?></h5>
                <a href="/" class="cta">
                    <span>Back to Home</span>
                    <svg width="13px" height="10px" viewBox="0 0 13 10">
                        <path d="M1,5 L11,5"></path>
                        <polyline points="8 1 12 5 8 9"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.error-code{
    position: absolute;
    font-size: 10rem;
    font-family: "Varela Round", sans-serif;
    color: #ffffffe6;
    line-height: 14rem;
    font-weight: 700;
    left: 20%;
}
.error-description{
    padding-top:80px;
}
.error-description h2{
    font-size: 3.8rem;
    font-weight: 700;
    color: #222;
    margin-top: 0px;
    line-height: 4rem;
}
.error-description h5{
    font-size: 1.2rem;
}

a {
  text-decoration: none;
  color: inherit;
}

.cta {
    position: relative;
    margin: auto;
    display: inline-block;
    margin-top: 20px;
    color: #222;
    padding: 16px 22px;
    transition: all 0.2s ease;
}
.cta:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  border-radius: 28px;
  background: #00a0e3;
  width: 56px;
  height: 56px;
  transition: all 0.3s ease;
}
.cta span {
  position: relative;
  font-size: 16px;
  line-height: 18px;
  font-weight: 900;
  letter-spacing: 0.25em;
  text-transform: uppercase;
  vertical-align: middle;
}
.cta svg {
  position: relative;
  top: 0;
  margin-left: 10px;
  fill: none;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke: #111;
  stroke-width: 2;
  transform: translateX(-5px);
  transition: all 0.3s ease;
}
.cta:hover:before {
  width: 100%;
  background: #00a0e3;
}
.cta:hover span {color:#fff}
.cta:hover svg {
  transform: translateX(0);
  stroke: #fff;
}
.cta:active {
  transform: scale(0.96);
}
@media screen and (max-width: 1199px) {
    .error-code {
        font-size: 8.5rem;
        line-height: 12rem;
    }
}
@media screen and (max-width: 600px) {
    .error-code {
        font-size: 17rem;
        line-height: 21rem;
    }
}
@media screen and (max-width: 425px) {
    .error-code {
        font-size: 15rem;
        line-height: 20rem;
    }
}
@media screen and (max-width: 390px) {
    .error-code {
        font-size: 13rem;
        line-height: 17rem;
    }
}
@media screen and (max-width: 390px) {
    .error-code {
        font-size: 12rem;
        line-height: 16rem;
    }
}
');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Varela+Round&display=swap');