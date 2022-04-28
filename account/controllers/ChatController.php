<?php

namespace account\controllers;

use common\models\AppliedApplications;
use common\models\ConversationMessages;
use common\models\ConversationParticipants;
use common\models\Conversations;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\db\Expression;
use common\models\Utilities;
use yii\helpers\Html;
use yii\web\Response;

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
                    ->select(['user_enc_id','first_name', 'REPLACE(initials_color, "#", "") as initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
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
                    ->andWhere([
                        'or',
                        ['a.status' => 'Accepted'],
                        ['a.status' => 'Hired']
                    ])
                    ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->groupBy(['b.organization_enc_id'])
                    ->asArray()
                    ->all();
                foreach ($applied_applications as $a){
                    array_push($organization_ids, $a['organization_enc_id']);
                }
                $applicable_organizations = Organizations::find()
                    ->select(['organization_enc_id user_enc_id', 'name first_name', 'REPLACE(initials_color, "#", "") as initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
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
//                ->select(['user_enc_id','first_name', 'initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
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
                ->select(['user_enc_id','first_name', 'REPLACE(initials_color, "#", "") as initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->all();
            if(count($result) == 0){
                $r = Organizations::find()
                    ->select(['organization_enc_id user_enc_id', 'name first_name', 'REPLACE(initials_color, "#", "") as initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
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

            if(Yii::$app->user->identity->organization->organization_enc_id) {
                $allConversations = Conversations::find()
                    ->alias('a')
                    ->select(['a.conversation_enc_id'])
                    ->joinWith(['conversationParticipants b'], false)
                    ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
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
                        ->andWhere(['!=', 'organization_enc_id',  Yii::$app->user->identity->organization->organization_enc_id])
                        ->asArray()
                        ->all();

                    $r = [];

                    foreach($users as $u){
                        array_push($r, $u["user_enc_id"]);
                    }

                    $result = Users::find()
                        ->select(['user_enc_id', 'first_name', 'REPLACE(initials_color, "#", "") as initials_color', 'last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
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
            }else{
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
                        ->select(['organization_enc_id'])
                        ->where(['in','conversation_enc_id',$recentChats])
                        ->andWhere(['!=', 'user_enc_id',  Yii::$app->user->identity->user_enc_id ])
                        ->asArray()
                        ->all();

                    $r = [];

                    foreach($users as $u){
                        array_push($r, $u["organization_enc_id"]);
                    }

                    $result = Organizations::find()
                        ->select(['organization_enc_id user_enc_id', 'name first_name', 'REPLACE(initials_color, "#", "") as initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
                        ->where(['in', 'organization_enc_id', $r])
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
              ->select(['user_enc_id','first_name', 'REPLACE(initials_color, "#", "") as initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
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
                ->andWhere([
                    'or',
                    ['a.status' => 'Accepted'],
                    ['a.status' => 'Hired']
                ])
                ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                ->groupBy(['b.organization_enc_id'])
                ->limit(10)
                ->asArray()
                ->all();
            foreach ($applied_applications as $a){
                array_push($organization_ids, $a['organization_enc_id']);
            }
            $applicable_organizations = Organizations::find()
                ->select(['organization_enc_id user_enc_id', 'name first_name', 'REPLACE(initials_color, "#", "") as initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
                ->where(['in', 'organization_enc_id', $organization_ids])
                ->asArray()
                ->all();
        }
    }

    public function actionGetRandomValues(){
        $referrerUrl = trim(Yii::$app->request->referrer, '/');
        $urlParts = parse_url($referrerUrl);;
        $actionid = explode('/', $urlParts['path'])[2];
        $actionSlug = explode('/', $urlParts['path'])[3];
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            if(Yii::$app->user->identity->organization->organization_enc_id){
                $applied_ids = [];
                $applied_candidates = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.created_by','a.application_enc_id'])
                    ->joinWith(['applicationEnc b' => function($x){
                        $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'Active']);
                    }], false)
                    ->where(['a.is_deleted' => 0])
                    ->andWhere(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]);
                    if($actionid == 'process-applications') {
                        $applied_candidates ->andWhere(['not',['a.status' => 'Rejected']]);
                    }
                    $applied_candidates = $applied_candidates->groupBy(['a.created_by'])
                    ->orderBy([new Expression('FIELD (a.application_enc_id, "'.$actionSlug.'") DESC'),'a.application_enc_id' => SORT_ASC])
                    ->groupBy(['a.created_by'])
                    ->limit(10)
                    ->asArray()
                    ->all();
                    if($applied_candidates) {
                        foreach ($applied_candidates as $a) {
                            array_push($applied_ids, $a['created_by']);
                        }
                    }
                $strAppliedUsers = implode(',',$applied_ids);
                $applicable_users = Users::find()
                    ->select(['user_enc_id','first_name', 'REPLACE(initials_color, "#", "") as initials_color','last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
                    ->where(['in', 'user_enc_id', $applied_ids])
                    ->orderBy([new Expression('FIELD (user_enc_id, "' . $strAppliedUsers .'") ASC')])
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
                    ->andWhere([
                        'or',
                        ['a.status' => 'Accepted'],
                        ['a.status' => 'Hired']
                    ])
                    ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->groupBy(['b.organization_enc_id'])
                    ->limit(10)
                    ->asArray()
                    ->all();
                foreach ($applied_applications as $a){
                    array_push($organization_ids, $a['organization_enc_id']);
                }
                $applicable_organizations = Organizations::find()
                    ->select(['organization_enc_id user_enc_id', 'name first_name', 'REPLACE(initials_color, "#", "") as initials_color', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END image'])
                    ->where(['in', 'organization_enc_id', $organization_ids])
                    ->asArray()
                    ->all();
                return json_encode($applicable_organizations);
            }
//            $result = Users::find()
//                ->select(['user_enc_id', 'first_name', 'initials_color', 'last_name', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", image_location, "/", image) ELSE NULL END image'])
//                ->where(['is_deleted' => 0])
//                ->orderBy(new Expression('rand()'))
//                ->limit(10)
//                ->asArray()
//                ->all();
//            return json_encode($result);
        }
    }

    private function createConversation($uniqueid, $sender, $sender_organization_id = null){
        $conversations = new Conversations();

        $conversations->conversation_enc_id = $uniqueid;

        if($sender_organization_id) {
            $conversations->created_by = $sender_organization_id;
        }else{
            $conversations->created_by = $sender;
        }

        if($conversations->save()){
            $saveSender = $this->addToParticipants($sender, $conversations->conversation_enc_id, $sender_organization_id);

            if($saveSender){
                return true;
            }
            return false;
        }
    }

    private function addToParticipants($user_id, $cid, $organization_id){
        $utilitiesModel = new Utilities();
        $participants = new ConversationParticipants();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $participants->participant_enc_id = $utilitiesModel->encrypt();
        $participants->conversation_enc_id = $cid;
        if($organization_id){
            $participants->organization_enc_id = $user_id;
            $participants->user_enc_id = $organization_id;
            $participants->created_by = $organization_id;
        }else{
            $participants->user_enc_id = $user_id;
            $participants->created_by = $user_id;
        }
        if(!$participants->save()){
            return false;
        }else{
            return true;
        }
    }

    public function actionSaveSender(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $sender = Yii::$app->request->post('sender');
            $sender_organization_id = Yii::$app->request->post('sender_organization_id');
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
                if(!$this->createConversation($uniqueid, $sender, $sender_organization_id)){
                    return json_encode($failure);
                }
            }


            if($sender_organization_id) {
                $pid = ConversationParticipants::find()
                    ->select(['participant_enc_id'])
                    ->where(['conversation_enc_id' => $uniqueid])
                    ->andWhere(['organization_enc_id' => $sender])
                    ->asArray()
                    ->one();
            }else{
                $pid = ConversationParticipants::find()
                    ->select(['participant_enc_id'])
                    ->where(['conversation_enc_id' => $uniqueid])
                    ->andWhere(['user_enc_id' => $sender])
                    ->asArray()
                    ->one();
            }


            $created_by_msg = null;
            if($sender_organization_id){
                $created_by_msg = $sender_organization_id;
            }else{
                $created_by_msg = $sender;
            }

            if(!$this->saveMessage($uniqueid, $messagekey, $pid['participant_enc_id'], $created_by_msg, $message)){
                return json_encode($failure);
            }else{
                return json_encode($success);
            }
        }
    }

    public function actionSaveReceiver(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $receiver = Yii::$app->request->post('receiver');
            $unique_id = Yii::$app->request->post('uniqueid');

            $success = [
                'code' => 200,
                'message' => 'success'
            ];

            $failure = [
                'code' => 201,
            ];

            if(Yii::$app->user->identity->organization->organization_enc_id) {
                $receiver_organization_id = Yii::$app->user->identity->user_enc_id;
                $this->addToParticipants($receiver, $unique_id, $receiver_organization_id);
            }else{
                $this->addToParticipants($receiver, $unique_id, null);
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


    private function _JobsOfCompany($appType){
        $allApplication = EmployerApplications::find()
            ->alias('a')
            ->select(['c.name job_title','a.application_enc_id','a.application_for','a.slug','pe.name', 'pe.icon', 'a.title', 'a.type','ate.name application_type',
                'ao.wage_type', 'ao.fixed_wage', 'ao.min_wage', 'ao.max_wage', 'ao.wage_duration',])
            ->joinWith(['title b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
            }], false, 'INNER JOIN')
            ->joinWith(['applicationTypeEnc ate'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->onCondition(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                $b->distinct();
            }])
            ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.is_deleted' => 0, 'ate.name' => $appType, 'a.status' => 'Active'])
            ->joinWith(['applicationOptions ao'], false)
            ->groupBy(['a.application_enc_id'])
            ->asArray()
            ->all();
        if($allApplication){
            foreach ($allApplication as $key => $value){
                if(!$value['applicationPlacementLocations']){
                    unset($allApplication[$key]['applicationPlacementLocations']);
                }
            }
        }
        return $allApplication;
    }

    public function actionGetAppliedCandidates(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $job_id=Yii::$app->request->post('job_id');

            $applied_users=AppliedApplications::find()
                ->alias('a')
                ->select(['a.applied_application_enc_id', 'a.created_by','c.phone', 'c.username','c.initials_color',
                    'CASE WHEN c.last_name IS NOT NULL THEN CONCAT(c.first_name, " ", c.last_name) ELSE c.first_name END name',
                    'CASE WHEN c.image IS NOT NULL THEN CONCAT("'. Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image).'", c.image_location, "/", c.image) ELSE NULL END image',
                    'cc.name city'])
                ->joinWith(['createdBy c'=>function($c){
                    $c->joinWith(['cityEnc cc']);
                }],false)
                ->where(['a.application_enc_id' => $job_id])
                ->asArray()
                ->all();

            $result = [
                'status' => 200,
                'applied_users' =>$applied_users,
            ];

            return $result;
        }
    }
    public function actionGetAllApplications(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type=Yii::$app->request->post('type');

            $allApplication=$this->_JobsOfCompany($type);
            $result = null;
            if($allApplication){
                $result = [
                    'status' => 200,
                    'allApplication' =>$allApplication,
                ];
            }else{
                $result = [
                    'status' => 201,
                    'message' => 'Some Error Occurred'
                ];
            }

            return $result;
        }
    }

    public function actionChatPage(){
        return $this->render('chat-page');
    }

}