<?php


namespace api\modules\v1\controllers;


use api\modules\v1\models\Candidates;
use common\models\CareerAdvicePostComments;
use common\models\CareerAdvisePosts;
use common\models\Categories;
use common\models\PostCategories;
use common\models\PostComments;
use common\models\Posts;
use common\models\PostTags;
use common\models\Tags;
use common\models\UserAccessTokens;
use common\models\Users;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use common\models\Utilities;
use yii\filters\auth\HttpBearerAuth;

class BlogsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'blogs-home',
                'post-details',
                'get-blog-child-comments',
                'blog-list',
                'get-posts-by-tag'
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'blogs-home' => ['POST'],
                'post-details' => ['POST'],
                'blog-list' => ['POST'],
                'get-blog-child-comments' => ['POST'],
                'save-parent-comment' => ['POST'],
                'save-child-comment' => ['POST'],
                'get-posts-by-tag' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user;
    }

    public function actionBlogsHome()
    {
        $featured = Posts::find()
            ->select(['title', 'slug', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", featured_image_location, "/", featured_image) image'])
            ->where(['status' => 'Active', 'is_deleted' => 0])
            ->orderby(['created_on' => SORT_ASC])
            ->limit(8)
            ->asArray()
            ->all();

        $popular_posts = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.title', 'a.slug','c.name', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) image'])
            ->innerJoinWith(['postCategories b' => function ($b) {
                $b->innerJoinWith(['categoryEnc c'], false);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['not', ['c.name' => 'Infographics']])
            ->andWhere(['not', ['c.name' => 'Quotes']])
            ->groupBy(['a.post_enc_id'])
            ->orderby(new Expression('rand()'))
            ->limit(3)
            ->asArray()
            ->all();

        $exclusions = [];

        foreach ($popular_posts as $p) {
            array_push($exclusions, $p['post_enc_id']);
        }

        $whats_new_posts = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.title', 'a.slug','c.name', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) image'])
            ->innerJoinWith(['postCategories b' => function ($b) {
                $b->innerJoinWith(['categoryEnc c'], false);
            }], false)
            ->where(['not in', 'a.post_enc_id', $exclusions])
            ->andWhere(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['not', ['c.name' => 'Infographics']])
            ->andWhere(['not', ['c.name' => 'Quotes']])
            ->groupBy(['a.post_enc_id'])
            ->orderby(new Expression('rand()'))
            ->limit(3)
            ->asArray()
            ->all();

        foreach ($whats_new_posts as $w) {
            array_push($exclusions, $w['post_enc_id']);
        }

        $trending_posts = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.title', 'a.slug','c.name', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) image'])
            ->innerJoinWith(['postCategories b' => function ($b) {
                $b->innerJoinWith(['categoryEnc c'], false);
            }], false)
            ->where(['not in', 'a.post_enc_id', $exclusions])
            ->andWhere(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['not', ['c.name' => 'Infographics']])
            ->andWhere(['not', ['c.name' => 'Quotes']])
            ->groupBy(['a.post_enc_id'])
            ->orderby(new Expression('rand()'))
            ->limit(3)
            ->asArray()
            ->all();

        $data = [];
        $data['featured'] = $featured;
        $data['popular'] = $popular_posts;
        $data['whats_new'] = $whats_new_posts;
        $data['trending'] = $trending_posts;

        if (!empty($data)) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionPostDetails()
    {

        $params = Yii::$app->request->post();
        $is_crawled = 1;

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        $post = Posts::find()->alias('a')
            ->select(['a.*', 'CONCAT(f.first_name, " ", f.last_name) name', 'f.description user_about', 'f.initials_color','CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", f.image_location, "/", f.image) image'])
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
            ->where([
                'a.slug' => $slug,
                'a.status' => 'Active',
//                'is_crawled' => $is_crawled,
                'a.is_deleted' => 0,
            ])
            ->asArray()
            ->one();


        $comments = PostComments::find()
            ->alias('a')
            ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
            ->joinWith(['userEnc b'], false)
            ->where(['a.reply_to' => NULL])
            ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $i = 0;
        foreach ($comments as $r) {
            $a = PostComments::find()
                ->where(['reply_to' => $r['comment_enc_id']])
                ->andWhere(['post_enc_id' => $post['post_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->exists();
            if ($a) {
                $comments[$i]['hasChild'] = true;
            } else {
                $comments[$i]['hasChild'] = false;
            }
            $i++;
        }

        if (!empty($comments)) {
            $post['comments'] = $comments;
        }

        if ($post) {
            $similar_posts = Posts::find()->alias('a')
                ->select(['a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'a.excerpt', 'a.featured_image', 'a.featured_image_location', 'a.featured_image_alt', 'a.featured_image_title', 'd.name', 'd.tag_enc_id'])
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

            $data = [];
            $data['post_detail'] = $post;
            $data['related_posts'] = $similar_posts;

            return $this->response(200, $data);

        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionBlogList()
    {

        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        if (isset($params['page'])) {
            $page = (int)$params['page'];
        } else {
            $page = 1;
        }

        if($params['limit']){
            $limit = (int)$params['limit'];
        }else{
            $limit = 3;
        }

        $posts = Posts::find()->alias('a')
            ->select(['a.title','CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) image', 'a.slug'])
            ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if (!empty($posts)) {
            return $this->response(200, $posts);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionGetBlogChildComments()
    {
        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        if (isset($params['comment_enc_id']) && !empty($params['comment_enc_id'])) {
            $parent = $params['comment_enc_id'];
        } else {
            return $this->response(422, 'missing information');
        }

        $post = Posts::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 'Active'])
            ->andWhere(['is_deleted' => 0])
            ->one();

        $child_comment = PostComments::find()
            ->alias('a')
            ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END img'])
            ->joinWith(['userEnc b'], false)
            ->where(['a.reply_to' => $parent])
            ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if (!empty($child_comment)) {
            return $this->response(200, $child_comment);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionSaveParentComment()
    {
        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        if (isset($params['comment']) && !empty($params['comment'])) {
            $comment = $params['comment'];
        } else {
            return $this->response(422, 'missing information');
        }

        $current_user = $this->userId();
        $current_user = $current_user->user_enc_id;

        $post = Posts::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 'Active'])
            ->andWhere(['is_deleted' => 0])
            ->one();

        if ($this->saveComment($comment, $post['post_enc_id'], $current_user, NULL)) {
            return $this->response(200,'saved');
        } else {
            return $this->response(500,'an error occured');
        }


    }

    public function actionSaveChildComment()
    {
        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        if (isset($params['comment']) && !empty($params['comment'])) {
            $comment = $params['comment'];
        } else {
            return $this->response(422, 'missing information');
        }

        if (isset($params['comment_enc_id']) && !empty($params['comment_enc_id'])) {
            $reply_id = $params['comment_enc_id'];
        } else {
            return $this->response(422, 'missing information');
        }


        $current_user = $this->userId();
        $current_user = $current_user->user_enc_id;
            $post = Posts::find()
                ->where(['slug' => $slug])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->one();

            if ($this->saveComment($comment, $post['post_enc_id'], $current_user, $reply_id)) {
               return $this->response(200,'save');
            } else {
                return $this->response(500,'an error occurred');
            }
    }

    private function saveComment($comment, $post_enc_id, $current_user, $reply_id = NULL)
    {
        $commentModel = new PostComments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $commentModel->comment_enc_id = $utilitiesModel->encrypt();
        $commentModel->comment = $comment;
        $commentModel->reply_to = $reply_id;
        $commentModel->post_enc_id = $post_enc_id;
        $commentModel->user_enc_id = $current_user;
        $commentModel->created_on = date('Y-m-d H:i:s');
        if ($commentModel->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function actionGetPostsByTag()
    {
        $params = Yii::$app->request->post();

        if (isset($params['tag']) && !empty($params['tag'])) {
            $tag = $params['tag'];
        } else {
            return $this->response(422, 'missing information');
        }

        if (isset($params['page'])) {
            $page = (int)$params['page'];
        } else {
            $page = 1;
        }

        if($params['limit']){
            $limit = (int)$params['limit'];
        }else{
            $limit = 3;
        }

        $postsModel = new Posts();
        $posts = $postsModel->find()->alias('a')
            ->select(['a.slug','a.title','a.excerpt','a.description','CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.featured_image_location, "/", a.featured_image) image'])
            ->innerJoin(PostTags::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Tags::tableName() . 'as c', 'c.tag_enc_id = b.tag_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => $tag, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if($posts){
            return $this->response(200,$posts);
        }else{
            return $this->response(404,'not found');
        }
    }
}