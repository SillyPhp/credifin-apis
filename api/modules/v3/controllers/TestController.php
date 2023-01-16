<?php

namespace api\modules\v3\controllers;

use api\modules\v1\models\Candidates;
use common\models\LoanApplications;
use common\models\Utilities;
use common\models\AssignedCategories;
use common\models\AssignedSkills;
use common\models\OpenJobRelatedSkills;
use common\models\OpenTitles;
use common\models\Skills;
use common\models\UserAccessTokens;
use Yii;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'demo' => ['OPTIONS', 'POST'],
                'move-titles' => ['OPTIONS', 'GET'],
                'empower-loans-bot' => ['POST'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionDemo()
    {
        if ($user = $this->isAuthorized()) {
            return $this->response(200, $user->user_enc_id);
        } else {
            return $this->response(401, 2);
        }
    }

    public function actionMoveTitles($limit = 100)
    {
        $openTitle = OpenTitles::find()
            ->where(['is_deleted' => 0])
            ->limit($limit)
            ->all();
        $_flag = false;
        if ($openTitle) {
            foreach ($openTitle as $title) {
                $profile = \common\models\Categories::findOne(['name' => $title->name]);
                if (!$profile) {
                    $profile = new \common\models\Categories();
                    $profile->category_enc_id = $title->title_enc_id;
                    $profile->name = $title->name;
                    $profile->slug = $title->slug;
                    $profile->source = 1;
                    if ($profile->save()) {
                        $_flag = true;
                    } else {
                        $_flag = false;
                    }
                    $assignJob = AssignedCategories::find()
                        ->andWhere(['category_enc_id' => $profile->category_enc_id])
                        ->andWhere(['assigned_to' => 'Jobs'])->one();
                    if (empty($assignJob)) {
                        $_flag = self::CreateAssignCat($profile->category_enc_id, 'Jobs');
                    }
                    $assignIntern = AssignedCategories::find()
                        ->andWhere(['category_enc_id' => $profile->category_enc_id])
                        ->andWhere(['assigned_to' => 'Internships'])->one();
                    if (empty($assignIntern)) {
                        $_flag = self::CreateAssignCat($profile->category_enc_id, 'Internships');
                    }
                    if ($_flag) {
                        $openTitleSkills = OpenJobRelatedSkills::find()
                            ->alias('a')
                            ->select(['a.skill_enc_id', 'b.name', 'a.level', 'a.importance', 'b.slug'])
                            ->joinWith(['skillEnc b'], false)
                            ->andWhere(['a.title_enc_id' => $profile->category_enc_id])
                            ->andWhere(['not', ['a.level' => 0]])
                            ->asArray()
                            ->all();
                        foreach ($openTitleSkills as $row) {
                            $createSkill = Skills::find()
                                ->where(['skill' => $row['name']])
                                ->one();
                            if (!$createSkill) {
                                $createSkill = new Skills();
                                $createSkill->skill_enc_id = $row['skill_enc_id'];
                                $createSkill->skill = $row['name'];
                                $createSkill->status = 'Publish';
                                $createSkill->source = 1;
                                $createSkill->created_on = date('Y-m-d H:i:s');
                                $createSkill->created_by = Yii::$app->user->identity->user_enc_id;
                                if ($createSkill->save()) {
                                    $_flag = true;
                                } else {
                                    $_flag = false;
                                }
                            }
                            if ($_flag) {
                                $skillId = $createSkill->skill_enc_id;
                                $skillJob = AssignedSkills::find()
                                    ->andWhere(['skill_enc_id' => $createSkill->skill_enc_id, 'category_enc_id' => $profile->category_enc_id])
                                    ->andWhere(['assigned_to' => 'Jobs'])
                                    ->asArray()
                                    ->one();
                                if (empty($skillJob)) {
                                    $_flag = self::CreateAssignSkill($skillId, $profile->category_enc_id, 'Jobs', $row['importance'], $row['level']);
                                }
                                $skillInternships = AssignedSkills::find()
                                    ->andWhere(['skill_enc_id' => $createSkill->skill_enc_id, 'category_enc_id' => $profile->category_enc_id])
                                    ->andWhere(['assigned_to' => 'Internships'])
                                    ->asArray()
                                    ->one();
                                if (empty($skillInternships)) {
                                    $_flag = self::CreateAssignSkill($skillId, $profile->category_enc_id, 'Internships', $row['importance'], $row['level']);
                                }
                            }
                        }
                    }
                    if ($_flag) {
                        $title->is_deleted = 1;
                        $title->last_updated_on = date('Y-m-d H:i:s');
                        $title->last_updated_by = '7B0P3kNEldvG6k9rJmvvQm14wrJXbj';
                        if ($title->save()) {
                            $_flag = true;
                        } else {
                            $_flag = false;
                        }
                    }
                }
            }
            if ($_flag) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Title Move Successfully.',
                ]);
            } else {
                return $this->response(201, [
                    'status' => 201,
                    'title' => 'Oops!!',
                    'message' => 'Something went wrong...',
                ]);
            }
        } else {
            return $this->response(201, [
                'status' => 201,
                'title' => 'Oops!!',
                'message' => 'Data not found',
            ]);
        }
    }

    private function CreateAssignCat($id, $type)
    {
        $assignCat = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignCat->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignCat->category_enc_id = $id;
        $assignCat->assigned_to = $type;
        $assignCat->status = 'Pending';
        $assignCat->created_on = date('Y-m-d H:i:s');
        $assignCat->created_by = '7B0P3kNEldvG6k9rJmvvQm14wrJXbj';
        if ($assignCat->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function CreateAssignSkill($skillId, $id, $type, $importance, $level)
    {
        $createAssignSkill = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $createAssignSkill->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $createAssignSkill->skill_enc_id = $skillId;
        $createAssignSkill->category_enc_id = $id;
        $createAssignSkill->assigned_to = $type;
        $createAssignSkill->importance = $importance;
        $createAssignSkill->level = $level;
        $createAssignSkill->status = 'Approved';
        $createAssignSkill->created_on = date('Y-m-d H:i:s');
        $createAssignSkill->created_by = '7B0P3kNEldvG6k9rJmvvQm14wrJXbj';
        if ($createAssignSkill->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function actionEmpowerLoansBot()
    {
        $path = "https://api.telegram.org/bot5793101730:AAHcjiMIF2hpWc8EQcwTm8hHfc55G3iAy48";
        $update = file_get_contents('php://input');
        //$update = json_decode($update, true);
       // $chatId = $update["message"]["chat"]["id"];
        //$message = json_encode($update["message"]["photo"]);
        $content = LoanApplications::findOne(['phone'=>'9592868808','loan_app_enc_id'=>'zroPWqDpjZxLwap2o48KZJnYE3wX6x']);
        $content->applicant_name = $update;
        $content->save();
        die();
        if ($message){
            $data = [];
            $data['apiKey'] = "bot5793101730:AAHcjiMIF2hpWc8EQcwTm8hHfc55G3iAy48";
            $data['groupId'] = $chatId;
            $data['content'] = $message;
            $res = $this->sendTelegram($data);
            if ($res['ok'] == true) {
                return 'done';
            } else {
                return 'failed';
            }
        }
        if (strpos($message, "/getLoans")===0){
            $number = substr($message, 10);
            $content = LoanApplications::findOne(['phone'=>$number]);
            if ($content){
                $str = "\xE2\x9C\x85 <b> Application Name:".$content->applicant_name."</b>" . chr(10) . chr(10) . "\xE2\x9C\x85<b> Laon Amount:".$content->amount." Rs</b>". chr(10) . chr(10) . "\xE2\x9C\x85<b> City:".$content->amount." Rs</b>";
                $data = [];
                $data['apiKey'] = "bot5793101730:AAHcjiMIF2hpWc8EQcwTm8hHfc55G3iAy48";
                $data['groupId'] = $chatId;
                $data['url'] = "https://www.empoweryouth.com/job/sales-manager-sales-manager-85001640948993";
                //  $data['content'] = "\xE2\x9C\x85 <b>Location:Ludhiana</b>" . chr(10) . chr(10) . "\xE2\x9C\x85<b>Designation:Sales Manager</b>" . chr(10) . chr(10) . "https://www.empoweryouth.com/job/sales-manager-sales-manager-85001640948993";
                $data['content'] = $str;
                $data['ButtonText'] = "Apply";
                $data['ButtonUrl'] = "https://www.empoweryouth.com/job/sales-manager-sales-manager-85001640948993";
                $res = $this->sendTelegram($data);
                if ($res['ok'] == true) {
                    return 'done';
                } else {
                    return 'failed';
                }
            }else{
                $data = [];
                $data['apiKey'] = "bot5793101730:AAHcjiMIF2hpWc8EQcwTm8hHfc55G3iAy48";
                $data['groupId'] = $chatId;
                $data['url'] = "https://www.empoweryouth.com/job/sales-manager-sales-manager-85001640948993";
                //  $data['content'] = "\xE2\x9C\x85 <b>Location:Ludhiana</b>" . chr(10) . chr(10) . "\xE2\x9C\x85<b>Designation:Sales Manager</b>" . chr(10) . chr(10) . "https://www.empoweryouth.com/job/sales-manager-sales-manager-85001640948993";
                $data['content'] = 'Mobile Number Not Found';
                $data['ButtonText'] = "Apply";
                $data['ButtonUrl'] = "https://www.empoweryouth.com/job/sales-manager-sales-manager-85001640948993";
                $res = $this->sendTelegram($data);
                if ($res['ok'] == true) {
                    return 'done';
                } else {
                    return 'failed';
                }
            }
        }
    }

    private function sendTelegram($data){
            $ch = curl_init("https://api.telegram.org/".$data['apiKey']."/sendMessage");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                "text" => $data['content'],
                "chat_id"=>$data['groupId'],
                "parse_mode"=>"html",
                "reply_markup"=>[
                    "inline_keyboard"=>[[
//                        ["text"=>$data['ButtonText'],
//                            "url"=>$data['ButtonUrl']
//                        ]
                    ]]
                ]
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
            ]);
            $response = curl_exec($ch);
            $response = json_decode($response,true);
            return $response;
    }
}