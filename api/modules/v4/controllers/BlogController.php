<?php

namespace api\modules\v4\controllers;

use common\models\PostCategories;
use common\models\Posts;
use yii\helpers\Url;
use yii\db\Expression;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

class BlogController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list' => ['POST', 'OPTIONS'],
                'detail' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionList()
    {

        $params = Yii::$app->request->post();

        $limit = 8;
        $page = 1;
        $keyword = 'loan';

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        }

        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $keyword = $params['keyword'];
        }

        $posts = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.featured_image_alt', 'featured_image_title', 'a.title', 'a.slug', 'a.excerpt',
                'CASE WHEN a.featured_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) END featured_image'])
            ->joinWith(['postTags b' => function ($b) {
                $b->joinWith(['tagEnc c']);
                $b->onCondition(['b.is_deleted' => 0]);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0, 'a.is_visible' => 1])
            ->andWhere(['c.name' => $keyword])
            ->orderBy(['a.created_on' => SORT_ASC])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->groupBy(['a.post_enc_id'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'posts' => $posts]);
    }

    public function actionDetail()
    {
        $params = Yii::$app->request->post();

        if (empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        $keyword = 'loan';
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $keyword = $params['keyword'];
        }

        $post = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.title', 'a.slug', 'a.description', 'a.featured_image_alt', 'featured_image_title',
                'CASE WHEN a.featured_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) END featured_image',
                'CONCAT(c.first_name," ", c.last_name) author_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", c.image_location, "/", c.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.first_name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END author_image'
            ])
            ->joinWith(['postTags b' => function ($b) {
                $b->select(['b.post_tag_enc_id', 'b.post_enc_id', 'b.tag_enc_id', 'b1.name']);
                $b->joinWith(['tagEnc b1'], false);
            }])
            ->joinWith(['authorEnc c'], false)
            ->where(['a.slug' => $params['slug'], 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.is_visible' => 1])
            ->asArray()
            ->one();

        $categories = [];
        if ($post) {

            $post_categories = PostCategories::find()
                ->alias('a')
                ->select(['a.category_enc_id', 'b.name category'])
                ->joinWith(['categoryEnc b'])
                ->where(['a.post_enc_id' => $post['post_enc_id']])
                ->asArray()
                ->all();

            foreach ($post_categories as $c) {
                $categories[] = $c['category_enc_id'];
            }
        }

        $similar_posts = Posts::find()
            ->alias('z')
            ->select(['z.post_enc_id', 'z.featured_image_alt', 'z.featured_image_title', 'z.title', 'z.slug', 'z.excerpt',
                'CASE WHEN z.featured_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", z.featured_image_location, "/", z.featured_image) END featured_image'])
            ->joinWith(['postTags a' => function ($a) use ($keyword) {
                $a->joinWith(['tagEnc a1' => function ($a1) use ($keyword) {
                    $a1->where(['a1.name' => $keyword]);
                }]);
            }], false)
            ->joinWith(['postCategories b'], false)
            ->andWhere(['!=', 'z.post_enc_id', $post['post_enc_id']])
            ->andWhere(['z.status' => 'Active', 'z.is_deleted' => 0])
            ->andWhere(['z.is_visible' => 1])
            ->andWhere(['b.category_enc_id' => $categories])
            ->orderBy(new Expression('rand()'))
            ->asArray()
            ->limit(3)
            ->all();

        if ($post) {
            return $this->response(200, ['status' => 200, 'detail' => $post, 'similar_posts' => $similar_posts]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }
}