<?php

namespace frontend\controllers;

use account\models\applications\ApplicationForm;
use common\models\Industries;
use common\models\LearningVideos;
use common\models\Skills;
use common\models\SkillsUpPosts;
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
        $model = new SkillsUpForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $var = Yii::$app->security->generateRandomString(10);
            $session = Yii::$app->session;
            $session->set($var, $model);
            return ['status' => 200, 'id' => $var];
        } else {
            return ['status' => 201];
        }
    }

    public function actionFeedPreview($id)
    {
        if (!empty($id)) {
            $session = Yii::$app->session;
            $object = $session->get($id);

            if (empty($object)) {
                return 'Oops Session expired..!';
            }

            $source = SkillsUpSources::findone(['source_enc_id' => $object->source_id])->name;

            $skills = Skills::find()
                ->select(['skill'])
                ->where(['skill_enc_id' => $object->skills])
                ->asArray()
                ->all();

            return $this->render('feed-preview', ['object' => $object, 'source' => $source, 'skills' => $skills]);

        } else {
            return 'Oops Session not found..!';
        }
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
                if ($data = $addSourceForm->save()) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Source Added.',
                        'id' => $data['id'],
                        'val' => $data['val']
                    ];
                } else {
                    return [
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

    public function actionTimeLine()
    {
        return $this->render('feed-timeline');
    }

    private function feedList($data)
    {
        $feedsList = SkillsUpPosts::find()
            ->alias('a')
            ->select([
                'a.post_enc_id', 'b.name source_name', 'c1.name author_name', 'a.post_title', 'a.post_short_summery',
                'a.slug', 'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->skill_up->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image',
                'a.post_image_url'])
            ->joinWith(['sourceEnc b'], false)
            ->joinWith(['skillsUpAuthors c' => function ($c) {
                $c->joinWith(['authorEnc c1']);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($data['content_type']) && !empty($data['content_type'])) {
            $feedsList->andWhere(['a.content_type' => $data['content_type']]);
        }

        if (isset($param['keyword']) && !empty($param['keyword'])) {
            $feedsList->andFilterWhere(['or',
//                ['like', 'c1.skill', $param['keyword']],
                ['like', 'a.post_title', $param['keyword']],
                ['like', 'a.post_short_summery', $param['keyword']],
                ['like', 'c1.name', $param['keyword']],
                ['like', 'b.name', $param['keyword']],
            ]);
        }


        if (isset($data['limit']) && isset($data['page'])) {
            $feedsList->limit($data['limit'])->offset(($data['page'] - 1) * $data['limit']);
        } elseif ($data['limit'] != null) {
            $feedsList->limit($data['limit']);
        } else {
            $feedsList->limit(10);
        }

        $feedsList = $feedsList->asArray()
            ->all();

        return $feedsList;
    }
}