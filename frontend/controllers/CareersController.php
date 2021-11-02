<?php

namespace frontend\controllers;

use common\models\EmployerApplications;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\models\applications\ApplicationCards;

class CareersController extends Controller
{

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            $options = [];
            $options['for_careers'] = 1;
            if ($type == 'Jobs') {
                $cards = ApplicationCards::jobs($options);
            } else {
                $cards = ApplicationCards::internships($options);
            }
            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }

        $jobs_cnt = EmployerApplications::find()
            ->alias('a')
            ->joinWith(['applicationTypeEnc j'])
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['a.application_for' => 1, 'a.for_careers' => 1])
            ->count();

        $internships_cnt = EmployerApplications::find()
            ->alias('a')
            ->joinWith(['applicationTypeEnc j'])
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['a.application_for' => 1, 'a.for_careers' => 1])
            ->count();

        return $this->render('index', ['jobs_count' => $jobs_cnt, 'internships_count' => $internships_cnt]);
    }
}