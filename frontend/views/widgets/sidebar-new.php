<?php

use yii\widgets\Menu;
$members = ['Member'];
$admins = ['Company Admin', 'Super Admin'];
$jobs_visibility = $internships_visibility = $freelancers_visibility = false;
$services = Yii::$app->user->identity->services;
$hr = [
        'label' => '<i class="icon-user"></i>' . Yii::t('frontend', 'Hr Dashboard'),
        'url' => ['/account/hr-consultants'],
    ];
$company = [
        'label' => '<i class="icon-user"></i>' . Yii::t('frontend', 'Company Dashboard'),
        'url' => ['/account/company-dashboard'],
    ];
$candidate = [
        'label' => '<i class="icon-user"></i>' . Yii::t('frontend', 'Candidate Dashboard'),
        'url' => ['/account/candidate-dashboard'],
    ];
$result = [];
foreach($services['menu_items'] as $service){
    $new = [
        'label'=>'<i class="'.$service['icon'].'"></i>'.Yii::t('frontend',$service['name']),
        'url'=>[$service['link']]
    ];
    array_push($result, $new);
}
array_push($result, $hr);
array_push($result, $company);
array_push($result, $candidate);


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
