<?php

namespace account\controllers;

use common\models\ConversationMessages;
use common\models\ConversationParticipants;
use common\models\Conversations;
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
            $result = Users::find()
                ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                ->where([
                    'or',
                    ['like', 'first_name', $key],
                ])
                ->andWhere(['!=', 'user_enc_id',  Yii::$app->user->identity->user_enc_id ])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->all();
            return json_encode($result);
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
            return json_encode($result);
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

    public function actionGetRandomValues(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            $result = Users::find()
                ->select(['user_enc_id', 'first_name', 'initials_color', 'last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                ->where(['is_deleted' => 0])
                ->orderBy(new Expression('rand()'))
                ->limit(10)
                ->asArray()
                ->all();
            return json_encode($result);
        }
    }

    private function createConversation($uniqueid, $sender, $receiver){
        $conversations = new Conversations();
        $conversations->conversation_enc_id = $uniqueid;
        $conversations->created_by = $sender;
        if($conversations->save()){
            $saveSender = $this->addToParticipants($sender, $conversations->conversation_enc_id);
            $saveReceiver = $this->addToParticipants($receiver, $conversations->conversation_enc_id);
            if($saveSender && $saveReceiver){
                return true;
            }
            return false;
        }
    }

    private function addToParticipants($user_id, $cid){
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

    public function actionSaveMessages(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $sender = Yii::$app->request->post('sender');
            $receiver = Yii::$app->request->post('receiver');
            $message = Yii::$app->request->post('message');
            $uniqueid = Yii::$app->request->post('uniqueid');
            $messagekey = Yii::$app->request->post('key');

            $message = Html::encode($message);

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
                if(!$this->createConversation($uniqueid, $sender, $receiver)){
                    return json_encode($failure);
                }
            }

            $pid = ConversationParticipants::find()
                        ->select(['participant_enc_id'])
                        ->where(['conversation_enc_id' => $uniqueid])
                        ->andWhere(['user_enc_id' => $sender])
                        ->asArray()
                        ->one();

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