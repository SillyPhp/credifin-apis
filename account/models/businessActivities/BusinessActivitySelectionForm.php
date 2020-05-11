<?php

namespace account\models\businessActivities;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\BusinessActivities;

class BusinessActivitySelectionForm extends Model
{

    public $businessActivity;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['businessActivity'], 'required'],
            [['businessActivity'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['businessActivity' => 'business_activity_enc_id']],
        ];
    }

    public function add()
    {
        if (!$this->validate()) {
            return false;
        }

        $organization = \common\models\Organizations::findOne(
            [
                "organization_enc_id" => Yii::$app->user->identity->organization->organization_enc_id,
                "status" => "Active",
                "is_deleted" => 0,
            ]
        );

        if (!$organization) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $organization->business_activity_enc_id = $this->businessActivity;
            $organization->last_updated_on = date('Y-m-d H:i:s');
            $organization->last_updated_by = Yii::$app->user->identity->user_enc_id;

            if (!$organization->validate() || !$organization->update()) {
                $transaction->rollBack();
                return false;
            } else {
                $transaction->commit();
                return true;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }

}
