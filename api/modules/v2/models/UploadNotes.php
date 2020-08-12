<?php


namespace api\modules\v2\models;

use common\models\ClassNotes;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Utilities;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class UploadNotes extends Model
{
    public $notes;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['notes'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, pdf, doc, docx, xlsx, xls', 'maxFiles' => 10],
        ];
    }

    public function upload($class_id, $user_id)
    {
        $note_ids = [];
        foreach ($this->notes as $note) {
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $class_notes = new ClassNotes();
            $class_notes->note_enc_id = $utilitiesModel->encrypt();
            $class_notes->class_enc_id = $class_id;
            $class_notes->note_location = Yii::$app->getSecurity()->generateRandomString();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $encrypted_string = $utilitiesModel->encrypt();
            if (substr($encrypted_string, -1) == '.') {
                $encrypted_string = substr($encrypted_string, 0, -1);
            }
            $class_notes->note = $encrypted_string . '.' . $note->extension;
            $class_notes->title = $note->baseName . '.' . $note->extension;
            $class_notes->alt = $note->baseName . '.' . $note->extension;
            $class_notes->created_on = date('Y-m-d h:i:s');
            $class_notes->created_by = $user_id;
            if ($class_notes->save()) {
                if ($this->uploadFile($class_notes->note, $note->tempName)) {
                    array_push($note_ids, $class_notes->note_enc_id);
                }
            } else {
                return false;
            }
        }
        return $note_ids;
    }

    public function uploadFile($file_name, $file)
    {
        $bucketName = 'mec-uploads';
        $access_key = 'AKIATDLKTDI76APKFGXO';
        $secret_key = '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';
        $s3 = new S3Client([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => $access_key,
                'secret' => $secret_key,
            ]
        ]);

        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key' => 'online_class_notes/' . $file_name,
            'SourceFile' => $file
        ]);

        if ($result) {
            $s3->putObjectAcl([
                'Bucket' => $bucketName,
                'Key' => 'online_class_notes/' . $file_name,
                'ACL' => 'public-read'
            ]);
            return true;
        } else {
            return false;
        }
    }
}