<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\helpers\Url;
use common\models\Posts;
use common\models\PostTags;
use common\models\PostCategories;
use common\models\Users;
use common\models\Tags;
use common\models\Categories;
use common\models\PostComments;

class BlogController extends Controller
{

    public function actionIndex()
    {
        $postsModel = new Posts();
        $posts = $postsModel->find()
            ->where(['status' => 'Active', 'is_deleted' => 0])
            ->orderby(['created_on' => SORT_ASC])
            ->limit(8)
            ->asArray()
            ->all();
        return $this->render('blog-main', [
            'posts' => $posts,
        ]);
    }

//    public function actionIndex()
//    {
//        $postsModel = new Posts();
//        $posts = $postsModel->find()
//            ->where(['status' => 'Active', 'is_deleted' => 'false'])
//            ->orderby(['created_on' => SORT_ASC])
//            ->limit(4)
//            ->asArray()
//            ->all();
//        $quotes = $postsModel->find()->alias('a')
//            ->select(['a.*', 'd.first_name', 'd.last_name'])
//            ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
//            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
//            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
//            ->where(['c.slug' => 'quotes', 'a.status' => 'Active', 'a.is_deleted' => 'false'])
//            ->orderby(['created_on' => SORT_DESC])
//            ->asArray()
//            ->all();
//        $similar_posts = $postsModel->find()
//            ->limit(4)
//            ->orderBy(['created_on' => SORT_DESC])
//            ->asArray()
//            ->all();
//
//        return $this->render('index', [
//            'posts' => $posts,
//            'quotes' => $quotes,
//            'similar_posts' => $similar_posts,
//        ]);
//    }

    public function actionDetail($slug)
    {
        $postsModel = new Posts();
        $post = $postsModel->find()->alias('a')
            ->select(['a.*', 'CONCAT(f.first_name, " ", f.last_name) name', 'f.description user_about', 'f.image', 'f.image_location', 'f.initials_color'])
            ->joinWith(['postCategories b' => function ($b) {
                $b->select(['b.post_enc_id', 'b.category_enc_id']);
                $b->joinWith(['categoryEnc c' => function ($y) {
                    $y->select(['c.category_enc_id', 'c.name', 'c.slug']);
                }]);
            }])
            ->joinWith(['postTags d' => function ($b) {
                $b->select(['d.post_enc_id', 'd.tag_enc_id']);
                $b->joinWith(['tagEnc e' => function ($z) {
                    $z->select(['e.tag_enc_id', 'e.name', 'e.slug']);
                }]);
            }])
            ->leftJoin(Users::tablename() . ' as f', 'f.user_enc_id = a.author_enc_id')
            ->where(['a.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($post) {
            $similar_posts = $postsModel->find()->alias('a')
                ->select(['a.title', 'a.slug', 'a.excerpt', 'a.featured_image', 'a.featured_image_location', 'a.featured_image_alt', 'a.featured_image_title', 'd.name', 'd.tag_enc_id'])
                ->innerJoin(PostCategories::tableName() . ' as b', 'b.post_enc_id = a.post_enc_id')
                ->innerJoin(PostTags::tableName() . ' as c', 'c.post_enc_id = a.post_enc_id')
                ->innerJoin(Tags::tableName() . ' as d', 'd.tag_enc_id = c.tag_enc_id')
                ->where(['!=', 'a.post_enc_id', $post['post_enc_id']])
                ->andWhere(['c.tag_enc_id' => $post['postTags'][0]['tag_enc_id'],
                    'a.status' => 'Active', 'a.is_deleted' => 0])
                ->limit(3)
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            return $this->render('detail', [
                'post' => $post,
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
            ->select(['a.*', 'd.first_name', 'd.last_name'])
            ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($posts) {
            return $this->render('posts-by-category', [
                'posts' => $posts,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionBlogList()
    {
        $postsModel = new Posts();
        $posts = $postsModel->find()
            ->where(['status' => 'Active', 'is_deleted' => 0])
            ->orderby(['created_on' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->render('blog-list', [
            'posts' => $posts,
        ]);
    }

    public function actionGetPostsByTag($slug)
    {
        $postsModel = new Posts();
        $posts = $postsModel->find()->alias('a')
            ->select(['a.*', 'd.first_name', 'd.last_name'])
            ->innerJoin(PostTags::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Tags::tableName() . 'as c', 'c.tag_enc_id = b.tag_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
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
        $postsModel = new Posts();
        if (!empty($slug)) {
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
                ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
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

    public function actionGetParentComments()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $q = Yii::$app->request->post('param');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $result = PostComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => NULL])
                ->andWhere(['a.post_enc_d' => $post['post_enc_d']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($result as $r) {
                $a = PostComments::find()
                    ->where(['reply_to' => $r['comment_enc_id']])
                    ->andWhere(['post_enc_d' => $post['post_enc_d']])
                    ->andWhere(['is_deleted' => 0])
                    ->exists();
                if ($a) {
                    $result[$i]['hasChild'] = true;
                } else {
                    $result[$i]['hasChild'] = false;
                }
                $i++;
            }

            return [
                'status' => 200,
                'result' => $result
            ];
        }
    }

    public function actionGetChildComments()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $q = Yii::$app->request->post('param');
            $parent = Yii::$app->request->post('parent');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $result = PostComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => $parent])
                ->andWhere(['a.post_enc_d' => $post['post_enc_d']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            return [
                'status' => 200,
                'result' => $result
            ];
        }
    }

    public function actionParentComment()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $comment = Yii::$app->request->post('comment');
            $q = Yii::$app->request->post('param');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            if ($a = $this->saveComment($comment, $post['post_enc_d'], $current_user, NULL)) {
                $user_info = [
                    'logo' => Yii::$app->user->identity->image,
                    'username' => Yii::$app->user->identity->username,
                    'path' => Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image,
                    'color' => Yii::$app->user->identity->initials_color,
                    'name' => Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name,
                    'comment_enc_id' => $a
                ];
                return [
                    'status' => 200,
                    'user_info' => $user_info
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }

        }

    }

    public function actionChildComment()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $comment = Yii::$app->request->post('reply');
            $reply_id = Yii::$app->request->post('parent_id');
            $q = Yii::$app->request->post('param');

            $post = Posts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            if ($a = $this->saveComment($comment, $post['post_enc_d'], $current_user, $reply_id)) {
                $user_info = [
                    'logo' => Yii::$app->user->identity->image,
                    'username' => Yii::$app->user->identity->username,
                    'path' => Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image,
                    'color' => Yii::$app->user->identity->initials_color,
                    'name' => Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name,
                    'comment_enc_id' => $a
                ];
                return [
                    'status' => 200,
                    'user_info' => $user_info
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
        }
    }

    private function saveComment($comment, $post_enc_d, $current_user, $reply_id = NULL)
    {
        $commentModel = new PostComments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $commentModel->comment_enc_id = $utilitiesModel->encrypt();
        $commentModel->comment = $comment;
        $commentModel->reply_to = $reply_id;
        $commentModel->post_enc_d = $post_enc_d;
        $commentModel->user_enc_id = $current_user;
        $commentModel->created_on = date('Y-m-d H:i:s');
        if ($commentModel->save()) {
            return $commentModel->comment_enc_id;
        } else {
            return false;
        }
    }

}