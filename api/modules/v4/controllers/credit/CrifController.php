<?php
namespace api\modules\v4\controllers\credit;
use api\modules\v4\controllers\ApiBaseController;
use common\models\auth\JwtAuth;
use common\models\credit\Process;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
class CrifController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'cr-report',
                'cr-test-report',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'cr-report' => ['POST', 'OPTIONS'],
                'cr-test-report' => ['POST', 'OPTIONS'],
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['POST', 'PUT', 'GET', 'OPTIONS'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['X-Wsse'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => False,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];
        return $behaviors;
    }

    public function actionCrReport(){
        try {
            if ($user = $this->isAuthorized()){
                $param = Yii::$app->request->post();
                if (JwtAuth::auth($param['tokenValue'])){
                    return Process::CrifCrReport($param,$user->user_enc_id);
                }else{
                    return  $this->response(401, ['message'=>'Token Expired or Invalid Token']);
                }
            } else{
                return  $this->response(401, ['message'=>'Error','Error'=>'Your Are Not Allowed To Perform This Action']);
            }
        }catch (\Exception $exception){
            return  $this->response(422, ['message'=>'Error','Error'=>$exception->getMessage()]);
        }
    }
}