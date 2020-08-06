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
                'speakers',
                'speaker-detail'
            ],
            'class' => HttpBearerAuth::className()
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'speakers' => ['POST', 'OPTIONS'],
                'speaker-detail' => ['POST', 'OPTIONS'],
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
        $webSpeaker = Speakers::find()
            ->distinct()
            ->alias('a')
            ->select(['a.speaker_enc_id',
                'a.unclaimed_org_id',
                'a.designation_enc_id',
                'b.designation',
                'CONCAT(f.first_name, " ", f.last_name) fullname',
                'f.email', 'f.phone',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) END image',
                'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", c.logo_location, "/", c.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END logo',
                'f.description',
                'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
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
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($webSpeaker) {
            return $this->response(200, ['status' => 200, 'data' => $webSpeaker]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'No detail found']);
    }

    public function actionSpeakerDetail()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['speaker_enc_id']) && empty($params['speaker_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $speaker = Speakers::find()
            ->alias('a')
            ->select(['a.speaker_enc_id',
                'a.unclaimed_org_id',
                'a.designation_enc_id',
                'b.designation',
                'CONCAT(f.first_name, " ", f.last_name) fullname',
                'f.email', 'f.phone',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) END image',
                'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", c.logo_location, "/", c.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", c.name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END logo',
                'f.description',
                'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                'REPLACE(c.name, "&amp;", "&") as org_name',
            ])
            ->where(['a.is_deleted' => 0, 'a.speaker_enc_id' => $params['speaker_enc_id']])
            ->joinWith(['designationEnc b'], false)
            ->joinWith(['unclaimedOrg c'], false)
            ->joinWith(['speakerExpertises d' => function ($d) {
                $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                $d->joinWith(['skillEnc e'], false);
            }])
            ->joinWith(['userEnc f'], false)
            ->asArray()
            ->one();

        if ($speaker) {
            return $this->response(200, ['status' => 200, 'data' => $speaker]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }
}