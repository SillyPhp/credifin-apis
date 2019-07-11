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
                ->select(['a.assigned_category_enc_id', 'a.category_enc_id', 'a.icon_png', 'b.name','b.slug','c.quiz_enc_id'])
                ->joinWith(['categoryEnc b'],false)
                ->joinWith(['quizzes c'],false)
                ->where(['a.assigned_to'=> 'Quiz','a.status' =>'Approved', 'a.parent_enc_id'=> NULL, 'a.is_deleted' => 0])
                ->groupBy(['c.quiz_enc_id'])
//                ->andWhere(['!=', 'c.quiz_enc_id', NULL])
                ->asArray()
                ->all();
            print_r($categories);
            exit();

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
                    'a.is_deleted' => 0
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
                    'd.slug' => $type
                ])
                ->asArray()
                ->all();
            return $this->render('all-quiz', [
                'data' => $quizes
            ]);
        }
    }
}