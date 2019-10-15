<?php

namespace frontend\controllers;

use common\models\QuestionsPool;
use common\models\QuestionsPoolAnswer;
use frontend\models\questions\Cards;
use frontend\models\questions\PostAnswer;
use frontend\models\questions\PostQuestion;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Questions Controller
 */
class QuestionsController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionDetail($slug){
        $model = new PostAnswer();
        $object = $model->fetchQuestions($slug);
        $is_answer = $model->is_answer($object['question_pool_enc_id']);
        $answers_count = $model->answerCount($object['question_pool_enc_id']);
        $related_questions = $model->relatedQuestion($object['topic_enc_id'],$object['question_pool_enc_id']);
        $related_videos = $model->relatedVideos($object['topic_enc_id']);
        if (empty($object))
        {
            return 'Not Found';
        };
        return $this->render('question-detail-page',[
            'object'=>$object,
            'is_answer'=>$is_answer,
            'model'=>$model,
            'answers_count'=>$answers_count,
            'related_questions'=>$related_questions,
            'related_videos'=>$related_videos,
        ]);
    } 
    public function actionPostAnswer()
    {
        $model = new PostAnswer();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(Yii::$app->request->referrer);
            }
            else
            {
                return 'Server Error';
            }
        }
    }
    public function actionIndex(){
        $model =  new PostQuestion();
        $object = QuestionsPool::find()
            ->alias('a')
            ->andWhere(['a.is_deleted'=>0])
            ->select(['a.question_pool_enc_id','c.name','question','privacy','a.slug','CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", f.image_location, "/", f.image) ELSE NULL END image','f.username','f.initials_color','CONCAT(f.first_name," ","f.last_name") user_name'])
            ->joinWith(['createdBy f'],false)
            ->joinWith(['topicEnc b'=>function($b)
            {
                $b->joinWith(['categoryEnc c'],false);
            }],false)
            ->joinWith(['questionsPoolAnswers d'=>function($b)
            {
                $b->joinWith(['createdBy e'],false);
                $b->select(['d.question_pool_enc_id','CONCAT(e.first_name," ",e.last_name) name','CASE WHEN e.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", e.image_location, "/", e.image) ELSE NULL END image','e.username','e.initials_color']);
                $b->limit(3);
            }])
            ->limit(3)
            ->asArray()
            ->all();
        if ($model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = $model->save();
            if ($res['status'])
            {
                return $this->redirect('/question/'.$res['slug']);
            }
            else
            {
                return 'Server error';
            }
        }
        return $this->render('question-landing-page',['model'=>$model,'object'=>$object]);
    }

    public function actionFetchAnswers()
    {
        $get = new Cards();
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post('params');
            $cards = $get->getCards($options);
            if ($cards['total'] > 0) {
                $response = [
                    'status' => 200,
                    'cards' => $cards['cards'],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }
}