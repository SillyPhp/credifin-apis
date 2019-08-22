<?php

namespace frontend\controllers\learning;

use common\models\LearningVideos;
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
                    'only' => ['submit'],
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

    public function actionSearch($type, $slug){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $result = null;
            if ($type === "category") {
                $result = LearningVideos::find()
                    ->alias('a')
                    ->joinWith(['assignedCategoryEnc b' => function ($x) {
                        $x->joinWith(['parentEnc c'], false);
                    }], false)
                    ->where(['c.slug' => $slug])
                    ->andWhere(['b.assigned_to' => 'Videos'])
                    ->andWhere(['b.status' => 'Approved'])
                    ->andWhere(['b.is_deleted' => 0])
                    ->andWhere(['a.status' => 1])
                    ->andWhere(['a.is_deleted' => 0])
                    ->asArray()
                    ->all();
//                print_r($result);
//                exit();
            } elseif ($type == "topic") {
                $result = LearningVideos::find()
                    ->alias('a')
                    ->joinWith(['tagEncs b'])
                    ->where(['b.slug' => $slug])
                    ->andWhere(['a.status' => 1])
                    ->andWhere(['a.is_deleted' => 0])
                    ->asArray()
                    ->all();

            }
            if (!empty($result)) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'video_gallery' => $result,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;

        }
        return $this->render('video-gallery');
    }

}