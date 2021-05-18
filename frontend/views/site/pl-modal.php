<?php
?>

<div class="p100">
    <a href="javascript:;" data-toggle="modal" data-target="#plModal">
       Preference Modal
    </a>
    <br>
    <br>
    <a href="javascript:;" data-toggle="modal" data-target="#completeProfileModal">
        Complete Profile Modal
    </a>
</div>
<?= $this->render('/widgets/preference-and-location-modal') ?>
<?= $this->render('@common/widgets/complete-profile-modal') ?>
<?php
$this->registerCSS('
    .p100{
        padding-top: 100px;
    }
    
');
$script = <<<JS
    $('#plModal').modal('show');
JS;
$this->registerJS($script);