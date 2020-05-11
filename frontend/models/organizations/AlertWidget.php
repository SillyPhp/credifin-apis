<?php
use yii\base\Widget;
use yii\helpers\Html;
use Yii;
class AlertWidget extends \yii\bootstrap\Widget
{
    public $alertTypes = [
        'modal-error' => 'alert-error',
        'modal-danger' => 'alert-danger',
        'modal-success' => 'alert-success',
        'modal-info' => 'alert-info',
        'modal-warning' => 'alert-warning'
    ];
    public function init()
    {
        Modal::begin([
            'id' => 'modal-' . $this->options['id'],
            'header' => '<h2>warning</h2>',
            'toggleButton' => false,
            'clientOptions' => ['show' => true]
        ]);
        /** original part  */
        echo \yii\bootstrap\Alert::widget([
            'body' => $message,
            'closeButton' => false,
            'options' => $this->options,
        ]);
        /** \original part */
        Modal::end();
    }
}