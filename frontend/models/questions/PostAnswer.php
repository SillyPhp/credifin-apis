<?php
namespace frontend\models\questions;
use common\models\QuestionsPool;
use common\models\QuestionsPoolAnswer;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class PostAnswer extends Model {

    public $question_id;
    public $answer;

    public function rules()
    {
        return [
            [['question_id','answer'],'required'],
            [['question_id','answer'], 'trim'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save()
    {
        $postAnswer = new QuestionsPoolAnswer();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $postAnswer->answer_enc_id = $utilitiesModel->encrypt();
        $postAnswer->question_pool_enc_id = $this->question_id;
        $postAnswer->answer = $this->answer;
        $postAnswer->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$postAnswer->save())
        {
            return false;
        }
        return true;
    }

    public function fetchQuestions($slug)
    {
        $object = QuestionsPool::find()
            ->alias('a')
            ->where(['a.slug'=>$slug])
            ->andWhere(['a.is_deleted'=>0])
            ->select(['a.question_pool_enc_id','c.name','question','privacy'])
            ->joinWith(['topicEnc b'=>function($b)
            {
                $b->joinWith(['categoryEnc c'],false);
            }],false)
            ->joinWith(['tagEncs d'=>function($b)
            {
                $b->select(['d.tag_enc_id','e.name']);
                $b->joinWith(['tagEnc e'],false);
            }])
            ->asArray()
            ->one();
        return $object;
    }

    public function is_answer($id)
    {
       return QuestionsPoolAnswer::find()
            ->select(['answer_enc_id'])
            ->where(['question_pool_enc_id'=>$id])
            ->andWhere(['created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['is_deleted' => 0])
            ->exists();
    }

    public function answerCount($id)
    {
       return QuestionsPoolAnswer::find()
            ->select(['answer'])
            ->where(['question_pool_enc_id'=>$id])
            ->andWhere(['is_deleted' => 0])
            ->asArray()
            ->count();
    }

}
