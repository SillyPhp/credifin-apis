<?php

namespace frontend\controllers;

use common\models\Speakers;
use common\models\WebinarConversationMessages;
use common\models\WebinarConversations;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
use common\models\WebinarSpeakers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;

class MentorsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['webinar-live', 'webinar-view'],
                'rules' => [
                    [
                        'actions' => ['webinar-live', 'webinar-view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionMentorshipIndex()
    {
        $model = new \frontend\models\mentorship\MentorshipEnquiryForm();

        return $this->render('mentorship-index', [
            'model' => $model,
        ]);
    }

    public function actionMentorProfile()
    {
        return $this->render('mentor-profile');
    }

    public function actionAllMentors()
    {
        return $this->render('all-mentors');
    }

    public function actionScoolMentorship()
    {
        return $this->render('scool-mentorship');
    }

    public function actionWebinarDetails()
    {
        return $this->render('webinar-details');
    }

    public function actionWebinarSpeakers()
    {
        return $this->render('speakers');
    }

    public function actionWebinarView($id)
    {
        $type = 'audience';
        $webinarDetail = self::getWebianrDetails($id);
        $webinars = self::getWebianrs($id);
//        $iframeUrl = '/live-stream/' . $type . '?id=' . $id;
        return $this->render('webinar-view', [
            'type' => $type,
            'webinars' => $webinars,
            'webinarDetail' => $webinarDetail
        ]);
    }

    public function actionWebinarLive($id)
    {
        $type = 'multi-stream';
        $webinarDetail = self::getWebianrDetails($id);
        $webinars = self::getWebianrs($id);
        $speakerIds = ArrayHelper::getColumn($webinarDetail['webinarSpeakers'], 'user_enc_id');
        if (in_array(Yii::$app->user->identity->user_enc_id, $speakerIds)) {
            return $this->render('webinar-view', [
                'type' => $type,
                'webinars' => $webinars,
                'webinarDetail' => $webinarDetail
            ]);
        } else {
            return $this->render('non-authorized');
        }
    }

    public function actionRegisterWebinar()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $key = Yii::$app->request->post('key');
            $chk = WebinarRegistrations::findOne(['webinar_enc_id' => $key, 'created_by' => Yii::$app->user->identity->user_enc_id]);
            if (!$chk) {
                $model = new WebinarRegistrations();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->register_enc_id = $utilitiesModel->encrypt();
                $model->webinar_enc_id = $key;
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                $model->status = 0;
                if ($model->save()) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Registered Successfully...',
                    ];
                } else {
                    return [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Something went wrong...',
                    ];
                }
            }
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

    public function actionGetWebinarSpeakers()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $offset = Yii::$app->request->post('offset');
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
                    'c.name org_name'
                ])
                ->where(['a.is_deleted' => 0])
                ->joinWith(['designationEnc b'], false)
                ->joinWith(['unclaimedOrg c'], false)
                ->joinWith(['speakerExpertises d' => function ($d) {
                    $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'e.skill']);
                    $d->joinWith(['skillEnc e'], false);
                }])
                ->joinWith(['userEnc f'], false)
                ->asArray()
                ->distinct()
                ->orderBy(['a.created_on' => SORT_DESC]);
            $totalSpeakerCount = $webSpeaker->count();
            $dataDetail = $webSpeaker->limit($limit)
                ->offset($offset)
                ->all();
            if ($dataDetail) {
                array_walk($dataDetail, function (&$item) {
                    if ($item['image']) {
                        $image_path = Yii::$app->params->upload_directories->users->image_path . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        if (file_exists($image_path)) {
                            $image = Yii::$app->params->upload_directories->users->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        }
                    }
                    $item['speaker_image'] = $image;
                    $item['speaker_image_fake'] = Url::to('@eyAssets/images/pages/webinar/default-user.png');
                    if($item['org_logo']){
                        $item['org_image'] = Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo . $item['org_logo_location'] . '/' . $item['org_logo']);
                    }
                    unset($item['image']);
                    unset($item['image_location']);
                    unset($item['org_logo']);
                    unset($item['org_logo_location']);
                });
            }
            return [
                'status' => 200,
                'cards' => $dataDetail,
                'total' => $totalSpeakerCount,
                'count' => sizeof($dataDetail)
            ];
        }
    }

    public function actionSaveConversation()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $webinar = Webinars::findOne(['session_enc_id' => $data['webinar_enc_id']]);
            $conversation_id = WebinarConversations::find()
                ->where(['webinar_enc_id' => $webinar->webinar_enc_id])
                ->one();

            if ($conversation_id) {
                $comment = new WebinarConversationMessages();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $comment->message_enc_id = $utilitiesModel->encrypt();
                $comment->conversation_enc_id = $conversation_id->conversation_enc_id;
                $comment->message = $data['message'];
                if (isset($data['reply_to']) && !empty($data['reply_to'])) {
                    $comment->parent_enc_id = $data['reply_to'];
                }
                $comment->created_on = date('Y-m-d H:i:s');
                $comment->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$comment->save()) {
                    return $response = [
                        'status' => 500,
                        'title' => 'Error',
                        'message' => 'an error occurred',
                    ];
                } else {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Successfully Added',
                    ];
                }
            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $conversation = new WebinarConversations();
                    $conversation->conversation_enc_id = $utilitiesModel->encrypt();
                    $conversation->conversation_type = 2;
                    $conversation->webinar_enc_id = $webinar->webinar_enc_id;
                    $conversation->created_by = Yii::$app->user->identity->user_enc_id;
                    $conversation->created_on = date('Y-m-d H:i:s');
                    if (!$conversation->save()) {
                        $transaction->rollBack();
                        return $response = [
                            'status' => 500,
                            'title' => 'Error',
                            'message' => 'an error occurred',
                        ];
                    }

                    $comment = new WebinarConversationMessages();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $comment->message_enc_id = $utilitiesModel->encrypt();
                    $comment->conversation_enc_id = $conversation->conversation_enc_id;
                    $comment->message = $data['message'];
                    if (isset($data['reply_to']) && !empty($data['reply_to'])) {
                        $comment->parent_enc_id = $data['reply_to'];
                    }
                    $comment->created_on = date('Y-m-d H:i:s');
                    $comment->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$comment->save()) {
                        $transaction->rollBack();
                        return $response = [
                            'status' => 500,
                            'title' => 'Error',
                            'message' => 'an error occurred',
                        ];
                    }

                    $transaction->commit();
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Successfully Added',
                    ];

                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return false;
                }
            }

        }
    }
}