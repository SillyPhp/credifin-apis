<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\Posts;
use common\models\PostTypes;
use common\models\PostTags;
use common\models\PostCategories;
use common\models\PostMedia;
use common\models\MediaTypes;
use common\models\Users;
use common\models\Tags;
use common\models\Categories;

class BlogController extends Controller {
    
    /**
     * @inheritdoc
     */
    
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionBlogMain(){
        $postsModel = new Posts();
        $posts = $postsModel->find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('blog-main', [
            'posts' => $posts,
        ]);
    }

    public function actionBlogDetail(){
        $postsModel = new Posts();
        $post = $postsModel->find()->alias('a')
            ->select(['a.*', 'CONCAT(f.first_name, " ", f.last_name) name', 'f.description user_about','f.image','f.image_location','f.initials_color'])
            ->joinWith(['postCategories b' => function ($b) {
                $b->select(['b.post_enc_id', 'b.category_enc_id']);
                $b->joinWith(['categoryEnc c' => function($y){
                    $y->select(['c.category_enc_id','c.name','c.slug']);
                }]);
            }])
            ->joinWith(['postTags d' => function ($b) {
                $b->select(['d.post_enc_id', 'd.tag_enc_id']);
                $b->joinWith(['tagEnc e' => function($z){
                    $z->select(['e.tag_enc_id','e.name','e.slug']);
                }]);
            }])
            ->leftJoin(Users::tablename() . ' as f', 'f.user_enc_id = a.author_enc_id')
            ->where(['a.slug' => 'dsa-12', 'a.status' => 'Active', 'a.is_deleted' => 'false'])
            ->asArray()
            ->one();

//        print_r($post);
//        exit();
        return $this->render('blog_detail',[
            'post' => $post,
        ]);
    }

    public function actionIndex() {
        $postsModel = new Posts();
        $posts = $postsModel->find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        $quotes = $postsModel->find()->alias('a')
                ->select(['a.*', 'd.first_name', 'd.last_name'])
                ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
                ->where(['c.slug' => 'quotes', 'a.status' => 'Active', 'a.is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_DESC])
                ->asArray()
                ->all();
        $similar_posts = $postsModel->find()
                ->limit(4)
                ->orderBy(['created_on' => SORT_DESC])
                ->asArray()
                ->all();

        return $this->render('index', [
                    'posts' => $posts,
                    'quotes' => $quotes,
                    'similar_posts' => $similar_posts,
        ]);
    }

    public function actionGetPostsByCategory($ctidk) {
        $postsModel = new Posts();
        $posts = $postsModel->find()->alias('a')
                ->select(['a.*', 'd.first_name', 'd.last_name'])
                ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
                ->where(['c.slug' => $ctidk, 'a.status' => 'Active', 'a.is_deleted' => 'false'])
                ->orderby(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

        return $this->render('posts-by-category', [
                    'posts' => $posts,
        ]);
    }

    public function actionGetPostsByTag($tgidk) {
        $postsModel = new Posts();
        $posts = $postsModel->find()->alias('a')
                ->select(['a.*', 'd.first_name', 'd.last_name'])
                ->innerJoin(PostTags::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
                ->innerJoin(Tags::tableName() . 'as c', 'c.tag_enc_id = b.tag_enc_id')
                ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
                ->where(['c.slug' => $tgidk, 'a.status' => 'Active', 'a.is_deleted' => 'false'])
                ->orderby(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

        return $this->render('posts-by-tag', [
                    'posts' => $posts,
        ]);
    }

    public function actionGetPostById($idk) {
        $postsModel = new Posts();
        $post = $postsModel->find()->alias('a')
                ->select(['a.*', 'c.first_name', 'c.last_name'])
                ->innerJoin(PostTypes::tableName() . ' as b', 'a.post_type_enc_id = b.post_type_enc_id')
                ->innerJoin(Users::tablename() . ' as c', 'c.user_enc_id = a.author_enc_id')
                ->where(['a.slug' => $idk, 'a.status' => 'Active', 'a.is_deleted' => 'false'])
                ->asArray()
                ->one();

        if (count($post) > 0) {
            $categoriesModel = new Categories();
            $post_categories = $categoriesModel->find()->alias('a')
                    ->select(['a.name', 'a.slug', 'a.category_enc_id'])
                    ->innerJoin(PostCategories::tableName() . ' as d', 'd.category_enc_id = a.category_enc_id')
                    ->where(['d.post_enc_id' => $post['post_enc_id']])
                    ->asArray()
                    ->all();

            $tagsModel = new Tags();
            $post_tags = $tagsModel->find()->alias('a')
                    ->select(['a.name', 'a.slug', 'a.tag_enc_id'])
                    ->innerJoin(PostTags::tableName() . ' as f', 'f.tag_enc_id = a.tag_enc_id')
                    ->where(['f.post_enc_id' => $post['post_enc_id']])
                    ->asArray()
                    ->all();

            $postMediaModel = new PostMedia();
            $post_media = $postMediaModel->find()->alias('a')
                    ->select(['a.*', 'h.media_type'])
                    ->innerJoin(MediaTypes::tableName() . ' as h', 'h.media_type_enc_id = a.media_type_enc_id')
                    ->where(['a.post_enc_id' => $post['post_enc_id']])
                    ->asArray()
                    ->all();

            $similar_posts = $postsModel->find()->alias('a')
                    ->select(['a.title', 'a.slug', 'a.excerpt', 'a.featured_image', 'a.featured_image_location', 'a.featured_image_alt', 'a.featured_image_title', 'd.name', 'd.tag_enc_id'])
                    ->innerJoin(PostCategories::tableName() . ' as b', 'b.post_enc_id = a.post_enc_id')
                    ->innerJoin(PostTags::tableName() . ' as c', 'c.post_enc_id = a.post_enc_id')
                    ->innerJoin(Tags::tableName() . ' as d', 'd.tag_enc_id = c.tag_enc_id')
                    ->where(['!=', 'a.post_enc_id', $post['post_enc_id']])
                    ->andWhere(['c.tag_enc_id' => $post_tags[0]['tag_enc_id']])
                    ->limit(4)
                    ->orderBy(['a.created_on' => SORT_DESC])
                    ->asArray()
                    ->all();

            $random_posts = $postsModel->find()->alias('a')
                    ->select(['a.title', 'a.slug', 'a.excerpt', 'a.featured_image', 'a.featured_image_location', 'a.featured_image_alt', 'a.featured_image_title', 'a.created_on'])
                    ->innerJoin(PostCategories::tableName() . ' as b', 'b.post_enc_id = a.post_enc_id')
                    ->where(['!=', 'a.post_enc_id', $post['post_enc_id']])
                    ->limit(4)
                    ->orderBy(['a.created_on' => SORT_DESC])
                    ->asArray()
                    ->all();

            return $this->render('detail', [
                        'post' => $post,
                        'post_categories' => $post_categories,
                        'post_tags' => $post_tags,
                        'post_media' => $post_media,
                        'similar_posts' => $similar_posts,
                        'random_posts' => $random_posts,
            ]);
        }
    }

    public function actionCategoryPosts($ctidk) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $postsModel = new Posts();
        if (!empty($ctidk)) {
            $posts = $postsModel->find()
                    ->alias('a')
                    ->distinct()
                    ->select(['a.title', 'CONCAT("' . Url::to('/blog/') . '", a.slug) AS url',
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
                    ->where(['c.slug' => $ctidk, 'a.status' => 'Active', 'a.is_deleted' => 'false'])
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

}
