<?php


namespace api\modules\v1\controllers;


use common\models\AssignedCollegeCourses;
use common\models\LoanTypes;
use common\models\OrganizationFeeComponents;
use common\models\Organizations;
use yii\helpers\Url;
use Yii;
use yii\filters\auth\HttpBearerAuth;

class LoansController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'college-list',
                'college-courses',
                'fee-components'
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'college-list' => ['POST'],
                'college-courses' => ['POST'],
                'fee-components' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionCollegeList()
    {
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'b.business_activity',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->joinWith(['businessActivityEnc b'], false)
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0,
                'b.business_activity' => ['College', 'School']
            ])
            ->asArray()
            ->all();

        if ($organizations) {
            return $this->response(200, $organizations);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionCollegeCourses()
    {

        $params = Yii::$app->request->post();

        if (isset($params['college_id']) && !empty($params['college_id'])) {
            $college_id = $params['college_id'];
        } else {
            return $this->response(422, 'missing information');
        }

        $courses = AssignedCollegeCourses::find()
            ->distinct()
            ->alias('a')
            ->select(['a.assigned_college_enc_id', 'c.course_name'])
            ->joinWith(['courseEnc c'], false)
            ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        if ($courses) {
            return $this->response(200, $courses);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionFeeComponents()
    {

        $params = Yii::$app->request->post();

        if (isset($params['college_id']) && !empty($params['college_id'])) {
            $college_id = $params['college_id'];
        } else {
            return $this->response(422, 'missing information');
        }

        $fee_components = OrganizationFeeComponents::find()
            ->distinct()
            ->alias('a')
            ->select(['a.fee_component_enc_id', 'a.name'])
            ->joinWith(['assignedOrganizationFeeComponents b'], false)
            ->where(['b.organization_enc_id' => $college_id, 'b.status' => 1, 'b.is_deleted' => 0])
            ->asArray()
            ->all();

        $loan_types = LoanTypes::find()
            ->select(['loan_type_enc_id', 'loan_name'])
            ->asArray()
            ->all();

        if ($fee_components) {
            return $this->response(200, ['fee_components' => $fee_components, 'loan_types' => $loan_types]);
        } else {
            return $this->response(404, 'not found');
        }

    }
}