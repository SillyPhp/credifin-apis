<?php

namespace api\modules\v4\models;

use common\models\LoanCertificatesImages;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\extended\LoanCertificatesExtended;
use common\models\spaces\Spaces;


class DocumentForm extends Model
{
    public $loan_id;
    public $loan_enc_id;

    public $proof_images;
    public $type_id;
    public $document_type;
    public $assigned_to;
    public $proof_of;
    public $financer_loan_document_enc_id;
    public $short_description;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['loan_id', 'document_type', 'proof_images'], 'required'],
            [['proof_of', 'financer_loan_document_enc_id', 'short_description', 'assigned_to'], 'safe'],
        ];
    }

    private function saveImages($user_id, $certificate_id)
    {
        foreach ($this->proof_images as $i) {
            $image = new LoanCertificatesImages();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $image->certificate_image_enc_id = $utilitiesModel->encrypt();
            $image->certificate_enc_id = $certificate_id;
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $image->image_location = $utilitiesModel->encrypt();
            $base_path = Yii::$app->params->upload_directories->loans->image . $image->image_location . '/';
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $image->image = $utilitiesModel->encrypt() . '.' . 'pdf';
            $image->created_by = $user_id;
            if ($image->save()) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($i->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $image->image, "private", ['params' => ['ContentType' => $i->type]]);
                if (!$result) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public function upload($identity, $type_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $certificate = new LoanCertificatesExtended();
            $certificate->certificate_enc_id = $utilitiesModel->encrypt();
            $certificate->loan_app_enc_id = $this->loan_id;
            $certificate->certificate_type_enc_id = $type_id;
            $certificate->proof_of = $this->proof_of;
            $certificate->financer_loan_document_enc_id = $this->financer_loan_document_enc_id;
            $certificate->created_by = $identity;
            $certificate->short_description = $this->short_description;
            $certificate->related_to = (int)$this->assigned_to;
            if ($certificate->save()) {
                if (!$this->saveImages($identity, $certificate->certificate_enc_id)) {
                    $transaction->rollBack();
                    return ['status' => 500, 'message' => 'an error occurred', 'error' => 'error occurred while uploading images'];
                }
                $transaction->commit();
                return ['status' => 200, 'message' => 'successfully updated'];
            } else {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'Some Error Occurred', 'error' => $certificate->getErrors()];
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }
}