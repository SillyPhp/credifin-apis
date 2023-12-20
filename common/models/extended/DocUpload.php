<?php

namespace common\models\extended;
use Yii;
use common\models\spaces\Spaces;
use yii\base\Model;

class DocUpload extends Model{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'maxSize' => 1024 * 1024 * 20],
        ];
    }

    public function upload($base_path,$type,$certificate)
    {
        if ($this->validate()) {
            //creating space object
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($this->file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $certificate->proof_image, "private", ['params' => ['ContentType' => $type]]);
            return [
                'status'=>true,
            ];
        } else {
            return [
                'status'=>false,
                'error'=>json_encode($this->getErrors())
            ];
        }
    }
}

?>