<?php

use common\models\Organizations;
use yii\helpers\Url;
use yii\db\Expression;

$controller_name = Yii::$app->controller->id;
$action_name = Yii::$app->controller->action->id;
switch ([$controller_name, $action_name]) {
    case ['colleges', ''] :
    case ['colleges', 'index'] :
        $val = '1';
        break;
    default :
        $val = '0';
}
$companies = Organizations::find()
    ->alias('z')
    ->joinWith(['businessActivityEnc a'], false)
    ->joinWith(['organizationLabels ol' => function ($x) {
        $x->onCondition(['ol.label_for' => 0, 'ol.is_deleted' => 0]);
        $x->joinWith(['labelEnc le' => function ($l) {
            $l->onCondition(['le.is_deleted' => 0]);
        }], false);
    }], false)
    ->andWhere(['not', ['z.logo' => null]])
    ->andWhere(['not', ['z.logo' => ""]]);
if ($val == 1) {
    $companies->andWhere(['z.is_erexx_registered' => $val]);
}
$companies->andWhere(['z.status' => 'Active', 'z.is_deleted' => 0])
    ->andWhere(['le.name' => 'Featured'])
    ->andWhere(['not', ['in', 'a.business_activity', ['College', 'Educational Institute', 'School']]])
    ->orderby(new Expression('rand()'))
    ->limit(12);
$companies = $companies->all();
?>
    <section class="companies">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="com-grid">
                        <h2 class="heading-style">Featured Companies</h2>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="type-1">
                        <div>
                            <a href="<?= Url::to('/organizations'); ?>" class="btn btn-3">
                                <span class="txting"><?= Yii::t('frontend', 'View all'); ?></span>
                                <span class="round"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($companies as $c) {
                    ?>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <a href="/<?= $c->slug ?>" title="<?= $c->name ?>">
                            <div class="cmp-main">
                                <div class="cmp-log">
                                    <img class="load-later" data-src="<?= Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $c->logo_location . '/' . $c->logo) ?>"
                                         src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="<?= $c->name ?>" title="<?= $c->name ?>"/>
                                </div>
                                <div class="cmp-name"><?= $c->name ?></div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.footer{
    margin-top: 0px !important;
}
.companies {
    background-color: #f5f5f5;
    padding: 20px 0 30px;
}
.ac-subheading{
    margin-top:-15px;
    font-family:Roboto;
    font-weight:400;
}
.all-coms a{
    color:#00a0e3;
}
.all-coms{
    font-family: roboto;
}
.all-coms a:hover{
    font-weight:500;
    font-family: roboto;
    margin-left:10px;
    transition:.3s ease;
}
.com-grid {
    margin-bottom: 20px;
}
.cmp-main {
    border: 2px solid transparent;
    text-align: center;
    padding: 10px 5px;
    margin-bottom: 20px;
    background-color:#fff;
    border-radius: 5px;
    height: 140px !important;
    cursor: pointer;
    transition: all 0.3s;
}
.cmp-main:hover{
    box-shadow:0 0 15px 10px #eee; 
}
.cmp-log {
    width: 65px;
    margin: auto;
    height: 65px;
    line-height: 61px;
    transition: all 0.3s;
}
.cmp-main:hover .cmp-log{
    transform:scale(1.05);
}
.cmp-name {
    font-size: 15px;
    font-family: roboto;
    line-height: 22px;
    padding:5px;
    font-weight: 500;
    display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
');
$script = <<<JS
$('.load-later').Lazy();
JS;
$this->registerJs($script);