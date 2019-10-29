<?php

namespace frontend\controllers\organizations;

use common\models\AppliedApplications;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\ApplicationTypes;
use frontend\models\JobApplied;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\HttpException;

class CareersController extends Controller
{
    public function actionIndex($slug)
    {
        $this->layout = 'without-header';
        $org = Organizations::find()
            ->select([
                'name',
                'website',
                'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", logo_location, "/", logo) END logo'
            ])
            ->where([
                'slug' => $slug
            ])
            ->andWhere(['or',['!=', 'website', null],['!=', 'website', ""]])
            ->asArray()
            ->one();
        if (!$org) {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post();
            if (isset($options['type']) == 'jobs' && $options['type'] == 'jobs') {
                $jobs = $this->getCareerInfo('Jobs', $options, $slug);
            } elseif (isset($options['type']) == 'internships' && $options['type'] == 'internships') {
                $internships = $this->getCareerInfo('Internships', $options, $slug);
            } else {
                $jobs = $this->getCareerInfo('Jobs', $options, $slug);
                $internships = $this->getCareerInfo('Internships', $options, $slug);
                $count = $jobs['count'] + $internships['count'];
            }
            return ['status' => 200, 'jobs' => $jobs['result'], 'internships' => $internships['result'], 'count' => $count];

        }

        return $this->render('career-company', [
            'org' => $org

        ]);
    }

    private function getCareerInfo($type, $options, $slug)
    {
        if ($options['limit']) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }
        $jobDetail = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.application_enc_id',
                'a.last_date',
                'a.type',
                'CONCAT("/",d.slug,"/",LOWER(LEFT(j.name,LENGTH(j.name) -1)),"/",a.slug) as slug',
                'dd.name category',
                'l.designation',
                'd.initials_color color',
                'CONCAT("' . Url::to('/', true) . '", d.slug) organization_link',
//                "g.name as city",
                'c.name as title',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', "https") . '", dd.icon) icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)
                https://ui-avatars.com/api/?name=
                ", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
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
            ])
            ->joinWith(['title b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
                $b->joinWith(['parentEnc dd'], false);
            }], false)
            ->joinWith(['organizationEnc d' => function ($a) {
                $a->where(['d.is_deleted' => 0]);
            }], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->select(['e.application_enc_id','g.name','e.placement_location_enc_id']);
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g' => function ($x) {
//                        $x->select(['g.name city']);
                        $x->joinWith(['stateEnc s'], false);
                    }], false);
                }], false);
            }], true)
            ->joinWith(['preferredIndustry h'], false)
            ->joinWith(['designationEnc l'], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => $type, 'a.status' => 'Active', 'a.is_deleted' => 0, 'd.slug' => $slug]);
        $count = $jobDetail->count();
        $result = $jobDetail
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
        return ['count' => $count, 'result' => $result];
    }

    public function actionDetail($username, $type, $slug)
    {
        $this->layout = 'without-header';
        $type = ucfirst($type);
        $application_details = EmployerApplications::find()
            ->alias('a')
            ->innerJoinWith(['organizationEnc b'], false)
            ->innerJoinWith(['applicationTypeEnc c'], false)
            ->where([
                'a.slug' => $slug,
                'b.slug' => $username,
                'c.name' => $type . 's',
                'a.is_deleted' => 0
            ])
            ->andWhere(['or',['!=', 'b.website', null],['!=', 'b.website', ""]])
            ->one();

        if (!$application_details) {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
        $object = new \account\models\applications\ApplicationForm();
        if (!empty($application_details->unclaimed_organization_enc_id)) {
            $org_details = $application_details->getUnclaimedOrganizationEnc()->select(['organization_enc_id', 'name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
            $data1 = $object->getCloneUnclaimed($application_details->application_enc_id, $application_type = $type . 's');
        } else {
            $org_details = $application_details->getOrganizationEnc()->select(['organization_enc_id', 'name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
            $data2 = $object->getCloneData($application_details->application_enc_id, $application_type = $type . 's');
        }
        if (!Yii::$app->user->isGuest) {
            $applied_jobs = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['is_deleted' => 0])
                ->exists();

            $shortlist = \common\models\ShortlistedApplications::find()
                ->select('shortlisted')
                ->where(['shortlisted' => 1, 'application_enc_id' => $application_details->application_enc_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();
        }
        $model = new \frontend\models\applications\JobApplied();
        return $this->render('/employer-applications/detail', [
            'application_details' => $application_details,
            'data1' => $data1,
            'data2' => $data2,
            'org' => $org_details,
            'applied' => $applied_jobs,
            'type' => $type,
            'model' => $model,
            'shortlist' => $shortlist,
            'settings' => [
                "showRelatedOpportunities" => false,
                "showNewPositionsWidget" => true,
            ]
        ]);
    }

}