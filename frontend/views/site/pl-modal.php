<?php
?>

<div class="p100">
    <a href="javascript:;" data-toggle="modal" data-target="#plModal">
        Log In
    </a>
</div>
<?= $this->render('/widgets/preference-and-location-modal') ?>
<?php
$this->registerCSS('
    .p100{
        padding-top: 100px;
    }
');