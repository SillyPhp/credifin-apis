<?php

namespace frontend\controllers;

use common\models\AssignedCategories;
use common\models\QuizAnswersPool;
use common\models\QuizPool;
use common\models\QuizRegistration;
use common\models\QuizSubmittedAnswers;
use common\models\Quizzes;
use common\models\UserAccessTokens;
use common\models\Users;
use common\models\Webinar;
use common\models\WebinarRegistrations;
use common\models\UserLogin;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\web\Response;
use yii\web\HttpException;

class QuizzesController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionList()
    {
        if ($type == null) {
            $categories = AssignedCategories::find()
                ->alias('a')
                ->select(['b.name', 'b.slug', 'CASE WHEN a.icon_png IS NULL OR a.icon_png = "" THEN "' . Url::to('@commonAssets/quiz_categories/other1.png') . '" ELSE CONCAT("' . Url::to('@commonAssets/quiz_categories/') . '", a.icon_png) END icon'])
                ->joinWith(['parentEnc b'], false)
                ->innerJoinWith(['quizzes c'], false)
                ->where(['a.assigned_to' => 'Quiz', 'a.status' => 'Approved', 'a.is_deleted' => 0, 'c.is_deleted' => 0, 'c.display' => 1])
                ->groupBy(['a.assigned_category_enc_id'])
                ->asArray()
                ->all();

            $quizes = Quizzes::find()
                ->alias('a')
                ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'a.num_of_ques cnt', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug'])
                ->innerJoinWith(['quizPoolEnc b' => function ($b) {
                    $b->innerJoinWith(['quizQuestionsPools z']);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 1,
                    'a.display' => 1
                ])
                ->groupBy('a.quiz_enc_id')
                ->asArray()
                ->limit(12)
                ->all();
            return $this->render('quiz-landing-page', [
                'data' => $categories,
                'quiz' => $quizes
            ]);
        } else {
            $quizes = Quizzes::find()
                ->alias('a')
                ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'a.num_of_ques cnt', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'd.name category_name', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", d.icon) icon'])
                ->innerJoinWith(['quizPoolEnc b' => function ($b) {
                    $b->innerJoinWith(['quizQuestionsPools z']);
                }], false)
                ->innerJoinWith(['assignedCategoryEnc c' => function ($x) {
                    $x->joinWith(['parentEnc d']);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
                    'a.display' => 1,
                    'd.slug' => $type
                ])
                ->groupBy('a.quiz_enc_id')
                ->asArray()
                ->all();
            return $this->render('all-quiz', [
                'data' => $quizes
            ]);
        }
    }

    public function actionAll()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $page = Yii::$app->request->post('page');
            $limit = Yii::$app->request->post('limit');
            $quizes = Quizzes::find()
                ->alias('a')
                ->select(['CASE WHEN a.sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->quiz->sharing->image, 'https') . '", a.sharing_image_location, "/", a.sharing_image) ELSE NULL END image', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'a.num_of_ques cnt'])
                ->innerJoinWith(['quizPoolEnc b' => function ($b) {
                    $b->innerJoinWith(['quizQuestionsPools z']);
                }], false)
                ->where([
                    'a.display' => 1,
                    'a.is_deleted' => 0
                ])
                ->groupBy('a.quiz_enc_id')
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->limit($limit)
                ->all();

            return [
                'status' => 200,
                'title' => 'Success',
                'data' => $quizes
            ];
        }

        return $this->render('all');
    }

    private function __registerQuiz($quiz_id)
    {
        $register = new QuizRegistration();
        $register->register_enc_id = Yii::$app->security->generateRandomString();
        $register->quiz_enc_id = $quiz_id;
        $register->status = 1;
        $register->created_by = Yii::$app->user->identity->user_enc_id;
        $register->created_on = date('Y-m-d H:i:s');
        if (!$register->save()) {
            return false;
        }

        return true;
    }

    private function __loginUserFromMec($username)
    {
        return Yii::$app->user->login(UserLogin::findByUsername($username), 0);
    }

    private function __returnData($message, $slug, $token = null, $type = null)
    {
        Yii::$app->session->setFlash('error', $message);
        if ($token == null) {
            return $this->redirect(['/quiz/' . $slug]);
        } else {
            return $this->render('non-authorized', [
                'type' => $type,
                'message' => $message
            ]);
        }
    }

    public function actionPlay($slug, $s = NULL, $t = NULL, $token = null)
    {

        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentTime = $dt->format('Y-m-d H:i:s');

        $temp = Quizzes::find()
            ->alias('a')
            ->innerJoinWith(['quizPoolEnc b' => function ($b) {
                $b->innerJoinWith(['quizQuestionsPools z']);
            }], false)
            ->where([
                'a.slug' => $slug,
                'a.status' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->one();


        // checking user logged in or not
        if (Yii::$app->user->isGuest) {

            if ($token != null) {

                //login user for one day if user from mec
                $user = UserAccessTokens::findOne(['access_token' => $token]);
                $username = Users::findOne(['user_enc_id' => $user->user_enc_id])->username;

                if (!$this->__loginUserFromMec($username)) {
                    return $this->__returnData("an error occurred", $temp['slug'], $token, 1);
                }
            } else {
                return $this->__returnData("Please Login to play quiz", $temp['slug']);
            }
        }

        // checking user registered for this quiz or not
        $registered = QuizRegistration::findOne(['quiz_enc_id' => $temp['quiz_enc_id'], 'is_deleted' => 0, 'status' => 1, 'created_by' => Yii::$app->user->identity->user_enc_id]);

        // if not registered and quiz is free then register the quiz before play else redirect to quiz detail page to register
        if (!$registered) {
            if ($temp['is_paid'] == 0) {
                if (!$this->__registerQuiz($temp['quiz_enc_id'])) {
                    return $this->__returnData("Please Register quiz to play", $temp['slug'], $token, 2);
                }
            } else {
                return $this->__returnData("Please Register quiz to play", $temp['slug'], $token, 2);

            }
        }

        //checking quiz play datetime
        if ($temp['quiz_start_datetime'] > $currentTime) {
            return $this->__returnData("Quiz will be held on " . $temp['quiz_start_datetime'], $temp['slug'], $token, 3);
        }

        if ($temp['quiz_end_datetime'] < $currentTime) {
            return $this->__returnData("Quiz is expired", $temp['slug'], $token, 4);
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($temp['template'] == 6) {
                $data = Yii::$app->request->post();
                $quizSubmittedAnsers = new QuizSubmittedAnswers();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $quizSubmittedAnsers->quiz_submitted_answers_enc_id = $utilitiesModel->encrypt();
                $quizSubmittedAnsers->quiz_question_pool_enc_id = $data['question'];
                $quizSubmittedAnsers->answer_enc_id = $data['ans'];
                $quizSubmittedAnsers->consumed_time = $data['ct'];
                $quizSubmittedAnsers->user_enc_id = Yii::$app->user->identity->user_enc_id;
                $quizSubmittedAnsers->quiz_slug = $slug;
                $checkAns = QuizAnswersPool::find()
                    ->select(['is_answer'])
                    ->where(['quiz_answer_pool_enc_id' => $data['ans']])
                    ->one();
                $quizSubmittedAnsers->is_correct = $checkAns['is_answer'];
                if (!$quizSubmittedAnsers->save()) {
                    return false;
                }

                $submittedQuestions = $this->_getPreviousQuestions($slug);
                $newQuestion = $this->_getQuestion($submittedQuestions, $slug);
                $result = QuizSubmittedAnswers::find()
                    ->select(['answer_enc_id'])
                    ->where(['quiz_slug' => $slug, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
                    ->count();
                if ($newQuestion && $result <= $temp['num_of_ques']) {
                    return $response = [
                        'status' => 200,
                        'message' => 'Success',
                        'question' => $newQuestion,
                    ];
                } else {
                    $result = $this->_getQuizResult($slug);
                    return $response = [
                        'status' => 205,
                        'message' => 'Success',
                        'result' => $result,
                    ];
                }
            } else {
                $quiz = Quizzes::find()
                    ->alias('a')
                    ->joinWith(['quizPoolEnc b' => function ($x) use ($temp) {
                        $x->andWhere([
                            'b.status' => 1,
                            'b.is_deleted' => 0
                        ]);
                        $x->joinWith(['quizQuestionsPools c' => function ($c) use ($temp) {
                            $c->joinWith(['quizAnswersPools d']);
                            $c->groupBy('c.quiz_question_pool_enc_id');
                            $c->orderby(new Expression('rand()'));
                            $c->limit($temp['num_of_ques']);
                        }]);
                    }])
                    ->where([
                        'a.slug' => $slug,
                        'a.status' => 1,
                        'a.is_deleted' => 0
                    ])
                    ->asArray()
                    ->one();
                return [
                    'results' => $quiz['quizPoolEnc']['quizQuestionsPools']
                ];
            }
        }
        switch ($temp['template']) {
            case 1:
                $this->layout = 'quiz-main';
                return $this->render('cricket-quiz', [
                    'score' => $s,
                    'total' => $t,
                    'quiz' => $temp
                ]);
                break;
            case 2:
                $this->layout = 'quiz2-main';
                return $this->render('cricket-quiz-2', [
                    'score' => $s,
                    'total' => $t,
                    'quiz' => $temp
                ]);
                break;
            case 3:
                $this->layout = 'quiz3-main';
                return $this->render('quiz-3', [
                    'score' => $s,
                    'total' => $t,
                    'quiz' => $temp
                ]);
                break;
            case 4:
                $this->layout = 'quiz4-main';
                return $this->render('quiz-4', [
                    'score' => $s,
                    'total' => $t,
                    'quiz' => $temp
                ]);
                break;
            case 5:
                $this->layout = 'quiz5-main';
                return $this->render('quiz-5', [
                    'score' => $s,
                    'total' => $t,
                    'quiz' => $temp
                ]);
                break;
            case 6:
                $this->layout = 'quiz6-main';
                $result = QuizSubmittedAnswers::find()
                    ->select(['answer_enc_id'])
                    ->where(['quiz_slug' => $slug, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
                    ->count();
                if ($result == 0 && $result <= $temp['num_of_ques']) {
                    return $this->render('college-quiz', [
                        'quiz' => $this->_getQuestion([], $slug),
                    ]);
                } else {
                    $noOfQuestion = Quizzes::find()
                        ->select('num_of_ques')
                        ->where(['slug' => $slug])
                        ->asArray()
                        ->one();
                    return $this->render('college-quiz', [
                        'result' => $this->_getQuizResult($slug),
                        'noOfQuestion' => $noOfQuestion,
                    ]);
                }
                break;
            default :
                throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    private function _getPreviousQuestions($slug)
    {
        $previousQuestions = QuizSubmittedAnswers::find()
            ->select(['quiz_question_pool_enc_id'])
            ->where(['quiz_slug' => $slug, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();
        $r = ArrayHelper::getColumn($previousQuestions, 'quiz_question_pool_enc_id');
        return $r;
    }

    private function _getQuestion($isSubmitted = [], $slug)
    {
        $question = Quizzes::find()
            ->alias('z')
            ->innerJoinWith(['quizPoolEnc a' => function ($a) use ($isSubmitted) {
                $a->innerJoinWith(['quizQuestionsPools c' => function ($c) use ($isSubmitted) {
                    $c->innerJoinWith(['quizAnswersPools d' => function ($d) {
                        $d->select(['d.quiz_answer_pool_enc_id', 'd.quiz_question_pool_enc_id', 'd.answer']);
                    }]);
                    $c->andWhere(['not in', 'c.quiz_question_pool_enc_id', $isSubmitted]);
                    $c->andWhere(['c.is_deleted'=>0]);
                    $c->orderby(new Expression('rand()'));
                    $c->limit(1);
                }]);
            }])
            ->where(['z.slug' => $slug])
            ->asArray()
            ->one();
        return $question;
    }

    private function _getQuizResult($slug)
    {
        $result = QuizSubmittedAnswers::find()
            ->select(['answer_enc_id'])
            ->where(['quiz_slug' => $slug, 'is_correct' => 1, 'user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->count();
        return $result;
    }

    public function actionGetResult($slug)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = $this->_getQuizResult($slug);
            return $response = [
                'status' => 205,
                'message' => 'Success',
                'result' => $result,
            ];
        }
    }

    public function actionSubjectPage()
    {
        return $this->render('subject-page');
    }

    public function actionTopics()
    {
        return $this->render('topics');
    }

    public function actionIndex($type = null)
    {
        return $this->render('quiz-filters');
    }

    public function actionDetail($slug)
    {
        return $this->render('quiz-detail');
    }
}