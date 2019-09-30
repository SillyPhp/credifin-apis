<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<?php if (!empty($categories)) { ?>
    <section>
        <div class="container">
            <div class="row col-md-12">
                <div class="heading-style col-md-6 col-sm-6">All Categories</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate">
                        <?php foreach ($categories as $c) { ?>
                            <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                                <a href="/learning/videos/category/<?= $c['slug']; ?>">
                                    <div class="newset">
                                        <div class="imag">
                                            <img src="<?= $c['icon'] ?>">
                                        </div>
                                        <div class="txt"><?= $c['name']?></div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section id="not-found" class="text-center">
        <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
    </section>
<?php } ?>

<?php
$this->registerCss('
.popular-cate{
    text-align:center;
}
.newset{
    text-align:center;
    max-width: 160px;
    min-height: 245px;  
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
.imag{
    text-align: right;
}
.txt {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: -4px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
');