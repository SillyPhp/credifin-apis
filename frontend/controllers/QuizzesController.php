<?php

namespace frontend\controllers;

use common\models\Quiz;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class QuizzesController extends Controller
{
    public function actionIndex($type = null){
        if ($type == null) {
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
                'data' => $quizes
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