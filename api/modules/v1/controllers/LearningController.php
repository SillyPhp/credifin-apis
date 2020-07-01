<?php


namespace api\modules\v1\controllers;


use common\models\AssignedCategories;
use common\models\extended\TrainingPrograms;
use common\models\LearningVideoComments;
use common\models\LearningVideoLikes;
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
                'video-detail',
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
            ->select(['a.question_pool_enc_id', 'c.name', 'question', 'privacy', 'a.slug', 'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) ELSE NULL END image', 'f.username', 'f.initials_color', 'CONCAT(f.first_name," ","f.last_name") user_name'])
            ->joinWith(['createdBy f'], false)
            ->joinWith(['topicEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->joinWith(['questionsPoolAnswers d' => function ($b) {
                $b->joinWith(['createdBy e'], false);
                $b->select(['d.question_pool_enc_id', 'CONCAT(e.first_name," ",e.last_name) name', 'CASE WHEN e.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", e.image_location, "/", e.image) ELSE NULL END image', 'e.username', 'e.initials_color']);
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

    public function actionVideoDetail()
    {
        $param = Yii::$app->request->post();
        if (isset($param['slug']) && !empty($param['slug'])) {
            $slug = $param['slug'];
        } else {
            return $this->response(422, 'Missing Information');
        }
        $video_detail = LearningVideos::find()
            ->alias('a')
            ->select(['a.*', 'c.category_enc_id', 'c.parent_enc_id', 'd.name child_name', 'e.name parent_name'])
            ->joinWith(['learningVideoTags b' => function ($y) {
                $y->select(['b.video_enc_id', 'b.tag_enc_id', 'f.name']);
                $y->joinWith(['tagEnc f'], false);
                $y->limit(10);
            }])
            ->joinWith(['assignedCategoryEnc c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
                $x->joinWith(['parentEnc e'], false);
            }], false)
            ->where(['a.slug' => $slug])
            ->andWhere(['a.status' => 1])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->one();
//        return $video_detail;
        if ($video_detail) {
            return $this->response(200, $video_detail);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionTopVideo($slug)
    {
        $video_detail = LearningVideos::find()
            ->alias('a')
            ->select(['a.*', 'c.category_enc_id', 'c.parent_enc_id', 'd.name child_name', 'e.name parent_name'])
            ->joinWith(['learningVideoTags b' => function ($y) {
                $y->select(['b.video_enc_id', 'b.tag_enc_id', 'f.name']);
                $y->joinWith(['tagEnc f'], false);
                $y->limit(10);
            }])
            ->joinWith(['assignedCategoryEnc c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
                $x->joinWith(['parentEnc e'], false);
            }], false)
            ->where(['a.slug' => $slug])
            ->andWhere(['a.status' => 1])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->one();
        $parent_id = Yii::$app->request->post('video_id');
        $tags_id = Yii::$app->request->post('tags_id');
        $current_video_id = LearningVideos::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 1])
            ->andWhere(['is_deleted' => 0])
            ->one();
        $interested_videos = [];
        if (count($tags_id) > 0) {
            $interested_videos = LearningVideos::find()
                ->alias('a')
                ->joinWith(['learningVideoTags b'], false)
                ->where(['in', 'b.tag_enc_id', $tags_id])
                ->andWhere(['a.status' => 1])
                ->andWhere(['a.is_deleted' => 0])
                ->andWhere(['!=', 'b.video_enc_id', $current_video_id['video_enc_id']])
                ->limit(8)
                ->asArray()
                ->all();
        }

        $related_videos = LearningVideos::find()
            ->alias('a')
            ->joinWith(['assignedCategoryEnc b'], false)
            ->where(['b.parent_enc_id' => $parent_id])
            ->andWhere(['a.status' => 1])
            ->andWhere(['a.is_deleted' => 0])
            ->andWhere(['!=', 'a.video_enc_id', $current_video_id['video_enc_id']])
            ->limit(10)
            ->asArray()
            ->all();
        $top_videos = LearningVideos::find()
            ->orderBy(['view_count' => SORT_DESC])
            ->where(['status' => 1])
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['!=', 'video_enc_id', $current_video_id['video_enc_id']])
            ->limit(2)
            ->asArray()
            ->all();

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;


            $top_category = AssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id', 'a.category_enc_id', 'a.parent_enc_id', 'c.slug', 'c.name', 'COUNT(a.parent_enc_id) cnt'])
                ->joinWith(['learningVideos b' => function ($b) {
                    $b->andOnCondition(['b.status' => 1]);
                    $b->andOnCondition(['b.is_deleted' => 0]);
                }], false)
                ->joinWith(['categoryEnc c'], false)
                ->where(['a.assigned_to' => 'Videos'])
                ->andWhere(['a.status' => 'Approved'])
                ->andWhere([
                    'or',
                    ['a.parent_enc_id' => ""],
                    ['a.parent_enc_id' => NULL]
                ])
                ->andWhere(['a.is_deleted' => 0])
                ->groupBy(['a.assigned_category_enc_id'])
                ->asArray()
                ->limit(15)
                ->all();
            if ($related_videos || $top_videos || $top_category || $interested_videos) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'related_videos' => $related_videos,
                    'top_videos' => $top_videos,
                    'top_category' => $top_category,
                    'interested_videos' => $interested_videos,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return ($response);
        }
        if (!empty($video_detail)) {
            $video_detail['duration'] = $this->toMinutes($video_detail['duration']);
            $likeStatus = LearningVideoLikes::find()
                ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->one();
            $likeCount = LearningVideoLikes::find()
                ->where(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['status' => 1])
                ->count();
            $dislikeCount = LearningVideoLikes::find()
                ->where(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['status' => 2])
                ->count();
            $commentCount = LearningVideoComments::find()
                ->where(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->count();
            return $this->render('video-detail', [
                'video_detail' => $video_detail,
                'like_status' => $likeStatus,
                'like_count' => $likeCount,
                'dislike_count' => $dislikeCount,
                'comment_count' => $commentCount,
            ]);
        } else {
            return $this->response(404, 'not found');
        }
    }


}