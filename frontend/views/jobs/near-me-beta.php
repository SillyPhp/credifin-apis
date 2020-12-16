<?php,
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
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