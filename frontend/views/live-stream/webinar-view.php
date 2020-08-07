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

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>The Live Will Start Soon</p>
                </div>
            </div>

        </div>
    </div>
<?php
$this->registerCss('
.modal-header{border:none;padding:10px;}
.modal-body{text-align:center;}
.modal-body p{
    font-size: 20px;
    font-family: roboto;
}
div#webinar-status {
    text-align: center;
}
');