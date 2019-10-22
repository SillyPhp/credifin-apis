<?php
$column = 'col-md-2 col-sm-3 col-xs-6';
if (isset($size)) {
    $column = $size;
}
?>
    <div class="loading-main">
        <div class="row">
            <?php
            for ($i = 0; $i < 6; $i++) {
                ?>
                <div class="<?= $column ?> loader-padding">
                    <div class="company-info">
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
.loader-padding{
    margin-bottom:20px;
}
.loading-main .company-info .loader{
    height:136px;
    width: 160px;
    margin:0 auto;
    box-shadow: 0 2px 5px 0 rgba(32,32,32,.1);
}
')
?>