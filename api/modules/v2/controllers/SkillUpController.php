<?php


namespace api\modules\v2\controllers;

use common\models\SkillsUpPosts;
use Yii;
use \yii\db\Expression;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class SkillUpController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'feed' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionFeed()
    {
        if ($user = $this->isAuthorized()) {

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

            $feeds = SkillsUpPosts::find()
                ->alias('a')
                ->select([
                    'a.post_enc_id',
                    'a.post_title',
                    'a.source_enc_id',
                    'a.post_short_summery',
                    'a.slug',
                    'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->skill_up->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->feed_sources->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END source_image',
                    'b.name source_name',
                    'b.url source_url',
                    'a.post_author',
                    'a.content_type'
                ])
                ->joinWith(['sourceEnc b'], false)
                ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'b.is_deleted' => 0])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();
            if ($feeds) {
                return $this->response(200, ['status' => 200, 'data' => $feeds]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}