<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class UploadedResumeController extends Controller {

    public function actionAllResumeProfiles() {
        return $this->render('all-resume-profiles');
    }

    public function actionCandidateResumes() {
        return $this->render('candidate-resumes');
    }
}
