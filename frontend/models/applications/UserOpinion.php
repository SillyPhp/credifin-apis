<?php
namespace frontend\models\applications;
use account\models\questionnaire\QuestionnaireViewForm;
use common\models\QuestionnaireFieldOptions;
use common\models\SuggestionQuestionnaireFields;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\db\Expression;
class UserOpinion extends Widget
{
    public $user_id=null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = new QuestionnaireViewForm();
        $fields = SuggestionQuestionnaireFields::find()
            ->alias('a')
            ->select(['a.field_enc_id', 'a.field_name','a.questionnaire_enc_id','a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
            ->orderBy(new Expression('rand()'))
            ->limit(1)
            ->asArray()->one();
        $field_option = QuestionnaireFieldOptions::find()
            ->select(['field_option_enc_id', 'field_option'])
            ->where(['field_enc_id' => $fields['field_enc_id']])
            ->asArray()
            ->all();
        $fields['options'] = $field_option;
        $arr['fields'] = $fields;
        if (!empty($arr)){
            return $this->render('@frontend/views/question-suggestion/index',['field' => $arr['fields'],'model' => $model]);
        }
    }
}

