<?php

namespace frontend\controllers;

use common\models\CareerAdvicePostComments;
use common\models\Categories;
use common\models\PostCategories;
use common\models\PostComments;
use common\models\Posts;
use common\models\Users;
use frontend\models\SubscribeNewsletterForm;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\db\Expression;
use common\models\Utilities;
use common\models\CareerAdvisePosts;

class CareerAdviceController extends Controller
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
        $infographicsPosts = $postsModel->find()->alias('a')
            ->select(['a.*', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'd.first_name', 'd.last_name'])
            ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => 'infographics', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC])
            ->limit(2)
            ->asArray()
            ->all();
        $articalsPosts = $postsModel->find()->alias('a')
            ->select(['a.*', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'd.first_name', 'd.last_name', 'a.featured_image_location', 'a.featured_image'])
            ->innerJoin(PostCategories::tableName() . 'as b', 'b.post_enc_id = a.post_enc_id')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Users::tableName() . 'as d', 'd.user_enc_id = a.author_enc_id')
            ->where(['c.slug' => 'articles', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC])
            ->limit(2)
            ->asArray()
            ->all();
        $posts = $postsModel->find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.featured_image_location', 'a.featured_image', 'a.featured_image_alt', 'featured_image_title', 'a.title', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug'])
            ->innerJoinWith(['postCategories b' => function ($b) {
                $b->innerJoinWith(['categoryEnc c' => function($c){
                    $c->onCondition(['c.slug' => 'articles']);
                }], false);
            }], false)
//            ->joinWith(['postTypeEnc d'], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
//            ->andWhere(['<>', 'd.post_type', 'Social'])
            ->orderby(['a.created_on' => SORT_ASC])
            ->limit(8)
            ->asArray()
            ->all();

        $quotes = Posts::find()
            ->alias('a')
            ->select(['a.post_enc_id', '(CASE WHEN a.is_crawled = "0" THEN CONCAT("c/",a.slug) ELSE a.slug END) as slug', 'CONCAT("' . Yii::$app->params->upload_directories->posts->featured_image . '", a.featured_image_location, "/", a.featured_image) image'])
            ->joinWith(['postCategories b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }], false)
            ->joinWith(['postTypeEnc d'], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['c.name' => null])
            ->andWhere(['<>', 'd.post_type', 'Social'])
            ->groupBy(['a.post_enc_id'])
            ->orderby(new Expression('rand()'))
            ->limit(6)
            ->asArray()
            ->all();
        return $this->render('index', [
            'posts' => $posts,
            'quotes' => $quotes,
            'infographicsPosts' => $infographicsPosts,
            'articalsPosts' => $articalsPosts,
        ]);
    }

    public function actionDetail($category)
    {
        $careerBlog = CareerAdvisePosts::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.description', 'a.link', 'c.slug category', 'c.name cat', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image) . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
            ->joinWith(['assignedCategoryEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }
            ], false)
            ->where([
                'a.status' => 1,
                'c.slug' => $category
            ])
            ->limit(12)
            ->asArray()
            ->all();

        if ($careerBlog) {
            return $this->render("detail", [
                'careerBlog' => $careerBlog,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
    }

    public function actionBlogDetail($category, $slug)
    {
        $careerDetail = CareerAdvisePosts::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.created_on', 'c.category_enc_id', 'a.assigned_category_enc_id', 'a.description', 'a.link', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image) . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
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
            ->select(['a.title', 'a.slug', 'a.created_on', 'a.link', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image) . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
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

        $newsletterForm = new SubscribeNewsletterForm();
        return $this->render('blog-detail', [
            'newsletterForm' => $newsletterForm,
            'careerDetail' => $careerDetail,
            'relatedArticles' => $relatedArticles,
        ]);
    }

    public function actionGetParentComments()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $q = Yii::$app->request->post('param');

            $post = CareerAdvisePosts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $result = CareerAdvicePostComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => NULL])
                ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($result as $r) {
                $a = CareerAdvicePostComments::find()
                    ->where(['reply_to' => $r['comment_enc_id']])
                    ->andWhere(['post_enc_id' => $post['post_enc_id']])
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

            $post = CareerAdvisePosts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $result = CareerAdvicePostComments::find()
                ->alias('a')
                ->select(['a.comment_enc_id', 'a.comment reply', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'b.initials_color color', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END img'])
                ->joinWith(['userEnc b'], false)
                ->where(['a.reply_to' => $parent])
                ->andWhere(['a.post_enc_id' => $post['post_enc_id']])
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

            $post = CareerAdvisePosts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            if ($a = $this->saveComment($comment, $post['post_enc_id'], $current_user, NULL)) {
                $user_info = [
                    'logo' => Yii::$app->user->identity->image,
                    'username' => Yii::$app->user->identity->username,
                    'path' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image,
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

            $post = CareerAdvisePosts::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            if ($a = $this->saveComment($comment, $post['post_enc_id'], $current_user, $reply_id)) {
                $user_info = [
                    'logo' => Yii::$app->user->identity->image,
                    'username' => Yii::$app->user->identity->username,
                    'path' => Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image,
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
            return $commentModel->comment_enc_id;
        } else {
            return false;
        }
    }
}