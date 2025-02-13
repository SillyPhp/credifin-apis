<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedLoanProvider;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\LoanPurposeExtended;
use common\models\LoanApplications;
use common\models\LoanAuditTrail;
use common\models\SelectedServices;
use common\models\SharedLoanApplications;
use common\models\UserRoles;
use common\models\Utilities;
use Yii;
use yii\db\Query;
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
        if (in_array($user->username, ["Phf24", "PHF141", "phf607", "PHF491", "Satparkash", "shgarima21", "Sumit1992"])) {
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

    public function actionDownloadQrCode($url, $name)
    {
        $file_path = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . $url . "&choe=UTF-8&chld=0|1";

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $name . '.png"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

// Clear output buffer
        ob_clean();
        flush();
        readfile($file_path);
        exit();
    }

    public function actionCaseReportDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }

        $tvr = $this->getTvr($params['loan_app_enc_id']);
        $pd = $this->getPd($params['loan_app_enc_id']);
        $fi = $this->getFi($params['loan_app_enc_id']);
        $lg = $this->getLogin($params['loan_app_enc_id']);

        $query = LoanApplications::find()
            ->alias('a')
            ->select([
                'a.login_date',
                "(CASE WHEN a.loan_app_enc_id IS NOT NULL THEN FALSE ELSE TRUE END) as login_fee",
                'a.loan_app_enc_id',
                'a.created_on as lead_start',
                'e.stamp as lead_end',
                'as.valuation',
                'CASE WHEN e.stamp IS NULL THEN NULL ELSE TIMESTAMPDIFF(MINUTE, a.created_on, e.stamp) END as lead_creation_tat',
                'b.diff as tvr_tat',
                'c.diff as pd_tat',
                'd.diff as fi_tat',
            ])
            ->joinWith(['assignedLoanProviders as'], false)
            ->join('LEFT JOIN', ['b' => $tvr], 'b.foreign_id = a.loan_app_enc_id')
            ->join('LEFT JOIN', ['c' => $pd], 'c.foreign_id = a.loan_app_enc_id')
            ->join('LEFT JOIN', ['d' => $fi], 'd.foreign_id = a.loan_app_enc_id')
            ->join('LEFT JOIN', ['e' => $lg], 'e.foreign_id = a.loan_app_enc_id')
            ->andWhere(['a.is_deleted' => 0, 'a.loan_app_enc_id' => $params['loan_app_enc_id']])
            ->asArray()
            ->one();

        if ($query['lead_end'] == null) {
            $query['lead_creation_tat'] = null;
        } else {
            $leadStart = new \DateTime($query['lead_start']);
            $leadEnd = new \DateTime($query['lead_end']);
            $leadDiff = $leadStart->diff($leadEnd);
            $query['lead_creation_tat'] = $leadDiff->format('%a days, %h hours, %i minutes');
        }

        $query['tvr_tat'] = $this->timeDiff($query['tvr_tat']);
        $query['pd_tat'] = $this->timeDiff($query['pd_tat']);
        $query['fi_tat'] = $this->timeDiff($query['fi_tat']);

        $total_tat_minutes = (int)$query['tvr_tat'] + (int)$query['fi_tat'] + (int)$query['pd_tat'];
        if ($query['lead_creation_tat'] != null) {
            $total_tat_minutes += (int)$query['lead_creation_tat'];
        }
        $total_tat_days = floor($total_tat_minutes / (24 * 60));
        $query['total_tat'] = "$total_tat_days";

        return $this->response(200, ['status' => 200, 'data' => $query]);
    }

    private function getTvr($loanAppEncId)
    {
        return (new Query())
            ->from(['a' => LoanAuditTrail::tableName()])
            ->select([
                'a.foreign_id',
                "TIMEDIFF(MAX(a.stamp) ,MIN(a.stamp)) diff",
            ])
            ->andWhere(['a.model' => 'LoanApplicationTvr', 'a.field' => 'status', 'a.foreign_id' => $loanAppEncId])
            ->andWhere([
                'OR',
                ['a.new_value' => 'Approved'],
                ['a.new_value' => 'Pending'],
            ])
            ->groupBy(['a.foreign_id']);
    }

    private function getFi($loanAppEncId)
    {
        return (new Query())
            ->from(['d' => LoanAuditTrail::tableName()])
            ->select([
                'd.foreign_id',
                "TIMEDIFF(MAX(d.stamp) ,MIN(d.stamp)) diff",
            ])
            ->andWhere(['d.model' => 'LoanApplicationFi', 'd.field' => 'status', 'd.foreign_id' => $loanAppEncId])
            ->andWhere([
                'OR',
                ['d.new_value' => 'Approved'],
                ['d.new_value' => 'Pending'],
            ])
            ->groupBy(['d.foreign_id']);
    }

    private function getPd($loanAppEncId)
    {
        return (new Query())
            ->from(['c' => LoanAuditTrail::tableName()])
            ->select([
                'c.foreign_id',
                "TIMEDIFF(MAX(c.stamp) ,MIN(c.stamp)) diff",
            ])
            ->andWhere(['c.model' => 'LoanApplicationPd', 'c.field' => 'status', 'c.foreign_id' => $loanAppEncId])
            ->andWhere([
                'OR',
                ['c.new_value' => 'Approved'],
                ['c.new_value' => 'Pending'],
            ])
            ->groupBy(['c.foreign_id']);
    }

    private function getLogin($loanAppEncId)
    {
        return (new Query())
            ->from(['e' => LoanAuditTrail::tableName()])
            ->select(['e.foreign_id', "e.stamp", 'e.field'])
            ->andWhere(['e.model' => 'AssignedLoanProvider', 'e.field' => 'status', 'e.new_value' => 'Login', 'e.foreign_id' => $loanAppEncId])
            ->groupBy(['e.foreign_id', 'e.stamp']);
    }

    private function timeDiff($timeDiff)
    {
        $timeComponents = explode(':', $timeDiff);
        $days = floor($timeComponents[0] / 24);
        $timeComponents[0] %= 24;
        $time = '';
        if ($days > 0) {
            $time .= $days . ' day' . ($days > 1 ? 's' : '') . ' ';
        }
        if ($timeComponents[0] > 0) {
            $time .= $timeComponents[0] . ' hour' . ($timeComponents[0] > 1 ? 's' : '') . ' ';
        }
        if ($timeComponents[1] > 0) {
            $time .= $timeComponents[1] . ' minute' . ($timeComponents[1] > 1 ? 's' : '') . ' ';
        }

        return trim($time);
    }

    public function actionStatusTat()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();
        if (empty($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }

        $query = LoanAuditTrail::find()
            ->alias('a')
            ->select(['a.foreign_id', 'a.new_value', 'a.stamp', 'a.old_value'])
            ->andWhere(['a.model' => 'AssignedLoanProvider', 'a.field' => 'status', 'a.foreign_id' => $params['loan_app_enc_id']])
            ->orderBy(['a.stamp' => SORT_ASC])
            ->asArray()
            ->all();

        $status_data = [];

        $status_count = count($query);

        if (!empty($query)) {
            for ($i = 0; $i < $status_count - 1; $i++) {
                $current_status = $query[$i]['new_value'];
                $next_status = $query[$i + 1]['new_value'];

                $current_stamp = new \DateTime($query[$i]['stamp']);
                $next_stamp = new \DateTime($query[$i + 1]['stamp']);

                $difference = $current_stamp->diff($next_stamp);

                $time_difference = '';

                if ($difference->d > 0) {
                    $time_difference .= $difference->d . ' day' . ($difference->d > 1 ? 's' : '') . ' ';
                }
                if ($difference->h > 0) {
                    $time_difference .= $difference->h . ' hour' . ($difference->h > 1 ? 's' : '') . ' ';
                }
                if ($difference->i > 0) {
                    $time_difference .= $difference->i . ' minute' . ($difference->i > 1 ? 's' : '') . ' ';
                }
                if ($difference->s > 0) {
                    $time_difference .= $difference->s . ' second' . ($difference->s > 1 ? 's' : '');
                }

                $start_date = $query[$i]['stamp'];
                $end_date = $query[$i + 1]['stamp'];

                $status_data[] = [
                    'status' => $current_status,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'time_difference' => $time_difference
                ];
            }

            $status_data[] = [
                'status' => $query[$status_count - 1]['new_value'],
                'start_date' => $query[$status_count - 1]['stamp'],
                'end_date' => null,
                'time_difference' => ''
            ];
        }

        return $this->response(200, ['status' => 200, 'data' => $status_data]);
    }

}

