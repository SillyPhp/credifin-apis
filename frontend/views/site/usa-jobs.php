<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = true;
?>

<Section class="bg-clr">
    <div class="container">
        <div class="row">
            <div class="job-head">Information Technology Specialists (IT Project Manager)</div>
            <div class="branch">Branch</div>
            <div class="office">office</div>
        </div>
    </div>
</Section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="overview-box">
                    <div class="text-overview">Overview</div>
                    <div class="open-close-date"></div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.bg-clr{
    background-color:#eee;
    padding-bottom:20px;
}
.job-head{
    padding-bottom: 5px;
    font-size: 35px;
    font-weight: 900;
}
.branch, .office{
    font-size: 18px;
}
');