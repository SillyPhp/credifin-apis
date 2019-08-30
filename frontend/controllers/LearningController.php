<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use common\models\Utilities;
use common\models\AssignedCategories;
use common\models\AssignedTags;
use common\models\Categories;
use common\models\LearningVideoComments;
use common\models\LearningVideoLikes;
use common\models\LearningVideos;
use common\models\LearningVideoTags;
use common\models\SubmittedVideos;
use common\models\Tags;
use common\models\Users;

class LearningController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['batch-videos'],
                'rules' => [
                    [
                        'actions' => ['batch-videos'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAddApproved()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $req = Yii::$app->request->post();

            $type = $req['type'];
            $category = $req['category'];
            $sub_category = $req['sub_category'];
            $name = $req['name'];
            $slug = $req['slug'];
            $link = $req['link'];
            $cover_image = $req['cover_image'];
            $description = $req['description'];
            $tags = $req['tags'];
            $created_by = $req['created_by'];
            $duration = $req['video_duration'];

            $tags_array = explode(",", trim($tags));
            $tags_id = [];

            foreach ($tags_array as $t) {
                $tag_id = null;

                $tag = trim($t);
                $tag_exists = $this->checkTag($tag);

                if (empty($tag_exists)) {
                    $tag_id = $this->addTag($tag, $created_by);
                    if ($tag_id) {
                        if (!$this->assignTag($tag_id, $created_by)) {
                            return [
                                'status' => 201,
                                'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                            ];
                        }
                    } else {
                        return [
                            'status' => 201,
                            'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                        ];
                    }
                } else {
                    $tag_id = $tag_exists[0]['tag_enc_id'];
                }
                array_push($tags_id, $tag_id);
            }

            $cat_exists = $this->checkCategory($category);

            $cat_id = null;
            $sub_cat_id = null;
            $assigned_cat_enc_id = null;

            if (empty($cat_exists)) {
                $cat_id = $this->addCategory($category, $created_by);
                if ($cat_id) {
                    if (!$this->assignCategory($cat_id, null, $created_by)) {
                        return [
                            'status' => 201,
                            'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                        ];
                    }
                } else {
                    return [
                        'status' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                    ];
                }
            } else {
                $cat_id = $cat_exists['category_enc_id'];
            }

            $sub_cat_exists = $this->checkCategory($sub_category);

            if (empty($sub_cat_exists)) {
                $sub_cat_id = $this->addCategory($sub_category, $created_by);
            } else {
                $sub_cat_id = $sub_cat_exists['category_enc_id'];
            }

            $chk_assigned = $this->checkAssigned($cat_id, $sub_cat_id);

            if (empty($chk_assigned)) {
                $assigned_cat_enc_id = $this->assignCategory($sub_cat_id, $cat_id, $created_by);
                if (!$assigned_cat_enc_id) {
                    return [
                        'response' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                    ];
                }
            } else {
                $assigned_cat_enc_id = $chk_assigned['assigned_category_enc_id'];
            }

            $learningVideosModel = new LearningVideos();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $learningVideosModel->video_enc_id = $utilitiesModel->encrypt();
            $learningVideosModel->assigned_category_enc_id = $assigned_cat_enc_id;
            $learningVideosModel->type = $type;
            $learningVideosModel->title = $name;
            $learningVideosModel->cover_image = $cover_image;
            $learningVideosModel->description = $description;
            $learningVideosModel->slug = $slug;
            $learningVideosModel->duration = $duration;
            $learningVideosModel->youtube_video_id = $link;
            $learningVideosModel->created_on = date('Y-m-d H:i:s');
            $learningVideosModel->created_by = $created_by;
            if ($learningVideosModel->save()) {
                foreach ($tags_id as $k) {
                    if (!$this->saveLearningVideoTags($learningVideosModel->video_enc_id, $k, $created_by)) {
                        return [
                            'response' => 201,
                            'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                        ];
                    }
                }
                return [
                    'response' => 200,
                    'message' => Yii::t('frontend', 'Successfully saved')
                ];
            } else {
                return [
                    'response' => 201,
                    'message' => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }
        }
    }

    private function saveLearningVideoTags($video_id, $k, $created_by)
    {
        $learningVideoTagsModel = new LearningVideoTags();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $learningVideoTagsModel->video_tag_enc_id = $utilitiesModel->encrypt();
        $learningVideoTagsModel->video_enc_id = $video_id;
        $learningVideoTagsModel->tag_enc_id = $k;
        $learningVideoTagsModel->created_on = date('Y-m-d H:i:s');
        $learningVideoTagsModel->created_by = $created_by;
        if ($learningVideoTagsModel->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function checkTag($tag)
    {
        return Tags::find()
            ->where(['name' => $tag])
            ->asArray()
            ->all();
    }

    private function checkCategory($category)
    {
        return Categories::find()
            ->where(['name' => $category])
            ->asArray()
            ->one();
    }

    private function addTag($tag, $created_by)
    {
        $tagsModel = new Tags();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $tagsModel->tag_enc_id = $utilitiesModel->encrypt();
        $tagsModel->name = $tag;
        $utilitiesModel->variables['name'] = $tag;
        $utilitiesModel->variables['table_name'] = Tags::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $tagsModel->slug = $utilitiesModel->create_slug();
        $tagsModel->created_on = date('Y-m-d H:i:s');
        $tagsModel->created_by = $created_by;
        if ($tagsModel->save()) {
            return $tagsModel->tag_enc_id;
        } else {
            return false;
        }
    }

    private function addCategory($category, $created_by)
    {
        $categoriesModel = new Categories();
        $utilitesModel = new Utilities();
        $utilitesModel->variables['string'] = time() . rand(100, 100000);
        $categoriesModel->category_enc_id = $utilitesModel->encrypt();
        $categoriesModel->name = $category;
        $utilitesModel->variables['name'] = $category;
        $utilitesModel->variables['table_name'] = Categories::tableName();
        $utilitesModel->variables['field_name'] = 'slug';
        $categoriesModel->slug = $utilitesModel->create_slug();
        $categoriesModel->created_on = date('Y-m-d H:i:s');
        $categoriesModel->created_by = $created_by;
        if ($categoriesModel->save()) {
            return $categoriesModel->category_enc_id;
        } else {
            return false;
        }
    }

    private function assignTag($tag_id, $created_by)
    {
        $assignedTagsModel = new AssignedTags();
        $utilitesModel = new Utilities();
        $utilitesModel->variables['string'] = time() . rand(100, 100000);
        $assignedTagsModel->assigned_tag_enc_id = $utilitesModel->encrypt();
        $assignedTagsModel->tag_enc_id = $tag_id;
        $assignedTagsModel->assigned_to = 2;
        $assignedTagsModel->created_on = date('Y-m-d H:i:s');
        $assignedTagsModel->created_by = $created_by;
        if ($assignedTagsModel->save()) {
            return $assignedTagsModel->assigned_tag_enc_id;
        } else {
            return false;
        }
    }

    private function assignCategory($cat_id, $parent_id, $created_by)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $cat_id;
        $assignedCategoryModel->parent_enc_id = $parent_id;
        $assignedCategoryModel->assigned_to = 'Videos';
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = $created_by;
        if ($assignedCategoryModel->save()) {
            return $assignedCategoryModel->assigned_category_enc_id;
        } else {
            return false;
        }
    }

    private function checkAssigned($cat_id, $sub_cat_id)
    {
        return Categories::find()
            ->alias('a')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->select(['b.assigned_category_enc_id', 'a.category_enc_id', 'b.parent_enc_id'])
            ->where(['b.category_enc_id' => $sub_cat_id])
            ->andWhere(['b.assigned_to' => 'Videos', 'b.parent_enc_id' => $cat_id])
            ->asArray()
            ->one();
    }

    public function actionSearchVideo()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $k = Yii::$app->request->post('keyword');

            $result = LearningVideos::find()
                ->alias('a')
                ->joinWith(['assignedCategoryEnc b' => function ($x) {
                    $x->joinWith(['categoryEnc d'], false);
                    $x->joinWith(['parentEnc e'], false);
                }], false)
                ->joinWith(['tagEncs c'], false)
                ->where(['a.status' => 1])
                ->andWhere(['a.is_deleted' => 0]);

            $result
                ->andFilterWhere([
                    'or',
                    ['like', 'a.type', $k],
                    ['like', 'a.title', $k],
                    ['like', 'a.description', $k],
                    ['like', 'c.name', $k],
                    ['like', 'd.name', $k],
                    ['like', 'e.name', $k],
                ]);

            $output = $result
                ->asArray()
                ->all();

            return [
                'status' => 200,
                'result' => $output
            ];
        }

        return $this->render('search');
    }

    public function actionIndex()
    {
        $categories = AssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id', 'a.category_enc_id', 'a.parent_enc_id', 'CASE WHEN a.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->categories->icon->png->icon, 'https') . '", a.icon_location, "/", a.icon) ELSE "/assets/themes/ey/images/pages/learning-corner/othercategory.png" END icon', 'c.slug', 'c.name'])
            ->joinWith(['learningVideos b' => function ($b) {
                $b->andOnCondition(['b.status' => 1]);
                $b->andOnCondition(['b.is_deleted' => 0]);
            }], false)
            ->joinWith(['categoryEnc c'], false)
            ->where(['a.assigned_to' => 'Videos'])
            ->andWhere(['a.status' => 'Approved'])
            ->andWhere([
                'or',
                ['a.parent_enc_id' => ""],
                ['a.parent_enc_id' => NULL]
            ])
            ->andWhere(['a.is_deleted' => 0])
            ->groupBy(['a.assigned_category_enc_id'])
            ->asArray()
            ->all();

        $popular_videos = LearningVideos::find()
//            ->orderBy(['view_count' => SORT_DESC])
            ->where([
                'is_deleted' => 0,
                'status' => 1
            ])
            ->asArray()
            ->all();
        $topics = Tags::find()
            ->alias('a')
            ->select(['a.tag_enc_id', 'a.name', 'a.slug', 'COUNT(c.video_tag_enc_id) cnt'])
            ->joinWith(['learningVideoTags c' => function ($x) {
                $x->joinWith(['videoEnc d'], false);
            }], false)
            ->joinWith(['assignedTags b' => function ($b) {
                $b->andOnCondition(['b.assigned_to' => 2]);
                $b->andOnCondition(['b.status' => 'Approved']);
                $b->andOnCondition(['b.is_deleted' => 0]);
            }], false)
            ->andWhere(['d.is_deleted' => 0])
            ->andWhere(['d.status' => 1])
            ->orderBy(['COUNT(c.tag_enc_id)' => SORT_DESC])
            ->groupBy('a.tag_enc_id')
            ->limit(8)
            ->asArray()
            ->all();

        $contributors = Users::find()
            ->alias('a')
            ->select(['a.user_type_enc_id', 'CONCAT(a.first_name, " ", a.last_name) as name', 'a.facebook', 'a.twitter', 'a.linkedin', 'a.instagram', 'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) ELSE "/assets/themes/ey/images/pages/learning-corner/collaborator.png" END image'])
            ->innerJoinWith(['userTypeEnc b' => function ($b) {
                $b->andOnCondition(['b.user_type' => 'Contributor']);
            }], false)
            ->where(['a.user_of' => 'EY', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere([
                'or',
                ['a.organization_enc_id' => ""],
                ['a.organization_enc_id' => NULL]
            ])
            ->asArray()
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'popular_videos' => $popular_videos,
            'topics' => $topics,
            'contributors' => $contributors,
        ]);
    }

    private function toMinutes($time)
    {
        $time = explode(':', $time);
        return ($time[0] * 60) + ($time[1]) + ($time[2] / 60);
    }

    public function actionVideo($slug)
    {
        $video_detail = LearningVideos::find()
            ->alias('a')
            ->select(['a.*', 'c.category_enc_id', 'c.parent_enc_id', 'd.name child_name', 'e.name parent_name'])
            ->joinWith(['learningVideoTags b' => function ($y) {
                $y->select(['b.video_enc_id', 'b.tag_enc_id', 'f.name']);
                $y->joinWith(['tagEnc f'], false);
            }])
            ->joinWith(['assignedCategoryEnc c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
                $x->joinWith(['parentEnc e'], false);
            }], false)
            ->where(['a.slug' => $slug])
            ->andWhere(['a.status' => 1])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->one();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parent_id = Yii::$app->request->post('video_id');
            $tags_id = Yii::$app->request->post('tags_id');
            $current_video_id = LearningVideos::find()
                ->where(['slug' => $slug])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();
            $interested_videos = [];
            if (count($tags_id) > 0) {
                $interested_videos = LearningVideos::find()
                    ->alias('a')
                    ->joinWith(['learningVideoTags b'], false)
                    ->where(['in', 'b.tag_enc_id', $tags_id])
                    ->andWhere(['!=', 'b.video_enc_id', $current_video_id['video_enc_id']])
                    ->asArray()
                    ->all();
            }
            $related_videos = LearningVideos::find()
                ->alias('a')
                ->joinWith(['assignedCategoryEnc b'], false)
                ->where(['b.parent_enc_id' => $parent_id])
                ->andWhere(['a.status' => 1])
                ->andWhere(['a.is_deleted' => 0])
                ->andWhere(['!=', 'a.video_enc_id', $current_video_id['video_enc_id']])
                ->asArray()
                ->all();
            $top_videos = LearningVideos::find()
                ->orderBy(['view_count' => SORT_DESC])
                ->where(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['!=', 'video_enc_id', $current_video_id['video_enc_id']])
                ->limit(2)
                ->asArray()
                ->all();
            $top_category = AssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id', 'a.category_enc_id', 'a.parent_enc_id', 'd.slug', 'c.name child_name', 'c.icon_png child_icon', 'd.icon_png parent_icon', 'd.name parent_name', 'COUNT(a.parent_enc_id) cnt'])
                ->joinWith(['learningVideos b'])
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['parentEnc d'], false)
                ->where(['a.assigned_to' => 'Videos'])
                ->andWhere(['a.status' => 'Approved'])
                ->andWhere(['!=', 'a.parent_enc_id', 'NULL'])
                ->andWhere(['a.is_deleted' => 0])
                ->andWhere(['b.status' => 1])
                ->andWhere(['b.is_deleted' => 0])
                ->groupBy(['b.assigned_category_enc_id'])
                ->groupBy(['a.parent_enc_id'])
                ->limit(15)
                ->asArray()
                ->all();
            if ($related_videos || $top_videos || $top_category || $interested_videos) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'related_videos' => $related_videos,
                    'top_videos' => $top_videos,
                    'top_category' => $top_category,
                    'interested_videos' => $interested_videos,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return ($response);
        }
        if (!empty($video_detail)) {
            $video_detail['duration'] = $this->toMinutes($video_detail['duration']);
            $likeStatus = LearningVideoLikes::find()
                ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->one();
            $likeCount = LearningVideoLikes::find()
                ->where(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['status' => 1])
                ->count();
            $dislikeCount = LearningVideoLikes::find()
                ->where(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->andWhere(['status' => 2])
                ->count();
            $commentCount = LearningVideoComments::find()
                ->where(['video_enc_id' => $video_detail['video_enc_id']])
                ->andWhere(['is_deleted' => 0])
                ->count();
            return $this->render('video-detail', [
                'video_detail' => $video_detail,
                'like_status' => $likeStatus,
                'like_count' => $likeCount,
                'dislike_count' => $dislikeCount,
                'comment_count' => $commentCount,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionVideoLiked()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            $status = Yii::$app->request->post('status');
            $q = Yii::$app->request->post('param');

            $learning_video = LearningVideos::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $current_user = Yii::$app->user->identity->user_enc_id;

            $hasLiked = LearningVideoLikes::find()
                ->where(['user_enc_id' => $current_user])
                ->andWhere(['video_enc_id' => $learning_video['video_enc_id']])
                ->exists();

            if ($hasLiked) {
                $user_row = LearningVideoLikes::find()
                    ->where(['user_enc_id' => $current_user])
                    ->andWhere(['video_enc_id' => $learning_video['video_enc_id']])
                    ->one();
                if ($type == "liked") {
                    if ($status === 'true') {
                        $user_row->status = 1;
                    } else {
                        $user_row->status = 0;
                    }
                } elseif ($type == "disliked") {
                    if ($status === 'true') {
                        $user_row->status = 2;
                    } else {
                        $user_row->status = 0;
                    }
                }
                if ($user_row->save()) {
                    return [
                        'status' => 200,
                    ];
                } else {
                    return [
                        'status' => 201,
                    ];
                }
            } else {
                $learning_video_likes = new LearningVideoLikes();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $learning_video_likes->like_enc_id = $utilitiesModel->encrypt();
                $learning_video_likes->video_enc_id = $learning_video['video_enc_id'];
                $learning_video_likes->user_enc_id = $current_user;
                if ($type == "liked") {
                    if ($status === 'true') {
                        $learning_video_likes->status = 1;
                    } else {
                        $learning_video_likes->status = 0;
                    }
                } elseif ($type == "disliked") {
                    if ($status === 'true') {
                        $learning_video_likes->status = 2;
                    } else {
                        $learning_video_likes->status = 0;
                    }
                }
                $learning_video_likes->created_on = date('Y-m-d H:i:s');
                if ($learning_video_likes->save()) {
                    return [
                        'status' => 200,
                    ];
                } else {
                    return [
                        'status' => 201,
                    ];
                }
            }
        }
    }

    public function actionBatchVideos()
    {
        $this->layout = 'main-secondary';
        return $this->render('batch-videos');
    }

    public function actionIncrementViews()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $q = Yii::$app->request->post('param');

            $learning_video = LearningVideos::find()
                ->where(['slug' => $q])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            $video = LearningVideos::find()
                ->where(['video_enc_id' => $learning_video['video_enc_id']])
                ->andWhere(['status' => 1])
                ->andWhere(['is_deleted' => 0])
                ->one();

            if (!$video->view_count) {
                $video->view_count = 1;
            } else {
                $video->view_count += 1;
            }
            if ($video->save()) {
                return [
                    'status' => 200,
                    'result' => 'success'
                ];
            } else {
                return [
                    'status' => 201,
                    'result' => 'failed'
                ];
            }
        }
    }

    public function actionSaveVideoData()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            foreach ($data['data'] as $d) {
                if (!$this->saveData($d)) {
                    return false;
                }
            }
            return $response = [
                'status' => 200,
                'message' => 'saved successfully'
            ];
        }

    }

    private function saveData($data)
    {
        $submittedVideosModel = new SubmittedVideos();
        $utilitiesModel = new Utilities();
        $submittedVideosModel->channel_id = $data['channel_id'];
        $submittedVideosModel->channel_name = $data['channel_name'];
        $submittedVideosModel->name = $data['title'];
        $submittedVideosModel->link = $data['link'];
        $submittedVideosModel->cover_image = $data['cover_image'];
        $submittedVideosModel->description = $data['description'];
        $submittedVideosModel->video_duration = $this->video_length($data['duration']);
        if (!empty($data['tags'])) {
            $submittedVideosModel->tags = implode(',', $data['tags']);
        }
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $submittedVideosModel->video_enc_id = $utilitiesModel->encrypt();
        $submittedVideosModel->type = 'Others';
        $submittedVideosModel->category = 'others';
        $submittedVideosModel->sub_category = 'others';
        $submittedVideosModel->created_by = Yii::$app->user->identity->user_enc_id;
        $submittedVideosModel->created_on = date('Y-m-d H:i:s');
        $utilitiesModel->variables['name'] = $data['title'];
        $utilitiesModel->variables['table_name'] = SubmittedVideos::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $submittedVideosModel->slug = $utilitiesModel->create_slug();
        if ($submittedVideosModel->save()) {
            return true;
        } else {
            return false;
        }
    }

    private function video_length($youtube_time)
    {
        $duration = new \DateInterval($youtube_time);
        return $duration->h . ':' . $duration->i . ':' . $duration->s;
    }

}