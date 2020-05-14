<?php

namespace account\controllers;
use account\models\quiz\QuizModel;
use common\models\Categories;
use common\models\QuizTopics;
use common\models\Topics;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use common\models\Utilities;
class QuizController extends Controller
{
    public function actionDashboard(){
        return $this->render('dashboard');
    }
    public function actionCreate(){
        $categories = $this->_data('Groups');
        $sub = $this->_data('Subject');
        $rec_topics = $this->_topics(1);
        $user_topics = $this->_topics(0);
        return $this->render('create-quiz-multi',['categories'=>$categories,'subject'=>$sub]);
    }

    public function actionAddGroups()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $d = Yii::$app->request->post('data');
            $model = new QuizModel();
            $res = $model->addGrp($d);
            if ($res)
            {
                return true;
            }
            else
            {
                return false;
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
            if ($res)
            {
                return true;
            }
            else
            {
                return false;
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
            ->asArray()
            ->all();
    }

    private function _topics($is_rec)
    {
        return Topics::find()
            ->where(['assigned_to'=>'quiz','is_deleted'=>0])
            ->andWhere([
                'or',
                ['=', 'status', 1],
                ['created_by' => Yii::$app->user->identity->user_enc_id]
            ])
            ->andWhere(['is_recommend'=>$is_rec])
            ->asArray()->all();
    }

    public function actionFaker()
    {
        $model = new Topics();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->topic_enc_id = $utilitiesModel->encrypt();
    }

}

