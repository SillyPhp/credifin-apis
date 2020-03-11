<?php

namespace api\modules\v3\controllers;

class JobController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list-companies' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionCreate()
    {

        if (Yii::$app->request->isPost) {
            $user_id = Yii::$app->request->post('user_id');
            $org_id = Yii::$app->request->post('org_id');
        }
    }
}