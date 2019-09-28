<?php

namespace frontend\controllers;

use common\models\QuestionsPool;
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
class QuestionBoxController extends Controller
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
        if (empty($object))
        {
            return 'Not Found';
        };
        return $this->render('question-detail-page',['object'=>$object]);
    } 

    public function actionList(){
        $model =  new PostQuestion();
        $object = QuestionsPool::find()
            ->alias('a')
            ->andWhere(['a.is_deleted'=>0])
            ->select(['a.question_pool_enc_id','c.name','question','privacy','a.slug'])
            ->joinWith(['topicEnc b'=>function($b)
            {
                $b->joinWith(['categoryEnc c'],false);
            }],false)
            ->joinWith(['questionsPoolAnswers d'=>function($b)
            {
                $b->select(['d.question_pool_enc_id']);
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
                return $this->redirect('detail?slug='.$res['slug']);
            }
            else
            {
                return 'Server error';
            }
        }
        return $this->render('question-landing-page',['model'=>$model,'object'=>$object]);
    }
}