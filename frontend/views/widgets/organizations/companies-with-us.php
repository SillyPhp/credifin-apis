<?php

use common\models\Organizations;
use yii\helpers\Url;
use yii\db\Expression;

$controller_name = Yii::$app->controller->id;
$action_name = Yii::$app->controller->action->id;
switch ([$controller_name, $action_name]) {
    case ['colleges', ''] :
    case ['colleges', 'index'] :
        $field = 'is_erexx_registered';
        break;
    default :
        $field = 'is_featured';
}
$companies = Organizations::find()
    ->where(['not', ['logo' => null]])
    ->andWhere(['not', ['logo' => ""]])
    ->andWhere(['status' => 'Active', 'is_deleted' => 0, $field => 1])
    ->orderby(new Expression('rand()'))
    ->limit(12)
    ->all();
?>
    <section class="companies">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="com-grid">
                        <h1 class="heading-style">Featured Companies</h1>
                        <div class="ac-subheading">Companies recruiting top talent from our portal.</div>
                        <div class="all-coms"><a href="/organizations">View All Companies</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($companies as $c) {
                    ?>
                    <div class="col-md-2 col-sm-4">
                        <a href="/<?= $c->slug ?>" title="<?= $c->name ?>">
                            <div class="cmp-main">
                                <div class="cmp-log">
                                    <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->logo . $c->logo_location . '/' . $c->logo) ?>"
                                         alt="" title="<?= $c->name ?>"/>
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
.companies {
    background-color: #f5f5f5;
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
    height: 147px !important;
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