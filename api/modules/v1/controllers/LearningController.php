<?php


namespace api\modules\v1\controllers;


use common\models\extended\TrainingPrograms;
use common\models\LearningVideos;
use common\models\QuestionsPool;
use common\models\Users;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use common\models\Utilities;
use yii\filters\auth\HttpBearerAuth;

class LearningController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'popular-videos',
                'contributors',
                'popular-questions',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'popular-videos' => ['POST'],
                'contributors' => ['POST'],
                'popular-questions' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionPopularVideos()
    {

        $popular_videos = LearningVideos::find()
            ->where([
                'is_deleted' => 0,
                'status' => 1
            ])
            ->orderBy(new Expression('rand()'))
            ->limit(6)
            ->asArray()
            ->all();

        if ($popular_videos) {
            return $this->response(200, $popular_videos);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionContributors()
    {

        $param = Yii::$app->request->post();

        if (isset($param['limit']) && !empty($param['limit'])) {
            $limit = $param['limit'];
        } else {
            $limit = 10;
        }

        if (isset($param['page']) && !empty($param['page'])) {
            $page = $param['page'];
        } else {
            $page = 1;
        }

        $contributors = Users::find()
            ->alias('a')
            ->select([
                'a.user_enc_id',
                'a.user_type_enc_id',
                'c.author_enc_id',
                'CONCAT(a.first_name," ", a.last_name) as name',
                'a.facebook',
                'a.twitter',
                'a.linkedin',
                'a.instagram',
                'count(c.id) as videos',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) ELSE "' . Url::to('/assets/themes/ey/images/pages/learning-corner/collaborator.png', 'https') . '" END image'
            ])
            ->innerJoinWith(['userTypeEnc b' => function ($b) {
                $b->andOnCondition(['b.user_type' => 'Contributor']);
            }], false)
            ->innerJoinWith(['youtubeChannels1 c' => function ($c) {
                $c->innerJoinWith(['learningVideos d' => function ($d) {
                    $d->andWhere(['d.is_deleted' => 0]);
                }]);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere([
                'or',
                ['a.organization_enc_id' => ""],
                ['a.organization_enc_id' => NULL]
            ])
            ->orderBy(['videos' => SORT_DESC])
            ->groupBy('a.id')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($contributors) {
            return $this->response(200, $contributors);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionPopularQuestions()
    {
        $questions = QuestionsPool::find()
            ->alias('a')
            ->andWhere(['a.is_deleted' => 0])
            ->select(['a.question_pool_enc_id', 'c.name', 'question', 'privacy', 'a.slug', 'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image,'https') . '", f.image_location, "/", f.image) ELSE NULL END image', 'f.username', 'f.initials_color', 'CONCAT(f.first_name," ","f.last_name") user_name'])
            ->joinWith(['createdBy f'], false)
            ->joinWith(['topicEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->joinWith(['questionsPoolAnswers d' => function ($b) {
                $b->joinWith(['createdBy e'], false);
                $b->select(['d.question_pool_enc_id', 'CONCAT(e.first_name," ",e.last_name) name', 'CASE WHEN e.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image,'https') . '", e.image_location, "/", e.image) ELSE NULL END image', 'e.username', 'e.initials_color']);
                $b->limit(3);
            }])
            ->limit(6)
            ->asArray()
            ->all();

        if ($questions) {
            return $this->response(200, $questions);
        } else {
            return $this->response(404, 'not found');
        }
    }

}