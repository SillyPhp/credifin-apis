<?php

namespace api\modules\v3;

class Module extends \yii\base\Module{

    public $controllerNamespace = 'api\modules\v3\controllers';

    public function init(){
        parent::init();
        require dirname(dirname(dirname(__DIR__))) . '/config/api/v3/config.php';
    }
}