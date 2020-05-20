<?php
namespace account\models\quiz;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Currencies;
use common\models\QuizAnswersPool;
use common\models\QuizPool;
use common\models\QuizQuestionsPool;
use common\models\Quizzes;
use common\models\Topics;
use Yii;
use yii\base\Model;
use common\models\Utilities; 

class QuizModel extends Model
{
    public $topic;
    public $subject;
    public $group;
    public $payment_status;
    public $amount;
    public $questions;
    public $intro;
    public $t_marks;
    public $time_dur;
    public $correct_marks;
    public $negetive_marks;

    public function rules()
    {
        return [
            [['topic','group','subject','payment_status','questions','intro','t_marks','time_dur','correct_marks'], 'required'],
            [['amount','negetive_marks'], 'safe'],
            [['amount'], 'number'],
            [['group', 'topic', 'subject',], 'string', 'max' => 100],
            [['intro'], 'string', 'max' => 300],
        ];
    }

    public function formName()
    {
        return '';
    }
    public function submit()
    {
        $questions = json_decode($this->questions,true);
        $quizPool = new QuizPool();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $quizPool->quiz_pool_enc_id = $utilitiesModel->encrypt();
        $quizPool->name = 'Quiz Pool '.rand(100, 100000);
        $quizPool->topic_enc_id = $this->topic;
        $quizPool->group_enc_id = $this->group;
        $quizPool->subject_enc_id = $this->subject;
        $quizPool->created_by = Yii::$app->user->identity->user_enc_id;
        if ($quizPool->save())
        {
            $cr = Currencies::find()->asArray()->where(['country'=>'India'])->select(['currency_enc_id'])->one();
            $quiz = new Quizzes();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $quiz->quiz_enc_id = $utilitiesModel->encrypt();
            $quiz->quiz_pool_enc_id = $quizPool->quiz_pool_enc_id;
            $quiz->created_by = Yii::$app->user->identity->user_enc_id;
            if ($this->payment_status==1&&$this->amount!==0)
            {
                $quiz->price = $this->amount;
                $quiz->currency_enc_id = $cr['currency_enc_id'];
            }
            $quiz->description = $this->intro;
            $quiz->name = 'Quiz '.rand(100, 100000);
            $utilitiesModel->variables['name'] = $quiz->name;
            $utilitiesModel->variables['table_name'] = Quizzes::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $quiz->slug = $utilitiesModel->create_slug();
            $quiz->template = 3;
            $quiz->type = 1;
            $quiz->time_duration = $this->time_dur;
            $quiz->total_marks = $this->t_marks;
            $quiz->correct_answer_marks = $this->correct_marks;
            $quiz->negetive_marks = $this->negetive_marks;
            $quiz->num_of_ques = count($questions);
            if ($quiz->save())
            {
                foreach ($questions as $question){
                    $quizQuestionPool = new QuizQuestionsPool();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $quizQuestionPool->quiz_question_pool_enc_id = $utilitiesModel->encrypt();
                    $quizQuestionPool->quiz_pool_enc_id = $quizPool->quiz_pool_enc_id;
                    $quizQuestionPool->created_by = Yii::$app->user->identity->user_enc_id;
                    $quizQuestionPool->question = $this->utf8ize($question['q']);
                    if ($quizQuestionPool->save())
                    {
                        for ($k=0;$k<count($question['options']);$k++) {
                            $quizAnswerPool = new QuizAnswersPool();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $quizAnswerPool->quiz_answer_pool_enc_id = $utilitiesModel->encrypt();
                            $quizAnswerPool->quiz_question_pool_enc_id = $quizQuestionPool->quiz_question_pool_enc_id;
                            $quizAnswerPool->answer = $this->utf8ize($question['options'][$k]);
                            if ($question['ra']==$k){ 
                                $quizAnswerPool->is_answer = 1;
                            }
                            if (!$quizAnswerPool->save())
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
              return [
                  'status'=>true,
                  'slug'=>$quiz->slug
              ];
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    public function addGrp($d)
    {
        $category_execute = Categories::find()
            ->alias('a')
            ->select(['a.id','a.category_enc_id'])
            ->where(['a.name' => $d]);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $categoriesModel->name = $d;
            $utilitiesModel->variables['name'] = $d;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
              return $this->addNewAssignedCategory($categoriesModel->category_enc_id,'Groups');
            } else {
                return false;
            }
        } else {
            $chk_assigned = $category_execute
                ->addSelect(['b.assigned_category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->andWhere(['b.assigned_to' => 'Groups', 'b.parent_enc_id' => null])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
               return $this->addNewAssignedCategory($chk_cat['category_enc_id'], 'Groups');
            } else {
               return [
                   'status'=>true,
                   'id'=>$chk_assigned['assigned_category_enc_id']
               ];
            }
        }
    }
    public function addSub($d)
    {
        $category_execute = Categories::find()
            ->alias('a')
            ->select(['a.id','a.category_enc_id'])
            ->where(['a.name' => $d]);
        $chk_cat = $category_execute->asArray()->one();
        if (empty($chk_cat)) {
            $categoriesModel = new Categories;
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
            $categoriesModel->name = $d;
            $utilitiesModel->variables['name'] = $d;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $categoriesModel->slug = $utilitiesModel->create_slug();
            $categoriesModel->created_on = date('Y-m-d H:i:s');
            $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
            if ($categoriesModel->save()) {
                return $this->addNewAssignedCategory($categoriesModel->category_enc_id,'Subject');
            } else {
                return false;
            }
        } else {
            $chk_assigned = $category_execute
                ->addSelect(['b.assigned_category_enc_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                ->andWhere(['b.assigned_to' => 'Subject', 'b.parent_enc_id' => null])
                ->asArray()
                ->one();
            if (empty($chk_assigned)) {
                return $this->addNewAssignedCategory($chk_cat['category_enc_id'], 'Subject');
            } else {
                return [
                    'status'=>true,
                    'id'=>$chk_assigned['assigned_category_enc_id']
                ];
            }
        }
    }

    public function addTopics($d)
    {
        $chk = Topics::find()
            ->select(['id','topic_enc_id'])
            ->where(['name'=>$d])
            ->asArray()
            ->one();
        if (empty($chk)){
            $model = new Topics();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->topic_enc_id = $utilitiesModel->encrypt();
            $model->name = $d;
            $model->created_by = Yii::$app->user->identity->user_enc_id;
            $model->assigned_to = 'quiz';
            if ($model->save())
            {
                return [
                    'status'=>true,
                    'id'=>$model->topic_enc_id
                ];
            }
            else{
                return false;
            }
        }else{
            return [
                'status'=>true,
                'id'=>$chk['topic_enc_id']
            ];
        }
    }

    private function addNewAssignedCategory($category_id, $type)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = null;
        $assignedCategoryModel->assigned_to = $type;
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            return [
                'status'=>true,
                'id'=>$assignedCategoryModel->assigned_category_enc_id
            ];
        } else {
            return false;
        }
    }
    private  function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
        return $mixed;
    }
}