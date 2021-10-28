<?php

namespace api\modules\v3\controllers;

use api\modules\v1\models\Candidates;
use common\models\Utilities;
use common\models\AssignedCategories;
use common\models\AssignedSkills;
use common\models\OpenJobRelatedSkills;
use common\models\OpenTitles;
use common\models\Skills;
use common\models\UserAccessTokens;
use Yii;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'demo' => ['OPTIONS', 'POST'],
                'move-titles' => ['OPTIONS', 'GET'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionDemo()
    {
        if ($user = $this->isAuthorized()) {
            return $this->response(200, $user->user_enc_id);
        } else {
            return $this->response(401, 2);
        }
    }

    public function actionMoveTitles($limit = 100)
    {
        $openTitle = OpenTitles::find()
            ->where(['is_deleted' => 0])
            ->limit($limit)
            ->all();
        $_flag = false;
        if ($openTitle) {
            foreach ($openTitle as $title) {
                $profile = \common\models\Categories::findOne(['name' => $title->name]);
                if (!$profile) {
                    $profile = new \common\models\Categories();
                    $profile->category_enc_id = $title->title_enc_id;
                    $profile->name = $title->name;
                    $profile->slug = $title->slug;
                    $profile->source = 1;
                    if ($profile->save()) {
                        $_flag = true;
                    } else {
                        $_flag = false;
                    }
                    $assignJob = AssignedCategories::find()
                        ->andWhere(['category_enc_id' => $profile->category_enc_id])
                        ->andWhere(['assigned_to' => 'Jobs'])->one();
                    if (empty($assignJob)) {
                        $_flag = self::CreateAssignCat($profile->category_enc_id, 'Jobs');
                    }
                    $assignIntern = AssignedCategories::find()
                        ->andWhere(['category_enc_id' => $profile->category_enc_id])
                        ->andWhere(['assigned_to' => 'Internships'])->one();
                    if (empty($assignIntern)) {
                        $_flag = self::CreateAssignCat($profile->category_enc_id, 'Internships');
                    }
                    if ($_flag) {
                        $openTitleSkills = OpenJobRelatedSkills::find()
                            ->alias('a')
                            ->select(['a.skill_enc_id', 'b.name', 'a.level', 'a.importance', 'b.slug'])
                            ->joinWith(['skillEnc b'], false)
                            ->andWhere(['a.title_enc_id' => $profile->category_enc_id])
                            ->andWhere(['not', ['a.level' => 0]])
                            ->asArray()
                            ->all();
                        foreach ($openTitleSkills as $row) {
                            $createSkill = Skills::find()
                                ->where(['skill' => $row['name']])
                                ->one();
                            if (!$createSkill) {
                                $createSkill = new Skills();
                                $createSkill->skill_enc_id = $row['skill_enc_id'];
                                $createSkill->skill = $row['name'];
                                $createSkill->status = 'Publish';
                                $createSkill->source = 1;
                                $createSkill->created_on = date('Y-m-d H:i:s');
                                $createSkill->created_by = Yii::$app->user->identity->user_enc_id;
                                if ($createSkill->save()) {
                                    $_flag = true;
                                } else {
                                    $_flag = false;
                                }
                            }
                            if ($_flag) {
                                $skillId = $createSkill->skill_enc_id;
                                $skillJob = AssignedSkills::find()
                                    ->andWhere(['skill_enc_id' => $createSkill->skill_enc_id, 'category_enc_id' => $profile->category_enc_id])
                                    ->andWhere(['assigned_to' => 'Jobs'])
                                    ->asArray()
                                    ->one();
                                if (empty($skillJob)) {
                                    $_flag = self::CreateAssignSkill($skillId, $profile->category_enc_id, 'Jobs', $row['importance'], $row['level']);
                                }
                                $skillInternships = AssignedSkills::find()
                                    ->andWhere(['skill_enc_id' => $createSkill->skill_enc_id, 'category_enc_id' => $profile->category_enc_id])
                                    ->andWhere(['assigned_to' => 'Internships'])
                                    ->asArray()
                                    ->one();
                                if (empty($skillInternships)) {
                                    $_flag = self::CreateAssignSkill($skillId, $profile->category_enc_id, 'Internships', $row['importance'], $row['level']);
                                }
                            }
                        }
                    }
                    if ($_flag) {
                        $title->is_deleted = 1;
                        $title->last_updated_on = date('Y-m-d H:i:s');
                        $title->last_updated_by = '7B0P3kNEldvG6k9rJmvvQm14wrJXbj';
                        if ($title->save()) {
                            $_flag = true;
                        } else {
                            $_flag = false;
                        }
                    }
                }
            }
            if ($_flag) {
                return $this->response(200, [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Title Move Successfully.',
                ]);
            } else {
                return $this->response(201, [
                    'status' => 201,
                    'title' => 'Oops!!',
                    'message' => 'Something went wrong...',
                ]);
            }
        } else {
            return $this->response(201, [
                'status' => 201,
                'title' => 'Oops!!',
                'message' => 'Data not found',
            ]);
        }
    }

    private function CreateAssignCat($id, $type)
    {
        $assignCat = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignCat->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignCat->category_enc_id = $id;
        $assignCat->assigned_to = $type;
        $assignCat->status = 'Pending';
        $assignCat->created_on = date('Y-m-d H:i:s');
        $assignCat->created_by = '7B0P3kNEldvG6k9rJmvvQm14wrJXbj';
        if ($assignCat->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function CreateAssignSkill($skillId, $id, $type, $importance, $level)
    {
        $createAssignSkill = new AssignedSkills();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $createAssignSkill->assigned_skill_enc_id = $utilitiesModel->encrypt();
        $createAssignSkill->skill_enc_id = $skillId;
        $createAssignSkill->category_enc_id = $id;
        $createAssignSkill->assigned_to = $type;
        $createAssignSkill->importance = $importance;
        $createAssignSkill->level = $level;
        $createAssignSkill->status = 'Approved';
        $createAssignSkill->created_on = date('Y-m-d H:i:s');
        $createAssignSkill->created_by = '7B0P3kNEldvG6k9rJmvvQm14wrJXbj';
        if ($createAssignSkill->save()) {
            return true;
        } else {
            return false;
        }
    }
}