<?php

namespace frontend\controllers\organizations;

use common\models\Organizations;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class ReviewsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionOrganizationReviews($slug)
    {
        //main review pppost
    }

    public function actionSearch($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Organizations::find()
                  ->select(['name','slug','CASE WHEN logo IS NULL OR logo = "" THEN "' . Url::to('@commonAssets/categories/enterprise.png') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",logo_location, "/", logo) END logo','business_activity'])
                  ->where('name LIKE "%' . $query . '%"')
                  ->joinWith(['businessActivityEnc'],false)
                  ->limit(20)
                  ->asArray()
                  ->all();

        return $data;
    }

}

