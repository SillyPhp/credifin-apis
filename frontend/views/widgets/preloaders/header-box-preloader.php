
<div class="loading-main">

    <div class="row">
        <?php
        for ($i = 0; $i < 4; $i++) {
            ?>
            <div class="<?= $column ?>">
                <div class="box-border fade-in one">
                    <div class="pre-loader-icon">
                        <div class="loader anim"></div>
                    </div>
                    <div class="h-heading"><div class="loader anim"></div></div>
                    <div class="h-text"><div class="loader anim"></div></div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</div>

<?php
$this->registerCss('
.box-border{
    background: #fff;
    border:1px solid rgba(234,238,238,.8);
    padding: 20px 30px;
    text-align: center;
    box-shadow: 0 0 5px rgba(0,0,0,.1); 
    margin-bottom: 20px; 
    position:relative;
    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
} 
.pre-loader-icon {
    border-radius:50%
    height: 100px;
    width: 100px;
}
.h-heading {
    font-weight: 500;
    font-family: Roboto;
    color: #000;
    padding-top: 15px;
    font-size: 16px;
}
.h-text {
    font-family: Roboto;
    font-weight: 300;
}
')
?>