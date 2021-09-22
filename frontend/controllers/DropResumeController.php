<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\OrganizationAssignedCategories;

class DropResumeController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionCheckResume()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $slug = Yii::$app->request->post('slug');

            $cv_exists = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['b.slug' => $slug])
                ->exists();

            if ($cv_exists) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'yes',
                ];
            } else {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'no',
                ];
            }
        }
    }

    public function actionIndex(){
        $refer = explode('/', Yii::$app->request->referrer);
        if(Yii::$app->user->identity->organization || $refer[3] == 'employers' ){
            return $this->render('drop-resume-companies');
        }else{
            return $this->render('drop-resume-landing-page');
        }
    }

}