<?php

namespace api\modules\v2\controllers;

use common\models\Speakers;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class WebinarsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'except' => [
                'speakers'
            ],
            'class' => HttpBearerAuth::className()
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'speakers' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionSpeakers()
    {
//        if ($user = $this->isAuthorized()) {
        $webSpeaker = Speakers::find()
            ->alias('a')
            ->select(['a.speaker_enc_id',
                'a.unclaimed_org_id',
                'a.designation_enc_id',
                'b.designation',
                'CONCAT(f.first_name, " ", f.last_name) fullname',
                'f.email', 'f.phone',
                'f.image', 'f.image_location',
                'f.description',
                'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                'c.logo org_logo', 'c.logo_location org_logo_location',
                'REPLACE(c.name, "&amp;", "&") as org_name',
            ])
            ->where(['a.is_deleted' => 0])
            ->joinWith(['designationEnc b'], false)
            ->joinWith(['unclaimedOrg c'], false)
            ->joinWith(['speakerExpertises d' => function ($d) {
                $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                $d->joinWith(['skillEnc e'], false);
            }])
            ->joinWith(['userEnc f'], false)
            ->distinct()
            ->asArray()
            ->orderBy(['a.created_on' => SORT_DESC])
            ->all();

        if ($webSpeaker) {
            return $this->response(200, ['status' => 200, 'data' => $webSpeaker]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'No detail found']);
//        }
    }
}