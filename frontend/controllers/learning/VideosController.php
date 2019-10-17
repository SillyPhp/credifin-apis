<?php

namespace frontend\controllers\learning;

use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\LearningVideos;
use mysql_xdevapi\Exception;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use frontend\models\learning\VideoForm;

class VideosController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['submit'],
                'rules' => [
                    [
                        'actions' => ['submit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSubmit()
    {
        $this->layout = 'main-secondary';

        $learningCornerFormModel = new VideoForm();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $learningCornerFormModel->load(Yii::$app->request->post());
            return ActiveForm::validate($learningCornerFormModel);
        }

        if ($learningCornerFormModel->load(Yii::$app->request->post()) && $learningCornerFormModel->validate()) {
            if ($learningCornerFormModel->save()) {
                Yii::$app->session->setFlash('success', 'Your video is submitted successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
            }
        }
        return $this->render('submit', [
            'learningCornerFormModel' => $learningCornerFormModel,
        ]);
    }

    public function actionSearch($type, $slug)
    {
        if ($type === "category") {
            $parentId = Categories::find()
                ->alias('a')
                ->select(['a.category_enc_id', 'a.name', 'CASE WHEN b.banner IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->categories->background->image, 'https') . '", b.banner_location, "/", b.banner) ELSE "/assets/themes/ey/images/pages/learning-corner/othercover.png" END banner'])
                ->joinWith(['assignedCategories b'], false)
                ->where([
                    'a.slug' => $slug,
                    'b.assigned_to' => 'Videos',
                ])
                ->andWhere([
                    'or',
                    ['not', ['b.parent_enc_id' => NULL]],
                    ['not', ['b.parent_enc_id' => ""]]
                ])
                ->asArray()
                ->one();

            if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                $result = null;
                if ($type === "category") {
                    $result = LearningVideos::find()
                        ->alias('a')
                        ->joinWith(['assignedCategoryEnc b' => function ($x) use ($slug) {
                            $x->andOnCondition(['b.assigned_to' => 'Videos']);
                            $x->andOnCondition(['b.status' => 'Approved']);
                            $x->andOnCondition(['b.is_deleted' => 0]);
                            $x->innerJoinWith(['categoryEnc c' => function ($y) use ($slug) {
                                $y->andOnCondition(['c.slug' => $slug]);
                            }]);
                        }])
                        ->andWhere(['a.status' => 1])
                        ->andWhere(['a.is_deleted' => 0])
                        ->asArray()
                        ->all();

                    $categories = AssignedCategories::find()
                        ->alias('a')
                        ->select(['a.assigned_category_enc_id', 'a.category_enc_id', 'a.parent_enc_id', 'c.slug', 'c.name', 'c.icon_png child_icon', 'd.icon_png parent_icon'])
                        ->joinWith(['learningVideos b' => function ($b) {
                            $b->andOnCondition(['b.status' => 1]);
                            $b->andOnCondition(['b.is_deleted' => 0]);
                        }], false)
                        ->joinWith(['categoryEnc c'], false)
                        ->joinWith(['parentEnc d'], false)
                        ->where(['a.assigned_to' => 'Videos'])
                        ->andWhere(['a.status' => 'Approved'])
                        ->andWhere(['a.parent_enc_id' => $parentId['category_enc_id']])
                        ->andWhere(['a.is_deleted' => 0])
                        ->groupBy(['a.assigned_category_enc_id'])
                        ->asArray()
                        ->all();

                } elseif ($type == "topic") {
                    $result = LearningVideos::find()
                        ->alias('a')
                        ->joinWith(['tagEncs b'])
                        ->where(['b.slug' => $slug])
                        ->andWhere(['a.status' => 1])
                        ->andWhere(['a.is_deleted' => 0])
                        ->asArray()
                        ->all();

                }
                if (!empty($result)) {
                    $response = [
                        'status' => 200,
                        'message' => 'Success',
                        'video_gallery' => $result,
                        'categories' => $categories,
                    ];
                } else {
                    $response = [
                        'status' => 201,
                    ];
                }
                return $response;

            }
            return $this->render('video-gallery', [
                'parentId' => $parentId,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionGetCategoryJob()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $s = Yii::$app->request->post('keyword');
            $jobs = EmployerApplications::find()
                ->alias('a')
                ->select([
                    'a.application_enc_id application_id',
                    'a.last_date',
                    'a.type',
                    'CONCAT("/job/", a.slug) link',
                    '(CASE
                    WHEN a.experience = "0" THEN "No Experience"
                    WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                    WHEN a.experience = "2" THEN "1 Year Experience"
                    WHEN a.experience = "3" THEN "2-3 Years Experience"
                    WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                    WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                    WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                    WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                    ELSE "No Experience"
                    END) as experience',
                    'c.initials_color color',
                    'CONCAT("/", c.slug) organization_link',
                    'c.name as organization_name',
                    'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", c.logo_location, "/", c.logo) ELSE NULL END logo',
                    'h.name category',
                    'g.name as title',
                    'e.designation',
                    'l.fixed_wage as fixed_salary',
                    'l.wage_type salary_type',
                    'l.max_wage as max_salary',
                    'l.min_wage as min_salary',
                    'l.wage_duration as salary_duration',
                    'i.location_enc_id location_id',
                    "k.name as city",
                ])
                ->innerJoinWith(['applicationTypeEnc b'], false)
                ->innerJoinWith(['organizationEnc c'], false)
                ->innerJoinWith(['title d' => function ($x) {
                    $x->innerJoinWith(['categoryEnc g'], false);
                    $x->innerJoinWith(['parentEnc h'], false);
                }], false)
                ->innerJoinWith(['designationEnc e'], false)
                ->innerJoinWith(['preferredIndustry f'], false)
                ->innerJoinWith(['applicationPlacementLocations i' => function ($x) {
                    $x->innerJoinWith(['locationEnc j' => function ($x) {
                        $x->innerJoinWith(['cityEnc k'], false);
                    }], false);
                }], false)
                ->innerJoinWith(['applicationOptions l'], false)
                ->where([
                    'b.name' => 'Jobs',
                    'a.for_careers' => 0,
                    'a.is_deleted' => 0,
                    'a.status' => 'Active'
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'a.slug', $s],
                    ['like', 'a.description', $s],
                    ['like', 'b.name', $s],
                    ['like', 'a.type', $s],
                    ['like', 'c.name', $s],
                    ['like', 'c.slug', $s],
                    ['like', 'c.website', $s],
                    ['like', 'g.name', $s],
                    ['like', 'h.name', $s],
                    ['like', 'g.slug', $s],
                    ['like', 'e.designation', $s],
                    ['like', 'e.slug', $s],
                    ['like', 'f.industry', $s],
                    ['like', 'f.slug', $s],
                    ['like', 'l.wage_type', $s],
                    ['like', 'l.wage_duration', $s],
                    ['like', 'j.location_name', $s],
                    ['like', 'j.address', $s],
                    ['like', 'k.name', $s],
                ])
                ->groupBy(['a.application_enc_id'])
                ->limit(6);

            $final_jobs = $jobs->asArray()->all();

            $i = 0;
            foreach ($final_jobs as $val) {
                $final_jobs[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] * 40 * 52 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] * 52 . ' p.a.';
                    } else {
                        $final_jobs[$i]['salary'] = $val['fixed_salary'] . ' p.a.';
                    }
                } elseif ($val['salary_type'] == "Negotiable") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_jobs[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . ' p.a.';
                        } else {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . ' p.a.';
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_jobs[$i]['salary'] = (string)$val['min_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary'] * 52) . ' p.a.';
                        } else {
                            $final_jobs[$i]['salary'] = (string)($val['min_salary']) . ' p.a.';
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_jobs[$i]['salary'] = (string)$val['max_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_jobs[$i]['salary'] = (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_jobs[$i]['salary'] = (string)($val['max_salary'] * 52) . ' p.a.';
                        } else {
                            $final_jobs[$i]['salary'] = (string)($val['max_salary']) . ' p.a.';
                        }
                    }
                }
                $i++;
            }

            $internships = EmployerApplications::find()
                ->alias('a')
                ->select([
                    'a.application_enc_id application_id',
                    'a.last_date',
                    'a.type',
                    'CONCAT("/internship/", a.slug) link',
                    'c.initials_color color',
                    'CONCAT("/", c.slug) organization_link',
                    'c.name as organization_name',
                    'CASE WHEN c.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", c.logo_location, "/", c.logo) ELSE NULL END logo',
                    'h.name category',
                    'g.name as title',
                    'l.fixed_wage as fixed_salary',
                    'l.wage_type salary_type',
                    'l.max_wage as max_salary',
                    'l.min_wage as min_salary',
                    'l.wage_duration as salary_duration',
                    'i.location_enc_id location_id',
                    "k.name as city",
                ])
                ->innerJoinWith(['applicationTypeEnc b'], false)
                ->innerJoinWith(['organizationEnc c'], false)
                ->innerJoinWith(['title d' => function ($x) {
                    $x->innerJoinWith(['categoryEnc g'], false);
                    $x->innerJoinWith(['parentEnc h'], false);
                }], false)
                ->innerJoinWith(['applicationPlacementLocations i' => function ($x) {
                    $x->innerJoinWith(['locationEnc j' => function ($x) {
                        $x->innerJoinWith(['cityEnc k'], false);
                    }], false);
                }], false)
                ->innerJoinWith(['applicationOptions l'], false)
                ->where([
                    'b.name' => 'Internships',
                    'a.for_careers' => 0,
                    'a.is_deleted' => 0,
                    'a.status' => 'Active'
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'a.slug', $s],
                    ['like', 'a.description', $s],
                    ['like', 'b.name', $s],
                    ['like', 'a.type', $s],
                    ['like', 'c.name', $s],
                    ['like', 'c.slug', $s],
                    ['like', 'c.website', $s],
                    ['like', 'g.name', $s],
                    ['like', 'h.name', $s],
                    ['like', 'g.slug', $s],
                    ['like', 'l.wage_type', $s],
                    ['like', 'l.wage_duration', $s],
                    ['like', 'j.location_name', $s],
                    ['like', 'j.address', $s],
                    ['like', 'k.name', $s],
                ])
                ->groupBy(['a.application_enc_id'])
                ->limit(6);

            $final_internships = $internships->asArray()->all();

            $i = 0;
            foreach ($final_internships as $val) {
                $final_internships[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $final_internships[$i]['salary'] = $val['fixed_salary'] . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $final_internships[$i]['salary'] = $val['fixed_salary'] * 730 . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $final_internships[$i]['salary'] = (int)$val['fixed_salary'] / 7 * 30 . ' p.m.';
                    } else {
                        $final_internships[$i]['salary'] = (int)$val['fixed_salary'] / 12 . ' p.m.';
                    }
                } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_internships[$i]['salary'] = (string)$val['min_salary'] . " - ₹" . (string)$val['max_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_internships[$i]['salary'] = (string)($val['min_salary'] * 730) . " - ₹" . (string)($val['max_salary'] * 730) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_internships[$i]['salary'] = (int)($val['min_salary'] / 7 * 30) . " - ₹" . (int)($val['max_salary'] / 7 * 30) . ' p.m.';
                        } else {
                            $final_internships[$i]['salary'] = (int)($val['min_salary']) / 12 . " - ₹" . (int)($val['max_salary']) / 12 . ' p.m.';
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_internships[$i]['salary'] = (string)$val['min_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_internships[$i]['salary'] = (string)($val['min_salary'] * 730) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_internships[$i]['salary'] = (int)($val['min_salary'] / 7 * 30) . ' p.m.';
                        } else {
                            $final_internships[$i]['salary'] = (int)($val['min_salary']) / 12 . ' p.m.';
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $final_internships[$i]['salary'] = (string)$val['max_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $final_internships[$i]['salary'] = (string)($val['max_salary'] * 730) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $final_internships[$i]['salary'] = (int)($val['max_salary'] / 7 * 30) . ' p.m.';
                        } else {
                            $final_internships[$i]['salary'] = (int)($val['max_salary']) / 12 . ' p.m.';
                        }
                    }
                }
                $i++;
            }

//        $result['internships'] = $final_internships;

            return $response = [
                'status' => 200,
                'title' => 'Success',
                'jobs' => $final_jobs,
                'internships' => $final_internships,
            ];
//        $result['jobs'] = ;
        }
    }

    public function actionVideos($slug)
    {
        $result = LearningVideos::find()
            ->alias('a')
            ->select(['a.video_enc_id', 'a.title', 'a.cover_image', 'a.slug'])
            ->innerJoinWith(['tagEncs b'])
            ->where(['b.slug' => $slug])
            ->andWhere(['a.status' => 1])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();

        if ($result) {
            return $this->render('tags-gallery', [
                'result' => $result,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
    }

}