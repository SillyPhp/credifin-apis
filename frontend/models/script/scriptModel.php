<?php
namespace frontend\models\script;
use frontend\models\script\phpqrcode\bindings\tcpdf\QRcode;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use yii\helpers\Url;
class scriptModel extends Model
{
    public $company_name;
    public $logo;

    public function rules()
    {
        return [
            [['company_name'],'required'],
            [['company_name'],'trim'],
            [['company_name'], 'string', 'max' => 80],
            [['logo'], 'image','skipOnEmpty' => false, 'extensions' => 'png'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function genrate($filepath=null,$dir=null)
    {
        $company_name = $this->company_name;
        $company_name = trim(strtoupper($company_name));
        $img = imagecreatefrompng(Url::to('@rootDirectory/assets/common/covid/14.png'));
        $box = new Box($img);
        $box->setFontFace(Url::to('@rootDirectory/assets/common/fonts/times.ttf'));
        $box->setFontSize(44);
        $box->setFontColor(new Color(0, 0, 0));
        // $box->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
        $box->setBox(717, 3240, 1200, 0);
        $box->setTextAlign('center', 'center');
        $box->draw('Issued In Public Health And Safety By: '.$company_name);
        //$profile_image = imagecreatefrompng(Url::to('@rootDirectory/assets/common/dum_icons/icon.png'));
        $profile_image = imagecreatefrompng($filepath);
        $color = imagecolorallocatealpha($profile_image, 0, 0, 0, 127);
        imagefill($profile_image, 0, 0, $color);
        imagecopy($img,$profile_image, 100, 100,0, 0, 200, 200);
        header("Content-type: image/png");
        $filename = Yii::$app->getSecurity()->generateRandomString().'.png';
        $save = Url::to('@rootDirectory/assets/themes/ey/temp/'.$dir.'/'.$filename);
        imagepng($img,$save);
        return [
            'path'=>$save,
            'filename'=>$filename
        ];
        imagedestroy($img);
    }
}