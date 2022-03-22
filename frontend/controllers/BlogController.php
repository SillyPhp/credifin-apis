<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\db\Expression;
use common\models\Posts;
use common\models\PostTags;
use common\models\PostCategories;
use common\models\Users;
use common\models\Tags;
use common\models\Categories;
use yii\helpers\ArrayHelper;

class BlogController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $postsModel = new Posts();
        $posts = $postsModel->find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.featured_image_location', 'a.featured_image', 'a.featured_image_alt', 'featured_image_title', 'a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug'])
            ->joinWith(['postCategories b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['not', ['c.category_enc_id' => null]])
            ->andWhere(['a.is_visible'=>1])
            ->orderby(['a.created_on' => SORT_ASC])
            ->limit(8)
            ->asArray()
            ->all();

        $quotes = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location, "/", a.featured_image) image'])
            ->joinWith(['postCategories b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['c.name' => null])
            ->groupBy(['a.post_enc_id'])
            ->orderby(new Expression('rand()'))
            ->limit(6)
            ->asArray()
            ->all();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = Yii::$app->request->post();

            $popular_posts = Posts::find()
                ->alias('a')
                ->select(['a.post_enc_id', 'a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'a.excerpt', 'c.name', 'CONCAT("' . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location, "/", a.featured_image) image'])
                ->joinWith(['postCategories b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false);
                }], false)
                ->where(['a.status' => 'Active', 'a.is_deleted' => 0]);
            if (isset($params['category']) && !empty($params['category'])) {
                $popular_posts->andFilterWhere(['like', 'c.name', $params['category']]);
            }

            $popular_posts = $popular_posts->orderby(new Expression('rand()'))
                ->limit(3)
                ->asArray()
                ->all();
            return $response = [
                'status' => 200,
                'message' => 'Success',
                'popular_posts' => $popular_posts,
            ];
        }
        return $this->render('blog-main', [
            'posts' => $posts,
            'quotes' => $quotes,
        ]);
    }

    public function actionTrendingPosts()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $popular_posts = Posts::find()
                ->alias('a')
                ->select(['a.post_enc_id', 'a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'a.excerpt', 'c.name', 'CONCAT("' . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location, "/", a.featured_image) image'])
                ->innerJoinWith(['postCategories b' => function ($b) {
                    $b->innerJoinWith(['categoryEnc c'], false);
                }], false)
                ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
                ->andWhere(['not', ['c.name' => 'Infographics']])
                ->andWhere(['not', ['c.name' => 'Quotes']])
                ->andWhere(['a.is_visible'=>1])
                ->groupBy(['a.post_enc_id'])
                ->orderby(new Expression('rand()'))
                ->limit(4)
                ->asArray()
                ->all();

            $exclusions = [];

            foreach ($popular_posts as $p) {
                array_push($exclusions, $p['post_enc_id']);
            }

            $whats_new_posts = Posts::find()
                ->alias('a')
                ->select(['a.post_enc_id', 'a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'a.excerpt', 'c.name', 'CONCAT("' . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location, "/", a.featured_image) image'])
                ->innerJoinWith(['postCategories b' => function ($b) {
                    $b->innerJoinWith(['categoryEnc c'], false);
                }], false)
                ->where(['not in', 'a.post_enc_id', $exclusions])
                ->andWhere(['a.status' => 'Active', 'a.is_deleted' => 0])
                ->andWhere(['not', ['c.name' => 'Infographics']])
                ->andWhere(['not', ['c.name' => 'Quotes']])
                ->andWhere(['a.is_visible'=>1])
                ->groupBy(['a.post_enc_id'])
                ->orderby(new Expression('rand()'))
                ->limit(6)
                ->asArray()
                ->all();

            foreach ($whats_new_posts as $w) {
                array_push($exclusions, $w['post_enc_id']);
            }

            $trending_posts = Posts::find()
                ->alias('a')
                ->select(['a.post_enc_id', 'a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'a.excerpt', 'c.name', 'CONCAT("' . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location, "/", a.featured_image) image'])
                ->innerJoinWith(['postCategories b' => function ($b) {
                    $b->innerJoinWith(['categoryEnc c'], false);
                }], false)
                ->where(['not in', 'a.post_enc_id', $exclusions])
                ->andWhere(['a.status' => 'Active', 'a.is_deleted' => 0])
                ->andWhere(['not', ['c.name' => 'Infographics']])
                ->andWhere(['not', ['c.name' => 'Quotes']])
                ->andWhere(['a.is_visible'=>1])
                ->groupBy(['a.post_enc_id'])
                ->orderby(new Expression('rand()'))
                ->limit(12)
                ->asArray()
                ->all();

            return $response = [
                'status' => 200,
                'message' => 'Success',
                'popular_posts' => $popular_posts,
                'whats_new_posts' => $whats_new_posts,
                'trending_posts' => $trending_posts,
            ];
        }
    }

    public function actionDetail($slug)
    {
        return $this->_getPostDetails($slug, 1);
    }

    private function _getPostDetails($slug, $is_crawled = 1)
    {
        $post = Posts::findOne(['is_deleted' => 0, 'slug' => $slug, 'status' => 'Active', 'is_crawled' => $is_crawled,'is_visible'=>1]);
        $tags = ArrayHelper::getColumn($post->postTags, 'tagEnc.name');
        if ($post) {
            $post_categories = PostCategories::find()
                ->alias('a')
                ->select(['a.category_enc_id', 'b.name category'])
                ->joinWith(['categoryEnc b'])
                ->where(['a.post_enc_id' => $post->post_enc_id])
                ->asArray()
                ->all();
            $categories = [];
            foreach ($post_categories as $c) {
                $categories[] = $c['category_enc_id'];
            }

            $similar_posts = Posts::find()
                ->alias('z')
                ->joinWith(['postTags a' => function ($a) use ($tags) {
                    $a->joinWith(['tagEnc a1' => function ($a1) use ($tags) {
                        $a1->where(['in', 'a1.name', $tags]);
                    }]);
                }])
                ->joinWith(['postCategories b'], false)
                ->andWhere(['!=', 'z.post_enc_id', $post->post_enc_id])
                ->andWhere(['z.status' => 'Active', 'z.is_deleted' => 0])
//                ->andFilterWhere(['like', 'b.category_enc_id', $categories])
                ->andWhere(['z.is_visible'=>1])
                ->andWhere(['b.category_enc_id' => $categories])
                ->orderBy(new Expression('rand()'))
                ->asArray()
                ->limit(3)
                ->all();

            return $this->render('detail', [
                'post' => $post,
                'catagory' => $post_categories,
                'similar_posts' => $similar_posts,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionGetPostsByCategory($slug)
    {
        $postsModel = new Posts();
        $posts = $postsModel->find()->alias('a')
            ->select(['a.*', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'd.first_name', 'd.last_name'])
            ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($posts) {
            if ($slug === "articles" || $slug === "infographics") {
                $page = 'category-landing-page';
            } else {
                $page = 'posts-by-category';
            }
            return $this->render($page, [
                'posts' => $posts,
                'slug' => $slug,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionGetPostsByTag($slug)
    {
        $postsModel = new Posts();
        $posts = $postsModel->find()->alias('a')
            ->select(['a.*', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'd.first_name', 'd.last_name'])
            ->innerJoin(PostTags::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Tags::tableName() . 'as c', 'c.tag_enc_id = b.tag_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0,'is_visible'=>1])
            ->orderby(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($posts) {
            return $this->render('posts-by-tag', [
                'posts' => $posts,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionCategoryPosts($slug)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($slug)) {
            $postsModel = new Posts();
            $posts = $postsModel->find()
                ->alias('a')
                ->distinct()
                ->select(['a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("' . Url::to('/blog/c/') . '",a.slug) ELSE CONCAT(a.slug) END) as url',
                    'a.excerpt', 'CONCAT("' . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location,"/",a.featured_image) AS image',
                    'a.featured_image_title AS image_title',
                    'a.featured_image_alt AS image_alt',
                    'a.created_on AS date',
                    'CONCAT(f.first_name," ",f.last_name) AS name'])
                ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(PostTags::tableName() . 'as d', 'd.post_enc_id = a.post_enc_id')
                ->innerJoin(Tags::tableName() . 'as e', 'e.tag_enc_id = d.tag_enc_id')
                ->innerJoin(Users::tableName() . 'as f', 'f.user_enc_id = a.author_enc_id')
                ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0,'is_visible'=>1])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->limit(5)
                ->asArray()
                ->all();
            for ($i = 1; $i <= count($posts); $i++) {
                if ($i == 1) {
                    $featured = $posts[$i - 1];
                } else {
                    $other[] = $posts[$i - 1];
                }
            }
            if (count($posts) > 0) {
                $response = [
                    'status' => 200,
                    'posts' => [
                        'featured' => $featured,
                        'other' => $other
                    ]
                ];
            } else {
                $response = [
                    'status' => 201
                ];
            }
        } else {
            $response = [
                'status' => 400
            ];
        }

        return $response;
    }

    public function actionUncralwedPost($slug)
    {
        return $this->_getPostDetails($slug, 0);
    }

}