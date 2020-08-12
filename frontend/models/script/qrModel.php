<?php
namespace frontend\models\script;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use yii\helpers\Url;
class qrModel extends Model
{
    public $job_link;
    public $logo_width=50;
    public $logo=null;
    public $is_logo=1;
    public function rules()
    {
        return [
            [['job_link','is_logo'],'required'],
            [['logo_width'],'safe'],
            [['job_link'],'trim'],
            [['job_link'], 'url', 'defaultScheme' => 'http'],
            [['logo'], 'image', 'skipOnEmpty' => true,'extensions' => 'png'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function genrate()
    {

    }

}