<?php

namespace frontend\controllers;
use common\models\IndianGovtDepartments;
use common\models\IndianGovtJobs;
use common\models\Utilities;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\HttpException;

class GovtJobsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
      return $this->render('index');
    }

    public function actionIndDepartmentDetail()
    {
        return $this->render('ind-department-detail');
    }

    public function actionDetail($id)
    {
        $get = IndianGovtJobs::find()
                ->select(['job_enc_id','slug','Organizations','Location','Position','Eligibility','Last_date','Pdf_link','Data'])
                ->where(['slug'=>$id])
                ->asArray()
                ->indexBy('job_enc_id')
                ->one();
        if (empty($get))
        {
            return 'Application Has Either Moved Or Deleted';
        }
        return $this->render('detail',['get'=>$get]);
    }
    public function actionGetData()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $offset = Yii::$app->request->post('offset');
            $keywords = Yii::$app->request->post('keywords');
            $d = IndianGovtJobs::find()
                    ->select(['job_enc_id id','slug','Organizations','Location','Position','Eligibility','Last_date'])
                    ->andFilterWhere([
                        'or',
                        'Organizations LIKE "%' . $keywords . '%"',
                        'Location LIKE "%' . $keywords . '%"',
                        'Position LIKE "%' . $keywords . '%"',
                        'Eligibility LIKE "%' . $keywords . '%"'
                    ]);

                  $data =  $d->limit($limit)
                    ->offset($offset)
                    ->orderBy(['job_id'=>SORT_DESC])
                    ->asArray()
                    ->all();
            return [
                'status'=>200,
                'cards'=>$data,
                'total'=>$d->count(),
                'count'=>sizeof($data)
            ];
        }
    }
    private  function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = $this->utf8ize($value);
        }
        } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
        return $mixed;
    }

    public function actionInsertData($getPath='https://ucf5e2e25dd692700dfc18eb1159.dl.dropboxusercontent.com/cd/0/get/AuobD2HY5EzCpm_a149ldbyYyj0C2CZlBivI4RKXlIAUYsNm53tjP8ceinb6yq3VZjhZ82wgtG_XCqiHKKzRrkZ7pR8g9vXcG9_Qk0hVUY8AP7gQ1lFM5I7hmuLZxugPkIs/file?dl=1#',$authkey='@empowerXaazs')
    {
        //for inserting data
        //$authkey='@empowerXaazs';
        if ($authkey !='@empowerXaazs'){
            return 'permision denied';
        }
        $csv = [];
        $i = 0;
        $path = $getPath;
        ini_set('auto_detect_line_endings', TRUE);
        if (($handle = fopen($path, "r")) !== false) {
            $columns = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle)) !== false) {
                $csv[] = array_combine($columns, $row);
                $i++;
            }
            ini_set('auto_detect_line_endings', FALSE);
            fclose($handle);
        }
        $csv = $this->utf8ize($csv);
        $len = count($csv);
        for ($k=0;$k<$len;$k++)
        {
          $jobsModel = new IndianGovtJobs();
          $utilitiesModel = new Utilities();
          $utilitiesModel->variables['string'] = time() . rand(100, 100000);
          $jobsModel->job_enc_id = $utilitiesModel->encrypt();
          $jobsModel->created_by = Yii::$app->user->identity->user_enc_id;
          $jobsModel->Organizations = $csv[$k]['Company'];
          $jobsModel->Location = $csv[$k]['Location'];
          $jobsModel->Position = $csv[$k]['Position'];
          $jobsModel->Eligibility = $csv[$k]['Eligibility'];
          $jobsModel->Pdf_link = $csv[$k]['Pdf_link'];
          $jobsModel->Last_date = $csv[$k]['Last Date'];
          $jobsModel->job_id = $csv[$k]['Job_Id'];
          $jobsModel->Data = $csv[$k]['Data'];
          if (!$jobsModel->save())
          {
              print_r($jobsModel->getErrors());
          }
        }
        return 'Done';
    }

    public function actionGetDepartments()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $offset = Yii::$app->request->post('offset');
            $d = IndianGovtDepartments::find()
                ->select(['Value','total_applications','slug','CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image) . '", image_location, "/", image) ELSE NULL END logo'])
                ->asArray()
                ->orderBy(['total_applications' => SORT_DESC]);

                $data =$d->limit($limit)
                ->offset($offset)
                ->all();
            return [
                'status'=>200,
                'cards'=>$data,
                'total'=>$d->count(),
                'count'=>sizeof($data)
            ];
        }
    }

    public function actionInsertDept($getPath,$authkey)
    {
        if ($authkey !='@empowerXaazs'){
            return 'permision denied';
        }
        $csv = [];
        $i = 0;
        $path = $getPath;
        ini_set('auto_detect_line_endings', TRUE);
        if (($handle = fopen($path, "r")) !== false) {
            $columns = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle)) !== false) {
                $csv[] = array_combine($columns, $row);
                $i++;
            }
            ini_set('auto_detect_line_endings', FALSE);
            fclose($handle);
        }
        $csv = $this->utf8ize($csv);
        $len = count($csv);
        for ($k=0;$k<$len;$k++)
        {
            $jobsModel = new IndianGovtDepartments();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $jobsModel->dept_enc_id = $utilitiesModel->encrypt();
            $jobsModel->slug = $csv[$k]['Slug'];
            $jobsModel->Value = $csv[$k]['Company'];
            if (!$jobsModel->save())
            {
                print_r($jobsModel->getErrors());
            }
        }
        return 'Done';
    }

    public function actionDepartments()
    {
        return $this->render('departments');
    }

    public function actionDept($slug)
    {
        if ($slug!=null) {
            $data = IndianGovtDepartments::find()
                ->select(['dept_enc_id','Value','total_applications','CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image) . '", image_location, "/", image) ELSE NULL END logo'])
                ->where(['slug' => $slug])
                ->asArray()->one();
            if ($data)
            {
                return $this->render('ind-department-detail',['data'=>$data]);
            }
            else {
                throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
            }
        }
    }

    public function actionDepartmentViseJobs()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $offset = Yii::$app->request->post('offset');
            $dept_id = Yii::$app->request->post('dept_id');
            $d = IndianGovtJobs::find()
                ->alias('a')
                ->select(['a.job_enc_id id','a.slug','CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image) . '", image_location, "/", image) ELSE NULL END logo','c.Value Organizations','Location','Position','Eligibility','Last_date'])
                ->joinWith(['assignedIndianJobs b'=>function($b) use($dept_id)
                {
                    $b->joinWith(['deptEnc c'],false);
                    $b->andWhere(['b.dept_enc_id'=>$dept_id]);
                }],false,'LEFT JOIN');

            $data = $d->limit($limit)
                ->orderBy(['a.created_on'=>SORT_DESC])
                ->offset($offset)
                ->asArray()
                ->all();

            return [
                'status'=>200,
                'cards'=>$data,
                'total'=>$d->count(),
                'count'=>sizeof($data)
            ];
        }
    }

}