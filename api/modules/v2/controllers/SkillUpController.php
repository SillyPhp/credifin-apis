<?php


namespace api\modules\v2\controllers;

use common\models\ConversationMessages;
use common\models\ConversationParticipants;
use common\models\Conversations;
use common\models\Skills;
use common\models\SkillsUpLikesDislikes;
use common\models\SkillsUpPostAssignedVideo;
use common\models\SkillsUpPostComments;
use common\models\SkillsUpPosts;
use common\models\SkillsUpRecommendedPost;
use common\models\Teachers;
use common\models\UserOtherDetails;
use common\models\UserPreferences;
use common\models\UserPreferredSkills;
use common\models\Users;
use Yii;
use \yii\db\Expression;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class SkillUpController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'feed' => ['POST', 'OPTIONS'],
                'post-like-dislike' => ['POST', 'OPTIONS'],
                'post-comments' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    private function __studentCollegeId()
    {
        if ($user = $this->isAuthorized()) {
            $user_college = UserOtherDetails::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $user_college['organization_enc_id'];
        }
    }

    public function actionFeed()
    {
        if ($user = $this->isAuthorized()) {

            $param = Yii::$app->request->post();

            if (isset($param['limit']) && !empty($param['limit'])) {
                $limit = (int)$param['limit'];
            } else {
                $limit = 10;
            }

            if (isset($param['page']) && !empty($param['page'])) {
                $page = (int)$param['page'];
            } else {
                $page = 1;
            }

            $student = UserOtherDetails::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->exists();

            if ($student) {

                $prefs = UserPreferences::findOne(['is_deleted' => 0, 'assigned_to' => 'Skills_Up', 'created_by' => $user->user_enc_id]);

                if ($prefs) {

                    $user_skills = UserPreferredSkills::find()
                        ->alias('a')
                        ->select(['a.preferred_skill_enc_id', 'a.preference_enc_id', 'a.skill_enc_id', 'b.skill'])
                        ->joinWith(['skillEnc b'], false)
                        ->where(['a.preference_enc_id' => $prefs->preference_enc_id, 'a.is_deleted' => 0])
                        ->asArray()
                        ->all();

                    if ($user_skills) {

                        $skills = [];
                        foreach ($user_skills as $s) {
                            array_push($skills, $s['skill']);
                        }
                        $param['user_skills'] = $skills;

                        $feeds = $this->feeds($page, $limit, $param);

                        if ($feeds) {
                            foreach ($feeds as $k => $v) {
                                $feeds[$k]['feedback_status'] = $this->getLikes($v['post_enc_id']) ? $this->getLikes($v['post_enc_id']) : 0;
                                $rec = $this->__getStudentRecommended($v['post_enc_id']);
                                $feeds[$k]['is_recommended'] = (count($rec) > 0) ? true : false;
                                $feeds[$k]['recommended_count'] = count($rec);
                                $feeds[$k]['recommended_by'] = $rec;
                            }

                            if ($page == 1) {
                                return $this->response(200, ['status' => 200, 'data' => $feeds, 'skills' => $user_skills]);
                            } else {
                                return $this->response(200, ['status' => 200, 'data' => $feeds]);
                            }

                        } else {
                            return $this->response(404, ['status' => 404, 'message' => 'not found']);
                        }
                    } else {
                        return $this->response(409, ['status' => 409, 'message' => 'skills not found']);
                    }
                } else {
                    return $this->response(409, ['status' => 409, 'message' => 'skills not found']);
                }
            } else {
                $feeds = $this->feeds($page, $limit, $param);

                if ($feeds) {
                    foreach ($feeds as $k => $v) {
                        $feeds[$k]['feedback_status'] = $this->getLikes($v['post_enc_id']) ? $this->getLikes($v['post_enc_id']) : 0;
                        $feeds[$k]['is_recommended'] = $v['skillsUpRecommendedPosts'] ? true : false;
                        $feeds[$k]['teacher_recommended'] = $this->__getTeacherRecommended($v['post_enc_id']);
                    }

                    return $this->response(200, ['status' => 200, 'data' => $feeds]);

                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function feeds($page, $limit, $param)
    {

        $college_id = $this->__studentCollegeId();

        $user = $this->isAuthorized();

        $feeds = SkillsUpPosts::find()
            ->alias('a')
            ->select([
                'a.post_enc_id',
                'a.post_title',
                'a.source_enc_id',
                'a.post_short_summery',
                'a.slug',
                'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->skill_up->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->feed_sources->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END source_image',
                'b.name source_name',
                'b.url source_url',
                'a.content_type',
                'a.post_image_url'
            ])
            ->joinWith(['sourceEnc b'], false)
            ->joinWith(['skillsUpAuthors i' => function ($i) {
                $i->select(['i.post_enc_id', 'i.author_enc_id', 'i1.name']);
                $i->joinWith(['authorEnc i1'], false);
            }])
            ->joinWith(['skillsUpPostAssignedSkills c' => function ($c) {
                $c->joinWith(['skillEnc c1' => function ($c1) {
                    $c1->onCondition(['c1.is_deleted' => 0, 'c1.status' => 'Publish']);
                }]);
            }], false);
        if (isset($param['teacher_recommendations']) && $param['teacher_recommendations']) {

            $college_id = $param['teacher_college_id'];

            $feeds->innerJoinWith(['skillsUpRecommendedPosts d' => function ($d) use ($college_id, $user) {
                $d->innerJoinWith(['recommendedBy d1' => function ($b) use ($college_id, $user) {
                    $b->innerJoinWith(['teachers d2' => function ($d2) use ($college_id, $user) {
                        $d2->onCondition(['d2.college_enc_id' => $college_id, 'd2.user_enc_id' => $user->user_enc_id]);
                    }]);
                }]);
                $d->onCondition(['d.is_deleted' => 0]);
            }], true);
        } else {
            $feeds->joinWith(['skillsUpRecommendedPosts d' => function ($d) use ($college_id) {
                $d->joinWith(['recommendedBy d1' => function ($b) use ($college_id) {
                    $b->joinWith(['teachers d2' => function ($d2) use ($college_id) {
                        $d2->onCondition(['d2.college_enc_id' => $college_id]);
                    }]);
                }]);
                $d->onCondition(['d.is_deleted' => 0]);
            }], true);
        }

        $feeds->where(['a.is_deleted' => 0, 'a.status' => 'Active']);

        if (isset($param['content_type']) && !empty($param['content_type'])) {
            $feeds->andWhere(['in', 'a.content_type', $param['content_type']]);
        }

        if (isset($param['skills']) && !empty($param['skills'])) {
            $feeds->andFilterWhere(['in', 'c1.skill', $param['skills']]);
        } elseif (isset($param['user_skills']) && !empty($param['user_skills'])) {
            $feeds->andFilterWhere(['in', 'c1.skill', $param['user_skills']]);
        }

        if (isset($param['keyword']) && !empty($param['keyword'])) {
            $feeds->andFilterWhere(['like', 'c1.skill', $param['keyword']]);
            $feeds->andFilterWhere(['like', 'a.post_title', $param['keyword']]);
            $feeds->andFilterWhere(['like', 'a.post_short_summery', $param['keyword']]);
        }

        $feeds = $feeds->limit($limit)
            ->offset(($page - 1) * $limit)
            ->groupBy(['a.post_enc_id'])
            ->orderBy(['d2.teacher_enc_id' => SORT_DESC, 'a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        return $feeds;
    }

    public function actionUserPrefSkills()
    {
        if ($user = $this->isAuthorized()) {
            $prefs = UserPreferences::findOne(['is_deleted' => 0, 'assigned_to' => 'Skills_Up', 'created_by' => $user->user_enc_id]);
            if ($prefs) {
                $user_skills = UserPreferredSkills::find()
                    ->alias('a')
                    ->select(['a.preferred_skill_enc_id', 'a.preference_enc_id', 'a.skill_enc_id', 'b.skill'])
                    ->joinWith(['skillEnc b'], false)
                    ->where(['a.preference_enc_id' => $prefs->preference_enc_id, 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();

                if ($user_skills) {
                    return $this->response(200, ['status' => 200, 'skills' => $user_skills]);
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }

            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getLikes($post_id)
    {
        if ($user = $this->isAuthorized()) {
            $l = SkillsUpLikesDislikes::find()
                ->where(['post_enc_id' => $post_id, 'created_by' => $user->user_enc_id])
                ->one();
            return $l->feedback_status;
        }
    }

    public function actionPostLikeDislike()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['action']) && empty($params['action'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
            if (!isset($params['post_id']) && empty($params['post_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $row = SkillsUpLikesDislikes::findOne(['post_enc_id' => $params['post_id'], 'created_by' => $user->user_enc_id]);

            if ($row) {
                $row->feedback_status = $params['action'];
                $row->last_updated_by = $user->user_enc_id;
                $row->last_updated_on = date('Y-m-d H:i:s');
                if (!$row->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                } else {
                    return $this->response(200, ['status' => 200, 'message' => 'success']);
                }
            } else {
                $model = new SkillsUpLikesDislikes();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->post_like_dislike_enc_id = $utilitiesModel->encrypt();
                $model->post_enc_id = $params['post_id'];
                $model->feedback_status = $params['action'];
                $model->created_by = $user->user_enc_id;
                $model->created_on = date('Y-m-d H:i:d');
                if (!$model->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                } else {
                    return $this->response(200, ['status' => 200, 'message' => 'success']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionPostComments()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (!isset($params['post_id']) && empty($params['post_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (!isset($params['comment']) && empty($params['comment'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['comment_id']) && !empty($params['comment_id'])) {
                $comment = SkillsUpPostComments::findOne(['comment_enc_id' => $params['comment_id'], 'is_deleted' => 0, 'status' => 'Approved']);
            } else {
                $comment = 0;
            }


            if ($comment) {
                $comment->comment = $params['comment'];
                $comment->last_updated_by = $user->user_enc_id;
                $comment->last_updated_on = date('Y-m-d H:i:s');
                if ($comment->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'success', 'comment_enc_id' => $comment->comment_enc_id]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {
                $model = new SkillsUpPostComments();
                $model->comment_enc_id = $params['id'];
                $model->post_enc_id = $params['post_id'];
                if (isset($params['reply_to']) && !empty($params['reply_to'])) {
                    $model->reply_to = $params['reply_to'];
                }
                $model->comment = $params['comment'];
                $model->created_by = $user->user_enc_id;
                $model->created_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return $this->response(200, ['status' => 200, 'message' => 'success', 'comment_enc_id' => $model->comment_enc_id]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetSkills()
    {
        if ($user = $this->isAuthorized()) {

            $keyword = Yii::$app->request->post('keyword');

            $skills = Skills::find()
                ->select(['skill_enc_id', 'skill'])
                ->where(['status' => 'Publish', 'is_deleted' => 0])
                ->andFilterWhere(['like', 'skill', $keyword])
                ->limit(20)
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'skills' => $skills]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSavePrefSkills()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['skills']) && empty($params['skills'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $prefs = UserPreferences::findOne(['is_deleted' => 0, 'assigned_to' => 'Skills_Up', 'created_by' => $user->user_enc_id]);

            if ($prefs) {
                $user_skill = UserPreferredSkills::find()
                    ->select(['skill_enc_id'])
                    ->where(['preference_enc_id' => $prefs->preference_enc_id])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();

                $old_skills = [];
                foreach ($user_skill as $skill_id) {
                    array_push($old_skills, $skill_id['skill_enc_id']);
                }

                $skills = [];
                foreach ($params['skills'] as $s) {
                    array_push($skills, $s['skill_enc_id']);
                }

                $new_userskill_to_update = $skills;

                $to_be_added_userskill = array_diff($new_userskill_to_update, $old_skills);
                $to_be_deleted_userskill = array_diff($old_skills, $new_userskill_to_update);

                if (count($to_be_deleted_userskill) > 0) {
                    foreach ($to_be_deleted_userskill as $del) {
                        $this->delSkills($del, $prefs->preference_enc_id);
                    }
                }

                if (count($to_be_added_userskill) > 0) {
                    foreach ($to_be_added_userskill as $skill) {
                        $this->setSkills($skill, $prefs->preference_enc_id, $user->user_enc_id);
                    }
                }

                return $this->response(200, ['status' => 200, 'message' => 'success']);

            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $prefs = new UserPreferences();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $prefs->preference_enc_id = $utilitiesModel->encrypt();
                    $prefs->assigned_to = 'Skills_Up';
                    $prefs->created_on = date('Y-m-d H:i:s');
                    $prefs->created_by = $user->user_enc_id;
                    if (!$prefs->save()) {
                        $transaction->rollback();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }

                    foreach ($params['skills'] as $s) {
                        $skills = new UserPreferredSkills();
                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $skills->preferred_skill_enc_id = $utilitiesModel->encrypt();
                        $skills->skill_enc_id = $s['skill_enc_id'];
                        $skills->preference_enc_id = $prefs->preference_enc_id;
                        $skills->created_on = date('Y-m-d H:i:s');
                        $skills->created_by = $user->user_enc_id;
                        if (!$skills->save()) {
                            $transaction->rollback();
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                        }
                    }

                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'success']);

                } catch (Exception $e) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function delSkills($skill_id, $user_preference)
    {
        $to_delete_userskill = UserPreferredSkills::find()
            ->where(['skill_enc_id' => $skill_id, 'preference_enc_id' => $user_preference])
            ->andWhere(['is_deleted' => 0])
            ->one();
        $to_delete_userskill->is_deleted = 1;
        $to_delete_userskill->update();
    }

    private function setSkills($skill_id, $preference_enc_id, $user_enc_id)
    {
        $skills = new UserPreferredSkills();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $skills->preferred_skill_enc_id = $utilitiesModel->encrypt();
        $skills->skill_enc_id = $skill_id;
        $skills->preference_enc_id = $preference_enc_id;
        $skills->created_on = date('Y-m-d H:i:s');
        $skills->created_by = $user_enc_id;
        $skills->save();
    }

    public function actionPostDetail()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['post_id']) && !empty($params['post_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $detail = SkillsUpPosts::find()
                ->alias('a')
                ->select(['a.post_enc_id',
                    'a.post_title',
                    'a.slug post_slug',
                    'a.post_source_url',
                    'a.post_image_url',
                    'a.source_enc_id',
                    'a.content_type',
                    'a.post_short_summery',
                    'a.post_description',
                    'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->skill_up->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->feed_sources->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END source_image',
                    'b.name source_name',
                    'b.url source_url',
                ])
                ->joinWith(['sourceEnc b'], false)
                ->joinWith(['skillsUpPostAssignedSkills c' => function ($c) {
                    $c->select(['c.assigned_skill_enc_id', 'c.post_enc_id', 'c.skill_enc_id', 'c1.skill']);
                    $c->joinWith(['skillEnc c1' => function ($c1) {
                        $c1->onCondition(['c1.is_deleted' => 0, 'c1.status' => 'Publish']);
                    }], false);
                }])
                ->joinWith(['skillsUpPostAssignedIndustries d' => function ($d) {
                    $d->select(['d.assigned_industry_enc_id', 'd.industry_enc_id', 'd1.industry']);
                    $d->joinWith(['industryEnc d1']);
                }])
                ->joinWith(['skillsUpPostAssignedVideos e' => function ($e) {
                    $e->select(['e.assigned_enc_id', 'e.post_enc_id', 'e.video_enc_id', 'e1.youtube_video_id', 'e1.description']);
                    $e->joinWith(['videoEnc e1'], false);
                }])
                ->joinWith(['skillsUpPostAssignedEmbeds f' => function ($f) {
                    $f->select(['f.assigned_enc_id', 'f.embed_enc_id', 'f.post_enc_id', 'f1.body', 'f1.description']);
                    $f->joinWith(['embedEnc f1'], false);
                }])
                ->joinWith(['skillsUpPostAssignedNews g' => function ($e) {
                    $e->select(['g.post_enc_id', 'g1.description']);
                    $e->joinWith(['newsEnc g1'], false);
                }])
                ->joinWith(['skillsUpPostAssignedBlogs h' => function ($h) {
                    $h->select(['h.post_enc_id', 'h1.description']);
                    $h->joinWith(['blogPostEnc h1'], false);
                }])
                ->joinWith(['skillsUpAuthors i' => function ($i) {
                    $i->select(['i.post_enc_id', 'i.author_enc_id', 'i1.name']);
                    $i->joinWith(['authorEnc i1'], false);
                }])
                ->where(['a.post_enc_id' => $params['post_id'], 'a.is_deleted' => 0, 'a.status' => 'Active'])
                ->asArray()
                ->one();

            if ($detail) {

                switch ($detail['content_type']) {
                    case 'Blog':
                    case 'Article':
                        $detail['post_description'] = $detail['post_description'] ? $detail['post_description'] : $detail['skillsUpPostAssignedBlogs'][0]['description'];
                        break;
                    case 'Audio':
                    case 'Podcast':
                        $detail['post_description'] = $detail['post_description'] ? $detail['post_description'] : $detail['skillsUpPostAssignedEmbeds'][0]['description'];
                        $detail['frame'] = $detail['skillsUpPostAssignedEmbeds'][0]['body'];
                        break;
                    case 'Video':
                        if ($detail['source_name'] == 'Youtube') {
                            $detail['post_description'] = $detail['post_description'] ? $detail['post_description'] : $detail['skillsUpPostAssignedVideos'][0]['description'];
                            $detail['frame'] = '<iframe width="1519" height="562" src="https://www.youtube.com/embed/' . $detail['skillsUpPostAssignedVideos'][0]['youtube_video_id'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        } else {
                            $detail['post_description'] = $detail['post_description'] ? $detail['post_description'] : $detail['skillsUpPostAssignedEmbeds'][0]['description'];
                            $detail['frame'] = $detail['skillsUpPostAssignedEmbeds'][0]['body'];
                        }
                        break;
                    case 'News':
                        $detail['post_description'] = $detail['post_description'] ? $detail['post_description'] : $detail['skillsUpPostAssignedNews'][0]['description'];
                        break;
                }

                $skills = [];
                if ($detail['skillsUpPostAssignedSkills']) {
                    foreach ($detail['skillsUpPostAssignedSkills'] as $d) {
                        array_push($skills, $d['skill']);
                    }
                }

                $params['skills'] = $skills;
                $related_post = $this->feeds(1, 5, $params);
                $detail['feedback_status'] = $this->getLikes($detail['post_enc_id']);

                $detail['teacher_recommended'] = $this->__getTeacherRecommended($detail['post_enc_id']);

                unset($detail['skillsUpPostAssignedVideos']);
                unset($detail['skillsUpPostAssignedEmbeds']);
                unset($detail['skillsUpPostAssignedNews']);
                unset($detail['skillsUpPostAssignedBlogs']);

                return $this->response(200, ['status' => 200, 'data' => $detail, 'related_posts' => $related_post]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveRecommendedPost()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['post_id']) && empty($params['post_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $already_rec = SkillsUpRecommendedPost::find()
                ->where(['post_enc_id' => $params['post_id'], 'recommended_by' => $user->user_enc_id])
                ->one();

            if ($already_rec) {
                $already_rec->last_updated_by = $user->user_enc_id;
                $already_rec->last_updated_on = date('Y-m-d H:i:s');
                if ($already_rec->is_deleted == 0) {
                    $already_rec->is_deleted = 1;
                } else {
                    $already_rec->is_deleted = 0;
                }
                if ($already_rec->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'success']);
                }
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            $rec = new SkillsUpRecommendedPost();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $rec->recommended_enc_id = $utilitiesModel->encrypt();
            $rec->post_enc_id = $params['post_id'];
            $rec->recommended_by = $user->user_enc_id;
            $rec->recommended_on = date('Y-m-s H:i:s');
            if ($rec->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'success']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __getTeacherRecommended($post_id)
    {
        if ($user = $this->isAuthorized()) {
            $teacher = Teachers::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($teacher) {
                $recommend = SkillsUpRecommendedPost::find()
                    ->where(['recommended_by' => $user->user_enc_id, 'post_enc_id' => $post_id, 'is_deleted' => 0])
                    ->exists();
                return $recommend;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function __getStudentRecommended($post_id)
    {
        if ($user = $this->isAuthorized()) {

            $college_id = $this->__studentCollegeId();

            $recommended = SkillsUpRecommendedPost::find()
                ->distinct()
                ->alias('a')
                ->select(['a.recommended_enc_id', 'a.post_enc_id', 'a.recommended_by',
                    'b.first_name', 'b.last_name',
                ])
                ->innerJoinWith(['recommendedBy b' => function ($b) {
                    $b->innerJoinWith(['teachers c']);
                }], false)
                ->where(['a.post_enc_id' => $post_id, 'a.is_deleted' => 0, 'c.college_enc_id' => $college_id])
                ->asArray()
                ->all();

            return $recommended;

        }
    }

    public function actionTeacherRecommendedPosts()
    {
        if ($user = $this->isAuthorized()) {

            $param = Yii::$app->request->post();

            if (isset($param['limit']) && !empty($param['limit'])) {
                $limit = (int)$param['limit'];
            } else {
                $limit = 10;
            }

            if (isset($param['page']) && !empty($param['page'])) {
                $page = (int)$param['page'];
            } else {
                $page = 1;
            }
            $param['teacher_recommendations'] = true;
            $teacher = Teachers::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->one();
            $param['teacher_college_id'] = $teacher->college_enc_id;
            $teacher_recommendations = $this->feeds($page, $limit, $param);

            if ($teacher_recommendations) {
                foreach ($teacher_recommendations as $k => $v) {
                    $teacher_recommendations[$k]['feedback_status'] = $this->getLikes($v['post_enc_id']) ? $this->getLikes($v['post_enc_id']) : 0;
                    $teacher_recommendations[$k]['is_recommended'] = $v['skillsUpRecommendedPosts'] ? true : false;
                    $teacher_recommendations[$k]['teacher_recommended'] = $this->__getTeacherRecommended($v['post_enc_id']);
                }
                return $this->response(200, ['status' => 200, 'message' => 'success', 'data' => $teacher_recommendations]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetTeacherStats()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $recommended_count = SkillsUpRecommendedPost::find()
                ->where(['recommended_by' => $user->user_enc_id, 'is_deleted' => 0])
                ->count();

            $like_count = SkillsUpLikesDislikes::find()
                ->where(['created_by' => $user->user_enc_id, 'feedback_status' => 1])
                ->count();

            $dislike_count = SkillsUpLikesDislikes::find()
                ->where(['created_by' => $user->user_enc_id, 'feedback_status' => 2])
                ->count();

            $counts = [];
            $counts['recommended_count'] = $recommended_count;
            $counts['likes_count'] = $like_count;
            $counts['dislikes_count'] = $dislike_count;

            return $this->response(200, ['status' => 200, 'counts' => $counts]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetStudentStats()
    {
        if ($user = $this->isAuthorized()) {

            $like_count = SkillsUpLikesDislikes::find()
                ->where(['created_by' => $user->user_enc_id, 'feedback_status' => 1])
                ->count();

            $dislike_count = SkillsUpLikesDislikes::find()
                ->where(['created_by' => $user->user_enc_id, 'feedback_status' => 2])
                ->count();

            $counts = [];
            $counts['likes_count'] = $like_count;
            $counts['dislikes_count'] = $dislike_count;

            return $this->response(200, ['status' => 200, 'counts' => $counts]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveChat()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['message_id']) && !empty($params['message_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['college_id']) && !empty($params['college_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (!isset($params['conversation_enc_id']) && empty($params['conversation_enc_id'])) {
                $conversation = new Conversations();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $conversation->conversation_enc_id = $utilitiesModel->encrypt();
                $conversation->conversation_type = 2;
                $conversation->created_by = $user->user_enc_id;
                $conversation->created_on = date('Y-m-d H:i:s');
                if (!$conversation->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
                $conversation_enc_id = $conversation->conversation_enc_id;
            } else {
                $conversation_enc_id = $params['conversation_enc_id'];
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $conversation_participants = new ConversationParticipants();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $conversation_participants->participant_enc_id = $utilitiesModel->encrypt();
                $conversation_participants->conversation_enc_id = $conversation_enc_id;
                $conversation_participants->user_enc_id = $user->user_enc_id;
                $conversation_participants->organization_enc_id = $params['college_id'];
                $conversation_participants->created_by = $user->user_enc_id;
                $conversation_participants->created_on = date('Y-m-d H:i:s');
                if (!$conversation_participants->save()) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }

                $conversation_messages = new ConversationMessages();
                $conversation_messages->message_enc_id = $params['message_id'];
                $conversation_messages->conversation_enc_id = $conversation_enc_id;
                $conversation_messages->participant_enc_id = $conversation_participants->participant_enc_id;
                $conversation_messages->created_by = $user->user_enc_id;
                $conversation_messages->created_on = date('Y-m-d H:i:s');
                if (!$conversation_messages->save()) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }

                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'saved', 'conversation_enc_id' => $conversation_enc_id]);

            } catch (Exception $e) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}