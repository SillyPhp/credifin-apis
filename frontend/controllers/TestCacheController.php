<?php

namespace frontend\controllers;
use common\models\Categories;
use common\models\OpenTitles;
use common\models\User;
use common\models\Usernames;
use common\models\UserTypes;
use frontend\models\applications\Careerjet_API;
use common\models\AppliedApplications;
use common\models\Auth;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\Posts;
use common\models\SkillsUpPostAssignedBlogs;
use common\models\Users;
use common\models\RandomColors;
use common\models\Utilities;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionTest()
    {
        try {
            $model = new Auth();
            $model->user_id = 12;
            if (!$model->save()) //model errors
            {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
            }

            //some kind of err
        } catch (\Exception $exception) {
            return $exception->getMessage(); //final messege for user
        }
    }

        public function actionBulkEmail($start=0,$end=0){
            $user_type = UserTypes::findOne([
                'user_type' => 'Individual',
            ]);
            $query = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id','a.applicant_name','a.email','a.phone'])
                ->joinWith(['educationLoanPayments b'],false)
                ->where(['a.created_by'=>null])
//                ->andWhere(['b.payment_status'=>'captured'])
                ->asArray()
                ->all();
            for ($i=$start;$i<$end;$i++){
                    $username = $this->generate_username($query[$i]['applicant_name'], 10000);
                    $array_name = explode(' ',$query[$i]['applicant_name']);
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['password'] = $query[$i]['phone'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $user = new Users([
                            'username' => $username,
                            'user_enc_id' => Yii::$app->security->generateRandomString(32),
                            'first_name' =>$array_name[0],
                            'last_name' => $array_name[1].(($array_name[2])?$array_name[2]:null),
                            'email' => $query['email'],
                            'phone' => $query['phone'],
                            'password' => $utilitiesModel->encrypt_pass(),
                            'auth_key' => Yii::$app->security->generateRandomString(8),
                            'user_type_enc_id' => $user_type->user_type_enc_id,
                            'status' => 'Active',
                            'initials_color' => RandomColors::one(),
                            'is_credential_change' => 1,
                        ]);
                        if ($user->save()) {
                            $usernamesModel = new Usernames();
                            $usernamesModel->username = $username;
                            $usernamesModel->assigned_to = 1;
                            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                                $transaction->rollBack();
                                //throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($usernamesModel->errors, 0, false)));
                            }
                            $loan = LoanApplications::findOne(['loan_app_enc_id'=>$query['loan_app_enc_id']]);
                            $loan->created_by = $user->user_enc_id;
                            if (!$loan->save){
                                $transaction->rollBack();
                                //throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loan->errors, 0, false)));
                            }else{
                                $params = [];
                                $params['username'] = $username;
                                $params['password'] = $query['phone'];
                                $params['email'] = $query['email'];
                                $params['name'] = $query['applicant_name'];
                                echo $this->educationLoanRegister($params);
                            }
                        }else{
                            $transaction->rollBack();
                            //throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($user->errors, 0, false)));
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        //return $e;
                    }
            }
        }

    private function generate_username($string_name=null, $rand_no = 200){
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
        $part3 = ($rand_no)?rand(0, $rand_no):"";

        $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }

    public function actionApplicationStatusEmail(){
        $params = AppliedApplications::find()
            ->alias('a')
            ->select(['CONCAT(b.first_name," ",b.last_name) name','b.email','a.applied_application_enc_id applied_id'])
            ->where(['application_enc_id'=>'2DeBxPEjOGdjkjgnV3beQpqANyVYw9','current_round'=>2])
            ->innerJoin(Users::tableName().'as b','b.user_enc_id = a.created_by')
            ->asArray()
            ->all();
        $k = 0;
        foreach ($params as $param){
            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
                ['html' => 'job-process-status'],['data'=>$param]
            )
                ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                ->setTo([$param['email'] => $param['name']])
                ->setSubject('Your Job Application Has Been Accepted');
            if ($mail->send()) {
                $k++;
            }
        }
        echo $k;
    }
    public function actionMoveTitles($limit=50, $offset=0){
        $_flag = false;
        $model = OpenTitles::find()
            ->select(['title_enc_id','name'])
            ->where(['is_deleted' => 0])
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['created_on' => SORT_DESC])
            ->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model) {
            foreach ($model as $m) {
                $category = Categories::find()
                    ->where(['name' => $m->name])
                    ->asArray()
                    ->one();
                if (empty($category)) {
                    $category = new Categories();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $category->category_enc_id = $m->title_enc_id;
                    $category->name = $m->name;
                    $utilitiesModel->variables['name'] = $category->name;
                    $utilitiesModel->variables['table_name'] = Categories::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $category->slug = $utilitiesModel->create_slug();
                    $category->source = 1;
                    $category->created_on = date('Y-m-d H:i:s');
                    $category->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($category->save()) {
                        $_flag = true;
                    } else {
                        $_flag = false;
                    }
                }
                $titleModel = OpenTitles::findOne(['title_enc_id' => $m->title_enc_id]);
                $titleModel->is_deleted = 1;
                $titleModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
                $titleModel->last_updated_on = date('Y-m-d H:i:s');
                if($titleModel->save()){
                    $_flag = true;
                } else {
                    $_flag = false;
                }
            }
            if($_flag){
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Data Move Successfully'
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Oops!!',
                    'message' => 'Something went wrong...'
                ];
            }
        } else {
            return [
                'status' => 201,
                'title' => 'Oops!!',
                'message' => 'Data Not Found'
            ];
        }
    }
}
