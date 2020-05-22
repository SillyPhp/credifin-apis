<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class MentorsController extends Controller
{
    public function actionMentorshipIndex(){
        $model = new \frontend\models\mentorship\MentorshipEnquiryForm();

        return $this->render('mentorship-index',[
            'model' => $model,
        ]);
    }

    public function actionMentorProfile(){
        return $this->render('mentor-profile');
    }

    public function actionAllMentors(){
        return $this->render('all-mentors');
    }

    public function actionScoolMentorship(){
        return $this->render('scool-mentorship');
    }
}