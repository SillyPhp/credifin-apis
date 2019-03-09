<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\Url;
use common\models\EmployerApplications;

class Jobs extends EmployerApplications {

//    public $primaryKey = 'application_enc_id';

    public function fields() {
        return [
            'id',
            'application_id' => 'application_enc_id',
            'name' => function($model) {
                $category = $model->getTitle()
                        ->select('b.name')
                        ->joinWith(['categoryEnc b'], false)
                        ->asArray()
                        ->one();

                return $category['name'];
            },
            'experience' => function($model) {
                switch ($model->experience) {
                    case '0':
                        return "No Experience";
                    case '1':
                        return "Less than 1 Year Experience";
                    case '2':
                        return "1 Year Experience";
                    case '3':
                        return "2-3 Years Experience";
                    case '3-5':
                        return "3-5 Years Experience";
                    case '5-10':
                        return "5-10 Years Experience";
                    case '10+':
                        return "10+ Years Experience";
                    default:
                        return "No Experience";
                }
            },
            'organization' => function($model) {
                if ($model->organizationEnc->logo) {
                    $logo = Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . $model->organizationEnc->logo_locatoin . $model->organizationEnc->logo;
                } else {
                    $logo = NULL;
                }
                return [
                    'name' => $model->organizationEnc->name,
                    'logo' => $logo,
                    'initials_color' => $model->organizationEnc->initials_color,
                ];
            },
            'salary' => function($model) {
                $salary = $model->getApplicationOptions()
                        ->select(['value salary'])
                        ->where(['option_name' => 'salary'])
                        ->asArray()
                        ->one();

                return $salary['salary'];
            },
            'url' => function($model) {
                return Url::to(substr_replace(strtolower($model->applicationTypeEnc->name), "", -1) . DIRECTORY_SEPARATOR . $model->slug, true);
            },
            'locations' => function($model) {
                $location = $model->getApplicationPlacementLocations()
                        ->select(['GROUP_CONCAT(DISTINCT z.name SEPARATOR ", ") locations'])
                        ->joinWith(['locationEnc x' => function($y) {
                                $y->joinWith(['cityEnc z']);
                            }], false)
                        ->asArray()
                        ->one();
                return $location['locations'];
            },
        ];
    }

}
