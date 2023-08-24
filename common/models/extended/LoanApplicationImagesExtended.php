<?php

namespace common\models\extended;

use common\models\LoanApplicationImages;

class LoanApplicationImagesExtended extends LoanApplicationImages
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationImages::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}