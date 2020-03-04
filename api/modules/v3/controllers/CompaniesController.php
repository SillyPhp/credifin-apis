<?php

namespace api\modules\v3\controllers;
use api\modules\v3\models\accounts\OrganizationSignUpForm;;
use api\modules\v3\models\OrganizationList;
use yii\widgets\ActiveForm;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CompaniesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list-companies' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }
    public function actionListCompanies()
    {
        if (Yii::$app->request->isPost)
        {
            $created_by = Yii::$app->request->post('id');
            $limit = Yii::$app->request->post('id');
            $offset = Yii::$app->request->post('id');
            if($created_by)
            {
              $object = new OrganizationList();
              $data = $object->getList($l=$limit,$o=$offset,$id=$created_by);
              if ($data){
                  return $this->response(200, $data);
              } else {
                  return $this->response(404, 'Not Found');
              }
            }
            else {
                return $this->response(404, 'Not Found');
            }
        }
    }

    public function actionCreate()
    {
        $model = new OrganizationSignUpForm();
        if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->validate()){
                return $model->add();
            }
            else
            {
                return ActiveForm::validate($model);
            }
        }
    }
}