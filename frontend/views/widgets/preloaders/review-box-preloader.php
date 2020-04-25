<?php
$column = 'col-md-4';
if (isset($size)) {
    $column = $size;
}
?>
    <div class="loading-main">
        <div class="row">
            <?php
            for ($i = 0; $i < 3; $i++) {
                ?>
                <div class="<?= $column ?> loader-padding">
                    <div class="review-box">
                        <div class="review-logo">
                            <div class="loader anim"></div>
                        </div>
                        <div class="r-name">
                            <div class="loader anim"></div>
                        </div>
                        <div class="r-jobs">
                            <div class="loader anim"></div>
                        </div>
                        <div class="r-intern">
                            <div class="loader anim"></div>
                        </div>
                        <div class="set-rating">
                            <div class="loader anim"></div>
                        </div>
                        <div class="t-reviews">
                            <div class="loader anim"></div>
                        </div>
                        <div class="row">
                            <div class="cm-btns padd-0">
                                <div class="col-md-6  col-xs-6">
                                    <div class="color-blue">
                                        <div class="loader anim"></div>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xs-6">
                                    <div class="color-orange">
                                        <div class="loader anim"></div>
                                    </div>
                                </div>
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
.loader-padding{
    margin-bottom:20px;
}
.review-box{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
    text-align: center;
    padding: 20px 0 6px 0;
    border-radius: 10px;
}
.review-logo .loader{
    width: 100px;
    height: 100px;
    margin: 0 auto;
    border-radius: 10px;
}
.r-name {
    position: relative;
    min-height: 60px;
}
.r-name .loader {
    text-align: center;
    position: absolute;
    width: 65%;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    height:20px;
}
.r-jobs .loader{
    width: 30%;
    margin: 0 auto;
    margin-bottom: 8px;
    margin-top:10px;
    height:14px;
}
.r-intern .loader{
    width: 40%;
    margin: 0 auto;
    margin-bottom: 5px;
    margin-top:10px;
    height:14px;
}
.set-rating .loader{
    width: 50%;
    margin: 0 auto;
    margin-bottom: 3px;
    padding:15px;
}
.t-reviews .loader{ 
    width: 30%;
    margin: 0 auto;
    margin-bottom: 8px;
    height:15px;    
}
.color-blue .loader, .color-orange .loader{
    width:65%;
    margin:0 auto;
}
.cm-btns{
    margin-top:20px !important;
}
')
?>