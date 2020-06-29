<?php

namespace frontend\controllers;

use common\models\Countries;
use common\models\Industries;
use common\models\Skills;
use common\models\User;
use common\models\UserAchievements;
use common\models\UserEducation;
use common\models\UserHobbies;
use common\models\UserInterests;
use common\models\UserPreferences;
use common\models\UserPreferredIndustries;
use common\models\UserPreferredJobProfile;
use common\models\UserPreferredLocations;
use common\models\UserPreferredSkills;
use common\models\UserTypes;
use common\models\UserWorkExperience;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\web\UploadedFile;
use frontend\models\profile\UserProfileBasicEdit;
use frontend\models\profile\UserProfileSocialEdit;
use common\models\Categories;
use common\models\Cities;
use common\models\States;
use common\models\Users;
use frontend\models\profile\UserProfilePictureEdit;

class UsersController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        return parent::beforeAction($action);
    }

    public function getPreference($type, $id)
    {

        $p = UserPreferences::find()
            ->alias('a')
            ->select([
                'a.preference_enc_id',
                'a.type',
                'a.assigned_to',
                'a.timings_from',
                'a.timings_to',
                'a.salary',
                'a.sat_frequency',
                'a.sun_frequency',
                'a.min_expected_salary',
                'a.max_expected_salary',
                'a.experience',
                'a.working_days',
                'c1.slug industry_slug',
            ])
            ->innerJoinWith(['userPreferredJobProfiles b' => function ($b) {
                $b->select(['b.preference_enc_id', 'b.job_profile_enc_id', 'b1.category_enc_id', 'b1.name profile_name']);
                $b->joinWith(['jobProfileEnc b1'], false);
                $b->andWhere(['b.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredIndustries c' => function ($c) {
                $c->select(['c.preference_enc_id', 'c.industry_enc_id', 'c1.industry']);
                $c->joinWith(['industryEnc c1'], false);
                $c->andWhere(['c.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredSkills d' => function ($d) {
                $d->select(['d.preference_enc_id', 'd.preferred_skill_enc_id', 'd1.skill_enc_id', 'd1.skill']);
                $d->joinWith(['skillEnc d1'], false);
                $d->andWhere(['d.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredLocations e' => function ($e) {
                $e->select(['e.preference_enc_id', 'e.city_enc_id', 'e1.name city_name', 'e2.name state_name', 'e3.name country_name']);
                $e->joinWith(['cityEnc e1' => function ($e1) {
                    $e1->joinWith(['stateEnc e2' => function ($e2) {
                        $e2->joinWith(['countryEnc e3']);
                    }]);
                }], false);
                $e->andWhere(['e.is_deleted' => 0]);
            }])
            ->andWhere(['a.is_deleted' => 0, 'a.created_by' => $id, 'a.assigned_to' => $type])
            ->asArray()
            ->one();

        $skills = [];
        $cities = [];
        $states = [];
        $countries = [];
        $profiles_name = [];
        $industry = [];
        foreach ($p['userPreferredIndustries'] as $i_slug) {
            array_push($industry, $i_slug['industry']);
        }
        foreach ($p['userPreferredJobProfiles'] as $p_slug) {
            array_push($profiles_name, $p_slug['profile_name']);
        }
        foreach ($p['userPreferredSkills'] as $s) {
            array_push($skills, $s['skill']);
        }
        foreach ($p['userPreferredLocations'] as $l) {
            array_push($cities, $l['city_name']);
            array_push($states, $l['state_name']);
            array_push($countries, $l['country_name']);
        }
        return [
            'profiles_name' => implode(', ', array_unique($profiles_name)),
            'industry' => implode(', ', array_unique($industry)),
            'skills' => implode(', ', array_unique($skills)),
            'cities' => implode(', ', array_unique($cities)),
            'states' => implode(', ', array_unique($states)),
            'countries' => implode(', ', array_unique($countries)),
            'days' => $p['working_days'],
            'exp' => $p['experience'],
            'min_salary' => $p['min_expected_salary'],
            'max_salary' => $p['max_expected_salary'],
            'sat_frequency' => $p['sat_frequency'],
            'sun_frequency' => $p['sun_frequency'],
            'from' => $p['timings_from'],
            'to' => $p['timings_to'],
            'salary' => $p['salary'],
            'type' => $p['type'],
        ];
    }

    public function actionProfile($username)
    {
        $user = Users::find()
            ->alias('a')
            ->select(['a.*',
                '(CASE 
                WHEN a.is_available = "0" THEN "Not Available"
                WHEN a.is_available = "1" THEN "Available"
                WHEN a.is_available = "2" THEN "Open"
                WHEN a.is_available = "3" THEN "Actively Looking"
                WHEN a.is_available = "4" THEN "Exploring Possibilities"
                ELSE "Undefined"
                END) as availability',
                'ROUND(DATEDIFF(CURDATE(),
                 a.dob)/ 365.25) as age',
                'b.name as city',
                'c.name as job_profile'
            ])
            ->leftJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
            ->leftJoin(Categories::tableName() . 'as c', 'c.category_enc_id = a.job_function')
            ->where(['username' => $username, 'status' => 'Active', 'is_deleted' => 0])
            ->asArray()
            ->one();

        if (!count($user) > 0) {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }

        $skills = \common\models\UserSkills::find()
            ->alias('a')
            ->select(['a.skill_enc_id', 'b.skill skills'])
            ->innerJoin(\common\models\Skills::tableName() . 'b', 'b.skill_enc_id = a.skill_enc_id')
            ->where(['a.created_by' => $user['user_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $language = \common\models\UserSpokenLanguages::find()
            ->alias('a')
            ->select(['a.language_enc_id', 'b.language language'])
            ->innerJoin(\common\models\SpokenLanguages::tableName() . 'b', 'b.language_enc_id = a.language_enc_id')
            ->where(['a.created_by' => $user['user_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();

        $userCv = \common\models\UserResume::find()
            ->select(['resume', 'resume_location'])
            ->where(['user_enc_id' => $user['user_enc_id']])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->one();

        $education = UserEducation::find()
            ->where(['user_enc_id' => $user['user_enc_id']])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'a.city_enc_id', 'a.company', 'a.title', 'a.from_date', 'a.to_date', 'b.name city_name'])
            ->where(['a.user_enc_id' => $user['user_enc_id']])
            ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $achievement = UserAchievements::find()
            ->where(['user_enc_id' => $user['user_enc_id'], 'is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $hobbies = UserHobbies::find()
            ->where(['user_enc_id' => $user['user_enc_id'], 'is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $interests = UserInterests::find()
            ->where(['user_enc_id' => $user['user_enc_id'], 'is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $job_preference = self::getPreference('Jobs', $user['user_enc_id']);
        $internship_preference = self::getPreference('Internships', $user['user_enc_id']);

        $dataProvider = [
            'user' => $user,
            'skills' => $skills,
            'language' => $language,
            'userCv' => $userCv,
            'job_preference' => $job_preference,
            'internship_preference' => $internship_preference,
            'education' => $education,
            'experience' => $experience,
            'achievement' => $achievement,
            'hobbies' => $hobbies,
            'interests' => $interests,
        ];

        if (Yii::$app->user->isGuest) {
            $page = 'guest-view';
        } else {
            $orgId = Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id])['organization_enc_id'];
            if ($orgId != null || $orgId != "") {
                $page = 'view';
            } else {
                if (Yii::$app->user->identity->user_enc_id == $user['user_enc_id']) {
                    $page = 'view';
                } else {
                    $page = 'guest-view';
                }
            }
        }
        return $this->render($page, $dataProvider);
    }

    public function actionEdit()
    {
        if (!Yii::$app->user->isGuest && empty(Yii::$app->user->identity->organization)) {
            $userProfilePicture = new UserProfilePictureEdit();
            $basicDetails = new UserProfileBasicEdit();
            $socialDetails = new UserProfileSocialEdit();
            $object = new \account\models\jobs\JobApplicationForm();
            $industry = $object->getPrimaryFields('Profiles');
            $statesModel = new States();
            $getName = $basicDetails->getJobFunction();
            $getCurrentCity = $basicDetails->getCurrentCity();
            $getCategory = $basicDetails->getCurrentCategory();
            $getExperience = $basicDetails->getExperience();
            $getSkills = $basicDetails->getUserSkills();
            $getlanguages = $basicDetails->getUserlanguages();
            return $this->render('edit', [
                'userProfilePicture' => $userProfilePicture,
                'userLanguage' => $getlanguages,
                'userSkills' => $getSkills,
                'getExperience' => $getExperience,
                'getCurrentCity' => $getCurrentCity,
                'getName' => $getName,
                'getCategory' => $getCategory,
                'basicDetails' => $basicDetails,
                'socialDetails' => $socialDetails,
                'statesModel' => $statesModel,
                'industry' => $industry,
            ]);
        } else {
            return 'You are not Login as candidate login';
        }
    }

    public function actionUpdateBasicDetail()
    {
        $basicDetails = new UserProfileBasicEdit();
        if ($basicDetails->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($basicDetails->update()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }

    public function actionUpdateSocialDetail()
    {
        $socialDetails = new UserProfileSocialEdit();
        if ($socialDetails->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($socialDetails->updateValues()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }

    public function actionUpdateProfilePicture()
    {
        $userProfilePicture = new UserProfilePictureEdit();
        if ($userProfilePicture->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($userProfilePicture->update()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }

}