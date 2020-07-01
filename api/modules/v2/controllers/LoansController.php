<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use common\models\AssignedCategories;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\LoanApplications;
use common\models\Organizations;
use common\models\UserOtherDetails;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class LoansController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'home-list' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    private function getOrgId()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $organizations['college_id'];
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveApplicants()
    {
        if ($user = $this->isAuthorized()) {
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
                if ($model->validate()) {
                    if ($model->add($user->user_enc_id)) {
                        return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully..']);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionCollegeStudentLoans()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $loan_requests = LoanApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.loan_app_enc_id',
                    'a.applicant_name',
                    'a.applicant_dob',
                    'a.applicant_current_city',
                    'a.degree',
                    'a.years',
                    'a.semesters',
                    'a.phone',
                    'a.email',
                    'a.gender',
                    'a.amount',
                    'a.purpose',
                    'c.course_name',
                ])
                ->joinWith(['createdBy b' => function ($b) {
                    $b->joinWith(['userOtherInfo b1']);
                }], false)
                ->joinWith(['collegeCourseEnc c'], false)
                ->joinWith(['loanCoApplicants d' => function ($d) {
                    $d->select([
                        'd.loan_co_app_enc_id',
                        'd.loan_app_enc_id',
                        'd.name',
                        'd.relation',
                        'd.employment_type',
                        'd.annual_income'
                    ]);
                }])
                ->where(['b1.organization_enc_id' => $college_id, 'a.status' => 0])
                ->asArray()
                ->all();
            if ($loan_requests) {
                return $this->response(200, ['status' => 200, 'data' => $loan_requests]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}