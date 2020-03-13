<?php


namespace api\modules\v1\controllers;


use api\modules\v1\models\Candidates;
use common\models\CareerAdvicePostComments;
use common\models\CareerAdvisePosts;
use common\models\UserAccessTokens;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use common\models\Utilities;
use yii\filters\auth\HttpBearerAuth;

class CareerAdviceController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'career-blogs',
                'blog-detail',
                'get-parent-comments',
                'get-child-comments',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'career-blogs' => ['POST'],
                'blog-detail' => ['POST'],
                'get-parent-comments' => ['POST'],
                'get-child-comments' => ['POST'],
                'save-parent-comment' => ['POST'],
                'save-child-comment' => ['POST'],
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

    public function actionCareerBlogs()
    {

        $params = Yii::$app->request->post();
        if (isset($params['category']) && !empty($params['category'])) {
            $category = $params['category'];
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


        $careerBlog = CareerAdvisePosts::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.description', 'a.link', 'c.slug category', 'c.name cat', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
            ->joinWith(['assignedCategoryEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }
            ], false)
            ->where([
                'a.status' => 1,
                'c.slug' => $category
            ])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();


        if ($careerBlog) {
            return $this->response(200, $careerBlog);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionBlogDetail()
    {
        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        $careerDetail = CareerAdvisePosts::find()
            ->alias('a')
            ->select(['a.title', 'a.post_enc_id', 'a.slug', 'a.created_on', 'c.category_enc_id', 'a.assigned_category_enc_id', 'a.description', 'a.link', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
            ->joinWith(['assignedCategoryEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->where([
                'a.slug' => $slug
            ])
            ->asArray()
            ->one();

        $relatedArticles = CareerAdvisePosts::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.created_on', 'a.link', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
            ->joinWith(['assignedCategoryEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->where([
                'a.status' => 1,
                'c.category_enc_id' => $careerDetail['category_enc_id']
            ])
            ->andwhere(['<>', 'a.assigned_category_enc_id', $careerDetail['assigned_category_enc_id']])
            ->limit(3)
            ->asArray()
            ->all();

        if (!empty($careerDetail) && !empty($relatedArticles)) {
            $data = [
                'blog-detail' => $careerDetail,
                'related-articles' => $relatedArticles
            ];
            return $this->response(200, $data);
        } elseif (!empty($careerDetail)) {
            return $this->response(200, $careerDetail);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionGetChildComments()
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

        $post = CareerAdvisePosts::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 1])
            ->andWhere(['is_deleted' => 0])
            ->one();

        $child_comment = CareerAdvicePostComments::find()
            ->alias('a')
            ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image,'https') . '", b.image_location, "/", b.image) ELSE NULL END img'])
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

    public function actionGetParentComments()
    {
        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        $post = CareerAdvisePosts::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 1])
            ->andWhere(['is_deleted' => 0])
            ->one();

        $comments = CareerAdvicePostComments::find()
            ->alias('a')
            ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END img'])
            ->joinWith(['userEnc b'], false)
            ->where(['a.reply_to' => NULL])
            ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $i = 0;
        foreach ($comments as $r) {
            $a = CareerAdvicePostComments::find()
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
            return $this->response(200, $comments);
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

        $post = CareerAdvisePosts::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 1])
            ->andWhere(['is_deleted' => 0])
            ->one();

        if ($this->saveComment($comment, $post['post_enc_id'], $current_user, NULL)) {
            return $this->response(200, 'saved');
        } else {
            return $this->response(500, 'an error occurred');
        }

    }

    public function actionSaveChildComment()
    {

        $params = Yii::$app->request->post();

        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information 1');
        }

        if (isset($params['comment']) && !empty($params['comment'])) {
            $comment = $params['comment'];
        } else {
            return $this->response(422, 'missing information 2');
        }

        if (isset($params['comment_enc_id']) && !empty($params['comment_enc_id'])) {
            $reply_id = $params['comment_enc_id'];
        } else {
            return $this->response(422, 'missing information 3');
        }


        $current_user = $this->userId();
        $current_user = $current_user->user_enc_id;

        $post = CareerAdvisePosts::find()
            ->where(['slug' => $slug])
            ->andWhere(['status' => 1])
            ->andWhere(['is_deleted' => 0])
            ->one();


        if ($this->saveComment($comment, $post['post_enc_id'], $current_user, $reply_id)) {
            return $this->response(200, 'saved');
        } else {
            return $this->response(500, 'an error occurred');
        }
    }

    private function saveComment($comment, $post_enc_id, $current_user, $reply_id = NULL)
    {
        $commentModel = new CareerAdvicePostComments();
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

}