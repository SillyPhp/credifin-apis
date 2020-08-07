<?php
namespace api\modules\v3\controllers;
use api\modules\v3\models\TokensModel;
use common\models\WebinarSessions;
use yii\widgets\ActiveForm;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
class VideoSessionController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-tokens' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetTokens()
    {
        $params= Yii::$app->request->post();
        $result = new TokensModel();
        $result = $result->getToken($params);
        if ($result) {
            return $this->response(200, $result);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionUpdateSession()
    {
        $session_id = Yii::$app->request->post('session_id');
        $id = Yii::$app->request->post('id');

        $model = WebinarSessions::findOne(['session_enc_id' => $id]);
        $model->session_id = $session_id;
        if ($model->save()) {
            return $this->response(200, $session_id);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionValidateTokens()
    {
        $params= Yii::$app->request->post();
        $result = new TokensModel();
        $result = $result->validateToken($params);
        if ($result) {
            return $this->response(200, $result);
        } else {
            return $this->response(404, 'Not Found');
        }
    }
}