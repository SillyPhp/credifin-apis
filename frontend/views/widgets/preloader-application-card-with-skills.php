<?php
$column = 'col-md-4';
if(isset($size)){
    $column = $size;
}
?>

<div class="loader-main">
    <?php
    for ($i = 0; $i < 3; $i++) {
        ?>
        <div class="row">
            <?php
            for ($j = 0; $j < 3; $j++) {
                ?>
                <div class="<?= $column ?>">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load">
                                    <div class="loader anim"></div>
                                </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5">
                                <a href="#" class="icon set_logo">
                                    <div class="loader anim"></div>
                                </a>
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title">
                                    <div class="loader anim"></div>
                                </h4>
                                <h5>
                                    <i class="locations">
                                        <div class="loader anim"></div>
                                    </i>
                                </h5>
                                <h5>
                                    <i class="periods">
                                        <div class="loader anim"></div>
                                    </i>
                                </h5>
                                <h5>
                                    <i class="periods">
                                        <div class="loader anim"></div>
                                    </i>
                                </h5>
                            </div>
                        </div>
                        <hr class="hr">
                        <h4 class="pull-right pt-10 custom_set">
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                        </h4>
                    </div>
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
.custom_set .anim{
    width:100px;
    height:30px;
    display: inline-block;
    margin: 0px 5px;
}
.custom_set .anim:nth-child(2){
    width:70px;
}
.custom_set .anim:nth-child(3){
    width:85px;
}
.loader-main .product.iconbox-border.iconbox-theme-colored{
    border-radius:10px;
}
');