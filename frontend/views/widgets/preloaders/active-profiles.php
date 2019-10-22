<?php
$column = 'col-md-3 col-sm-6 col-xs-6';
if (isset($size)) {
    $column = $size;
}
?>
    <div class="loading-main">
        <?php
        for ($j = 0; $j < 2; $j++) {
            ?>
            <div class="row">
                <?php
                for ($i = 0; $i < 4; $i++) {
                    ?>
                    <div class="<?= $column ?> loader-padding">
                        <div class="grids">
                            <div class="loader anim"></div>
                        </div>
                        <h4 class="name">
                            <div class="loader anim"></div>
                        </h4>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
<?php
$this->registerCss('
.loader-padding{
    margin-bottom:20px;
}
.loading-main .grids .loader{
    height:100%;
    width: 100%;
    border-radius:50%;
}
.loading-main .grids::after{
    border:none !important;
}
.loading-main .name .loader{
    margin:0 auto;
}
')
?>