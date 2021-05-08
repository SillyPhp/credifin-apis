<?php

namespace frontend\controllers;

use common\models\Industries;
use common\models\LearningVideos;
use common\models\Skills;
use common\models\SkillsUpSources;
use frontend\models\OrganizationEmployeesForm;
use frontend\models\skillsUp\AddSourceForm;
use frontend\models\skillsUp\SkillsUpForm;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use yii\web\Response;

class SkillsUpController extends Controller
{

    public function actionIndex()
    {
        $model = new SkillsUpForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                print_r('saved');
                die();
            } else {
                print_r('an error occurred');
                die();
            }
        } else {
            $sources = SkillsUpSources::find()->where(['is_deleted' => 0])->asArray()->all();
            return $this->render('feeds-form', ['model' => $model, 'sources' => $sources]);
        }
    }

    public function actionPreview()
    {
        return $this->render('feed-preview');

    }

    public function actionIndustryList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = Industries::find()
                ->select('industry_enc_id AS id, industry AS text')
                ->andFilterWhere(['like', 'industry', $q])
                ->limit(10)
                ->asArray()
                ->all();
            $out['results'] = array_values($data);
        } elseif ($id != null) {
            $out['results'] = ['id' => $id, 'text' => Industries::find()->where(['industry_enc_id' => $id])->name];
        }
        return $out;
    }

    public function actionSkillList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = Skills::find()
                ->select('skill_enc_id AS id, skill AS text')
                ->where(['status' => 'Publish', 'is_deleted' => 0])
                ->andFilterWhere(['like', 'skill', $q])
                ->limit(10)
                ->asArray()
                ->all();
            $out['results'] = array_values($data);
        } elseif ($id != null) {
            $out['results'] = ['id' => $id, 'text' => Industries::find()->where(['industry_enc_id' => $id])->name];
        }
        return $out;
    }

    public function actionValidateUrl()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $url = Yii::$app->request->post('url');
            return $this->youTubeVideoID($url);
        }
    }

    private function youTubeVideoID($url)
    {
        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);
        $id = "";
        if (isset($params['v']) && strlen($params['v']) > 0) {
            $id = $params['v'];
            if ($id != "") {
                return [
                    'status' => 200,
                    'title' => 'success!',
                    'video_id' => $id,
                    'message' => 'Successfully',
                ];
            }
        }

        return [
            'status' => 201,
            'title' => 'LearningVideo',
            'message' => 'Video id not Found..',
        ];
    }

    public function actionAddSource()
    {
        if (Yii::$app->request->isAjax) {
            $addSourceForm = new AddSourceForm();
            if ($addSourceForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $addSourceForm->image = UploadedFile::getInstance($addSourceForm, 'image');
                print_r($addSourceForm);
                exit();
                if ($addSourceForm->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Source Added.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            }
            return $this->renderAjax('add-source-form', [
                'addSourceForm' => $addSourceForm,
            ]);
        }
    }
}