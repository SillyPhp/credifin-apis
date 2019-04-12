<?php
namespace account\models\templates;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFieldOptions;
use common\models\QuestionnaireFields;
use common\models\QuestionnaireTemplateFieldOptions;
use common\models\QuestionnaireTemplateFields;
use common\models\Utilities;
use Yii;
use common\models\QuestionnaireTemplates;

class QuestionnaireModel
{
    public function assignToOrg($id)
    {
        $model1 = QuestionnaireTemplates::findOne(['questionnaire_enc_id'=>$id]);
        $model2 = new OrganizationQuestionnaire();
        $model2->setAttributes($model1->getAttributes(), false);
        $model2->id = NULL;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model2->questionnaire_enc_id = $utilitiesModel->encrypt();
        $model2->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        if (!$model2->save())
        {
            return false;
        }

        $model3 = QuestionnaireTemplateFields::findAll(['questionnaire_enc_id'=>$id]);
        foreach ($model3 as $model)
        {
          $model4 = new QuestionnaireFields();
          $model4->setAttributes($model->getAttributes(), true);
          $utilitiesModel = new Utilities();
          $utilitiesModel->variables['string'] = time() . rand(100, 100000);
          $model4->field_enc_id = $utilitiesModel->encrypt();
          $model4->questionnaire_enc_id = $model2->questionnaire_enc_id;
          $model4->id = NULL;
          if ($model4->save())
          {
          $model5 = QuestionnaireTemplateFieldOptions::findOne(['field_enc_id'=>$model->field_enc_id]);
          if (!empty($model5)){
              $model6 = new QuestionnaireFieldOptions();
              $model6->setAttributes($model5->getAttributes(), true);
              $utilitiesModel = new Utilities();
              $utilitiesModel->variables['string'] = time() . rand(100, 100000);
              $model6->field_option_enc_id = $utilitiesModel->encrypt();
              $model6->field_enc_id = $model4->field_enc_id;
              $model6->id = NULL;
              if (!$model6->save())
              {
                  return false;
              }
          }
        }
          else
          {
              return false;
          }
       }
        return true;
     }
}