<?php
$script = <<< JS

JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/ey/broadcast/js/agora-rtm-sdk-1.2.2.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>