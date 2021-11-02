<?php

namespace frontend\controllers;

use common\models\SkillsUpPosts;
use common\models\Users;
use frontend\models\skillsUp\AddSourceForm;
use frontend\models\skillsUp\SkillsUpForm;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;
use yii\db\Expression;
use yii\web\HttpException;

class  SkillUpController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
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
                $d->andWhere(['d.is_deleted' => 0]);
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
                $d->andWhere(['d.is_deleted' => 0]);
            }])
            ->joinWith(['skillsUpPostAssignedEmbeds e' => function ($e) {
                $e->joinWith(['embedEnc e1']);
            }], false)
            ->joinWith(['skillsUpPostAssignedVideos f' => function ($f) {
                $f->joinWith(['videoEnc f1']);
            }], false);
        $permissions = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Skill-Up-Executive");
        $user = Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id])->user_of;
        if ($permissions || $user == 'MIS') {
            $postDetail->where(['a.slug' => $slug, 'a.is_deleted' => 0]);
        } else {
            $postDetail->where(['a.slug' => $slug, 'a.status' => 'Active', 'a.is_deleted' => 0]);
        }


        $postDetail = $postDetail->asArray()
            ->one();

        if (!empty($postDetail)) {
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
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

}