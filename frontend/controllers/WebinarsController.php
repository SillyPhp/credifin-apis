<?php

namespace frontend\controllers;

use common\models\WebinarOutcomes;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
use common\models\WebinarSpeakers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\httpclient\Client;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use common\models\Utilities;

class WebinarsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['live'],
                'rules' => [
                    [
                        'actions' => ['live'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLive($id)
    {
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinarDetail = self::getWebianrDetails($id);
        $webinars = self::getWebianrs($id);
        $speakerUserIds = ArrayHelper::getColumn($webinarDetail['webinarSpeakers'], 'user_enc_id');
        if(in_array($user_id,$speakerUserIds)){
            $type = 'multi-host';
        } else {
            $type = 'audience';
        }
        return $this->render('live', [
            'type' => $type,
            'webinars' => $webinars,
            'webinarDetail' => $webinarDetail
        ]);
    }
    public function actionWebinarDetails($slug)
    {
        if (!Yii::$app->user->isGuest) {
            $webinar = Webinars::find()
                ->select(['webinar_enc_id','slug', 'session_enc_id','status', 'title', 'start_datetime', 'description', 'seats'])
                ->where(['slug' => $slug])
                ->asArray()
                ->one();
            $assignSpeaker = WebinarSpeakers::find()
                ->alias('z')
                ->distinct()
                ->select([
                    'z.webinar_enc_id',
                    'z.speaker_enc_id',
                    'a.unclaimed_org_id',
                    'a.designation_enc_id',
                    'b.designation',
                    'CONCAT(f.first_name, " ", f.last_name) fullname',
                    'f.email', 'f.phone',
                    'f.image', 'f.image_location',
                    'f.description',
                    'f.facebook', 'f.twitter', 'f.instagram', 'f.linkedin',
                    'c.logo org_logo', 'c.logo_location org_logo_location',
                    'c.name org_name'
                ])
                ->joinWith(['speakerEnc a' => function ($a) {
                    $a->andWhere(['a.is_deleted' => 0]);
                    $a->joinWith(['designationEnc b'], false);
                    $a->joinWith(['unclaimedOrg c'], false);
                    $a->joinWith(['speakerExpertises d' => function ($d) {
                        $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                        $d->joinWith(['skillEnc e'], false);
                    }]);
                    $a->joinWith(['userEnc f'], false);
                }])
                ->andWhere(['z.is_deleted' => 0, 'z.webinar_enc_id' => $webinar['webinar_enc_id']])
                ->asArray()
                ->all();
            if ($assignSpeaker) {
                array_walk($assignSpeaker, function (&$item) {
                    if ($item['image']) {
                        $image_path = Yii::$app->params->upload_directories->users->image_path . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        if (file_exists($image_path)) {
                            $image = Yii::$app->params->upload_directories->users->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        }
                    }
                    $item['speaker_image'] = $image;
                    $item['speaker_image_fake'] = Url::to('@eyAssets/images/pages/webinar/default-user.png');
                    if ($item['org_logo']) {
                        $item['org_image'] = Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo . $item['org_logo_location'] . '/' . $item['org_logo']);
                    }
                    unset($item['image']);
                    unset($item['image_location']);
                    unset($item['org_logo']);
                    unset($item['org_logo_location']);
                });
            }
            $outComes = WebinarOutcomes::find()
                ->alias('z')
                ->select(['z.webinar_enc_id', 'z.outcome_pool_enc_id', 'oe.name', 'oe.icon_location', 'oe.icon', 'oe.bg_colour'])
                ->joinWith(['outcomePoolEnc oe'], false)
                ->where(['z.is_deleted' => 0, 'z.webinar_enc_id' => $webinar['webinar_enc_id']])
                ->asArray()
                ->all();
            $register = WebinarRegistrations::find()
                ->alias('z')
                ->select(['z.webinar_enc_id', 'z.register_enc_id', 'z.interest_status', 'z.created_by', 'c.image', 'c.image_location'])
                ->joinWith(['createdBy c'], false)
                ->where(['z.webinar_enc_id' => $webinar['webinar_enc_id'], 'z.is_deleted' => 0,'z.interest_status' => 3,'c.is_deleted' => 0])
                ->andWhere(['not', ['c.image' => null]])
                ->andWhere(['not', ['c.image' => '']])
                ->limit(6)
                ->asArray()
                ->all();
            $webinarRegistrations = WebinarRegistrations::find()
                ->alias('z')
                ->select(['z.webinar_enc_id', 'z.register_enc_id', 'z.interest_status', 'z.created_by', 'c.image', 'c.image_location'])
                ->joinWith(['createdBy c'], false)
                ->where(['z.webinar_enc_id' => $webinar['webinar_enc_id'], 'z.is_deleted' => 0,'z.interest_status' => 3,'c.is_deleted' => 0])
                ->asArray()
                ->all();
            $webResig = WebinarRegistrations::find()
                ->where(['is_deleted' => 0, 'webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->one();
        } else {
            return $this->redirect('/login');
        }
        return $this->render('webinar-details', [
            'webinar' => $webinar,
            'assignSpeaker' => $assignSpeaker,
            'outComes' => $outComes,
            'register' => $register,
            'webinarRegistrations' => $webinarRegistrations,
            'webResig' => $webResig,
        ]);
    }
    public function actionWebinarRegistation(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $uid = Yii::$app->user->identity->user_enc_id;
            $wid = Yii::$app->request->post('wid');
            $value = Yii::$app->request->post('value');
            $model = WebinarRegistrations::findOne(['webinar_enc_id' => $wid,'created_by' => $uid]);
            if(!empty($model)) {
                switch ($value) {
                    case 'interested':
                        $model->interest_status = 1;
                        break;
                    case 'not interested':
                        $model->interest_status = 2;
                        break;
                    case 'attending':
                        $model->interest_status = 3;
                }
                $model->is_deleted = 0;
                $model->last_updated_by = $uid;
                $model->last_updated_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Updated Successfully',
                    ];
                } else {
                    return [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'something went wrong'
                    ];
                }
            } else {
                $register = new WebinarRegistrations();
                $utilitiesModel = new  \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $register->register_enc_id = $utilitiesModel->encrypt();
                $register->webinar_enc_id = $wid;
                switch ($value) {
                    case 'interested':
                        $register->interest_status = 1;
                        break;
                    case 'not interested':
                        $register->interest_status = 2;
                        break;
                    case 'attending':
                        $register->interest_status = 3;
                }
                $register->status = 0;
                $register->created_by = $uid;
                $register->created_on = date('Y-m-d H:i:s');
                if($register->save()){
                    return [
                        'status' => 200,
                        'title' => 'success',
                        'message' => 'Status added successfully'
                    ];
                } else {
                    return [
                        'status' => 201,
                        'title' => 'error',
                        'message' => 'something went wrong'
                    ];
                }
            }
        }
    }
    public function actionMultiHost($id)
    {
        $data = WebinarSessions::findOne(['session_enc_id' => $id]);
        if (!$data->session_id) {
            $data = $data->webinars;
            foreach ($data as $d) {
                foreach ($d->webinarSpeakers as $speaker) {
                    $user_id = $speaker->speakerEnc->userEnc->user_enc_id;
                    break;
                }
                break;
            }
            return $this->renderAjax('generate-session', ['user_id' => $user_id, 'id' => $id]);
        }
        $this->layout = 'blank-layout';
        $session = Yii::$app->session;
        if (empty($session->get('uid'))) {
            $session->set('uid', Yii::$app->user->identity->id);
        }
        if ($id) {
            return $this->render('multi-host', ['tokenId' => $id, 'uid' => $session->get('uid')]);
        }
    }

    public function actionAudience($id)
    {
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinar_id = Webinars::findOne(['session_enc_id' => $id])['webinar_enc_id'];
        $chkRegistration = WebinarRegistrations::findOne(['created_by' => $user_id]);
        if (empty($chkRegistration)) {
            self::webinarRegistration($user_id, $webinar_id);
        }
        $this->layout = 'blank-layout';
        if ($id) {
            return $this->render('multi-view', ['tokenId' => $id]);
        }
    }

    private function webinarRegistration($user_id, $webinar_id)
    {
        $model = new WebinarRegistrations();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->register_enc_id = $utilitiesModel->encrypt();
        $model->webinar_enc_id = $webinar_id;
        $model->status = 1;
        $model->created_by = $user_id;
        $model->created_on = date('Y-m-d h:i:s');
        if ($model->save()) {
            return true;
        }
    }

    private function getWebianrDetails($id)
    {
        $webinar = Webinars::find()
            ->alias('a')
            ->select([
                'a.webinar_enc_id',
                'a.session_enc_id',
                'a.title',
                'a.start_datetime',
                'a.duration',
                'a.availability',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',
                'a.description',
            ])
            ->joinWith(['webinarSpeakers d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.speaker_enc_id',
                    'd1.user_enc_id',
                    'CONCAT(d2.first_name, " ", d2.last_name) as fullname',
                ]);
                $d->joinWith(['speakerEnc d1' => function ($d1) {
                    $d1->joinWith(['userEnc d2']);
                }], false);
                $d->andWhere(['d.is_deleted' => 0]);
            }])
            ->joinWith(['sessionEnc e'])
            ->andWhere(['a.session_enc_id' => $id])
            ->asArray()
            ->one();
        return $webinar;
    }

    private function getWebianrs($id)
    {
        $webinars = Webinars::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.webinar_enc_id',
                'a.session_enc_id',
                'a.title',
                'a.start_datetime',
                'a.duration',
                'a.availability',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) END image',
                'a.description',
            ])
            ->joinWith(['assignedWebinarTos b'], false)
            ->joinWith(['webinarRegistrations d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.register_enc_id',
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) END image'
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->limit(6);
                $d->onCondition(['d.status' => 1, 'd.is_deleted' => 0]);
            }])
            ->joinWith(['sessionEnc e'])
            ->where([
                'a.is_deleted' => 0,
            ])
            ->andWhere(['not', ['a.session_for' => 1]])
            ->andWhere(['not', ['a.session_enc_id' => $id]])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->limit(2)
            ->all();
        return $webinars;
    }
}