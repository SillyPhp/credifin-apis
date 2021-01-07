<?php


namespace api\modules\v2\controllers;

use common\models\Skills;
use common\models\SkillsUpLikesDislikes;
use common\models\SkillsUpPostComments;
use common\models\SkillsUpPosts;
use common\models\UserPreferences;
use common\models\UserPreferredSkills;
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
                    'a.post_author',
                    'a.content_type'
                ])
                ->joinWith(['sourceEnc b'], false)
                ->joinWith(['skillsUpPostAssignedSkills c' => function ($c) {
                    $c->joinWith(['skillEnc c1' => function ($c1) {
                        $c1->onCondition(['c1.is_deleted' => 0, 'c1.status' => 'Publish']);
                    }]);
                }], false)
                ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'b.is_deleted' => 0]);
            if (isset($param['content_type']) && !empty($param['content_type'])) {
                $feeds->andWhere(['in', 'a.content_type', $param['content_type']]);
            }
            if (isset($param['skills']) && !empty($param['skills'])) {
                $feeds->andWhere(['in', 'c1.skill', $param['skills']]);
            }
            $feeds = $feeds->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();
            if ($feeds) {

                foreach ($feeds as $k => $v) {
                    $feeds[$k]['feedback_status'] = $this->getLikes($v['post_enc_id']) ? $this->getLikes($v['post_enc_id']) : 0;
                }

                return $this->response(200, ['status' => 200, 'data' => $feeds]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
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
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->comment_enc_id = $utilitiesModel->encrypt();
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
                ->andWhere(['like', 'skill', $keyword])
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
                ->select(['a.post_enc_id', 'a.post_title',
                    'a.slug post_slug',
                    'a.author',
                    'a.post_source_url',
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
                ->where(['a.post_enc_id' => $params['post_id'], 'a.is_deleted' => 0, 'a.status' => 'Active'])
                ->asArray()
                ->all();

            if ($detail) {
                $detail['feedback_status'] = $this->getLikes($detail['post_enc_id']);
                return $this->response(200, ['status' => 200, 'data' => $detail]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}