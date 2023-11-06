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
use api\modules\v4\utilities\UserUtilities;
use common\models\UserAccessTokens;

// base controller for v4 api's
class ApiBaseController extends Controller
{

    public $user;
    public $post;

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

    // this method is used to return data from api's
    public function response($code, $data = '')
    {
        !empty($data) && empty($data['status']) ? ($data['status'] = $code) : '';

        // if data not empty then returning data in response else setting only status code in response
        $response = !empty($data) ? ['response' => $data] : ['response' => ['status' => $code]];

        // setting headers
        $this->setHeader($code);

        // if code 401 then this will return 401 in headers
        if ($code == 401) {
            echo json_encode($response);
            die();
        } else {
            // this response returns 200 code everytime in headers
            return $response;
        }
    }

    // getting status message from http code
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

    // setting header for api
    private function setHeader($status)
    {
        $status_header = 'HTTP/2 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Empower Youth Foundation");
    }

    // checking if user is authorized or not
    public function isAuthorized()
    {
        // getting source and authorization from request headers
        $source = Yii::$app->request->headers->get('source');
        $bearer_token = Yii::$app->request->headers->get('Authorization');

        // If the format is not correct, or there is no Bearer token present, the method returns false
        $token = explode(" ", $bearer_token);

        if (isset($token[0]) && $token[0] != 'Bearer') {
            return false;
        }

        if (!isset($token[1])) {
            return false;
        }

        // getting token detail from DB
        $access_token = UserAccessTokens::find()->where(['access_token' => $token[1], 'source' => $source, 'is_deleted' => 0])->one();

        // check if token exists in token detail and source == token detail source
        if (!empty($access_token)) {

            // it checks if the access token is still valid.
            if (strtotime($access_token->access_token_expiration) > strtotime("now")) {

                // If the access token is valid, it refreshes the access and refresh token expiration times.
                $time_now = date('Y-m-d H:i:s');
                $access_token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
                $access_token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));

                // after token validation getting user data object
                $user = Candidates::findOne(['user_enc_id' => $access_token->user_enc_id]);

                if ($user['status'] != 'Active' || $user['is_deleted'] == 1) {
                    return false;
                }

                // identity login
                Yii::$app->user->login($user);
                // returning user object
                return $user;
            }

            return false;
        }

        return false;
    }

    public function isSpecialUser($type = false)
    {
        $this->isAuth();
        if (!$this->isSpecial($type)) {
            $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    public function isAuth($type = false): void
    {
        if ((!$user = $this->isAuthorized()) && (!$type || $this->isSpecial($type))) {
            $this->response(401, ["message" => "unauthorized"]);
        }
        $this->post = Yii::$app->request->post();
        $this->user = $user;
    }

    public function isSpecial($type): bool
    {
        $res = false;
        if ($type == 1) {
            $res = (UserUtilities::getUserType($this->user->user_enc_id) == 'Financer' || self::specialCheck($this->user->user_enc_id));
        } elseif ($type == 2) {
            $res = UserUtilities::getUserType($this->user->user_enc_id) == 'Financer';
        } elseif ($type == 3) {
            $res = self::specialCheck($this->user->user_enc_id);
        }
        return $res;
    }

    public static function specialCheck($user_id)
    {
        $accessroles = UserUtilities::$rolesArray;
        $role = UserRoles::find()
            ->alias('a')
            ->where(['user_enc_id' => $user_id])
            ->andWhere(['a.is_deleted' => 0])
            ->joinWith(['designation b' => function ($b) use ($accessroles) {
                $b->andWhere(['in', 'b.designation', $accessroles]);
            }], true, 'INNER JOIN')
            ->exists();
        return $role;
    }

    // getting financer id from logged-in user. user can be dsa, connector, employee, financer
    public function getFinancerId($user)
    {
        // getting user service
        $service = $this->getServices($user);

        // Extracts the 'name' field from each element of the $service array
        $serviceArr = array_column($service, 'name');

        // getting user type of this user. user types can be Individual, Employee, Dealer
        $user_type = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;

        // if service is Loans then return this user organization_enc_id
        if (in_array('Loans', $serviceArr)) {
            return $user->organization_enc_id;
        } else if (in_array('E-Partners', $serviceArr)) {
            // if service assigned to this user is e-partners then make user type to DSA
            $user_type = "DSA";
        } else if (in_array('Connector', $serviceArr)) {
            // if service assigned to this user is Connector then make user type to Connector
            $user_type = "Connector";
        }

        // if user type is Employee then getting organization/fianancer of this user
        if ($user_type == 'Employee') {

            // getting data from user roles to check from which organization/financer this employee belongs to
            $user_role = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);

            // if not empty $user_role then return organization_enc_id else returns null.
            return !empty($user_role) ? $user_role->organization_enc_id : null;
        }

        // if user type is Dealer then getting organization/fianancer of this user
        if ($user_type == 'Dealer') {

            // getting data from user roles to check from which organization/financer this dealer belongs to
            $dealer_role = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);

            // if not empty $dealer_role then return organization_enc_id else returns null.
            return !empty($dealer_role) ? $dealer_role->organization_enc_id : null;
        }

        // if user type is DSA then getting organization/fianancer of this user
        if ($user_type == 'DSA') {

            // getting dsa detail
            $dsa = $this->getDsaDetail($user);

            // if not empty $dsa then return organization_enc_id else returns null.
            return !empty($dsa) ? $dsa['organization_enc_id'] : null;
        }

        if ($user_type == 'Connector') {

            // getting connector service obj to find who make this user connector
            $s = SelectedServices::findOne(['created_by' => $user->user_enc_id]);

            // object of user who make this user connector
            $u = Users::findOne(['user_enc_id' => $s->assigned_user]);

            // getting assigned by user service
            $ser = $this->getServices($u);

            // Extracts the 'name' field from each element of the $service array
            $serArr = array_column($ser, 'name');

            // service Loans means financer
            // if assigned by user is financer return this user organization_enc_id
            if (in_array('Loans', $serArr)) {
                return $u->organization_enc_id;
            } else if (in_array('E-Partners', $serviceArr)) {

                // if assigned by user is dsa
                // getting dsa detail
                $dsa = $this->getDsaDetail($user);

                // if not empty $dsa then return organization_enc_id else returns null.
                return !empty($dsa) ? $dsa['organization_enc_id'] : null;
            }
        }

        return null;
    }

    // getting DSA detail
    private function getDsaDetail($user)
    {
        $dsa = AssignedSupervisor::find()
            ->alias('a')
            ->select(['a.assigned_enc_id', 'a.supervisor_enc_id', 'b.organization_enc_id'])
            ->joinWith(['supervisorEnc b'], false);
        if ($user->organization_enc_id) {
            $dsa->where(['a.assigned_organization_enc_id' => $user->organization_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
        } else {
            $dsa->where(['a.assigned_user_enc_id' => $user->user_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
        }
        return $dsa->asArray()->one();
    }

    // getting user services what service assigned to user
    private function getServices($user)
    {
        $service = SelectedServices::find()
            ->alias('a')
            ->select(['b.name'])
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.is_selected' => 1]);

        if (!empty($user->organization_enc_id)) {
            $service->andWhere(['or', ['a.organization_enc_id' => $user->organization_enc_id]]);
        } else {
            $service->andWhere(['or', ['a.created_by' => $user->user_enc_id]]);
        }

        return $service->asArray()->all();
    }
}
