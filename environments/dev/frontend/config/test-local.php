<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    require __DIR__ . '/../../config/frontend/main.php',
    require __DIR__ . '/../../config/frontend/main-local.php',
    require __DIR__ . '/../../config/frontend/test.php',
    [
    ]
);
