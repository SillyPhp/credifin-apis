<?php
namespace frontend\models\questions;
use common\models\LearningVideos;
use common\models\QuestionsPool;
use common\models\QuestionsPoolAnswer;
use common\models\Utilities;
use Yii;
use yii\base\Model;
use yii\db\Expression;

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
            ->select(['a.question_pool_enc_id','c.name','question','privacy','a.topic_enc_id'])
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

    public function relatedQuestion($tid,$id)
    {
      $que = QuestionsPool::find()
              ->select(['question','slug'])
              ->where(['topic_enc_id'=>$tid,'is_deleted'=>0])
              ->andWhere(['not', ['question_pool_enc_id' => $id]])
              ->orderBy(new Expression('rand()'))
              ->limit(4)
              ->asArray()
              ->all();
      return $que;
    }

    public function relatedVideos($tid)
    {
        $related_videos = LearningVideos::find()
            ->alias('a')
            ->joinWith(['assignedCategoryEnc b'], false)
            ->where(['b.parent_enc_id' => $tid])
            ->andWhere(['a.status' => 1]) 
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(new Expression('rand()'))
            ->limit(4)
            ->asArray()
            ->all();
      return  $related_videos;
    }

}
