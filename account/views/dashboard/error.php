<?php
use yii\helpers\Html;

$this->title = $name;
?>
<div class="page-content-container">
    <div class="page-content-row-main">
        <div class="page-content-cols">
            <div class="row">
                <div class="col-md-12 page-500 text-center">
                    <div class=" number font-red"><?= $exception->statusCode ?></div>
                    <div class=" details">
                        <h3><?= Html::encode($this->title); ?></h3>
                        <p> <?= nl2br(Html::encode($message)); ?>
                            <br></p>
                        <p>
                            <a href="/account/dashboard" class="btn red btn-outline"> Return to Dashboard </a>
                            <br></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.page-content-row-main {
    width: 100%;
    height: 60vh;
    position: relative;
}
.page-content-cols{
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.page-500 .number {
    display: inline-block;
    color: #ec8c8c;
    text-align: right;
}
.page-404 .number, .page-500 .number {
    letter-spacing: -10px;
    line-height: 128px;
    font-size: 128px;
    font-weight: 300;
}
.page-500 .details {
    text-align: left;
}
.page-404 .details, .page-500 .details {
    margin-left: 40px;
    display: inline-block;
}
');