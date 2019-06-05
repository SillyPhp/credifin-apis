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

    public function actionShortlisted()
    {

        $shortlist_org = FollowedOrganizations::find()
            ->alias('a')
            ->select(['b.establishment_year','a.followed_enc_id', 'b.name as org_name', 'b.initials_color', 'c.industry', 'b.logo', 'b.logo_location', 'b.slug'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
            ->joinWith(['organizationEnc b'=>function($a){
                $a->where(['is_deleted'=>0]);
            }],false)
            ->leftJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = b.industry_enc_id')
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
