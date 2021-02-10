<?php

namespace account\controllers;

use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\DropResumeApplications;
use common\models\DropResumeAppliedApplications;
use common\models\DropResumeAppliedTitles;
use common\models\DropResumeOrgApplication;
use common\models\EmployerApplications;
use common\models\OrganizationAssignedCategories;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class UploadedResumeController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionAllResumeProfiles()
    {
        return $this->render('all-resume-profiles');
    }

    public function actionCandidateResumes()
    {
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $profile = Yii::$app->request->post('profile');
            $type = Yii::$app->request->post('type');
            $limit = Yii::$app->request->post('limit');
            $page = Yii::$app->request->post('page');
            $user_data = $this->getDropResumeApplication($profile, $type,$limit,$page);
            if ($user_data){
                return [
                    'status'=>200,
                    'cards'=>$user_data
                ];
            }else{
                return [
                    'status'=>201,
                ];
            }
       }
        $profile = Categories::findOne(['category_enc_id'=>Yii::$app->request->get('id')])->name;
        return $this->render('candidate-resumes', [
            'available_applications' => '',
            'profile_name'=>$profile
        ]);
    }

    private function getDropResumeApplication($profile, $type,$limit,$page){
        if (isset($limit)&&!empty($limit)) {
            $limit = $limit;
            $offset = ($page - 1) * $limit;
        }
        $data = DropResumeOrgApplication::find()
            ->alias('a')
            ->select(['a.application_enc_id','COUNT(d.parent_enc_id) count','a.organization_enc_id','a.applied_application_enc_id','CONCAT(f.first_name," ",f.last_name) name','f.initials_color','f.username','CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", image_location, "/", image) ELSE NULL END logo'])
            ->where(['a.organization_enc_id'=>Yii::$app->user->identity->organization_enc_id])
            ->joinWith(['appliedApplicationEnc b'=>function($x) use($profile,$type){
                $x->select(['b.applied_application_enc_id',
                'g.resume',
                'g.resume_location',
                '(CASE
                WHEN b.experience = "0" THEN "Fresher"
                WHEN b.experience = "1" THEN "Less Than 1 Year"
                WHEN b.experience = "2" THEN "1 Year"
                WHEN b.experience = "3" THEN "2-3 Years"
                WHEN b.experience = "4" THEN "3-5 Years"
                WHEN b.experience = "5" THEN "5-10 Years"
                WHEN b.experience = "6" THEN "10-20 Years"
                WHEN b.experience = "7" THEN "20+ Years"
                ELSE "Fresher"
               END) as experience']);
                $x->joinWith(['dropResumeAppliedTitles c'=>function($x) use ($profile,$type){
                    $x->select(['d.assigned_category_enc_id','c.applied_application_enc_id','e.name','d.parent_enc_id']);
                    $x->joinWith(['assignedCategoryEnc d'=>function($x) use ($profile,$type){
                        $x->andWhere(['d.parent_enc_id'=>$profile]);
                        $x->andWhere(['d.assigned_to'=>$type]);
                        $x->joinWith(['categoryEnc e'],false);
                    }],false);
                }],true,'INNER JOIN');
                $x->joinWith(['resumeEnc g'],false,'LEFT JOIN');
            }],true,'INNER JOIN')
            ->joinWith(['createdBy f'],false,'INNER JOIN')
            ->groupBy(['a.organization_enc_id','application_enc_id'])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        if ($data){
            $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            foreach ($data as $key=>$value){
                if ($data[$key]['appliedApplicationEnc']['resume']){
                    $data[$key]['resume'] = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $data[$key]['appliedApplicationEnc']['resume'] . DIRECTORY_SEPARATOR . $data[$key]['appliedApplicationEnc']['resume_location'], "15 minutes");
                }
            }
            return $data;
        }
    }

    private function getNewResumeData($title_id, $type)
    {

        $parent_id = OrganizationAssignedCategories::find()
            ->select(['category_enc_id'])
            ->where(['assigned_category_enc_id' => $title_id])
            ->asArray()
            ->one();

        $childs = OrganizationAssignedCategories::find()
            ->select(['assigned_category_enc_id'])
            ->where(['parent_enc_id' => $parent_id['category_enc_id']])
            ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
            ->andWhere(['assigned_to' => $type])
            ->asArray()
            ->all();

        $titles = [];
        foreach ($childs as $c) {
            array_push($titles, $c["assigned_category_enc_id"]);
        }

        $data = DropResumeApplications::find()
            ->alias('a')
            ->joinWith(['userEnc b' => function ($x) {
                $x->select(['g.city_enc_id', 'g.name city_name', 'f.category_enc_id', 'b.job_function', 'f.name', 'b.user_enc_id', 'b.username', 'b.first_name', 'b.last_name', 'b.image', 'b.image_location', 'c.created_by']);
                $x->joinWith(['userSkills c' => function ($y) {
                    $y->select(['c.created_by', 'd.skill', 'c.skill_enc_id']);
                    $y->onCondition(['c.is_deleted' => 0]);
                    $y->joinWith(['skillEnc d'], false);
                }]);
                $x->joinWith(['jobFunction f'], false);
                $x->joinWith(['cityEnc g'], false);
            }])
            ->joinWith(['dropResumeApplicationTitles h'])
            ->where(['in', 'h.title', $titles])
            ->andWhere([
                'or',
                ['a.status' => 0],
                ['a.status' => 1]
            ])
            ->asArray()
            ->all();

        return $data;
    }


    public function actionReject()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $data = Yii::$app->request->post(selectedList);
            $success = ['status' => 200];
            $failure = ['status' => 201];
            foreach ($data as $d) {
                if (!$this->setRejection($d)) {
                    return json_encode($failure);
                }
            }
            return json_encode($success);
        }
    }

    private function setRejection($applied_title_enc_id)
    {
        $reject = DropResumeApplications::find()
            ->where(['applied_application_enc_id' => $applied_title_enc_id])
            ->andWhere(['status' => 0])
            ->one();
        $reject->status = 2;
        if ($reject->update()) ;
        {
            return true;
        }
    }

    public function actionShortList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $applied_app_enc_id = Yii::$app->request->post('selected_candidates');
            $application_id = Yii::$app->request->post('application_selected');

            $success = ['status' => 200];
            $failure = ['status' => 201];

            foreach ($applied_app_enc_id as $c) {
                if (!$this->setShortList($c, $application_id)) {
                    return json_encode($failure);
                }
            }
            return json_encode($success);

        }
    }

    private function setShortList($c, $application_id)
    {
        $shortList = DropResumeApplications::find()
            ->where(['applied_application_enc_id' => $c])
            ->andWhere(['status' => 0])
            ->one();
        $shortList->status = 1;
        $shortList->application_enc_id = $application_id;
        if ($shortList->save()) ;
        {
            return true;
        }
    }

}
