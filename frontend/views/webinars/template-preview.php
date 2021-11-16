<?php
$this->params['header_dark'] = true;
use yii\helpers\Url;
use yii\helpers\Html;
?>
    <?= $this->render('/widgets/webinar-templates/'.$template_name.''); ?>
<?php
$this->registerCssFile('https://fonts.googleapis.com');
$this->registerCssFile('https://fonts.gstatic.com');
