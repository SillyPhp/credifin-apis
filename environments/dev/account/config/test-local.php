<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    require __DIR__ . '/../../config/account/main.php',
    require __DIR__ . '/../../config/account/main-local.php',
    require __DIR__ . '/../../config/account/test.php',
    [
    ]
);
