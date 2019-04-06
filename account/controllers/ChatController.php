<?php

namespace account\controllers;

use common\models\AppliedApplications;
use common\models\ConversationMessages;
use common\models\ConversationParticipants;
use common\models\Conversations;
use common\models\Organizations;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\db\Expression;
use common\models\Utilities;
use yii\helpers\Html;

class ChatController extends Controller{

    public function actionSearchUser(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            $key =  Yii::$app->request->post('user');

            if(Yii::$app->user->identity->organization->organization_enc_id){
                $applied_ids = [];
                $applied_candidates = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.created_by'])
                    ->joinWith(['applicationEnc b' => function($x){
                        $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                    }], false)
                    ->where(['a.is_deleted' => 0])
                    ->andWhere(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                    ->groupBy(['a.created_by'])
                    ->asArray()
                    ->all();
                foreach ($applied_candidates as $a){
                    array_push($applied_ids, $a['created_by']);
                }
                $applicable_users = Users::find()
                    ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                    ->where(['in', 'user_enc_id', $applied_ids])
                    ->andWhere([
                        'or',
                        ['like', 'first_name', $key],
                    ])
                    ->asArray()
                    ->all();
                return json_encode($applicable_users);

            }else{
                $organization_ids = [];
                $applied_applications = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.applied_application_enc_id', 'a.application_enc_id', 'b.organization_enc_id'])
                    ->joinWith(['applicationEnc b' => function($x){
                        $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                    }], false)
                    ->where(['a.is_deleted' => 0])
                    ->andWhere(['a.status' => 'Accepted'])
                    ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->groupBy(['b.organization_enc_id'])
                    ->asArray()
                    ->all();
                foreach ($applied_applications as $a){
                    array_push($organization_ids, $a['organization_enc_id']);
                }
                $applicable_organizations = Organizations::find()
                    ->select(['organization_enc_id user_enc_id', 'name first_name', 'initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
                    ->where(['in', 'organization_enc_id', $organization_ids])
                    ->andWhere([
                        'or',
                        ['like', 'name', $key],
                    ])
                    ->asArray()
                    ->all();
                return json_encode($applicable_organizations);
            }
//            $result = Users::find()
//                ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
//                ->where([
//                    'or',
//                    ['like', 'first_name', $key],
//                ])
//                ->andWhere(['!=', 'user_enc_id',  Yii::$app->user->identity->user_enc_id ])
//                ->andWhere(['is_deleted' => 0])
//                ->asArray()
//                ->all();
//            return json_encode($result);
        }
    }

    public function actionGetName(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            $id =  Yii::$app->request->post('id');
            $result = Users::find()
                ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->all();
            if(count($result) == 0){
                $r = Organizations::find()
                    ->select(['organization_enc_id user_enc_id', 'name first_name', 'initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
                    ->where(['organization_enc_id' => $id])
                    ->asArray()
                    ->all();
                return json_encode($r);
            }else{
                return json_encode($result);
            }
        }
    }

    public function actionGetRecentUsers(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){

            $allConversations = Conversations::find()
                ->alias('a')
                ->select(['a.conversation_enc_id'])
                ->joinWith(['conversationParticipants b'], false)
                ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->all();

            if(count($allConversations) > 0){
                $recentChats = [];
                foreach($allConversations as $a){
                    array_push($recentChats, $a['conversation_enc_id']);
                }
                $users = ConversationParticipants::find()
                    ->select(['user_enc_id'])
                    ->where(['in','conversation_enc_id',$recentChats])
                    ->andWhere(['!=', 'user_enc_id',  Yii::$app->user->identity->user_enc_id ])
                    ->asArray()
                    ->all();

                $r = [];

                foreach($users as $u){
                    array_push($r, $u["user_enc_id"]);
                }

                $result = Users::find()
                    ->select(['user_enc_id', 'first_name', 'initials_color', 'last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                    ->where(['in', 'user_enc_id', $r])
                    ->limit(10)
                    ->asArray()
                    ->all();

                $res = [
                    'code' => 200,
                    'data' => $result
                ];

                return json_encode($res);
            }else{
                $noResult = [
                    'code'=>101,
                ];
                return json_encode($noResult);
            }
        }
    }

    public function actionTest(){
      if(Yii::$app->user->identity->organization->organization_enc_id){
            $applied_ids = [];
            $applied_candidates = AppliedApplications::find()
                ->alias('a')
                ->select(['a.created_by'])
                ->joinWith(['applicationEnc b' => function($x){
                    $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                }], false)
                ->where(['a.is_deleted' => 0])
                ->andWhere(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->groupBy(['a.created_by'])
                ->limit(10)
                ->asArray()
                ->all();
            foreach ($applied_candidates as $a){
                array_push($applied_ids, $a['created_by']);
            }
            $applicable_users = Users::find()
              ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
              ->where(['in', 'user_enc_id', $applied_ids])
              ->asArray()
              ->all();

      }else{
            $organization_ids = [];
            $applied_applications = AppliedApplications::find()
                                    ->alias('a')
                                    ->select(['a.applied_application_enc_id', 'a.application_enc_id', 'b.organization_enc_id'])
                                    ->joinWith(['applicationEnc b' => function($x){
                                        $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                                    }], false)
                                    ->where(['a.is_deleted' => 0])
                                    ->andWhere(['a.status' => 'Accepted'])
                                    ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                                    ->groupBy(['b.organization_enc_id'])
                                    ->limit(10)
                                    ->asArray()
                                    ->all();
          foreach ($applied_applications as $a){
              array_push($organization_ids, $a['organization_enc_id']);
          }
          $applicable_organizations = Organizations::find()
              ->select(['organization_enc_id user_enc_id', 'name first_name', 'initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
              ->where(['in', 'organization_enc_id', $organization_ids])
              ->asArray()
              ->all();
      }
    }

    public function actionGetRandomValues(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            if(Yii::$app->user->identity->organization->organization_enc_id){
                $applied_ids = [];
                $applied_candidates = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.created_by'])
                    ->joinWith(['applicationEnc b' => function($x){
                        $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                    }], false)
                    ->where(['a.is_deleted' => 0])
                    ->andWhere(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                    ->groupBy(['a.created_by'])
                    ->limit(10)
                    ->asArray()
                    ->all();
                foreach ($applied_candidates as $a){
                    array_push($applied_ids, $a['created_by']);
                }
                $applicable_users = Users::find()
                    ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                    ->where(['in', 'user_enc_id', $applied_ids])
                    ->asArray()
                    ->all();
                return json_encode($applicable_users);

            }else{
                $organization_ids = [];
                $applied_applications = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.applied_application_enc_id', 'a.application_enc_id', 'b.organization_enc_id'])
                    ->joinWith(['applicationEnc b' => function($x){
                        $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                    }], false)
                    ->where(['a.is_deleted' => 0])
                    ->andWhere(['a.status' => 'Accepted'])
                    ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->groupBy(['b.organization_enc_id'])
                    ->limit(10)
                    ->asArray()
                    ->all();
                foreach ($applied_applications as $a){
                    array_push($organization_ids, $a['organization_enc_id']);
                }
                $applicable_organizations = Organizations::find()
                    ->select(['organization_enc_id user_enc_id', 'name first_name', 'initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
                    ->where(['in', 'organization_enc_id', $organization_ids])
                    ->asArray()
                    ->all();
                return json_encode($applicable_organizations);
            }
//            $result = Users::find()
//                ->select(['user_enc_id', 'first_name', 'initials_color', 'last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
//                ->where(['is_deleted' => 0])
//                ->orderBy(new Expression('rand()'))
//                ->limit(10)
//                ->asArray()
//                ->all();
//            return json_encode($result);
        }
    }

    private function createConversation($uniqueid, $sender, $receiver, $sender_type, $sender_user_id, $receiver_type){
        $conversations = new Conversations();
        $conversations->conversation_enc_id = $uniqueid;
        if($sender_type) {
            $conversations->created_by = $sender_user_id;
        }else{
            $conversations->created_by = $sender;
        }
        if($conversations->save()){
            if($sender_type) {
                $saveSender = $this->addToParticipants($sender_user_id, $conversations->conversation_enc_id, $sender_type);
            }else{
                $saveSender = $this->addToParticipants($sender, $conversations->conversation_enc_id, $sender_type);
            }
            $saveReceiver = $this->addToParticipants($receiver, $conversations->conversation_enc_id, $receiver_type);
            if($saveSender && $saveReceiver){
                return true;
            }
            return false;
        }
    }

    private function addToParticipants($user_id, $cid, $type){
        $utilitiesModel = new Utilities();
        $participants = new ConversationParticipants();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $participants->participant_enc_id = $utilitiesModel->encrypt();
        $participants->conversation_enc_id = $cid;
        $participants->user_enc_id = $user_id;
        $participants->created_by = $user_id;
        if(!$participants->save()){
            return false;
        }else{
            return true;
        }
    }

    private function organizationExists($id){
        return Organizations::find()
            ->where(['organization_enc_id' => $id])
            ->exists();
    }

    public function actionSaveMessages(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $sender = Yii::$app->request->post('sender');
            $receiver = Yii::$app->request->post('receiver');
            $message = Yii::$app->request->post('message');
            $uniqueid = Yii::$app->request->post('uniqueid');
            $messagekey = Yii::$app->request->post('key');
            $message = Html::encode($message);

            $sender_type = false;
            $receiver_type = false;

            $sender_check = $this->organizationExists($sender);
            if($sender_check){
                $sender_user_id = Yii::$app->user->identity->user_enc_id;
                $sender_type = true;
            }

            $receiver_check = $this->organizationExists($receiver);
            if($receiver_check){
               $receiver_type = true;
            }

            $success = [
                'code' => 200,
                'message' => 'success'
            ];

            $failure = [
                'code' => 201,
            ];

            $conversationExists = Conversations::find()
                            ->where(['conversation_enc_id' => $uniqueid])
                            ->exists();

            if(!$conversationExists){
                if(!$this->createConversation($uniqueid, $sender, $receiver, $sender_type, $sender_user_id, $receiver_type)){
                    return json_encode($failure);
                }
            }

            if($sender_type) {
                $pid = ConversationParticipants::find()
                    ->select(['participant_enc_id'])
                    ->where(['conversation_enc_id' => $uniqueid])
                    ->andWhere(['user_enc_id' => $sender_user_id])
                    ->asArray()
                    ->one();

                if(count($pid) == 0){
                    if(!$this->addToParticipants($sender_user_id, $uniqueid)){
                        return json_encode($failure);
                    }else{
                        $pid = ConversationParticipants::find()
                            ->select(['participant_enc_id'])
                            ->where(['conversation_enc_id' => $uniqueid])
                            ->andWhere(['user_enc_id' => $sender_user_id])
                            ->asArray()
                            ->one();
                    }
                }
            }else{
                $pid = ConversationParticipants::find()
                    ->select(['participant_enc_id'])
                    ->where(['conversation_enc_id' => $uniqueid])
                    ->andWhere(['user_enc_id' => $sender])
                    ->asArray()
                    ->one();
            }

            if(!$this->saveMessage($uniqueid, $messagekey, $pid['participant_enc_id'], $sender, $message)){
                return json_encode($failure);
            }else{
                return json_encode($success);
            }
        }

    }

    private function saveMessage($uniqueid, $messagekey, $pid, $sender, $message){
        $messages = new ConversationMessages();
        $messages->message_enc_id = $messagekey;
        $messages->conversation_enc_id = $uniqueid;
        $messages->participant_enc_id = $pid;
        $messages->message = $message;
        $messages->created_by = $sender;
        if($messages->save()){
            return true;
        }
        return false;
    }

}