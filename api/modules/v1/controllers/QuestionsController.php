<?php


namespace api\modules\v1\controllers;


use common\models\AssignedCategories;
use common\models\Categories;
use common\models\extended\TrainingPrograms;
use common\models\LearningVideoComments;
use common\models\LearningVideoLikes;
use common\models\LearningVideos;
use common\models\QuestionsPool;
use common\models\Users;
use frontend\models\questions\PostAnswer;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use common\models\Utilities;
use yii\filters\auth\HttpBearerAuth;

class QuestionsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'detail',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'popular-videos' => ['POST'],
                'contributors' => ['POST'],
                'popular-questions' => ['POST'],
                'video-detail' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionDetail()
    {
        $slug = Yii::$app->request->post('slug');
        $model = new PostAnswer();
        $object = $model->fetchQuestions($slug);
        $is_answer = $model->is_answer($object['question_pool_enc_id']);
        $answers_count = $model->answerCount($object['question_pool_enc_id']);
        $related_questions = $model->relatedQuestion($object['topic_enc_id'], $object['question_pool_enc_id']);
        $related_videos = $model->relatedVideos($object['topic_enc_id']);

        if (!empty($object)) {
            $response = [
                'object' => $object,
                'is_answer' => $is_answer,
                'model' => $model,
                'answers_count' => $answers_count,
                'related_questions' => $related_questions,
                'related_videos' => $related_videos,
            ];
            return $this->response(200, $response);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

}