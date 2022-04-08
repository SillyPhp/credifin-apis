<?php

namespace api\modules\v4\controllers;

use common\models\Cities;
use common\models\Designations;
use common\models\OrganizationTypes;
use common\models\States;
use yii\filters\VerbFilter;
use Yii;

class UtilitiesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'simple-application' => ['POST'],
                'update-payment-status' => ['POST'],
                'organization-types' => ['GET'],
                'designations' => ['GET'],
            ]
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
            ->select(['designation_enc_id', 'designation',])
            ->where(['is_deleted' => 0])
            ->andFilterWhere(['like', 'designation', $keyword])
            ->limit(20)
            ->asArray()
            ->all();

        return $this->response(200, ['designations' => $designations]);
    }

    public function actionStates()
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->andWhere(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['states' => $states]);
    }

    public function actionCities($state_id='OVlINEg0MGxyRzMydlFrblNTSWExQT09')
    {
        $cities = Cities::find()
            ->select(['city_enc_id', 'name'])
            ->andWhere(['state_enc_id' => $state_id])
            ->asArray()
            ->all();

        return $this->response(200, ['cities' => $cities]);
    }
}