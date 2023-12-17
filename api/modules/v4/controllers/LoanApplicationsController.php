<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use api\modules\v4\utilities\UserUtilities;
use common\models\AssignedLoanProvider;
use common\models\AssignedSupervisor;
use common\models\ClaimedDeals;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\LoanPurposeExtended;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\LoanApplications;
use common\models\LoanPurpose;
use common\models\SelectedServices;
use common\models\SharedLoanApplications;
use common\models\UserRoles;
use common\models\Utilities;
use common\models\WebhookTest;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class LoanApplicationsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'update-loan-application' => ['POST', 'OPTIONS'],
                'status-application-list' => ['POST', 'OPTIONS'],
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

    public function actionUpdateLoanApplication()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing loan_id']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $loan_id = $params['loan_id'];
            $product_id = $params['product_enc_id'];
            $purposes = $params['purpose'];
            $user_id = $user->user_enc_id;
            $application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $loan_id]);
            $loan_provider = AssignedLoanProvider::findOne(['loan_application_enc_id' => $loan_id]);
            if (!$loan_provider) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while fetching loan provider');
            }
            $branch_id = $loan_provider['branch_enc_id'];
            $application->loan_products_enc_id = $product_id;
            $new_application_number = LoanApplication::generateApplicationNumber($product_id, $branch_id, $purposes);
            if (!$new_application_number) {
                throw new \Exception ('error while fetching new application number');
            }
            $application->application_number = $new_application_number;
            $application->updated_on = date('Y-m-d H:i:s');
            $application->updated_by = $user_id;
            if (!$application->save()) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while updating application');
            }
            $purposeData = $this->purpose($purposes, $user_id, $loan_id);
            if (!$purposeData) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while updating purposes');
            }
            $status = $this->status($params, $user_id, $loan_id);
            if (!$status) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while updating status');
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
        }
    }

    private function purpose($purposes, $user_id, $loan_id)
    {
        LoanPurposeExtended::updateAll(['is_deleted' => 1], ['loan_app_enc_id' => $loan_id]);
        foreach ($purposes as $d) {
            $purpose = new LoanPurposeExtended();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $purpose->loan_purpose_enc_id = $utilitiesModel->encrypt();
            $purpose->financer_loan_purpose_enc_id = $d;
            $purpose->loan_app_enc_id = $loan_id;
            $purpose->created_on = $purpose->updated_on = date('Y-m-d H:i:s');
            $purpose->created_by = $purpose->updated_by = $user_id;
            if (!$purpose->save()) {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($purpose->errors, 0, false)));
            }
        }
        return true;
    }


    private function status($params, $user_id, $loan_id)
    {
        $status = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $loan_id]);

        if ($status) {
            $status->status = $params['status'];
            $status->updated_on = date('Y-m-d H:i:s');
            $status->updated_by = $user_id;

            if (!$status->save()) {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($status->errors, 0, false)));
            }
        }
        return true;
    }

    public function actionStatusApplicationList()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        $org_id = $user->organization_enc_id;

        if (!$org_id) {
            $user_roles = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $user_roles->organization_enc_id;
        }

        if ($params['type'] == 'disbursed') {
            $where = ['i.status' => 31];
        } else {
            $where = ['a.is_removed' => 1];
        }
        $data = $this->getList($org_id, $user, $where, true);
        $totalCount = $data['count'];
        return $this->response(200, ['status' => 200, 'data' => $data['data'], 'count' => $totalCount]);
    }

    private function getList($org_id, $user, $conditions, $disableShareApp = false)
    {
        $params = $this->post;
        $user_id = $user->user_enc_id;
        $service = SelectedServices::find()
            ->alias('a')
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.organization_enc_id' => $org_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
            ->exists();

        //get user roles
        $leadsAccessOnly = false;
        $roleUnderId = null;
        if (in_array($user->username, ["Phf24", "PHF141", "phf607", "PHF491", "satparkash", "shgarima21", "Sumit1992"])) {
            $leadsAccessOnly = $user->username === "Sumit1992" ? "lap" : "vehicle";
        }
        $shared_apps = null;
        if (!$disableShareApp) {
            $shared_apps = $this->sharedApps($user->user_enc_id);
        }

        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;

        $list = LoanApplications::find()
            ->alias('a')
            ->distinct('a.id')
            ->select([
                'a.id', 'a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date', 'a.application_number', 'a.amount', 'a.is_removed',
                'a.amount_received', 'a.amount_due', 'a.scholarship', 'a.loan_type', 'a.loan_products_enc_id',
                'a.semesters', 'a.years', 'a.phone', 'a.email', 'a.applicant_current_city as city',
                'a.applicant_dob as dob', 'a.created_by', 'a.lead_by', 'a.managed_by', 'a.created_on',
                'i.status status_number', 'i.updated_on',
                'j.organization_enc_id',
                'h.name as applicant_name',
                'lp.name as loan_product',
                'i.bdo_approved_amount',
                'i.tl_approved_amount',
                'i.soft_approval', 'i.soft_sanction',
                'be.location_name as branch', 'be.location_enc_id as branch_id',
                'a.loan_status_updated_on as disbursement_date'
            ])
            ->addSelect([
                "CONCAT(k.first_name, ' ', COALESCE(k.last_name,'')) employee_name",
                "(CASE
                    WHEN a.lead_by IS NOT NULL THEN CONCAT(lb.first_name,' ',COALESCE(lb.last_name, ''))
                    ELSE CONCAT('SELF (',cb.first_name, ' ', COALESCE(cb.last_name, ''), ')')
                END) as creator_name",
                "(CASE 
                    WHEN a.lead_by IS NOT NULL THEN '0' 
                    ELSE '1' 
                END) as is_self",
                "REPLACE(g.name, '&amp;', '&') as org_name",
                "(CASE
                    WHEN a.gender = '1' THEN 'Male'
                    WHEN a.gender = '2' THEN 'Female'
                    ELSE 'N/A'
                END) as gender"
            ])
            ->joinWith(['collegeCourseEnc f'], false)
            ->joinWith(['loanPurposes lpp' => function ($lpp) {
                $lpp->select(['lpp.loan_app_enc_id', 'lpp1.financer_loan_product_purpose_enc_id', 'lpp1.purpose']);
                $lpp->joinWith(['financerLoanPurposeEnc lpp1'], false);
            }], false)
            ->joinWith(['collegeEnc g'], false)
            ->joinWith(['leadBy lb'], false)
            ->joinWith(['createdBy cb' => function ($cr) {
                $cr->joinWith(['userTypeEnc ute'], false);
            }], false)
            ->joinWith(['loanCoApplicants h' => function ($h) {
                $h->andOnCondition(['h.borrower_type' => 'Borrower']);
            }])
            ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $org_id, $roleUnderId) {
                $i->joinWith(['providerEnc j']);
                // if loans service exists then using andWhere with provider_enc_id
                if ($service) {
                    $i->andWhere(['i.is_deleted' => 0, 'i.provider_enc_id' => $org_id]);
                }
                if (!empty($roleUnderId) || $roleUnderId != null) {
                    $i->andWhere(['i.provider_enc_id' => $roleUnderId]);
                }
                $i->joinWith(['branchEnc be']);
            }])
            ->joinWith(['managedBy k'], false)
            ->joinWith(['loanProductsEnc lp' => function ($lp) {
                $lp->onCondition(['lp.is_deleted' => 0]);
            }], false)
            ->joinWith(['sharedLoanApplications n' => function ($n) {
                $n->select([
                    'n.shared_loan_app_enc_id', 'n.loan_app_enc_id', 'n.access', 'n.status', "CONCAT(n1.first_name, ' ',n1.last_name) name", 'n1.phone',
                    "CASE WHEN n1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', n1.image_location, '/', n1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', concat(n1.first_name,' ',n1.last_name), '&size=200&rounded=false&background=', REPLACE(n1.initials_color, '#', ''), '&color=ffffff') END image"
                ])
                    ->joinWith(['sharedTo n1'], false)
                    ->onCondition(['n.is_deleted' => 0]);
            }])
            ->where(['a.is_deleted' => 0, 'j.organization_enc_id' => $org_id])
            ->andWhere($conditions)
            ->orderBy(['a.loan_status_updated_on' => SORT_DESC]);

        if (!$org_id && !$leadsAccessOnly) {
            // else checking lead_by and managed_by by logged-in user
            $list->andWhere(['or', ['a.lead_by' => $user_id], ['a.managed_by' => $user_id]]);
        }

        if ($shared_apps && $shared_apps['app_ids']) {
            $list->orWhere(['a.loan_app_enc_id' => $shared_apps['app_ids']]);
        }

        if (!empty($params['fields_search'])) {
            // fields array for "a" alias table
            $a = ['applicant_name', 'application_number', 'loan_status_updated_on', 'disbursement_date', 'amount', 'apply_date', 'loan_type', 'loan_products_enc_id'];

            // fields array for "cb" alias table
            $name_search = ['created_by', 'sharedTo'];

            // fields array for "lpp" alias table
            $purpose_search = ['purpose'];

            // fields array for "i" alias table
            $i = ['bdo_approved_amount', 'tl_approved_amount', 'soft_approval', 'soft_sanction', 'valuation', 'disbursement_approved', 'insurance_charges', 'status', 'branch'];

            // loop fields
            foreach ($params['fields_search'] as $key => $val) {

                if (!empty($val) || $val == '0') {
                    // key match to "a" table array
                    if (in_array($key, $a)) {

                        // if key is apply_date then checking created_on time
                        if ($key == 'apply_date') {
                            $list->andWhere(['like', 'a.created_on', $val]);
                        } elseif ($key == 'disbursement_date') {
                            $list->andWhere(['like', 'a.loan_status_updated_on', $val]);
                        } else {
                            if ($key == 'applicant_name'):
                                $list->andWhere(['like', 'h.name', $val]);
                            else:
                                // else checking other fields with their names
                                $list->andWhere(['like', 'a.' . $key, $val]);
                            endif;
                        }
                    }

                    // key match to "lpp" table array
                    if (in_array($key, $purpose_search)) {
                        if ($key == 'purpose') {
                            $list->andWhere(['like', 'lpp1.purpose', $val]);
                        }
                    }

                    // key match to "i" table array
                    if (in_array($key, $i)) {
                        switch ($key) {
                            case 'branch':
                                $list->andWhere(['like', 'i.branch_enc_id', $val]);
                                break;
                            case 'status':
                                $list->andWhere(['i.status' => $val]);
                                break;
                            default:
                                $list->andWhere(['like', 'i.' . $key, $val]);
                                break;
                        }
                    }

                    // key match to "$name_search" table array
                    if (in_array($key, $name_search)) {
                        switch ($key) {
                            case 'created_by':
                                $list->andWhere([
                                    'or',
                                    [
                                        'and',
                                        [
                                            'not',
                                            ['a.lead_by' => null]
                                        ],
                                        ['like', 'CONCAT(lb.first_name, " ", COALESCE(lb.last_name,""))', $val]
                                    ],
                                    [
                                        'and',
                                        ['a.lead_by' => null],
                                        ['like', 'CONCAT(cb.first_name, " ", COALESCE(cb.last_name, ""))', $val]
                                    ]
                                ]);
                                break;
                            case 'sharedTo':
                                $list->andWhere(['like', 'CONCAT(n1.first_name, " ", COALESCE(n1.last_name,""))', $val]);
                                break;
                        }
                    }
                }
            }
        }

        $count = $list->count();

        $list = $list
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($list) {
            foreach ($list as $key => $val) {
                $list[$key]['sharedTo'] = $val['sharedLoanApplications'];
                unset($list[$key]['sharedLoanApplications']);

                $list[$key]['access'] = null;
                $list[$key]['shared_by'] = null;
                $list[$key]['is_shared'] = false;
                if ($shared_apps && $shared_apps['app_ids']) {
                    foreach ($shared_apps['shared'] as $s) {
                        if ($val['loan_app_enc_id'] == $s['loan_app_enc_id']) {
                            $list[$key]['access'] = $s['access'];
                            $list[$key]['shared_by'] = $s['shared_by'];
                            $list[$key]['is_shared'] = true;
                        }
                    }
                }

                $provider_id = $this->getFinancerId($user);

                $provider = AssignedLoanProvider::find()
                    ->alias('a')
                    ->select(['a.assigned_loan_provider_enc_id', 'a.branch_enc_id', 'b.location_name', 'b1.name city', 'a.bdo_approved_amount', 'a.tl_approved_amount', 'a.soft_approval', 'a.soft_sanction', 'a.valuation', 'a.disbursement_approved', 'a.insurance_charges'])
                    ->joinWith(['branchEnc b' => function ($b) {
                        $b->joinWith(['cityEnc b1']);
                    }], false)
                    ->andWhere(['a.loan_application_enc_id' => $val['loan_app_enc_id'], 'a.provider_enc_id' => $provider_id])
                    ->asArray()
                    ->one();

                if (!empty($provider)) {
                    $list[$key]['bdo_approved_amount'] = $provider['bdo_approved_amount'];
                    $list[$key]['tl_approved_amount'] = $provider['tl_approved_amount'];
                    $list[$key]['soft_approval'] = $provider['soft_approval'];
                    $list[$key]['soft_sanction'] = $provider['soft_sanction'];
                    $list[$key]['valuation'] = $provider['valuation'];
                    $list[$key]['disbursement_approved'] = $provider['disbursement_approved'];
                    $list[$key]['insurance_charges'] = $provider['insurance_charges'];
                    $list[$key]['branch_id'] = $provider['branch_enc_id'];
                    $list[$key]['branch'] = $provider['location_name'] ? $provider['location_name'] . ', ' . $provider['city'] : $provider['city'];
                }
            }
        }

        return ['data' => $list, 'count' => $count];
    }

    private function sharedApps($user_id)
    {
        // getting loan applications shared to this user
        $shared = SharedLoanApplications::find()
            ->alias('a')
            ->select(["a.loan_app_enc_id", "a.access"])
            ->addSelect(["CONCAT(b.first_name, ' ' ,b.last_name) shared_by"])
            ->joinWith(['sharedBy b'], false)
            ->joinWith(['loanAppEnc c'], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'a.shared_to' => $user_id, 'c.is_deleted' => 0])
            ->asArray()
            ->all();
        $loan_app_ids = [];
        if ($shared) {
            foreach ($shared as $s) {
                $loan_app_ids[] = $s["loan_app_enc_id"];
            }
        }

        // returning application id's and shared detail
        return ['app_ids' => $loan_app_ids, 'shared' => $shared];
    }


}

