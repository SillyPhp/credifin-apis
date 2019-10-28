<?php

namespace frontend\controllers;

use frontend\models\SubscribeNewsletterForm;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\HttpException;
use common\models\CareerAdvisePosts;

class CareerAdviceController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->requestedRoute);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDetail($slug)
    {
        $careerBlog = CareerAdvisePosts::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.description', 'a.link', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image) . '", a.image_location, "/", a.image) ELSE CONCAT("' . Url::to('@eyAssets/images/pages/locations/goa.png') . '") END image'])
            ->joinWith(['assignedCategoryEnc b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
            }
            ], false)
            ->where([
                'a.status' => 1,
                'c.slug' => $slug
            ])
            ->limit(6)
            ->asArray()
            ->all();

        if ($careerBlog) {
            return $this->render("detail", [
                'careerBlog' => $careerBlog
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
    }

    public function actionCareerBlogDetail(){
        $newsletterForm = new SubscribeNewsletterForm();
        return $this->render('career-blog-detail',[
            'newsletterForm' =>  $newsletterForm
        ]);
    }
}