<?php

namespace frontend\controllers;

use common\models\AssignedCategories;
use common\models\Quiz;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class QuizzesController extends Controller
{
    public function actionIndex($type = null){
        if ($type == null) {
            $categories = AssignedCategories::find()
                ->alias('a')
                ->select(['b.name','b.slug','CASE WHEN a.icon_png IS NULL OR a.icon_png = "" THEN "' . Url::to('@commonAssets/quiz_categories/others.png') . '" ELSE CONCAT("' . Url::to('@commonAssets/quiz_categories/') . '", a.icon_png) END icon'])
                ->joinWith(['parentEnc b'], false)
                ->innerJoinWith(['quizzes c'], false)
                ->where(['a.assigned_to'=> 'Quiz','a.status' =>'Approved', 'a.is_deleted' => 0, 'c.is_deleted'=> 0, 'c.display' => 1])
                ->groupBy(['a.assigned_category_enc_id'])
                ->asArray()
                ->all();

            $quizes = Quiz::find()
                ->alias('a')
                ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt'])
                ->joinWith(['quizQuestions b' => function ($x) {
                    $x->onCondition([
                        'b.is_deleted' => 0
                    ]);
                    $x->groupBy(['b.quiz_enc_id']);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 1,
                    'a.display' => 1
                ])
                ->asArray()
                ->all();
            return $this->render('quiz-landing-page', [
                'data' => $categories,
                'quiz' => $quizes
            ]);
        } else {
            $quizes = Quiz::find()
                ->alias('a')
                ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt', 'd.name category_name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", d.icon) icon'])
                ->joinWith(['quizQuestions b' => function ($x) {
                    $x->onCondition([
                        'b.is_deleted' => 0
                    ]);
                    $x->groupBy(['b.quiz_enc_id']);
                }], false)
                ->joinWith(['assignedCategoryEnc c' => function ($x) {
                    $x->joinWith(['parentEnc d']);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.display' => 1,
                    'd.slug' => $type
                ])
                ->asArray()
                ->all();
            return $this->render('all-quiz', [
                'data' => $quizes
            ]);
        }
    }

    public function actionAll(){
        $quizes = Quiz::find()
            ->alias('a')
            ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt'])
            ->joinWith(['quizQuestions b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0
                ]);
                $x->groupBy(['b.quiz_enc_id']);
            }], false)
            ->where([
                'a.display' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->all();

        return $this->render('all', [
            'data' => $quizes
        ]);
    }
}