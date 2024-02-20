<?php

namespace api\modules\v4\controllers;

use common\models\EmployeeIncentivePoints;
use common\models\Utilities;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class EmployeeIncentivePointsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'add-incentive-points' => ['POST', 'OPTIONS'],
                'get-incentive-points' => ['POST', 'OPTIONS'],
                'get-incentive-sum' => ['POST', 'OPTIONS'],
                'delete-incentive-points' => ['POST', 'OPTIONS'],
                'update-incentive-points' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionAddIncentivePoints()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }

        $params = Yii::$app->request->post();

        $incentivePoints = new EmployeeIncentivePoints();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $incentivePoints->points_enc_id = $utilitiesModel->encrypt();
        $incentivePoints->user_enc_id = $params['employee'];
        $incentivePoints->loan_app_enc_id = $params['loan_app_enc_id'];
        $incentivePoints->points = $params['points_type'] === 'others' ? $params['points_type_others'] : $params['points_type'];
        $incentivePoints->points_value = $params['points_value'];
        $incentivePoints->created_by = $user->user_enc_id;
        $incentivePoints->created_on = date('Y-m-d H:i:s');
        if (!$incentivePoints->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving', 'error' => $incentivePoints->getErrors()]);
        }


        return $this->response(200, ['status' => 200, 'message' => 'Saved successfully']);

    }

    public function actionGetIncentivePoints()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
        }

        $incentivePoints = EmployeeIncentivePoints::find()
            ->alias('a')
            ->select(['a.points_enc_id', 'a.loan_app_enc_id', 'a.user_enc_id', 'a.points', 'a.points_value',
                "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) employee"])
            ->joinWith(['userEnc b'], false)
            ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        if ($incentivePoints) {
            return $this->response(200, ['status' => 200, 'incentivePoints' => $incentivePoints]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
    }

    public function actionGetIncentiveSum()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $currentMonth = date('m');
        $currentYear = date('Y');

        $user_id = $user->user_enc_id;
        $incentive_sum = EmployeeIncentivePoints::find()
            ->alias('a')
            ->select(['SUM(a.points_value) as total'])
            ->where(['a.user_enc_id' => $user_id, 'MONTH(a.created_on)' => $currentMonth, 'YEAR(a.created_on)' => $currentYear, 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($incentive_sum && isset($incentive_sum['total'])) {
            return $this->response(200, ['status' => 200, 'data' => $incentive_sum['total']]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
    }


    public function actionDeleteIncentivePoints()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['points_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "points_id"']);
        }

        $incentivePoints = EmployeeIncentivePoints::findOne(['points_enc_id' => $params['points_id']]);
        if ($incentivePoints) {
            $incentivePoints->is_deleted = 1;
            $incentivePoints->updated_by = $user->user_enc_id;
            $incentivePoints->updated_on = date('Y-m-d h:i:s');
            if (!$incentivePoints->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving', 'error' => $incentivePoints->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);

        }
    }

    public function actionUpdateIncentivePoints()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['points_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "points_enc_id"']);
        }

        $incentivePoints = EmployeeIncentivePoints::findOne(['points_enc_id' => $params['points_enc_id']]);
        $incentivePoints->points = $params['points_type'] === 'others' ? $params['points_type_others'] : $params['points_type'];
        $incentivePoints->points_value = $params['points_value'];
        $incentivePoints->updated_by = $user->user_enc_id;
        $incentivePoints->updated_on = date('Y-m-d h:i:s');
        if (!$incentivePoints->update()) {
            return $this->response(500, ['status' => 500, 'message' => 'An error occurred while updating', 'error' => $incentivePoints->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
    }
}