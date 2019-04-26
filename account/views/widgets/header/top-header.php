<?php

use yii\widgets\Menu;
use yii\helpers\Url;

$services = Yii::$app->user->identity->services;
$result = [];

foreach ($services['menu_items'] as $service) {
    $new = [
        'label' => '<i class="' . $service['icon'] . '"></i>' . Yii::t('account', $service['name']),
        'url' => Url::toRoute($service['link']),
    ];
    array_push($result, $new);
}
if (!empty(Yii::$app->user->identity->organization)) {
    $template = [
        'label' => '<i class=""></i>' . Yii::t('account', 'Templates'),
        'url' => Url::toRoute('/templates'),
    ];
    array_push($result, $template);
}
$profile = [
    'label' => '<i class=""></i>' . Yii::t('account', 'My Profile'),
    'url' => Url::to((!empty(Yii::$app->user->identity->organization)) ? '/' . Yii::$app->user->identity->organization->slug : '/' . Yii::$app->user->identity->username),
    'template' => '<a href="{url}" target="_blank">{label}</a>',
];
array_push($result, $profile);

$learning = [
    'label' => '<i class=""></i>' . Yii::t('account', 'Learning'),
    'url' => Url::toRoute('learning/dashboard'),
];
array_push($result, $learning);

echo Menu::widget([
    'activateItems' => true,
    'activateParents' => true,
    'encodeLabels' => false,
    'activeCssClass' => 'active open selected',
    'items' => $result,
    'options' => [
        'class' => 'nav navbar-nav',
    ],
    'itemOptions' => [
        'class' => 'dropdown dropdown-fw dropdown-fw-disabled',
    ],
    'linkTemplate' => '<a href="{url}">{label}</a>',
    'submenuTemplate' => '<ul class="sub-menu">{items}</ul>',
]);
$script = <<<JS
var thispageurl = window.location.pathname;

$(".dropdown-fw.dropdown-fw-disabled a").each(function(){
    var attr = $(this).attr('href');
      if (attr === thispageurl) {
        $(this).parent().addClass('open');
      }
});
JS;
$this->registerJs($script);
