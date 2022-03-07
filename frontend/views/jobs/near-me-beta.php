<?php
use yii\helpers\Url;
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
    ],
    'name' => [
    ],
    'property' => [
    ],
];
    echo $this->render('/widgets/jobs-near-me', [
        'type' => 'jobs',
        'action' => 'near-me'
    ]);
?>