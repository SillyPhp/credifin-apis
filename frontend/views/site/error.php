<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['header_dark'] = true;
?>
<section id="home" class="fullscreen bg-lightest">
    <div class="display-table text-center">
        <div class="display-table-cell">
            <div class="container pt-0 pb-0">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="text-theme-colored mt-0 mb-0"><i class="fas fa-map-signs text-theme-color-2"></i><?= Html::encode($this->title); ?></h1>
                        <h2 class="mt-0"><?= nl2br(Html::encode($message)); ?></h2>                
                        <a class="btn btn-border btn-gray btn-transparent btn-circled" href="/">Return Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>