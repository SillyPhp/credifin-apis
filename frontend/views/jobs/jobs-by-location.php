<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
    <section class="jl-header">
        <div class="container">

        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Jobs By Top Locations</div>
                </div>
                <div class="col-md-12">
                    <div class="top-loc">
                        <ul class="top-cities">
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/ludhiana.png') ?>">
                                        </div>
                                        <div class="city-name">Ludhiana</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/chandigarh.png') ?>">
                                        </div>
                                        <div class="city-name">Chandigarh</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/jalandhar.png') ?>">
                                        </div>
                                        <div class="city-name">Jalandhar</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/mohali.png') ?>">
                                        </div>
                                        <div class="city-name">Mohali</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/delhi.png') ?>">
                                        </div>
                                        <div class="city-name">Delhi</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/noida.png') ?>">
                                        </div>
                                        <div class="city-name">Noida</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/gurgaon.png') ?>">
                                        </div>
                                        <div class="city-name">Gurgaon</div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="tc-box">
                                    <a href="">
                                        <div class="city-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/bangalore.png') ?>">
                                        </div>
                                        <div class="city-name">Bangalore</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Browse Jobs by States</div>
                </div>
            </div>
            <?php if (!empty($jobs_by_location)) { ?>

                <div class="row">
                    <?php
                    $rows = ceil(count($jobs_by_location) / 4);
                    $next = 0;
                    for ($i = 0; $i < $rows; $i++) {
                        ?>
                        <div class="col-md-3">
                            <?php for ($j = 0; $j < $rows; $j++) { ?>
                                <div class="box-jobs">
                                    <div class="cheading"><?= $jobs_by_location[$next]['name'] ?></div>
                                    <ul class="j-list">
                                        <?php for ($k = 0; $k < count($jobs_by_location[$next]['cities']); $k++) { ?>
                                            <li><a href="<?= Url::to('/jobs/list?location='.$jobs_by_location[$next]['cities'][$k]['name']) ?>">Jobs
                                                    in <?= $jobs_by_location[$next]['cities'][$k]['name'] ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php
                            $next++;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            <?php } ?>
        </div>
    </section>
<?php
$this->registerCss('
.jl-header{
    background:
}
ul.top-cities li{
    display:inline-block ;
    padding:0 5px;
} 
.tc-box{
    border:1px solid #eee; 
    border-radius:5px;
    text-align:center;
    margin-bottom:10px;
}
.city-icon img{
    border-radius:5px 5px 0 0;
    width:125px;
}
.city-name{
    padding:5px 0;
    font-weight:bold;
}
.tc-box:hover{
    box-shadow:0 0 5px rgba(156, 156, 156, 0.5);
    transition:.2s ease;
}
.tc-box:hover .city-name{
    color:#00a0e3;
}
.minus-padd{
    margin-top:-30px;
}
.box-jobs ul li a:hover{
    color:#00a0e3;
    padding-left:5px;
    transition:.2s ease-in;
}
.box-jobs{
    padding-left:10px;
    margin-top:20px;
}
.cheading{
    font-size:15px;
    color:#00a0e3;
    font-weight:bold;
}
');
$script = <<<JS
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
