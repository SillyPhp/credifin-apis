<?php
$this->params['header_dark'] = True;

use yii\helpers\Url;

?>

    <div class="head-img"></div>

    <section>
        <div class="container">
            <div class="row">
                <div class="department">
                    <div class="depart-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/blog/articles.png'); ?>" class="img_load">
                    </div>
                    <div class="depart-name">sbi</div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Jobs</div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="blogbox"></div>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/mustache/application-card');
$this->registerCss('
.head-img{
    background: url(\'/assets/themes/ey/images/pages/blog/articles.png\');
    background-repeat: repeat;
    background-size: auto;
    min-height: 200px;
    background-size: cover;
    background-repeat: no-repeat;
}
.department {
    margin-top: -75px;
    display:flex;
}
.depart-logo {
    display: inline-block;
    width: 104px;
    height: 104px;
    border:2px solid #eee;
    text-align: center;
}
.depart-logo img {
    height: 100px;
    width: 100px;
}
.depart-name {
    display: inline-block;
    font-size: 25px;
    font-family: roboto;
    font-weight: 700;
    margin: 55px 0px 0px 10px;
    text-transform: uppercase;
}
');