<?php
$column = 'col-md-3 col-sm-6';
if (isset($size)) {
    $column = $size;
}
?>

    <div class="loading-main">
        <div class="row">
            <?php
            for ($i = 0; $i < 4; $i++) {
                ?>
                <div class="<?= $column; ?>">
                    <div class="whats-new-box">
                        <div class="wn-box-icon">
                            <div class="loader anim"></div>
                        </div>
                        <div class="wn-box-details">
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

    </div>


<?php
$this->registerCss('
.loading-main .whats-new-box .loader{
    margin: 0 auto;
}
.loading-main .whats-new-box:hover{
    box-shadow:none;
}
.loading-main .wn-box-icon .loader{
    width:100% !important;
    height:190px;
    border-radius:10px 10px 0 0 !important;
}
.loading-main .wn-box-details{
    height:50px !important;
}
.loading-main .wn-box-details .loader:nth-child(1){
    height:16px;
}
.loading-main .wn-box-details .loader{
    width:100%;
    margin-top:10px;
}
');
$script = <<<JS

JS;
$this->registerJs($script);
?>