<?php
$column = 'col-md-6';
if (isset($size)) {
    $column = $size;
}
?>
<div class="container">
    <div class="row">
        <?php
            for($i = 0; $i < 2; $i++) {
                ?>
                <div class="<?= $column ?>">
                    <div class="gov-job">
                        <div class="loader anim"></div>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<?php
$this->registerCss('
.gov-job {
    border-radius: 10px;
}
.gov-job .loader {
    height: 100%;
    width: 100%;
}
');
?>
