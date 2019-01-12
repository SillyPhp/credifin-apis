<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\Skills;

class SkillsController extends Controller {

    public function actionGetSkills() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $q = Yii::$app->request->post('q');

        if (!empty($q)) {
            $skillsModel = new Skills();
            $skills = $skillsModel->find()
                ->select(['skill_enc_id', 'skill'])
                ->where(['is_deleted' => 0])
                ->andWhere(['like', 'skill', $q])
                ->orderBy(['skill' => SORT_ASC])
                ->all();

            return $skills;

            if ($skills) {
                $response = [
                    'status' => 200,
                    'skills' => $skills,
                ];
            } else {
                $response = [
                    'status' => 201,
                    'message' => 'No results found.',
                ];
            }
            return $response;
        }
    }

}
