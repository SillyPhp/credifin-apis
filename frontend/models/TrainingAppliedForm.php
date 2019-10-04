<?php

namespace frontend\models;
use common\models\AppliedTrainingApplications;
use common\models\AppliedTrainingBatches;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class TrainingAppliedForm extends Model
{

  public $application_id;
  public $batch_id;

    public function formName()
    {
        return '';
    }

  public function rules()
  {
      return [
          [['application_id','batch_id'],'required'],
      ];
  }

  public function save()
  {
      $appliedTraining = new AppliedTrainingApplications();
      $utilitiesModel = new Utilities();
      $utilitiesModel->variables['string'] = time() . rand(100, 100000);
      $appliedTraining->applied_application_enc_id = $utilitiesModel->encrypt();
      $appliedTraining->application_number = rand(1000, 10000) . time();
      $appliedTraining->application_enc_id = $this->application_id;
      $appliedTraining->created_by = Yii::$app->user->identity->user_enc_id;
      $appliedTraining->created_on = date('Y-m-d H:i:s');
      if ($appliedTraining->save())
      {
          foreach ($this->batch_id as $b) {
              $trainingBatchApplied = new AppliedTrainingBatches();
              $utilitiesModel = new Utilities();
              $utilitiesModel->variables['string'] = time() . rand(100, 100000);
              $trainingBatchApplied->applied_batches_application_enc_id = $utilitiesModel->encrypt();
              $trainingBatchApplied->applied_application_enc_id = $appliedTraining->applied_application_enc_id;
              $trainingBatchApplied->batch_enc_id = $b;
              $trainingBatchApplied->created_by = Yii::$app->user->identity->user_enc_id;
              $trainingBatchApplied->created_on = date('Y-m-d H:i:s');
              if (!$trainingBatchApplied->save())
              {
                  return false;
              }
          }
          return true;
      }
      else
      {
          return false;
      }
  }

}