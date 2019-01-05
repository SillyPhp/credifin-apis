<?php

use yii\widgets\Menu;

$jobs_visibility = $internships_visibility = $freelancers_visibility = false;
$services = Yii::$app->user->identity->services;
$result = [];

foreach ($services['menu_items'] as $service) {
    $new = [
        'label' => '<i class="' . $service['icon'] . '"></i>' . Yii::t('account', $service['name']),
        'url' => $service['link'],
    ];
    array_push($result, $new);
}

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
