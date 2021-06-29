<?php

namespace account\controllers;

use common\models\SkillsUpPosts;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class SkillUpController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionDashboard()
    {

        if (!Yii::$app->user->identity->user_enc_id && !Yii::$app->user->identity->organization) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

        $permissions = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Skills-Up");
        if (!$permissions) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

        $counts['video'] = $this->getFeedCounts('Video');
        $counts['audio'] = $this->getFeedCounts('Audio');
        $counts['blog'] = $this->getFeedCounts('Blog');
        $counts['podcast'] = $this->getFeedCounts('Podcast');
        $counts['news'] = $this->getFeedCounts('News');
        $counts['article'] = $this->getFeedCounts('Article');
        $counts['course'] = $this->getFeedCounts('Course');

        $feedList = $this->getFeedsList(10);

        return $this->render('feed-dashboard', ['counts' => $counts, 'feeds' => $feedList]);
    }

    private function getFeedsList($limit = null, $page = null)
    {
        $feedList = SkillsUpPosts::find()
            ->alias('a')
            ->select(['a.post_enc_id', 'a.post_title', 'b1.name author_name', 'a.post_source_url', 'c.name source', 'a.content_type', "DATE_FORMAT(a.created_on, '%d/%m/%Y') date",
                'GROUP_CONCAT(DISTINCT(d1.skill) SEPARATOR ",") skills', 'GROUP_CONCAT(DISTINCT(e1.industry) SEPARATOR ",") industries'])
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
            $feeds = $this->getFeedsList($params['limit'], $params['page']);
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
}