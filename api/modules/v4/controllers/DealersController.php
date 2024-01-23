<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\FinancerVehicleTypeForm;
use common\models\AssignedFinancerDealers;
use common\models\BankDetails;
use common\models\FinancerVehicleTypes;
use common\models\OrganizationLocations;
use common\models\UserRoles;
use common\models\Users;
use yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

class DealersController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'financer-vehicle-type' => ['POST', 'OPTIONS'],
                'remove-financer-vehicle-type' => ['POST', 'OPTIONS'],
                'get-financer-vehicle-type' => ['POST', 'OPTIONS'],
                'get-dealer-details' => ['POST', 'OPTIONS'],
                'update-bank-details' => ['POST', 'OPTIONS'],
                'add-location' => ['POST', 'OPTIONS'],
                'get-location' => ['POST', 'OPTIONS'],
                'remove-location' => ['POST', 'OPTIONS'],
                'remove-dealer' => ['POST', 'OPTIONS'],
                'index' => ['POST', 'OPTIONS', 'GET'],
                'check-numbers' => ['POST', 'OPTIONS', 'GET'],
                'check-email' => ['POST', 'OPTIONS', 'GET'],
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
        $org_id = $user->organization_enc_id;
        if (!$org_id) {
            $user_roles = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $user_roles->organization_enc_id;
        }


        $financer_list = FinancerVehicleTypes::find()
            ->alias('a')
            ->select([
                'a.financer_vehicle_type_enc_id',
                'a.vehicle_type',
//                '(CASE WHEN a.dealer_type = "0" Then "vehicle" WHEN a.dealer_type = "1" Then "electronics" ELSE NULL END) as dealer_type',
                'CASE WHEN a.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->vehicle_types->icon, 'https') . '", a.icon_location, "/", a.icon) ELSE NULL END icon'
            ])
            ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $org_id])
            ->asArray()
            ->all();

        if ($financer_list) {
            return $this->response(200, ['status' => 200, 'financer_list' => $financer_list]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'Not found']);
    }

    public function actionGetDealerDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['organization_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "organization_enc_id"']);
        }

        $dealer_list = AssignedFinancerDealers::find()
            ->alias('a')
            ->select([
                'a.dealer_enc_id', 'b1.bank_details_enc_id', 'a.assigned_dealer_enc_id', 'c.category',
                "(CASE WHEN c.trade_certificate = 1 THEN 'yes' ELSE 'no' END) as trade_certificate",
                "(CASE WHEN c.dealer_type = 0 THEN 'vehicle' ELSE 'electronics' END) as dealer_type",
                'b1.name', 'b1.bank_name', 'b1.bank_account_number', 'b1.ifsc_code', 'b.name as org_name',
                'e.email', 'e.phone', "CONCAT(e.first_name,' ',COALESCE(e.last_name, '')) as contact_person", 'e.status'
            ])
            ->joinWith(['dealerEnc b' => function ($b) {
                $b->select(['a.assigned_dealer_enc_id']);
                $b->joinWith(['bankDetails b1'], false);
            }], false)
            ->joinWith(['assignedDealerOptions c'], false)
            ->joinWith(['createdBy e' => function ($e) {
                $e->select(['a.assigned_dealer_enc_id']);
            }], false)
            ->andWhere(['a.is_deleted' => 0, 'a.dealer_enc_id' => $params['organization_enc_id']])
            ->asArray()
            ->one();

        if ($dealer_list) {
            $created_by['org_name'] = $dealer_list['org_name'];
            $created_by['category'] = $dealer_list['category'];
            $created_by['dealer_type'] = $dealer_list['dealer_type'];
            $created_by['email'] = $dealer_list['email'];
            $created_by['phone'] = $dealer_list['phone'];
            $created_by['status'] = $dealer_list['status'];
            $created_by['contact_person'] = $dealer_list['contact_person'];
            unset($dealer_list['org_name'], $dealer_list['email'], $dealer_list['phone'], $dealer_list['contact_person'], $dealer_list['status']);

            return $this->response(200, ['status' => 200, 'dealer_bank_details' => $dealer_list, 'dealer_info' => $created_by]);
        }
    }

    public function actionUpdateBankDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['name']) || empty($params['bank_name']) || empty($params['bank_account_number']) || empty($params['ifsc_code'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "name or bank_name or bank_account_number or ifsc_code"']);
        }

        $bank_details = BankDetails::findOne(['bank_details_enc_id' => $params['bank_details_enc_id']]);

        if ($bank_details == null) {
            $bank_details = new BankDetails();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $bank_details->bank_details_enc_id = $utilitiesModel->encrypt();
            $bank_details->created_on = date('Y-m-d H:i:s');
            $bank_details->created_by = $user->user_enc_id;
        }

        $bank_details->name = $params['name'];
        $bank_details->bank_name = $params['bank_name'];
        $bank_details->bank_account_number = $params['bank_account_number'];
        $bank_details->organization_enc_id = $params['organization_enc_id'];
        $bank_details->ifsc_code = $params['ifsc_code'];
        $bank_details->updated_by = $user->user_enc_id;
        $bank_details->updated_on = date('Y-m-d H:i:s');

        if ($bank_details->save()) {
            if ($bank_details->isNewRecord) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved successfully']);
            } else {
                return $this->response(200, ['status' => 200, 'message' => 'Updated successfully']);
            }
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving', 'error' => $bank_details->getErrors()]);
        }
    }

    public function actionAddLocation()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        $updateOperation = !empty($params['location_enc_id']);

        $location = null;

        if ($updateOperation) {
            $location = OrganizationLocations::findOne(['location_enc_id' => $params['location_enc_id']]);

            if ($location == null) {
                return $this->response(404, ['status' => 404, 'message' => 'Location not found for update']);
            }
        } else {
            $location = new OrganizationLocations();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $location->location_enc_id = $utilitiesModel->encrypt();
            $location->created_on = date('Y-m-d H:i:s');
            $location->created_by = $user->user_enc_id;
            $location->organization_enc_id = $params['organization_enc_id'];
        }

        $location->location_name = $params['location_name'];
        $location->address = $params['address'];
        $location->city_enc_id = $params['city_enc_id'];

        $location->location_for = !empty($params['location_for']) ? $params['location_for'] : null;
        $location->last_updated_by = $user->user_enc_id;
        $location->last_updated_on = date('Y-m-d H:i:s');

        if ($location->save()) {
            if ($location->isNewRecord) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved successfully']);
            } else {
                return $this->response(200, ['status' => 200, 'message' => 'Updated successfully']);
            }
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving', 'error' => $location->getErrors()]);
        }
    }


    public function actionGetLocation()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['organization_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "organization_enc_id"']);
        }

        $location_list = OrganizationLocations::find()
            ->alias('a')
            ->select(['a.location_name', 'a.address', 'a.location_enc_id', 'b.name as city_name', 'b.city_enc_id'])
            ->joinWith(['cityEnc b'], false)
            ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $params['organization_enc_id']])
            ->asArray()
            ->all();

        if ($location_list) {
            return $this->response(200, ['status' => 200, 'list' => $location_list]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Not found']);
    }

    public function actionRemoveLocation()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['location_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "location_enc_id"']);
        }

        $remove_location = OrganizationLocations::findOne([
            'location_enc_id' => $params['location_enc_id'],
            'is_deleted' => 0
        ]);

        if ($remove_location) {
            $remove_location->is_deleted = 1;
            $remove_location->last_updated_by = $user->user_enc_id;
            $remove_location->last_updated_on = date('Y-m-d H:i:s');
            if (!$remove_location->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $remove_location->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionRemoveDealer()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['assigned_dealer_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_dealer_enc_id"']);
        }

        $remove_dealer = AssignedFinancerDealers::findOne([
            'assigned_dealer_enc_id' => $params['assigned_dealer_enc_id'],
            'is_deleted' => 0
        ]);

        if ($remove_dealer) {
            $remove_dealer->is_deleted = 1;
            $remove_dealer->updated_by = $user->user_enc_id;
            $remove_dealer->updated_on = date('Y-m-d H:i:s');
            if (!$remove_dealer->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $remove_dealer->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionCheckNumbers()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (!empty($params['phone'])) {
            $phoneNumber = $params['phone'];

            $phoneExists = Users::find()
                ->alias('a')
                ->where([
                    'or',
                    ['a.phone' => $phoneNumber],
                    ['a.phone' => '+91' . $phoneNumber],
                    ['a.phone' => '+' . $phoneNumber],
                    ['a.phone' => preg_replace('/^\+?91/', '', $phoneNumber)],
                    ['a.phone' => preg_replace('/^\+?+/', '', $phoneNumber)],
                    ['a.phone' => '+91' . preg_replace('/^\+?+/', '', $phoneNumber)],
                    ['a.phone' => '+' . $phoneNumber],
                ]);

            $phoneExists = $phoneExists->andWhere(['a.is_deleted' => 0])
                ->exists();

            if ($phoneExists) {
                return $this->response(400, ['status' => 400, 'message' => 'Phone number already exists']);
            } else {
                return $this->response(200, ['status' => 200, 'message' => 'Phone number does not exists']);
            }

        }
    }

    public function actionCheckEmail()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (!empty($params['email'])) {
            $email = $params['email'];

            $emailExists = Users::find()
                ->where(['email' => $email])
                ->andWhere(['is_deleted' => 0])
                ->exists();

            if ($emailExists) {
                return $this->response(400, ['status' => 400, 'message' => 'Email already exists']);
            } else {
                return $this->response(200, ['status' => 200, 'message' => 'Email does not exists']);
            }
        }
    }

    public function actionIndex()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (!$params) {
            $params = $_GET;
        }

        // getting dealer data
        $dealer = $this->dealerList($params);

        if ($dealer) {
            return $this->response(200, ['status' => 200, 'list' => $dealer]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'no record']);
        }
    }

    private function dealerList($params)
    {
        $dealer = AssignedFinancerDealers::find()
            ->alias('a')
            ->select([
                'a.assigned_financer_enc_id', 'a.assigned_dealer_enc_id', 'a.dealer_enc_id', 'a.dealer_enc_id as id',
                "CASE WHEN d.logo IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, "https") . "', d.logo_location, '/', d.logo) ELSE CONCAT('https://ui-avatars.com/api/?name=', d.name, '&size=200&rounded=false&background=', REPLACE(d.initials_color, '#', ''), '&color=ffffff') END logo",
                'c.category', "(CASE WHEN c.trade_certificate = 1 THEN 'yes' ELSE 'no' END) as trade_certificate", "(CASE WHEN c.dealer_type = 0 THEN 'vehicle' ELSE 'electronics' END) as dealer_type",
                'b.username', 'b.email', 'b.phone', 'd.name', "CONCAT(b.first_name,' ',COALESCE(b.last_name, '')) as contact_person", 'b.status', 'c.dealership_date'
         ])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['assignedDealerOptions c'], false)
            ->joinWith(['dealerEnc d'], false)
            ->where(['a.assigned_financer_enc_id' => $params['assigned_financer_enc_id']])
            ->andWhere(['a.is_deleted' => 0, 'b.is_deleted' => 0])
            ->orderby(['a.created_on' => SORT_DESC]);

        if (!empty($params['field_search'])) {
            foreach ($params['field_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'dealership_date') {
                        $dealer->andWhere(['c.' . $key => $value]);
                    } elseif ($key == 'category') {
                        $dealer->andWhere(['like', 'c.' . $key, $value]);
                    } elseif ($key == 'email' || $key == 'phone') {
                        $dealer->andWhere(['or',
                            ['like', 'b.email', $value],
                            ['like', 'b.phone', $value]
                        ]);
                    } elseif ($key == 'username') {
                        $dealer->andWhere(['like', 'b.' . $key, $value]);
                    } elseif ($key == 'contact_person') {
                        $dealer->andWhere(['like', "CONCAT(b.first_name,' ',COALESCE(b.last_name, ''))", $value]);
                    } elseif ($key == 'name') {
                        $dealer->andWhere(['like', 'd.' . $key, $value]);
                    } elseif ($key == 'dealer_type') {
                        $dealer->andWhere(['c.dealer_type' => ($value == 'electronics' ? 1 : 0)]);
                    } else {
                        $dealer->andWhere(['like', $key, $value]);
                    }
                }
            }
        }


        // filter dealer search on dealer name, username, email and phone
        if ($params != null && !empty($params['employee_search'])) {
            $dealer->andWhere([
                'and',
                [
                    'or',
                    ['like', "CONCAT(b.first_name, ' ', b.last_name)", $params['employee_search']],
                    ['like', 'b.username', $params['employee_search']],
                    ['like', 'd.name', $params['employee_search']],
                    ['like', 'b.email', $params['employee_search']],
                    ['like', 'b.phone', $params['employee_search']],
                ],
                ['b.status' => 'active'],
            ]);
        }

        return $dealer->asArray()
            ->all();
    }

}

?>