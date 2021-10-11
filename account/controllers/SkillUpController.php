<?php

namespace account\controllers;

use account\models\skillsUp\AddSourceForm;
use account\models\skillsUp\SkillsUpEditForm;
use account\models\skillsUp\SkillsUpForm;
use common\models\Industries;
use common\models\Skills;
use common\models\SkillsUpPosts;
use common\models\SkillsUpSources;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

class SkillUpController extends Controller
{

    public function beforeAction($action)
    {
        $permissions = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Skill-Up-Executive");
        if (!$permissions) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionDashboard()
    {

        $counts['video'] = $this->getFeedCounts('Video');
        $counts['audio'] = $this->getFeedCounts('Audio');
        $counts['blog'] = $this->getFeedCounts('Blog');
        $counts['podcast'] = $this->getFeedCounts('Podcast');
        $counts['news'] = $this->getFeedCounts('News');
        $counts['article'] = $this->getFeedCounts('Article');
        $counts['course'] = $this->getFeedCounts('Course');
        $counts['case_study'] = $this->getFeedCounts('Case Study');
        $counts['research_paper'] = $this->getFeedCounts('Research Paper');
        $counts['vlog_webinar'] = $this->getFeedCounts('Vlog/Webinar');

        return $this->render('feed-dashboard', ['counts' => $counts,]);
    }

    private function getFeedsList($data)
    {

        $limit = 10;
        $page = 1;

        if (isset($data['limit']) && !empty($data['limit'])) {
            $limit = $data['limit'];
        }

        if (isset($data['page']) && !empty($data['page'])) {
            $page = $data['page'];
        }

        $feedList = SkillsUpPosts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.post_title', 'b1.name author_name', 'a.post_source_url', 'c.name source', 'a.content_type', "DATE_FORMAT(a.created_on, '%d/%m/%Y') date",
                'GROUP_CONCAT(DISTINCT(d1.skill) SEPARATOR ",") skills', 'GROUP_CONCAT(DISTINCT(e1.industry) SEPARATOR ",") industries', 'a.slug', 'IF(a.status != "Active", 1, NULL) as status',
                '(CASE
                    WHEN a.status = "Active" THEN "Accept"
                    WHEN a.status = "Rejected" THEN "Reject"
                    WHEN a.status = "On Hold" THEN "On Hold"
                    WHEN a.status = "Inactive" THEN "Review"
                    WHEN a.status = "Pending" THEN "Check"
                    END) as post_status',])
            ->joinWith(['skillsUpAuthors b' => function ($b) {
                $b->joinWith(['authorEnc b1']);
            }], false)
            ->joinWith(['sourceEnc c'], false)
            ->joinWith(['skillsUpPostAssignedSkills d' => function ($d) {
                $d->select(['d.assigned_skill_enc_id', 'd.skill_enc_id', 'd.post_enc_id', 'd1.skill']);
                $d->joinWith(['skillEnc d1'], false);
            }], false)
            ->joinWith(['skillsUpPostAssignedIndustries e' => function ($e) {
                $e->select(['e.assigned_industry_enc_id', 'e.industry_enc_id', 'e.post_enc_id', 'e1.industry']);
                $e->joinWith(['industryEnc e1'], false);
            }], false)
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0]);

        if (isset($data['title']) && !empty($data['title'])) {
            $feedList->andFilterWhere(['like', 'a.post_title', $data['title']]);
        }

        if (isset($data['author_name']) && !empty($data['author_name'])) {
            $feedList->andFilterWhere(['like', 'b1.name', $data['author_name']]);
        }

        if (isset($data['source']) && !empty($data['source'])) {
            $feedList->andFilterWhere(['like', 'c.name', $data['source']]);
        }

        if (isset($data['content_type']) && !empty($data['content_type'])) {
            $feedList->andFilterWhere(['like', 'a.content_type', $data['content_type']]);
        }

        if (isset($data['status']) && !empty($data['status'])) {
            $feedList->andWhere(['a.status' => $data['status']]);
        }

        if ($limit != null && $page != null) {
            $feedList->limit($limit)
                ->offset(($page - 1) * $limit);
        } elseif ($limit != null) {
            $feedList->limit($limit);
        } else {
            $feedList->limit(10);
        }
        $feedList = $feedList->orderBy(['a.created_on' => SORT_DESC])
            ->groupBy(['a.post_enc_id'])
            ->asArray()
            ->all();

        return $feedList;
    }

    private function getFeedCounts($type)
    {
        return SkillsUpPosts::find()->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'content_type' => $type, 'is_deleted' => 0])->count();
    }

    public function actionViewAll()
    {
        return $this->render('view-all');
    }

    public function actionGetList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $params = Yii::$app->request->post();
            $feeds = $this->getFeedsList($params);
            if ($feeds) {
                return [
                    'status' => 200,
                    'data' => $feeds
                ];
            }

            return [
                'status' => 201,
                'message' => 'not found'
            ];
        }
    }

    public function actionCreate()
    {
        $model = new SkillsUpForm();

        if ($model->load(Yii::$app->request->post())) {
            $data = $model->save();
            if ($data['status'] == 200) {
                Yii::$app->session->setFlash('success', "Form saved successfully.");
                $this->redirect('/account/skill-up/create');
            } else {
                Yii::$app->session->setFlash('error', 'An error has occurred');
                $this->redirect('/account/skill-up/create');
            }
        } else {
            $sources = SkillsUpSources::find()->where(['is_deleted' => 0])->asArray()->all();
            return $this->render('feeds-form', ['model' => $model, 'sources' => $sources]);
        }
    }

    public function actionEdit($slug)
    {
        $fullSlug = explode('-', $slug);
        $model = new SkillsUpEditForm();
        $defaultData = SkillsUpPosts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.post_title title', 'a.post_source_url source_url', 'a.source_enc_id source_id', 'a.content_type',
                'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->skill_up->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image',
                'a.post_image_url', 'a.slug', 'a.post_description description', 'a.post_short_summery short_description', 'b.name source_name', 'c1.name author', 'e1.body embed_code',
                'f1.youtube_video_id'])
            ->joinWith(['sourceEnc b'], false)
            ->joinWith(['skillsUpAuthors c' => function ($c) {
                $c->joinWith(['authorEnc c1']);
            }], false)
            ->joinWith(['skillsUpPostAssignedSkills d' => function ($d) {
                $d->select(['d.assigned_skill_enc_id', 'd.skill_enc_id', 'd.post_enc_id', 'd1.skill']);
                $d->joinWith(['skillEnc d1'], false);
                $d->andWhere(['d.is_deleted' => 0]);
            }])
            ->joinWith(['skillsUpPostAssignedEmbeds e' => function ($e) {
                $e->joinWith(['embedEnc e1']);
            }], false)
            ->joinWith(['skillsUpPostAssignedVideos f' => function ($f) {
                $f->joinWith(['videoEnc f1']);
            }], false)
            ->joinWith(['skillsUpPostAssignedIndustries g' => function ($g) {
                $g->select(['g.post_enc_id', 'g.industry_enc_id', 'g1.industry']);
                $g->joinWith(['industryEnc g1'], false);
                $g->andWhere(['g.is_deleted' => 0]);
            }])
            ->where(['a.slug' => $slug, 'a.is_deleted' => 0])
            ->andWhere(['not', ['a.status' => 'Active']])
            ->asArray()
            ->one();
        if (!empty($defaultData)) {
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $assignedIndustries = ArrayHelper::getColumn($defaultData['skillsUpPostAssignedIndustries'], 'industry_enc_id');
                $assignedSkills = ArrayHelper::getColumn($defaultData['skillsUpPostAssignedSkills'], 'skill');
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->post_enc_id = $defaultData['post_enc_id'];
                $model->content_type = $defaultData['content_type'];
                $model->source_url = $defaultData['source_url'];
                $model->assigned_skills = $assignedSkills;
                $model->assigned_industries = $assignedIndustries;
                $data = $model->update();
                if ($data['status'] == 200) {
                    $this->redirect('/account/skill-up/view-all');
                } else {
//                    return $data;
                    Yii::$app->session->setFlash('error', 'An error has occurred');
                }
            }
            $model->load($defaultData);
            $sources = SkillsUpSources::find()->where(['is_deleted' => 0])->asArray()->all();
            return $this->render('feeds-form-edit', ['model' => $model, 'sources' => $sources, 'defaultData' => $defaultData]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    private function getMetaInfo($url)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $html = $this->getCurlData($url);

        //parsing begins here:
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        $title = $nodes->item(0)->nodeValue;

        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++) {
            $meta = $metas->item($i);
            if ($meta->getAttribute('name') == 'description') {
                $description = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('name') == 'keywords') {
                $keywords = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('name') == 'twitter:image') {
                $image = $meta->getAttribute('content');
            }
            if (!$image) {
                if ($meta->getAttribute('property') == 'og:image') {
                    $image = $meta->getAttribute('content');
                }
            }
        }

        $domain = $this->get_domain($url);

        $source = SkillsUpSources::find()
            ->select(['source_enc_id', 'name',
                "SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url, '/', 3), '://', -1), '/', 1), '?', 1),'www.',-1) domain"
            ])
            ->where(["SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url, '/', 3), '://', -1), '/', 1), '?', 1),'www.',-1)" => $domain])
            ->asArray()
            ->one();

        return [
            'status' => 203,
            'title' => $title,
            'keywords' => $keywords,
            'image' => $image,
            'description' => $description,
            'source' => $source
        ];
    }

    private function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }

    private function getCurlData($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function actionPreview()
    {
        $model = new SkillsUpForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!ActiveForm::validate($model)) {
                $var = Yii::$app->security->generateRandomString(10);
                $session = Yii::$app->session;
                $session->set($var, $model);
                return ['status' => 200, 'id' => $var];
            } else {
                return ['status' => 409];
            }
        } else {
            return ['status' => 201];
        }
    }

    public function actionValidateSource()
    {
        $model = new SkillsUpForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
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

            return $this->render('feed-preview', ['object' => $object, 'source' => $source, 'skills' => $object->skills]);

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
            return $this->getMetaInfo(Yii::$app->request->post('url'));
        }
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

    public function actionGetSources($keywords = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $sources = SkillsUpSources::find()
            ->select(['source_enc_id', 'name', 'description', 'url source_url',
                'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->feed_sources->image, 'https') . '", image_location, "/", image) ELSE NULL END source_image'
            ])
            ->where(['is_deleted' => 0]);
        if ($keywords != null) {
            $sources->andWhere(['like', 'name', $keywords]);
        }
        $sources = $sources
            ->limit(10)
            ->asArray()
            ->all();

        return ['status' => 200, 'sources' => $sources];

    }
}