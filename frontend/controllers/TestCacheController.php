<?php

namespace frontend\controllers;
use common\models\Categories;
use common\models\CreditLoanApplicationReports;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanCoApplicants;
use common\models\OpenTitles;
use common\models\TestData;
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
use common\models\EmiCollection;
use common\models\RandomColors;
use common\models\Utilities;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class TestCacheController extends Controller
{

    public function actionFaker(){
        $result = self::generateApplicationNumber();
        $model = new TestData();
        $model->loan_account_number = $result;
        if (!$model->save()) {
            print_r($model->getErrors());
            exit();
        }
        //echo $result;
        echo $result;
    }

    public static function generateApplicationNumber($cityCode,$purposeCode,$loap_p_code,$yearmonth)
    {
        for ($i=0;$i<=100;$i++){
            $loan_num['product_code'] = $loap_p_code;
            $branchCode = '';
            $cityCode = $cityCode;
            $purposeCode = $purposeCode;
            $finalPurposeCode = $purposeCode ? '-' . $purposeCode : '';

            $yearmonth = $yearmonth;

            $loanAccountNumber = "{$loan_num['product_code']}{$finalPurposeCode}-{$cityCode}-{$yearmonth}";
            $pattern1 = "{$loan_num['product_code']}-%-{$cityCode}-{$yearmonth}-%";
            $pattern2 = "{$loan_num['product_code']}-{$cityCode}-{$yearmonth}-%";
            $incremental = LoanApplications::find()
                ->alias('a')
                ->select(['a.application_number'])
                ->where([
                    'OR',
                    ['LIKE', 'application_number', $pattern1,false],
                    ['LIKE', 'application_number', $pattern2,false]
                ])
                ->orderBy([
                    "CAST(SUBSTRING_INDEX(application_number, '-', -1) AS UNSIGNED)" => SORT_DESC
                ])
                ->limit(1)
                ->one();
            if ($incremental) {
                $my_string = $incremental['application_number'];
                $my_array = explode('-', $my_string);
                $prev_num = ((int)$my_array[count($my_array) - 1] + 1);
                $new_num = $prev_num <= 9 ? '00' . $prev_num : ($prev_num < 99 ? '0' . $prev_num : $prev_num);
                $final_num = "$loanAccountNumber-{$new_num}";
                return $final_num;
            } else {
                return "$loanAccountNumber-001";
            }
        }
    }

    public function actionDuplicate($page=1,$limit=500){
        $offset = ($page - 1) * $limit;
        $data = LoanApplications::find()
            ->select(['application_number','COUNT(*) count'])
            ->groupBy('application_number')
            ->where([
                'or',
                ['!=','application_number',Null],
                ['!=','application_number','']
            ])
            ->having('COUNT(*) > 1')
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
        if ($data):
        foreach ($data as $app) {
            $applicationNumber = $app['application_number'];
            $count = $app['count'];

            $ids = LoanApplications::find()
                ->select(['loan_app_enc_id'])
                ->where(['application_number' => $applicationNumber])
                ->asArray()
                ->column(); // Fetching IDs directly as an array

            $result[] = [
                'application_number' => $applicationNumber,
                'count' => $count,
                'IDs' => $ids,
            ];
        }
        //print_r($result);exit();
        foreach ($result as $dat){
            $loan_array = explode("-", $dat['application_number']);
            if (count($loan_array)==4){
                for ($i=0;$i<($dat['count']-1);$i++) {
                  echo  $newSeries = self::generateApplicationNumber($loan_array[1],null,$loan_array[0],$loan_array[2]);
                    self::saveNewSeries($newSeries,$dat['IDs'][$i]);
                }
            }else if (count($loan_array)==5){
                for ($i=0;$i<($dat['count']-1);$i++) {
                    $newSeries = self::generateApplicationNumber($loan_array[2],$loan_array[1],$loan_array[0],$loan_array[3]);
                   self::saveNewSeries($newSeries,$dat['IDs'][$i]);
                }
            }
        }
        else:
            echo 'no results left';
            endif;
    }
    private function saveNewSeries($newSeries,$id){
        $model = LoanApplications::findOne(['loan_app_enc_id'=>$id]);
        $model->application_number = $newSeries;
        if (!$model->save()){
            print_r($model->getErrors());
        }else{
            return false;
        }
    }
    public function actionCopyDuplicates($page=1,$limit=500){
        $offset = ($page - 1) * $limit;
        $data = LoanApplications::find()
            ->select(['application_number','COUNT(*) count'])
            ->groupBy('application_number')
            ->where([
                'or',
                ['!=','application_number',Null],
                ['!=','application_number','']
            ])
            ->having('COUNT(*) > 1')
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
        if ($data):
        foreach ($data as $dat){
            $updateAll[] =  LoanApplications::updateAll(['old_application_number'=>$dat['application_number']],['application_number'=>$dat['application_number']]);
        }
        echo count($updateAll);
        else:
            echo 'no results left';
            endif;
    }
}
