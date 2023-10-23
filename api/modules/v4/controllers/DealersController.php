<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\FinancerVehicleTypeForm;
use common\models\FinancerVehicleTypes;
use common\models\SharedLoanApplications;
use common\models\UserRoles;
use common\models\UserTypes;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\helpers\Url;

use yii;

class DealersController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'financer-vehicle-type' => ['POST', 'OPTIONS'],
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

    public function actionFinancerVehicleType()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $model = new FinancerVehicleTypeForm();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstanceByName('icon_image');
            if ($model->validate()) {
                $organization_id = $model->organization_enc_id;
                $vehicle_type = $model->vehicleType($user, Yii::$app->request->post('organization_enc_id'));
                if ($vehicle_type['status'] == 201) {
                    return $this->response(201, $vehicle_type);
                } else {
                    return $this->response(500, $vehicle_type);
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
            }
        } else {
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        }
    }

    public function actionRemoveFinancerVehicleType()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['financer_vehicle_type_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_vehicle_type_enc_id"']);
        }

        $financer_type = FinancerVehicleTypes::findOne([
            'financer_vehicle_type_enc_id' => $params['financer_vehicle_type_enc_id'],
            'is_deleted' => 0
        ]);

        if ($financer_type) {
            $financer_type->is_deleted = 1;
            $financer_type->updated_by = $user->user_enc_id;
            $financer_type->updated_on = date('Y-m-d H:i:s');
            if (!$financer_type->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $financer_type->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionGetFinancerVehicleType()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $financer_list = FinancerVehicleTypes::find()
            ->alias('a')
            ->select([
                'a.financer_vehicle_type_enc_id',
                'a.vehicle_type',
//                '(CASE WHEN a.dealer_type = "0" Then "vehicle" WHEN a.dealer_type = "1" Then "electronics" ELSE NULL END) as dealer_type',
                'CASE WHEN a.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->vehicle_types->icon, 'https') . '", a.icon_location, "/", a.icon) ELSE NULL END icon'
            ])
            ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $user->organization_enc_id])
            ->asArray()
            ->all();

        if ($financer_list) {
            return $this->response(200, ['status' => 200, 'financer_list' => $financer_list]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'Not found']);
    }

    public function actionDealerSearch($dealer_search, $type, $loan_id = null)
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();

        $params['dealer_search'] = $dealer_search;
        $params['type'] = $type;
        $params['loan_id'] = $loan_id;

        $lender = $this->getFinancerId($user);

        // if lender not found
        if (!$lender) {
            return $this->response(404, ['status' => 404, 'message' => 'lender not found']);
        }

        // getting employee list already assigned to this loan_id
        $already_exists = UserTypes::find()
            ->select(['user_type'])
            ->where(['is_deleted' => 0, 'loan_app_enc_id' => $loan_id])
            ->asArray()
            ->all();

        // extracting shared to ids
        $already_exists_ids = [];
        if ($already_exists) {
            foreach ($already_exists as $e) {
                $already_exists_ids[] = $e['shared_to'];
            }
        }

        // assigning already exists in params
        $params['alreadyExists'] = $already_exists_ids;

        // getting employees list
        $employees = $this->employeesList($lender, $params);

        // if type employees
        if ($params['type'] == 'employees') {

            // if employees exists
            if ($employees) {

                // looping employees
                foreach ($employees as $key => $val) {

                    // adding lead_by and managed_by = false in employees
                    $employees[$key]['lead_by'] = $loan_id != null && $val['user_enc_id'] == LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']])->lead_by;
                    $employees[$key]['managed_by'] = $loan_id != null && $val['user_enc_id'] == LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']])->managed_by;
                    $employees[$key]['id'] = $val['user_enc_id'];
                    $employees[$key]['name'] = $val['first_name'] . ' ' . $val['last_name'];
                }
            }
        }

        return $this->response(200, ['status' => 200, 'list' => $employees]);
    }

}


?>