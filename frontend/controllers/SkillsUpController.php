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
use yii\helpers\Url;
use yii\db\Expression;

class SkillsUpController extends Controller
{

    public function actionIndex()
    {
        $model = new SkillsUpForm();

        if ($model->load(Yii::$app->request->post())) {
            $data = $model->save();
            if ($data['status'] == 200) {
                Yii::$app->session->setFlash('success', "Form saved successfully.");
                $this->redirect('/skills-up/index');
            } else {
                Yii::$app->session->setFlash('error', $data['message']);
                $this->redirect('/skills-up/index');
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
                $source_exists = SkillsUpSources::findOne(['name' => $addSourceForm->source_name, 'is_deleted' => 0]);
                if ($source_exists) {
                    return [
                        'status' => 201,
                        'title' => 'duplication',
                        'message' => 'This source name already exists',
                    ];
                }

                return $addSourceForm->save();


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

    public function actionFeedList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $data = Yii::$app->request->post();

            $feedsList = $this->feedsList($data);

            if ($feedsList) {
                return [
                    'status' => 200,
                    'data' => $feedsList
                ];
            }

            return [
                'status' => 201,
                'message' => 'not found'
            ];
        }
    }

    private function feedsList($data)
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
            ->joinWith(['skillsUpPostAssignedSkills d' => function ($d) {
                $d->joinWith(['skillEnc d1'], false);
            }], false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($data['content_type']) && !empty($data['content_type'])) {
            $feedsList->andWhere(['a.content_type' => $data['content_type']]);
        }

        if (isset($data['keyword']) && !empty($data['keyword'])) {
            $feedsList->andFilterWhere(['or',
                ['like', 'd1.skill', $data['keyword']],
                ['like', 'a.post_title', $data['keyword']],
                ['like', 'a.post_short_summery', $data['keyword']],
                ['like', 'c1.name', $data['keyword']],
                ['like', 'b.name', $data['keyword']],
            ]);
        }

        if (isset($data['skills']) && !empty($data['skills'])) {
            $feedsList->andWhere(['d1.skill' => $data['skills']]);
        }

        if (isset($data['post_id']) && !empty($data['post_id'])) {
            $feedsList->andWhere(['<>', 'a.post_enc_id', $data['post_id']]);
        }

        if (isset($data['isRandom']) && $data['isRandom']) {
            $feedsList->orderBy(new Expression('rand()'));
        } else {
            $feedsList->orderBy(['a.created_on' => SORT_DESC]);
        }


        if (isset($data['limit']) && isset($data['page'])) {
            $feedsList->limit($data['limit'])->offset(($data['page'] - 1) * $data['limit']);
        } elseif ($data['limit'] != null) {
            $feedsList->limit($data['limit']);
        } else {
            $feedsList->limit(10);
        }

        $feedsList = $feedsList->groupBy(['a.post_enc_id'])->asArray()
            ->all();

        return $feedsList;
    }

    public function actionDetail($slug)
    {
        $postDetail = SkillsUpPosts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.post_title', 'a.post_source_url', 'a.source_enc_id', 'a.content_type',
                'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->skill_up->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image',
                'a.post_image_url', 'a.slug', 'a.post_description', 'b.name source_name', 'c1.name author_name', 'e1.body embed_code',
                'f1.youtube_video_id'])
            ->joinWith(['sourceEnc b'], false)
            ->joinWith(['skillsUpAuthors c' => function ($c) {
                $c->joinWith(['authorEnc c1']);
            }], false)
            ->joinWith(['skillsUpPostAssignedSkills d' => function ($d) {
                $d->select(['d.assigned_skill_enc_id', 'd.skill_enc_id', 'd.post_enc_id', 'd1.skill']);
                $d->joinWith(['skillEnc d1'], false);
            }])
            ->joinWith(['skillsUpPostAssignedEmbeds e' => function ($e) {
                $e->joinWith(['embedEnc e1']);
            }], false)
            ->joinWith(['skillsUpPostAssignedVideos f' => function ($f) {
                $f->joinWith(['videoEnc f1']);
            }], false)
            ->where(['a.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        $skills = [];
        foreach ($postDetail['skillsUpPostAssignedSkills'] as $s) {
            $skills[] = $s['skill'];
        }

        $data['limit'] = 5;
        $data['page'] = 1;
        $data['post_id'] = $postDetail['post_enc_id'];
        $data['skills'] = $skills;
        $data['isRandom'] = true;
        $related_posts = $this->feedsList($data);

        return $this->render('feed-detail', ['detail' => $postDetail, 'related_posts' => $related_posts]);
    }
}