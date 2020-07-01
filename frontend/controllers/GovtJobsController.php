<?php

namespace frontend\controllers;
use common\models\IndianGovtDepartments;
use common\models\IndianGovtJobs;
use common\models\Utilities;
use frontend\models\applications\ApplicationCards;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\HttpException;

class GovtJobsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
      return $this->render('index');
    }
    public function actionSearch($s=null)
    {
        return $this->render('search-index',['s'=>str_replace("-", " ", $s)]);
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
            $search = trim($keywords, " "); 
            $search_pattern = ApplicationCards::makeSQL_search_pattern($search);
            $d = IndianGovtJobs::find()
                    ->alias('a')
                    ->select(['job_id id','c.slug company_slug','CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image) . '", image_location, "/", image) ELSE NULL END logo','a.slug','a.Organizations','a.Location','a.Position','a.Eligibility','a.Last_date'])
                    ->andWhere(['a.is_deleted'=>0])
                    ->andFilterWhere([
                    'or',
                    ['REGEXP', 'a.Organizations', $search_pattern],
                    ['REGEXP', 'a.Location', $search_pattern],
                    ['REGEXP', 'a.Position', $search_pattern],
                    ['REGEXP', 'a.Eligibility', $search_pattern],
                    ])
                ->joinWith(['assignedIndianJobs b'=>function($b)
                {
                    $b->joinWith(['deptEnc c'],false);
                }],false,'LEFT JOIN');

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