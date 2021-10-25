<?php
namespace api\modules\v3\controllers;
use common\models\Webinar;
use common\models\WebinarPayments;
use yii\filters\VerbFilter;
use Yii;
class WebinarController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'request-payment' => ['POST', 'OPTIONS'],
                'update-status' => ['POST', 'OPTIONS']
            ]
        ];
        return $behaviors;
    }

    public function actionRequestPayment()
    {
        $args = Yii::$app->request->post();
        if ($args['webinar_enc_id']&&$args['created_by'])
        {
            //check weather the webinar exist or not
            $model = Webinar::findOne(['webinar_enc_id'=>$args['webinar_enc_id']]);
            if (empty($model))
            {
                return $this->response(422, ['status' => 422, 'message' => 'Webinar information Not Found']);
            }else{
                //check weather its free or already paid;
                if ($model->price==0||$model->price==null){
                    return $this->response(422, ['status' => 422, 'message' => 'This Webinar Doesn\'t have any amount value']);
                }
                //check weather user has already paid
                $webinar_payments = WebinarPayments::find()
                    ->where(['webinar_enc_id'=>$args['webinar_enc_id'],'created_by'=>$args['created_by']])->andWhere(['payment_status'=>'captured'])
                    ->one();
                if (!empty($webinar_payments))
                {
                    return $this->response(422, ['status' => 422, 'message' => 'User Already Paid The Amount']);
                }else{
                    $payment = new \common\models\extended\WebinarPayments();
                    if ($payment->load($args,''))
                    {
                        if ($data = $payment->checkout()) {
                            return $this->response(200, ['status' => 200, 'callback' => $data]);
                        } else {
                            return $this->response(500, ['status' => 500, 'message' => 'Something Went Wrong On Server Side..']);
                        }
                    }
                }
            }
        }else{
            return $this->response(422, ['status' => 422, 'message' => 'Missing Arguments']);
        }
    }

    public function actionUpdateStatus()
    {
        $args = Yii::$app->request->post();
        if ($args['payment_enc_id'])
        {
            $payment = new \common\models\extended\WebinarPayments();
                if ($payment->updateStatus($args)) {
                    return $this->response(200, ['status' => 200, 'message' => 'success']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'Something Went Wrong On Server Side..']);
                }
        }else{
            return $this->response(422, ['status' => 422, 'message' => 'Missing Arguments']);
        }
    }
}