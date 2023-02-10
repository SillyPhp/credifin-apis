<?php

namespace api\modules\v4\controllers;

use common\models\AssignedSupervisor;
use common\models\SelectedServices;
use common\models\UserRoles;
use common\models\Users;
use common\models\UserTypes;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use api\modules\v4\models\Candidates;
use common\models\UserAccessTokens;

class ApiBaseController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function response($code, $data = '')
    {
        $message = $this->getStatusCodeMessage($code);

        if (!empty($data)) {
            $response = [
                'response' => $data
            ];
        }

        $this->setHeader($code);

        if ($code == 401) {
            echo json_encode($response);
            die();
        } else {
            return $response;
        }

    }

    private function getStatusCodeMessage($status)
    {
        $codes = [

            //Success Codes
            200 => 'OK',
            201 => 'New Resource Created',

            //Client Error
            401 => 'Unauthorised',
            404 => 'Resource Not Found',
            405 => 'Method Not allowed',
            409 => 'Conflict', //Validation Error or Creating resource that already exists
            422 => 'Missing Information in Request',

            //Server Error
            500 => 'Information cant be processes', //data didnt saved
            503 => 'Service Unavailable',
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function setHeader($status)
    {
        $status_header = 'HTTP/2 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Empower Youth Foundation");
    }

    public function isAuthorized()
    {
        $source = Yii::$app->request->headers->get('source');
        $bearer_token = Yii::$app->request->headers->get('Authorization');
        $token = explode(" ", $bearer_token)[1];
        $access_token = UserAccessTokens::findOne(['access_token' => $token]);
        if (!empty($access_token) && $source == $access_token->source) {
            if (strtotime($access_token->access_token_expiration) > strtotime("now")) {
                $time_now = date('Y-m-d H:i:s');
                $access_token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
                $access_token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
                $identity = Candidates::findOne(['user_enc_id' => $access_token->user_enc_id]);
                Yii::$app->user->login($identity);
                return Candidates::findOne(['user_enc_id' => $access_token->user_enc_id]);
            }
            return false;
        }
        return false;
    }

    public function getFinancerId($user)
    {
        $service = $this->getServices($user);

        $serviceArr = array_column($service, 'name');

        $user_type = '';
        if (in_array('Loans', $serviceArr)) {
            return $user->organization_enc_id;
        } else if (in_array('E-Partners', $serviceArr)) {
            $user_type = "DSA";
        } else if (in_array('Connector', $serviceArr)) {
            $user_type = "Connector";
        } else {
            $user_type = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;
        }

        if ($user_type == 'Employee') {

            $org_id = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);

            if ($org_id) {
                return $org_id->organization_enc_id;
            }

            return null;
        }

        if ($user_type == 'DSA') {

            $dsa = AssignedSupervisor::find()
                ->alias('a')
                ->select(['a.assigned_enc_id', 'a.supervisor_enc_id', 'b.organization_enc_id'])
                ->joinWith(['supervisorEnc b'], false);
            if ($user->organization_enc_id) {
                $dsa->where(['a.assigned_organization_enc_id' => $user->organization_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
            } else {
                $dsa->where(['a.assigned_user_enc_id' => $user->user_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
            }
            $dsa = $dsa->asArray()->one();

            if ($dsa) {
                return $dsa['organization_enc_id'];
            }

            return null;
        }

        if ($user_type == 'Connector') {

            // getting connector service obj
            $s = SelectedServices::findOne(['created_by' => $user->user_enc_id]);

            // connector assigned by user data
            $u = Users::findOne(['user_enc_id' => $s->assigned_user]);

            // getting assigned by user service
            $ser = $this->getServices($u);

            $serArr = array_column($ser, 'name');

            // if assigned by user is financer
            if (in_array('Loans', $serArr)) {
                return $u->organization_enc_id;
            } else if (in_array('E-Partners', $serviceArr)) {
                // if assigned by user is dsa
                $dsa = AssignedSupervisor::find()
                    ->alias('a')
                    ->select(['a.assigned_enc_id', 'a.supervisor_enc_id', 'b.organization_enc_id'])
                    ->joinWith(['supervisorEnc b'], false);
                if ($u->organization_enc_id) {
                    $dsa->where(['a.assigned_organization_enc_id' => $u->organization_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
                } else {
                    $dsa->where(['a.assigned_user_enc_id' => $u->user_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
                }
                $dsa = $dsa->asArray()->one();

                if ($dsa) {
                    return $dsa['organization_enc_id'];
                }

                return null;
            }
        }

        return null;
    }

    private function getServices($user)
    {
        $service = SelectedServices::find()
            ->alias('a')
            ->select(['b.name'])
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.is_selected' => 1]);
        if ($user->organization_enc_id) {
            $service->andWhere(['or', ['a.organization_enc_id' => $user->organization_enc_id]]);
        } else {
            $service->andWhere(['or', ['a.created_by' => $user->user_enc_id]]);
        }

        $service = $service->asArray()
            ->all();

        return $service;
    }
}