<?php

use yii\helpers\Url;

?>

<?= $this->render('/widgets/skill-up/my-contributions',[
    'for' => 'all',
    'pagination' => true
])?>

<?php
$script = <<< JS
feeds();
JS;
$this->registerJs($script);
