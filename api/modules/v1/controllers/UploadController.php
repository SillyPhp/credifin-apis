<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v1\models\CandidateUpload;
use api\modules\v1\models\PictureUpload;
use api\modules\v1\models\ResumeUpload;
use common\models\UserAccessTokens;
use yii\helpers\Url;
use common\models\Users;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;


class UploadController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'profile-picture' => ['POST'],
                'resume' => ['POST'],
                'get-profile-link' => ['POST']
            ]
        ];
        return $behaviors;
    }

    public function actionProfilePicture()
    {
        $req = Yii::$app->request->post();
        if (empty($req['image_string'])) {
            return $this->response(422, 'Missing Information');
        }
        $image = base64_decode($req['image_string']);

        $userProfilePicture = new PictureUpload();
        if ($user_id = $userProfilePicture->update($image)) {
            $usersModel = new Users();
            $user = $usersModel->find()
                ->where(['user_enc_id' => $user_id])
                ->one();

            $result['profile_picture'] = Url::to(Yii::$app->params->upload_directories->users->image . $user->image_location . DIRECTORY_SEPARATOR . $user->image, 'https');
            return $this->response(200, $result);
        }
        return $this->response(500, 'error or not saved');
    }

    public function actionResume()
    {
        $req = Yii::$app->request->post();
        if (empty($req['resume_string']) && empty($req['resume_ext']) && empty($req['resume_name'])) {
            return $this->response(422, 'Missing Information');
        }
        $resume = base64_decode($req['resume_string']);
        $resume_ext = $req['resume_ext'];
        $resume_name = $req['resume_name'];

        $userResume = new ResumeUpload();
        if ($res = $userResume->upload($resume, $resume_ext, $resume_name)) {
            return $this->response(202, $res);
        } else {
            return $this->response(500, 'an error or not saved');
        }

    }

    public function actionGetProfileLink()
    {
        if (Yii::$app->request->headers->get('Authorization') && Yii::$app->request->headers->get('source')) {

            $token_holder_id = UserAccessTokens::find()
                ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                ->one();

            $user = Candidates::findOne([
                'user_enc_id' => $token_holder_id->user_enc_id
            ]);

            $result['profile_picture'] = Url::to(Yii::$app->params->upload_directories->users->image . $user->image_location . DIRECTORY_SEPARATOR . $user->image, 'https');
            if (!empty($result['profile_picture'])) {
                return $this->response(200, $result);
            }else{
                return $this->response(404,'Not Found');
            }

        }
    }
}
