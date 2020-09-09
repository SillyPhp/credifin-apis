<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
    <!-- Trigger the modal with a button -->
    <!--    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
    <div class="center-align" id="webinar-status">
        <h2><?= $webinar->title ?></h2>
        <h4><span class="text-danger">Start time</span> : <?= date('d/m/Y h:i A', strtotime($webinar->start_datetime)) ?></h4>
    </div>

<?php
$this->registerCss('
div#webinar-status {
    text-align: center;
    color: #fff;
    padding-top: 96px;
}
');