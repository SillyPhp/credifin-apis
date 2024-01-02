<?php

namespace common\models\extended;

use common\models\AssignedLoanAccounts;
use common\models\EmiCollection;
use common\models\LoanAccounts;

class LoanAccountsExtended extends LoanAccounts
{
    public function behaviors()
    {
        $model = explode("\\", LoanAccounts::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }

    public function getAssignedLoanAccounts()
    {
        return $this->hasMany(AssignedLoanAccounts::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }

    public function getEmiCollectionsCustom()
    {
        return $this->hasOne(EmiCollection::className(), ['loan_account_enc_id' => 'loan_account_enc_id']);
    }
}