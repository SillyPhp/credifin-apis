<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\SubmittedVideos;
use frontend\models\VideoDetailForm;
use frontend\models\VideoRangeForm;


class LearningController extends Controller
{
    public function actionIndex()
    {
        $submittedVideos = SubmittedVideos::find()
            ->select(['id', 'name', 'cover_image', 'slug'])
            ->limit(6)
            ->all();
        $job_categories = SubmittedVideos::find()
            ->distinct()
            ->select(['category'])
            ->limit(8)
            ->asArray()
            ->all();
        return $this->render('index', [
            'submittedVideos' => $submittedVideos,
            'job_categories' => $job_categories,
        ]);
    }

    public function actionCategory()
    {
        return $this->render('category-list');
    }

    public function actionVideoGallery()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $video_gallery = SubmittedVideos::find()
                ->select(['name', 'cover_image', 'slug'])
                ->asArray()
                ->all();
            if ($video_gallery) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'video_gallery' => $video_gallery,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
        return $this->render('video-gallery');

    }

    public function actionSlideShare()
    {
        return $this->render('slide-share');
    }

    public function actionVideoDetail($vidk)
    {
        $videodetailformModel = new VideoDetailForm();
        $videorangeformModel = new VideoRangeForm();
        $video_detail = SubmittedVideos::find()
            ->where(['slug' => $vidk])
            ->one();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $related_videos = SubmittedVideos::find()
                ->select(['name', 'slug', 'cover_image'])
                ->where(['!=', 'id', $video_detail->id])
//                ->andWhere([
//                    'or',
//                    ($video_detail->category) ? ['like', 'category', $video_detail->category] : '',
//                    ($video_detail->sub_category) ? ['like', 'sub_category', $video_detail->sub_category] : '',
//                    ($video_detail->tags) ? ['tags' => explode(',', $video_detail->tags)] : '',
//                ])
                ->limit(8)
                ->asArray()
                ->all();

            $top_videos = SubmittedVideos::find()
                ->select(['name', 'slug', 'cover_image'])
                ->where(['!=', 'id', $video_detail->id])
//                ->andWhere([
//                    'or',
//                    ($video_detail->category) ? ['like', 'category', $video_detail->category] : '',
//                    ($video_detail->sub_category) ? ['like', 'sub_category', $video_detail->sub_category] : '',
//                    ($video_detail->tags) ? ['tags' => explode(',', $video_detail->tags)] : '',
//                ])
                ->limit(2)
                ->asArray()
                ->all();
            $top_category = SubmittedVideos::find()
                ->select(['category'])
                ->asArray()
                ->all();;
            if ($related_videos || $top_videos || $top_category) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'related_videos' => $related_videos,
                    'top_videos' => $top_videos,
                    'top_category' => $top_category,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return ($response);
//            print_r($response);
//            die();
        }
        return $this->render('video-detail', [
            'video_detail' => $video_detail,
            'videodetailformModel' => $videodetailformModel,
            'videorangeformModel' => $videorangeformModel,
        ]);
    }
}