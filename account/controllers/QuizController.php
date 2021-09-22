<?php

namespace account\controllers;
use account\models\bankDetails\BankDetailForm;
use account\models\quiz\QuizModel;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\QuizPool;
use common\models\QuizTopics;
use common\models\Quizzes;
use common\models\Topics;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use common\models\Utilities;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
class QuizController extends Controller
{
    public function actionDashboard(){
        return $this->render('dashboard');
    }
    public function actionCreate(){
        $categories = $this->_data('Groups');
        $sub = $this->_data('Subject');
        $rec_topics = $this->_topics($is_rec=true);
        $user_topics = $this->_topics($is_rec=false);
        $intros_Desc = $this->_desc();
        return $this->render('create-quiz-multi',['categories'=>$categories,
            'subject'=>$sub,
            'recommend_topics'=>$rec_topics,
            'user_topics'=>$user_topics,
            'intros_Desc'=>$intros_Desc,
            ]);
    }

    public function actionCreateDummy(){
        $categories = $this->_data('Groups');
        $sub = $this->_data('Subject');
        $rec_topics = $this->_topics($is_rec=true);
        $user_topics = $this->_topics($is_rec=false);
        $intros_Desc = $this->_desc();
        return $this->render('create-quiz-dummy',['categories'=>$categories,
            'subject'=>$sub,
            'recommend_topics'=>$rec_topics,
            'user_topics'=>$user_topics,
            'intros_Desc'=>$intros_Desc,
        ]);
    }

    public function actionAddGroups()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $d = Yii::$app->request->post('data');
            $model = new QuizModel();
            $res = $model->addGrp($d);
            if ($res['status']==true){
                return [
                    'status'=>true,
                    'response'=>'success',
                    'id'=>$res['id'],
                ];
            }else{
                return [
                    'status'=>false,
                    'response'=>'Server Error'
                ];
            }
        }
    }

    public function actionAddSubject()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $d = Yii::$app->request->post('data');
            $model = new QuizModel();
            $res = $model->addSub($d);
            if ($res['status']==true){
                return [
                    'status'=>true,
                    'response'=>'success',
                    'id'=>$res['id'],
                ];
            }else{
                return [
                    'status'=>false,
                    'response'=>'Server Error'
                ];
            }
        }
    }
    public function actionAddTopic()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $d = Yii::$app->request->post('data');
            $model = new QuizModel();
            $res = $model->addTopics($d);
            if ($res['status']==true){
                return [
                    'status'=>true,
                    'response'=>'success',
                    'id'=>$res['id'],
                ];
            }else{
                return [
                    'status'=>false,
                    'response'=>'Server Error'
                ];
            }
        }
    }
    private function _data($type)
    {
       return Categories::find()
            ->alias('a')
            ->select(['a.name', 'b.assigned_category_enc_id as id'])
            ->joinWith(['assignedCategories b'],false)
            ->andWhere([
                'b.assigned_to' => $type,
                'b.parent_enc_id'=>null
            ])
            ->andWhere([
                'or',
                ['=', 'b.status', 'Approved'],
                ['b.created_by' => Yii::$app->user->identity->user_enc_id]
            ])
            ->orderBy(['b.created_on' => SORT_DESC])
            ->asArray()
            ->all();
    }

    private function _topics($is_rec)
    {
        $topics = Topics::find()
            ->select(['topic_enc_id id','name'])
            ->where(['assigned_to'=>'quiz','is_deleted'=>0])
            ->orderBy(['created_on' => SORT_DESC])
            ->andWhere([
                'or',
                ['=', 'status', 1],
                ['created_by' => Yii::$app->user->identity->user_enc_id]
            ]);
        if ($is_rec){
            return $topics->andWhere(['is_recommend'=>$is_rec])
                ->asArray()->all();
        }
        else{
            return $topics->asArray()->all();
        }

    }

    private function _desc()
    {
        return Quizzes::find()
            ->select(['quiz_enc_id id','description name'])
            ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();
    }

    public function actionQuizView()
    {
        return $this->render('quiz-view');
    }
    public function actionMyQuiz()
    {
        $my_quizs = QuizPool::find()
            ->alias('a')
            ->select(['a.is_deleted','COUNT(q.quiz_question_pool_enc_id) total_que','a.quiz_pool_enc_id','a.name quiz_pool_name','x.name subject','y.name group','d.name topic'])
            ->where(['a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.status'=>1,'a.is_deleted'=>0])
            ->joinWith(['subjectEnc b'=>function($x)
            {
                $x->joinWith(['categoryEnc x'],false,'INNER JOIN');
            }],false,'INNER JOIN')
            ->joinWith(['groupEnc c'=>function($x)
            {
                $x->joinWith(['categoryEnc y'],false,'INNER JOIN');
            }],false,'INNER JOIN')
            ->joinWith(['topicEnc d'],false,'INNER JOIN')
            ->joinWith(['quizzes p'=>function($x)
            {
                $x->select(['p.quiz_enc_id','p.quiz_pool_enc_id','p.name quiz_name','p.slug','p.total_marks','p.time_duration']);
                $x->andWhere(['p.status'=>1,'p.is_deleted'=>0,'p.display'=>1]);
            }],'INNER JOIN')
            ->joinWith(['quizQuestionsPools q'],false)
            ->groupBy('q.quiz_pool_enc_id')
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();
        return $this->render('my-quiz',['my_quizs'=>$my_quizs]);
    }
    public function actionSubmitForm()
    {
        $model = new QuizModel();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $is_validate = ActiveForm::validate($model);
            if (empty($is_validate))
            {
                $res = $model->submit();
                if ($res['status']==true){
                    return [
                        'status'=>true,
                        'response'=>'success',
                        'slug'=>$res['slug'],
                    ];
                }else{
                    return [
                        'status'=>false,
                        'response'=>'Server Error'
                    ];
                }
            }
            else{
                return [
                    'status'=>false,
                    'response'=>$is_validate
                ];
            }
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('data');
            if ($id){
                $update = Yii::$app->db->createCommand()
                    ->update(QuizPool::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['quiz_pool_enc_id' => $id])
                    ->execute();
                if ($update==1) {
                    return true;
                } else {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }

    public function actionBankDetails(){
        $model = new BankDetailForm();
        return $this->render('bank-details',[
            'model' => $model
        ]);
    }

}

