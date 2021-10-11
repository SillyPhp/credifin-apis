<?php

namespace account\controllers;

use common\models\FollowedOrganizations;
use Yii;
use yii\web\Controller;
use common\models\Utilities;
use common\models\Industries;
use common\models\Organizations;
use common\models\ShortlistedOrganizations;

class OrganizationController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionShortlisted()
    {
        $shortlist_org = FollowedOrganizations::find()
            ->alias('a')
            ->select(['az.organization_enc_id', 'a.organization_enc_id', 'az.establishment_year', 'a.followed_enc_id', 'az.name as org_name', 'az.initials_color', 'c.industry', 'az.logo', 'az.logo_location', 'az.slug'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
            ->joinWith(['organizationEnc az'=> function($az){
                $az->joinWith(['employerApplications b' => function ($x) {
                    $x->select(['b.organization_enc_id', 'b.application_type_enc_id', 'h.name', 'COUNT(distinct b.application_enc_id) as total_application']);
                    $x->joinWith(['applicationTypeEnc h' => function ($x2) {
                        $x2->distinct();
                        $x2->groupBy(['h.name']);
                        $x2->orderBy([new \yii\db\Expression('FIELD (h.name, "Jobs") DESC, h.name DESC')]);
                    }], true);
                    $x->groupBy(['b.application_enc_id']);
                    $x->onCondition(['b.is_deleted' => 0, 'b.application_for' => 1, 'b.status' => 'ACTIVE']);
                }], true);
                $az->groupBy(['az.organization_enc_id']);
                $az->distinct();
            }])
            ->leftJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = az.industry_enc_id')
            ->groupBy(['a.followed_enc_id'])
            ->distinct()
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->render('individual/shortlist-companies', [
            'shortlist_org' => $shortlist_org,
        ]);
    }

    public function actionShortlist()
    {
        if (Yii::$app->request->isPost) {
            $org_id = Yii::$app->request->post("org_id");
            $chkuser = ShortlistedOrganizations::find()
                ->select('shortlisted')
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                ->asArray()
                ->one();

            $status = $chkuser['shortlisted'];

            if (empty($chkuser)) {
                $shortlist = new ShortlistedOrganizations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $shortlist->shortlisted_enc_id = $utilitiesModel->encrypt();
                $shortlist->organization_enc_id = $org_id;
                $shortlist->shortlisted = 1;
                $shortlist->created_on = date('Y-m-d H:i:s');
                $shortlist->created_by = Yii::$app->user->identity->user_enc_id;
                $shortlist->last_updated_on = date('Y-m-d H:i:s');
                $shortlist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                if ($shortlist->save()) {
                    return 'short';
                } else {
                    return false;
                }
            } else if ($status == 1) {
                $update = Yii::$app->db->createCommand()
                    ->update(ShortlistedOrganizations::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                    ->execute();
                if ($update == 1) {
                    return 'unshort';
                }
            } else if ($status == 0) {
                $update = Yii::$app->db->createCommand()
                    ->update(ShortlistedOrganizations::tableName(), ['shortlisted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'organization_enc_id' => $org_id])
                    ->execute();
                if ($update == 1) {
                    return 'short';
                }
            }
        }
    }

}
