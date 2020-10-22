<?php
namespace frontend\controllers;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use Yii;
use yii\web\Controller;
use common\models\spaces\Spaces;
use Razorpay\Api\Api;
class TestCacheController extends Controller
{
    public function actionTest()
    {
        $api_key = 'rzp_test_lzrrcON3EuW3nI';
        $api_secret = 'caFrU097wpTYMi0xQgcCfonJ';
        $api = new Api($api_key,$api_secret);

        $order  = $api->order->create([
            'receipt' => 'order_rcptid_11',
            'amount'  => 50000,
            'currency' => 'INR'
        ]);

        print_r($order);
    }

    public function actionPay()
    {
        return $this->render('pay');
    }
}
