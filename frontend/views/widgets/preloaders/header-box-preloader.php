<?php
$column = 'col-md-3 col-sm-6 col-xs-6';
if (isset($size)) {
    $column = $size;
}
?>
    <div class="loading-main">
        <div class="perloader-header-row">
            <div class="container">
                <div class="preloader-header-boxs">
                    <div class="row">
                        <?php
                        for ($i = 0; $i < 4; $i++) {
                            ?>
                            <div class="<?= $column ?>">
                                <div class="box-border fade-in one">
                                    <div class="pre-loader-icon">
                                        <div class="loader anim"></div>
                                    </div>
                                    <div class="preloader-h-heading">
                                        <div class="loader anim"></div>
                                    </div>
                                    <div class="preloader-h-text">
                                        <div class="loader anim"></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.preloader-header-boxs {
    max-width: 850px;
    margin: 0 auto;
    display: flex;
    justify-content: center;
}
.preloader-header-row {
    margin-top: -90px;
    padding: 0 0 20px 0;
    position: relative;
    z-index: 9;
}
.box-border{
    border:1px solid rgba(234,238,238,.8);
    padding: 20px 30px;
    box-shadow: 0 0 5px rgba(0,0,0,.1); 
    margin-bottom: 20px; 
    position:relative;
} 

.pre-loader-icon > div {
    margin: 0 auto;
    border-radius:50%;
    height: 100px;
    width: 100px;
}
.preloader-h-heading {
    padding-top: 25px;
 
}
.preloader-h-text {
    padding-top: 15px;
}
')
?>