<?php

namespace account\controllers;

use common\models\DropResumeApplications;
use common\models\DropResumeApplicationTitles;
use common\models\EmployerApplications;
use common\models\OrganizationAssignedCategories;
use common\models\Users;
use Yii;
use yii\web\Controller;

class UploadedResumeController extends Controller {

    public function actionAllResumeProfiles() {
        return $this->render('all-resume-profiles');
    }

    public function actionCandidateResumes() {
        $title_id = Yii::$app->request->get('id');
        $type = Yii::$app->request->get('type');
        $user_data = $this->getNewResumeData($title_id,$type);

        $organization_id = OrganizationAssignedCategories::find()
                            ->select(['organization_enc_id'])
                            ->where(['assigned_category_enc_id' => $title_id])
                            ->asArray()
                            ->one();

        $employer_applications = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.title', 'c.category_enc_id', 'd.name'])
            ->joinWith(['title c' => function($x){
                    $x->joinWith(['categoryEnc d'], false);
            }], false)
            ->joinWith(['organizationEnc b'], false)
            ->where(['b.organization_enc_id' => $organization_id['organization_enc_id']])
            ->andWhere(['c.assigned_to'=>$type])
            ->asArray()
            ->all();


        return $this->render('candidate-resumes',[
            'user_data'=>$user_data,
            'available_applications' => $employer_applications,
            'type'=>$type,
        ]);
    }

    private function getNewResumeData($title_id, $type){

        $parent_id = OrganizationAssignedCategories::find()
            ->select(['category_enc_id'])
            ->where(['assigned_category_enc_id'=>$title_id])
            ->asArray()
            ->one();

        $childs = OrganizationAssignedCategories::find()
            ->select(['assigned_category_enc_id'])
            ->where(['parent_enc_id'=>$parent_id['category_enc_id']])
            ->andWhere(['organization_enc_id'=>Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['assigned_to'=>$type])
            ->asArray()
            ->all();

        $titles = [];
        foreach ($childs as $c){
            array_push($titles,$c["assigned_category_enc_id"]);
        }

        $data = DropResumeApplications::find()
            ->alias('a')
            ->joinWith(['userEnc b'=> function($x){
                $x->select(['g.city_enc_id', 'g.name city_name','f.category_enc_id','b.job_function','f.name','b.user_enc_id','b.username','b.first_name','b.last_name','b.image','b.image_location', 'c.created_by']);
                $x->joinWith(['userSkills c' => function($y){
                    $y->select(['c.created_by','d.skill','c.skill_enc_id']);
                    $y->onCondition(['c.is_deleted'=>0]);
                    $y->joinWith(['skillEnc d'], false);
                }]);
                $x->joinWith(['jobFunction f'], false);
                $x->joinWith(['cityEnc g'], false);
            }])
            ->joinWith(['dropResumeApplicationTitles h'])
            ->where(['in','h.title',$titles])
            ->andWhere([
                'or',
                ['a.status' => 0],
                ['a.status' => 1]
            ])
            ->asArray()
            ->all();

        return $data;
    }



    public function actionReject(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post(selectedList);
            $success = ['status'=>200];
            $failure = ['status'=>201];
            foreach ($data as $d){
                if(!$this->setRejection($d)){
                    return json_encode($failure);
                }
            }
            return json_encode($success);
        }
    }

    private function setRejection($applied_title_enc_id){
        $reject = DropResumeApplications::find()
            ->where(['applied_application_enc_id'=>$applied_title_enc_id])
            ->andWhere(['status'=>0])
            ->one();
        $reject->status = 2;
        if($reject->update());
        {
            return true;
        }
    }

    public function actionShortList(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $applied_app_enc_id = Yii::$app->request->post('selected_candidates');
            $application_id = Yii::$app->request->post('application_selected');

            $success = ['status'=>200];
            $failure = ['status'=>201];

            foreach($applied_app_enc_id as $c){
                if (!$this->setShortList($c,$application_id)){
                    return json_encode($failure);
                }
            }
            return json_encode($success);

        }
    }

    private function setShortList($c,$application_id){
        $shortList = DropResumeApplications::find()
            ->where(['applied_application_enc_id'=>$c])
            ->andWhere(['status'=>0])
            ->one();
        $shortList->status = 1;
        $shortList->application_enc_id = $application_id;
        if($shortList->save());
        {
            return true;
        }
    }

}
