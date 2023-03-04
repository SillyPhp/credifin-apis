<?php

namespace common\models\extended;

use common\models\LoanApplicationComments;

class LoanApplicationCommentsExtended extends LoanApplicationComments
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationComments::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}