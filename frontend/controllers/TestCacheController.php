<?php

namespace frontend\controllers;
use common\models\UserOtherDetails;
use frontend\models\applications\PreferencesCards;
use frontend\models\script\Box;
use frontend\models\script\Color;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionIndex()
    {
        $data = new PreferencesCards();
        print_r($data->getPreferenceCards());
    }

    public function actionTest()
    {
        $candidates = UserOtherDetails::find()
            ->alias('a')
            ->distinct()
            ->where(['a.organization_enc_id' => 'RXVWV1duTFYwZTRJZmsyVUJuMGFVUT09'])
            //->select([
//                    'a.user_other_details_enc_id',
//                    'a.user_enc_id',
//                    'b.email',
//                    'b.phone',
//                    'a.university_roll_number',
//                    'c.name department',
//                    'b.first_name',
//                    'b.last_name',
//                    'a.starting_year',
//                    'a.ending_year',
//                    'a.semester',
//                    'c.name',
//                    'cc.educational_requirement course_name',
//                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
    //])
            ->joinWith(['userEnc b' => function ($b) {
                $b->select(['b.user_enc_id']);
                $b->joinWith(['appliedApplications ccc' => function ($c) {
                   $c->select(['ccc.created_by','applied_application_enc_id','d.application_enc_id','application_for']);
//                       // $c->select(['ccc.created_by','ccc.application_enc_id','e.organization_enc_id','e.name company_name','f.name','ccc.applied_application_enc_id','COUNT(CASE WHEN g.is_completed = 1 THEN 1 END) as active', 'COUNT(g.is_completed) total']);
////                    $c->joinWith(['appliedApplicationProcesses g' => function ($g) {
////                        $g->select(['g.applied_application_enc_id', 'h.field_enc_id']);
////                        $g->joinWith(['fieldEnc h' => function ($h) {
////                            $h->select(['h.field_enc_id', 'h.field_name', 'h.sequence']);
////                        }]);
////                    }],false);
                    $c->joinWith(['applicationEnc d' => function ($d) {
                        $d->onCondition(['or',
                            ['d.application_for'=>0],
                            ['d.application_for'=>2]
                        ]);
//////                        $d->joinWith(['title ee' => function ($ee) {
//////                            $ee->joinWith(['categoryEnc f']);
//////                        }]);
//////                        $d->joinWith(['organizationEnc e']);
//                        $d->andWhere([
//                            'd.status' => 'Active',
//                            'd.is_deleted' => 0,
//                        ])
                        //$d->andOnCondition(['in','d.application_for',[0,2]]);
                    }], false,'LEFT JOIN');
//                    $c->groupBy(['ccc.applied_application_enc_id','ccc.created_by']);
                }],true);
            }], true,'LEFT JOIN')
            ->joinWith(['educationalRequirementEnc cc'], false)
            ->joinWith(['departmentEnc c'], false);
        print_r($candidates->createCommand()->getRawSql());
       // print_r($candidates->asArray()->all());
        exit;
    }

    public function actionScript()
    {
        $output_image = 'image_final.png';
        $company_name = 'Capital Bank';
        $font = Url::to('@rootDirectory/assets/common/image/image_script/GeoSlb712MdBTBold.ttf');
        $font2 = Url::to('@rootDirectory/assets/common/image/image_script/Gelasio-Regular.ttf');
        $font3 = Url::to('@rootDirectory/assets/common/image/image_script/GeoSlb712MdBTBold.ttf');
        $script_path = Url::to('@rootDirectory/assets/common/image/image_script/image_genrate_script.py');
        $job_title = 'Full Stack Developer s';
        $canvas_name = 'A';
        $icon_path = Url::to('@rootDirectory/assets/common/image/image_script/icon.png');
        $temp_image = Url::to('@rootDirectory/assets/common/image/image_script/share-orignal-image.png');
        $res = exec('python "'.$script_path.'" "'.$company_name.'" "'.$job_title.'" "'.$canvas_name.'" "'.$temp_image.'" "'.$font.'" "'.$font2.'" "'.$font3.'" "'.$output_image.'" "'.$icon_path.'" ',$output, $return_var);
        echo $res;
    }

    public function actionImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        ini_set('max_execution_time', 0);
        $dir = Yii::$app->getSecurity()->generateRandomString();
        $start = microtime(true);
        $company_name = 'DSB Law Groups';
        $company_name = trim(strtoupper($company_name));
        $filepath =
            $img = imagecreatefrompng(Url::to('@rootDirectory/assets/profile/accounting.png'));
            $box = new Box($img);
            $box->setFontFace(Url::to('@rootDirectory/assets/common/fonts/times.ttf'));
            $box->setFontSize(44);
            $box->setFontColor(new Color(0, 0, 0));
            // $box->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
            $box->setBox(717, 3240, 1200, 0);
            $box->setTextAlign('center', 'center');
            $box->draw('Issued In Public Health And Safety By: ' . $company_name);
            //$profile_image = imagecreatefrompng(Url::to('@rootDirectory/assets/common/dum_icons/icon.png'));
            $profile_image = imagecreatefrompng($filepath);
            $color = imagecolorallocatealpha($profile_image, 0, 0, 0, 127);
            imagefill($profile_image, 0, 0, $color);
            imagecopy($img, $profile_image, 100, 100, 0, 0, 300, 300);
            header("Content-type: image/png");
            $filename = Yii::$app->getSecurity()->generateRandomString() . '.png';
            $save = Url::to('@rootDirectory/files/temp/' . $dir . '/' . $filename);
            imagepng($img, $save);
            imagedestroy($img);
        $slug = $this->createSlug($company_name);
        $pathdir = Url::to('@rootDirectory/files/temp/' . $dir . '/');
        $zipcreated = Url::to('@rootDirectory/files/temp/' . $dir . '/' . $slug . '.zip');
        $user_path = Url::to('@root/files/temp/' . $dir . '/' . $slug . '.zip');
        $end = number_format((microtime(true) - $start), 2);
        return [
            'path' => $save,
            'filename' => $user_path,
            'time' => $end,
        ];
    }
}