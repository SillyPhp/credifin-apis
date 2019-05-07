<?php
namespace account\models\templates;
use common\models\BookmarkedHiringTemplates;
use common\models\HiringProcessTemplateFields;
use common\models\HiringProcessTemplates;
use common\models\InterviewProcessFields;
use common\models\OrganizationInterviewProcess;
use common\models\Utilities;
use Yii;
class HiringProcessModel
{
    public function assignToBookMark($id)
    {
        $model = BookmarkedHiringTemplates::findOne(['hiring_process_enc_id'=>$id]);
        if (empty($model)) {
            $model = new BookmarkedHiringTemplates();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->bookmared_enc_id = $utilitiesModel->encrypt();
            $model->hiring_process_enc_id = $id;
            $model->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $model->created_by = Yii::$app->user->identity->user_enc_id;
            $model->is_bookmared = 1;
            if ($model->save()) {
                return 'mark';
            } else {
                return false;
            }
        }
        else
        {
            if ($model->is_bookmared==0)
            {
                $model->is_bookmared = 1;
                if ($model->save())
                {
                    return 'mark';
                }
            }
            elseif ($model->is_bookmared==1)
            {
                $model->is_bookmared = 0;
                if ($model->save())
                {
                    return 'unmark';
                }
            }
        }

    }

    public function assignToOrg($id)
    {
        $model1 = HiringProcessTemplates::findOne(['hiring_process_enc_id'=>$id]);
        $model2 = new OrganizationInterviewProcess();
        $model2->setAttributes($model1->getAttributes(), false);
        $model2->id = NULL;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model2->interview_process_enc_id = $utilitiesModel->encrypt();
        $model2->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        if (!$model2->save())
        {
            return false;
        }

        $model3 = HiringProcessTemplateFields::findAll(['hiring_process_enc_id'=>$id]);
        foreach ($model3 as $model)
        {
            $model4 = new InterviewProcessFields();
            $model4->setAttributes($model->getAttributes(), true);
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model4->field_enc_id = $utilitiesModel->encrypt();
            $model4->interview_process_enc_id = $model2->interview_process_enc_id;
            $model4->id = NULL;
            if (!$model4->save()) {
              return false;
            }
        }
        return true;
    }
}