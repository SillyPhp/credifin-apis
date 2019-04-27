<?php

namespace frontend\controllers\learning;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use frontend\models\learning\VideoForm;

class VideosController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['submit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSubmit()
    {
        $this->layout = 'main-secondary';

        $learningCornerFormModel = new VideoForm();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $learningCornerFormModel->load(Yii::$app->request->post());
            return ActiveForm::validate($learningCornerFormModel);
        }

        if ($learningCornerFormModel->load(Yii::$app->request->post()) && $learningCornerFormModel->validate()) {
            if ($learningCornerFormModel->save()) {
                Yii::$app->session->setFlash('success', 'Your video is submitted successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
            }
        }

        return $this->render('submit', [
            'learningCornerFormModel' => $learningCornerFormModel,
        ]);
    }

}