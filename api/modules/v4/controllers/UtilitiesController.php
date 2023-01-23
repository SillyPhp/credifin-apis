<?php

namespace api\modules\v4\controllers;

use common\models\AssignedFinancerLoanType;
use common\models\AssignedLoanProvider;
use common\models\BillDetails;
use common\models\Cities;
use common\models\Designations;
use common\models\LoanStatus;
use common\models\OrganizationTypes;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
use common\models\UserRoles;
use common\models\Users;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use common\models\Utilities;

class UtilitiesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'organization-types' => ['GET', 'OPTIONS'],
                'designations' => ['GET', 'OPTIONS'],
                'states' => ['GET', 'OPTIONS'],
                'cities' => ['GET', 'OPTIONS'],
                'search-cities' => ['GET', 'OPTIONS'],
                'file-upload' => ['POST', 'OPTIONS'],
                'move-data' => ['GET', 'OPTIONS'],
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

    public function actionOrganizationTypes()
    {
        $org_types = OrganizationTypes::find()
            ->select(['organization_type_enc_id', 'organization_type'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'organization_types' => $org_types]);
    }

    public function actionDesignations($keyword)
    {
        $designations = Designations::find()
            ->select(['designation_enc_id', 'designation', 'designation_enc_id id', 'designation name'])
            ->where(['is_deleted' => 0])
            ->andFilterWhere(['like', 'designation', $keyword])
            ->limit(20)
            ->asArray()
            ->all();

        // remove designations after deploy on react
        return $this->response(200, ['status' => 200, 'list' => $designations, 'designations' => $designations]);
    }

    public function actionStates()
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->andWhere(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'states' => $states]);
    }

    public function actionCities($state_id = 'OVlINEg0MGxyRzMydlFrblNTSWExQT09')
    {
        $cities = Cities::find()
            ->select(['city_enc_id', 'name'])
            ->andWhere(['state_enc_id' => $state_id])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'cities' => $cities]);
    }

    public function actionSearchCities($keyword)
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['a.city_enc_id id', 'concat(a.name,", ",b.name) name'])
            ->joinWith(['stateEnc b' => function ($b) {
                $b->joinWith(['countryEnc c'], false);
            }], false)
            ->andWhere(['like', 'a.name', $keyword])
            ->andWhere(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'list' => $cities]);
    }

    public function actionFileUpload()
    {
        if ($this->isAuthorized()) {
            $file = UploadedFile::getInstanceByName('file');

            $base_path = Yii::$app->params->upload_directories->loans->e_sign . Yii::$app->getSecurity()->generateRandomString() . '/';
            $type = $file->type;
            $file_name = Yii::$app->getSecurity()->generateRandomString() . '.' . 'pdf';

            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $file_name, "private", ['params' => ['ContentType' => $type]]);
            if ($result['ObjectURL']) {
                return $this->response(200, ['status' => 200, 'path' => Yii::$app->params->digitalOcean->rootDirectory . $base_path . $file_name]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveCourse()
    {
        $params = Yii::$app->request->post();

        $course = new SponsoredCourses();
        $course->course_enc_id = Yii::$app->getSecurity()->generateRandomString();
        $course->name = $params['name'];
        $course->phone = $params['phone'];
        $course->email = $params['email'];
        $course->course_name = $params['course_name'];
        $course->created_on = date('Y-m-d H:i:s');
        if (!empty($params['course_price'])) {
            $course->price = $params['course_price'];
        }

        if ($user = $this->isAuthorized()) {
            $course->created_by = $user->user_enc_id;
        }

        if (!$course->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $course->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
    }

    public function actionAddLoanStatus()
    {
        if ($user = $this->isAuthorized()) {
            $status_arr = ['New Lead', 'Accepted', 'Pre Verification', 'Under Process', 'Sanctioned', 'Disbursed',
                'Login', 'Credit Check', 'Online Login Not Received', 'Invalid Login: Login Again', 'CIBIL Reject', 'CIBIL Approved',
                'Field Visit & Document Collection', 'TL Approved', 'PD Planned', 'TVR Calling Done', 'PD Done', 'Soft Approval',
                'Conditional Sanction', 'Pendencies', 'Decision Pending', 'L&T Fee Pending', 'Legal/Technical initiated', 'Valuation Received',
                'Legal Received', 'Technical/Legal Approval Received', 'Soft Sanction', 'Finalise ASAP', 'Disbursement Approval', 'Disbursement',
                'CNI', 'On Hold', 'Rejected', 'Completed'];

            foreach ($status_arr as $s) {
                $status = new LoanStatus();
                $status->loan_status_enc_id = Yii::$app->getSecurity()->generateRandomString(50);
                $status->loan_status = $s;
                $status->created_by = $user->user_enc_id;
                $status->created_on = date('Y-m-d H:i:s');
                if (!$status->save()) {
                    return $this->response(500, ['status' => 500, 'error' => $status->getErrors()]);
                }
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateProviderStatus()
    {
        if ($user = $this->isAuthorized()) {
            $list = AssignedLoanProvider::find()
                ->select(['assigned_loan_provider_enc_id', 'status'])
                ->where(['status' => [4, 5, 10, 11]])
                ->asArray()
                ->all();

            if ($list) {
                foreach ($list as $l) {
                    $provider = AssignedLoanProvider::findOne(['assigned_loan_provider_enc_id' => $l['assigned_loan_provider_enc_id']]);
                    if ($provider->status == 4) {
                        $provider->status = 30;
                    } elseif ($provider->status == 5) {
                        $provider->status = 31;
                    } elseif ($provider->status == 10) {
                        $provider->status = 32;
                    } elseif ($provider->status == 11) {
                        $provider->status = 33;
                    }

                    $provider->updated_on = date('Y-m-d H:i:s');
                    if (!$provider->update()) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $provider->getErrors()]);
                    }

                }
                return $this->response(200, ['status' => 200, 'message' => 'updated']);
            }
        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionUpdateSequence()
    {
        if ($this->isAuthorized()) {
            $status = LoanStatus::find()->asArray()->all();
            if ($status) {
                foreach ($status as $key => $val) {
                    $s = LoanStatus::findOne(['loan_status_enc_id' => $val['loan_status_enc_id']]);
                    $s->value = $key;
                    $s->sequence = $key;
                    $s->updated_on = date('Y-m-d H:i:s');
                    if (!$s->update()) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $s->getErrors()]);
                    }
                }
                return $this->response(200, ['status' => 200, 'message' => 'updated']);
            }
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionAddEmployee()
    {
        $employees = Users::find()
            ->alias('a')
            ->joinWith(['userTypeEnc b'], false)
            ->where(['a.last_visit_through' => 'EL', 'b.user_type' => 'Employee'])
            ->asArray()
            ->all();

        if ($employees) {
            foreach ($employees as $e) {
                $ref_enc_id = ReferralSignUpTracking::findOne(['sign_up_user_enc_id' => $e['user_enc_id']]);
                if (!empty($ref_enc_id)) {
                    $org_id = Referral::findOne(['referral_enc_id' => $ref_enc_id->referral_enc_id])->organization_enc_id;
                    if ($org_id) {
                        $already = UserRoles::findOne(['user_enc_id' => $e['user_enc_id'], 'organization_enc_id' => $org_id]);
                        if (!$already) {
                            $user_role = new UserRoles();
                            $user_role->role_enc_id = Yii::$app->getSecurity()->generateRandomString();
                            $user_role->user_type_enc_id = $e['user_type_enc_id'];
                            $user_role->user_enc_id = $e['user_enc_id'];
                            $user_role->organization_enc_id = $org_id;
                            $user_role->created_by = $e['user_enc_id'];
                            $user_role->created_on = date('Y-m-d H:i:s');
                            if (!$user_role->save()) {
                                return $this->response(500, ['status' => 500, 'error' => $user_role->getErrors()]);
                            }
                        }
                    }
                }
            }

            return 'done';
        }

        return 'not found';
    }

}