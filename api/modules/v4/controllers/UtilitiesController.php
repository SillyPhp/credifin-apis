<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\Cities;
use common\models\Designations;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\LoanCertificates;
use common\models\LoanCertificatesImages;
use common\models\OrganizationTypes;
use common\models\SelectedServices;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
use common\models\Users;
use common\models\UserTypes;
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

    // this action is used to get organization types
    public function actionOrganizationTypes()
    {
        $org_types = OrganizationTypes::find()
            ->select(['organization_type_enc_id', 'organization_type'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'organization_types' => $org_types]);
    }

    // this action is used to search designations
    public function actionDesignations($keyword)
    {
        $designations = Designations::find()
            ->select(['designation_enc_id', 'designation', 'designation_enc_id id', 'designation name'])
            ->where(['is_deleted' => 0])
            ->andFilterWhere(['like', 'designation', $keyword])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'list' => $designations, 'designations' => $designations]);
    }

    // this action is used to states list default country_enc_id = INDIA
    public function actionStates()
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->andWhere(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'states' => $states]);
    }

    // this action is used to get cities list by default state_id = PUNJAB
    public function actionCities($state_id = 'OVlINEg0MGxyRzMydlFrblNTSWExQT09')
    {
        $cities = Cities::find()
            ->select(['city_enc_id', 'name'])
            ->andWhere(['state_enc_id' => $state_id])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'cities' => $cities]);
    }

    // this action is used to search cities default country_enc_id is INDIA
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

    // this action is used to upload file for e-sign
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

    // this action is used to shift images from loan certificates to LoanCertificatesImages
    public function actionImageShifter()
    {
        if ($this->isAuthorized()) {
            $query = LoanCertificates::find()
                ->where(['is_deleted' => 0])
                ->andWhere(['IS NOT', 'proof_image', null])
                ->asArray()
                ->all();

            $utilitiesModel = new \common\models\Utilities();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($query as $oldRow) {
                    $newRow = new LoanCertificatesImages();
                    $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                    $newRow->certificate_image_enc_id = $utilitiesModel->encrypt();
                    $newRow->certificate_enc_id = $oldRow['certificate_enc_id'];
                    $newRow->image = $oldRow['proof_image'];
                    $newRow->image_location = $oldRow['proof_image_location'];
                    $newRow->created_by = $oldRow['created_by'];
                    $newRow->created_on = $oldRow['created_on'];
                    if (!$newRow->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $newRow->getErrors()]);
                    }
                }
                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}
