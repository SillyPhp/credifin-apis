<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    require __DIR__ . '/../../config/api/main.php',
    require __DIR__ . '/../../config/api/main-local.php',
    require __DIR__ . '/../../config/api/test.php',
    [
    ]
);
