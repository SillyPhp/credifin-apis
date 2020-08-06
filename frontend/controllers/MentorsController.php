<?php

namespace frontend\controllers;

use common\models\Speakers;
use common\models\WebinarConversationMessages;
use common\models\WebinarConversations;
use common\models\Webinars;
use common\models\WebinarSpeakers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

class MentorsController extends Controller
{
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

    public function actionWebinarView()
    {
        $type = 'view';
        return $this->render('webinar-view', ['type' => $type]);
    }

    public function actionWebinarLive()
    {
        $type = 'broadcast';
        return $this->render('webinar-view', ['type' => $type]);
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
                    'a.fullname',
                    'a.image', 'a.image_location',
                    'a.description',
                    'a.facebook', 'a.twitter', 'a.instagram', 'a.linkedin',
                    'a.is_deleted',
                    'b.designation',
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
                        $image_path = Yii::$app->params->upload_directories->speakers->image_path . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        if (file_exists($image_path)) {
                            $image = Yii::$app->params->upload_directories->speakers->image . $item['image_location'] . DIRECTORY_SEPARATOR . $item['image'];
                        }
                    }
                    $item['speaker_image'] = $image;
                    $item['speaker_image_fake'] = Url::to('@eyAssets/images/pages/webinar/speaker1.jpg');
                    $item['org_image'] = Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo . $item['org_logo_location'] . '/' . $item['org_logo']);
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