<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<section>
    <div class="header-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="h-inner">
                        <div class="logo-absolute">
                            <div class="logo-box">
                                <div class="logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/review/dummy-logo.png') ?>">
                                </div>
                            </div>
                           <div class="com-details">
                                <div class="com-name">Company Name</div>
                                <div class="com-establish">Established in 2010</div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$this->registerCss('
.header-bg{
    background:url(' . Url::to('@eyAssets/images/backgrounds/default_cover.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
}
.h-inner{
    position:relative;
    min-height:300px;
    display: -webkit-box;
}
.logo-absolute{
    position:absolute;
    bottom:-60px;
    display:inherit;
}
.logo-box{
    height:200px;
    width:220px;
    padding:0 10px;
    background:#fff;
    display:table; 
    text-align:center;
    border-radius:2px;
    box-shadow:0 0 10px rgba(0,0,0,.5);
    position:relative;
} 
.logo{
    display:table-cell;
    vertical-align: middle;     
}
.com-name{
    font-size:40px;
    font-family:lobster;
    color:#fff;
    padding: 0 0 0 30px; 
}
.com-establish{
    color:#fff;
    padding: 0 0 0 30px; 
    font-size:15px;
}
');
$script = <<<JS

JS;
$this->registerJs($script);
