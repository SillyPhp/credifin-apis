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
                    <div class="city-main">
                        <div class="city-image">
                            <div class="loader anim"></div>
                        </div>
                        <div class="city-name"><div class="loader anim"></div></div>
                        <div class="divider"></div>
                        <div class="city-data">
                            <div class="openings">
                                <div class="loader anim"></div>
                            </div>
                            <div class="count">
                                <div class="loader anim"></div> <div class="loader anim"></div>
                            </div>
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
.city-main .loader{
    margin: 0 auto;
}
.city-image .loader{
    width:100% !important;
    height:100px;
    border-radius:10px 10px 0 0 !important;
}
.city-name .loader{
    height:16px;
}
.loading-main .city-data .count > .loader{
    width:50px;
    display:inline-block;
}
');
?>