<?php


namespace api\modules\v2\models;

use common\models\ClassNotes;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Utilities;

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
            [['notes'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, pdf, doc, docx','maxFiles' => 10],
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
            $base_path = Yii::$app->params->upload_directories->resume->file_path . $class_notes->note_location;
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
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if ($note->saveAs($base_path . DIRECTORY_SEPARATOR . $class_notes->note)) {
                            array_push($note_ids,$class_notes->note_enc_id);
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
        return $note_ids;
    }
}