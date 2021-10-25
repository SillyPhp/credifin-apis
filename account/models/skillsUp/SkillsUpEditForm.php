<?php

namespace account\models\skillsUp;

use common\models\AssignedTags;
use common\models\Authors;
use common\models\Categories;
use common\models\Courses;
use common\models\ExternalNewsUpdate;
use common\models\LearningVideos;
use common\models\LearningVideoTags;
use common\models\PostCategories;
use common\models\Posts;
use common\models\PostTypes;
use common\models\Skills;
use common\models\SkillsUpAuthors;
use common\models\SkillsUpEmbedPosts;
use common\models\SkillsUpPostAssignedBlogs;
use common\models\SkillsUpPostAssignedCourses;
use common\models\SkillsUpPostAssignedEmbeds;
use common\models\SkillsUpPostAssignedIndustries;
use common\models\SkillsUpPostAssignedNews;
use common\models\SkillsUpPostAssignedSkills;
use common\models\SkillsUpPostAssignedVideo;
use common\models\SkillsUpPosts;
use common\models\SkillsUpSources;
use common\models\spaces\Spaces;
use common\models\Tags;
use common\models\YoutubeChannels;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;

class SkillsUpEditForm extends Model
{
    public $post_enc_id;
    public $assigned_skills;
    public $assigned_industries;
    public $source_url;
    public $content_type;
    public $image;
    public $title;
    public $source;
    public $source_id;
    public $embed_code;
    public $author;
    public $short_description;
    public $skills;
    public $industry;
    public $description;
    public $image_url;
    public $user_id;
    public $channel_name;
    public $channel_id;
    public $video_id;
    public $news_id;
    public $video_tags;
    public $video_duration;
    public $author_id;
    public $blog_tags;
    public $video_enc_id;

    public function rules()
    {
        return [
            [['title', 'description', 'source_id', 'skills', 'industry'], 'required'],
            [['skills', 'description', 'title', 'embed_code', 'channel_name', 'channel_id', 'video_id', 'video_tags', 'video_duration', 'blog_tags', 'author', 'industry', 'image', 'image_url', 'short_description', 'content_type'], 'trim'],
//            [['source_url'], 'url', 'defaultScheme' => 'http'],
            [['image', 'source_url'], 'safe'],
//            ['source_url', 'unique', 'targetClass' => SkillsUpPosts::className(), 'targetAttribute' => ['source_url' => 'post_source_url'], 'message' => 'This link has already been used.'],
            [['image'], 'file', 'extensions' => 'jpg, png, svg', 'skipOnEmpty' => true, 'maxFiles' => 1, 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function update()
    {
//        $this->image = UploadedFile::getInstanceByName('image');
//        if (!$this->validate()) {
//            return [
//                'status' => 201,
//                'title' => 'Validation Error',
//            ];
//        }
        if (empty($this->skills) && empty($this->industry)) {
            return [
                'status' => 201,
                'title' => 'Required',
                'message' => 'Please add at least one skill or industry'
            ];
        }

        $this->user_id = Yii::$app->user->identity->user_enc_id;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new Utilities();
            $model = SkillsUpPosts::findOne(['post_enc_id' => $this->post_enc_id]);
                $model->last_updated_by = $this->user_id;
                $model->last_updated_on = date('Y-m-d H:i:s');
            if ($this->title) {
                $title = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
                $model->post_title = $title;
            }
            $model->post_image_url = $this->image_url;
            $model->source_enc_id = $this->source_id;
            if ($this->description) {
                $this->description = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->description);
                $model->post_description = $this->description;
            }
            if ($this->short_description) {
                $short_desc = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->short_description);
                $model->post_short_summery = $short_desc;
            }
            $model->content_type = $this->content_type;

            if ($this->image) {
                // saving post image
                $model->cover_image_location = \Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->skill_up->cover_image . $model->cover_image_location . '/';
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->cover_image = $utilitiesModel->encrypt() . '.' . $this->image->extension;
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFile($this->image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $model->cover_image, "public");
                $this->image_url = $result['ObjectURL'];
                if (!$result) {
                    throw new \Exception($result);
                }

            }
            if (!$model->validate() || !$model->save()) {
                $transaction->rollBack();
                return [
                    'status' => 201,
                    'title' => 'model Error',
                ];
            }
            $this->source = SkillsUpSources::findOne(['source_enc_id' => $this->source_id])->name;
            switch ($this->content_type) {
                case 'News':
                    $assignedNewsModel = SkillsUpPostAssignedNews::findOne(['post_enc_id' => $this->post_enc_id]);
                    $externalNewsModel = ExternalNewsUpdate::findOne(['news_enc_id' => $assignedNewsModel->news_enc_id]);
                    $externalNewsModel->last_updated_by = $this->user_id;
                    $externalNewsModel->last_updated_on = date('Y-m-d H:i:s');
                    $externalNewsModel->title = $this->title;
                    $externalNewsModel->link = $this->source_url;
                    $externalNewsModel->source = $this->source;
                    $externalNewsModel->description = $this->description;
                    $externalNewsModel->image = $model->cover_image;
                    $externalNewsModel->image_location = $model->cover_image_location;
                    if (!$externalNewsModel->validate() || !$externalNewsModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'externalNewsModel Error',
                        ];
                    } else {
                        $this->news_id = $externalNewsModel->news_enc_id;
                    }

                    $assignedNewsModel->last_updated_by = $this->user_id;
                    $assignedNewsModel->last_updated_on = date('Y-m-d H:i:s');
                    $assignedNewsModel->news_enc_id = $this->news_id;
                    $assignedNewsModel->post_enc_id = $this->post_enc_id;
                    if (!$assignedNewsModel->validate() || !$assignedNewsModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'assignedNewsModel Error',
                        ];
                    }
                    break;
                case 'Video':
                    $postAssignedVideoModel = SkillsUpPostAssignedVideo::findOne(['post_enc_id' => $this->post_enc_id]);
                    $videosModel = LearningVideos::findOne(['video_enc_id' => $postAssignedVideoModel->video_enc_id]);
                    $videosModel->last_updated_by = $this->user_id;
                    $videosModel->last_updated_on = date('Y-m-d H:i:s');
                    $this->video_id = $videosModel->video_enc_id;
                    $videosModel->title = $this->title;
                    $videosModel->description = $this->description;
                    if (!$videosModel->validate() || !$videosModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'videosModel Error',
                        ];
                    }

                    $postAssignedVideoModel->last_updated_by = $this->user_id;
                    $postAssignedVideoModel->last_updated_on = date('Y-m-d H:i:s');
                    $postAssignedVideoModel->video_enc_id = $this->video_id;
                    $postAssignedVideoModel->post_enc_id = $this->post_enc_id;
                    if (!$postAssignedVideoModel->validate() || !$postAssignedVideoModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'postAssignedVideoModel Error',
                        ];
                    }
                    break;
                case  'Podcast':
                case 'Audio':
                case 'Case Study':
                case 'Research Paper':
                case 'Vlog/Webinar':
                    break;
                case  'Blog':
                case 'Article':
                    $assignedBlogModel = SkillsUpPostAssignedBlogs::findOne(['post_enc_id' => $this->post_enc_id]);
                    $postModel = Posts::findOne(['post_enc_id' => $assignedBlogModel->blog_post_enc_id]);
                    $postModel->last_updated_by = $this->user_id;
                    $postModel->last_updated_on = date('Y-m-d H:i:s');
                    $postModel->title = $this->title;
                    $postModel->description = $this->description;
                    $postType = PostTypes::findOne(['post_type' => 'Post']);
                    $postModel->post_type_enc_id = $postType->post_type_enc_id;
                    // Save Featured Image
                    $postModel->featured_image_location = $model->cover_image_location;
                    $postModel->featured_image = $model->cover_image;
                    $postModel->featured_image_title = $postModel->featured_image_alt = $this->image->baseName;
                    if (!$postModel->validate() || !$postModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'postModel Table Error',
                        ];
                    }
                    break;
                case 'Course':
                    $skillsupCourse = SkillsUpPostAssignedCourses::findOne(['post_enc_id' => $this->post_enc_id]);
                    $courses = Courses::findOne(['course_enc_id' => $skillsupCourse->course_enc_id]);
                    $courses->source_enc_id = $this->source_id;
                    $courses->title = $this->title;
                    $courses->image = $this->image_url;
                    $courses->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    $courses->last_updated_on = date('Y-m-d H:i:s');
                    if (!$courses->validate() || !$courses->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'postModel Table Error',
                        ];
                    }
                    break;
                default:
                    return [
                        'status' => 201,
                        'title' => 'Content Type Error',
                        'message' => 'Content type not validate'
                    ];
            }

            if ($this->author) {
                $web_link = null;
                $authorModel = Authors::findOne(['name' => $this->author]);
                if (!$authorModel) {
                    $authorModel = new Authors();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $authorModel->author_enc_id = $utilitiesModel->encrypt();
                    $authorModel->name = $this->author;
                    $authorModel->website = $web_link;
                    $authorModel->created_by = $this->user_id;
                    $authorModel->created_on = date('Y-m-d H:i:s');
                    if (!$authorModel->validate() || !$authorModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'authorModel Error',
                        ];
                    }
                }
                $this->author_id = $authorModel->author_enc_id;
                if ($this->author_id) {
                    $skillsUpAuthorsModel = SkillsUpAuthors::findOne(['post_enc_id' => $this->post_enc_id]);
                    $skillsUpAuthorsModel->author_enc_id = $this->author_id;
                    $skillsUpAuthorsModel->last_updated_by = $this->user_id;
                    $skillsUpAuthorsModel->last_updated_on = date('Y-m-d H:i:s');
                    if (!$skillsUpAuthorsModel->validate() || !$skillsUpAuthorsModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'skillsUpAuthorsModel Error',
                        ];
                    }
                }
            }
            if ($this->embed_code) {
                $embedAssignedModel = SkillsUpPostAssignedEmbeds::findOne(['post_enc_id' => $this->post_enc_id]);
                $embedModel = SkillsUpEmbedPosts::findOne(['embed_enc_id' => $embedAssignedModel->embed_enc_id]);
                if (!$embedModel) {
                    $embedModel = new SkillsUpEmbedPosts();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $embedModel->embed_enc_id = $utilitiesModel->encrypt();
                    $embedModel->created_by = $this->user_id;
                    $embedModel->created_on = date('Y-m-d H:i:s');
                } else {
                    $embedModel->last_updated_by = $this->user_id;
                    $embedModel->last_updated_on = date('Y-m-d H:i:s');
                }
                $embedModel->body = $this->embed_code;
                if (!$embedModel->validate() || !$embedModel->save()) {
                    $transaction->rollBack();
                    return [
                        'status' => 201,
                        'title' => 'embedModel Error',
                    ];
                }
                if (!$embedAssignedModel) {
                    $embedAssignedModel = new SkillsUpPostAssignedEmbeds();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $embedAssignedModel->assigned_enc_id = $utilitiesModel->encrypt();
                    $embedAssignedModel->created_by = $this->user_id;
                    $embedAssignedModel->created_on = date('Y-m-d H:i:s');
                } else {
                    $embedAssignedModel->last_updated_by = $this->user_id;
                    $embedAssignedModel->last_updated_on = date('Y-m-d H:i:s');
                }
                $embedAssignedModel->embed_enc_id = $embedModel->embed_enc_id;
                $embedAssignedModel->post_enc_id = $this->post_enc_id;
                if (!$embedAssignedModel->validate() || !$embedAssignedModel->save()) {
                    $transaction->rollBack();
                    return [
                        'status' => 201,
                        'title' => 'embedAssignedModel Error',
                    ];
                }
            }

            if (empty($this->industry)) {
                $this->industry = [];
            }
            $del_industries = array_diff(array_unique($this->assigned_industries), array_unique($this->industry));
            if (!empty($del_industries)) {
                foreach ($del_industries as $industry_id) {
                    $deleteIndustryModel = SkillsUpPostAssignedIndustries::findOne(['industry_enc_id' => $industry_id, 'post_enc_id' => $this->post_enc_id, 'is_deleted' => 0]);
                    $deleteIndustryModel->is_deleted = 1;
                    if (!$deleteIndustryModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'deleteIndustryModel Error',
                        ];
                    }
                }
            }
            if (!empty($this->industry)) {
                foreach (array_unique($this->industry) as $industry_id) {
                    $postAssignedIndustriesModel = SkillsUpPostAssignedIndustries::findOne(['industry_enc_id' => $industry_id, 'post_enc_id' => $this->post_enc_id]);
                    if (!$postAssignedIndustriesModel) {
                        $postAssignedIndustriesModel = new SkillsUpPostAssignedIndustries();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $postAssignedIndustriesModel->assigned_industry_enc_id = $utilitiesModel->encrypt();
                        $postAssignedIndustriesModel->created_by = $this->user_id;
                        $postAssignedIndustriesModel->created_on = date('Y-m-d H:i:s');
                    } else {
                        $postAssignedIndustriesModel->is_deleted = 0;
                        $postAssignedIndustriesModel->last_updated_by = $this->user_id;
                        $postAssignedIndustriesModel->last_updated_on = date('Y-m-d H:i:s');
                    }
                    $postAssignedIndustriesModel->industry_enc_id = $industry_id;
                    $postAssignedIndustriesModel->post_enc_id = $this->post_enc_id;
                    if (!$postAssignedIndustriesModel->validate() || !$postAssignedIndustriesModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'postAssignedIndustriesModel Error',
                        ];
                    }
                }
            }
            $del_skills = array_diff(array_unique($this->assigned_skills), array_unique($this->skills));
            if (!empty($del_skills)) {
                foreach ($del_skills as $skill_name) {
                    $skill_id = Skills::findOne(['skill' => $skill_name])->skill_enc_id;
                    $deleteSkillsModel = SkillsUpPostAssignedSkills::findOne(['skill_enc_id' => $skill_id, 'post_enc_id' => $this->post_enc_id, 'is_deleted' => 0]);
                    $deleteSkillsModel->is_deleted = 1;
                    if (!$deleteSkillsModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'deleteSkillsModel Error',
                        ];
                    }
                }
            }
            if (!empty($this->skills)) {
                foreach (array_unique($this->skills) as $skill_name) {
                    $skillModel = Skills::findOne(['skill' => $skill_name]);
                    if (!$skillModel) {
                        $skillModel = new Skills();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $skillModel->skill_enc_id = $utilitiesModel->encrypt();
                        $skillModel->skill = $skill_name;
                        $skillModel->status = 'Publish';
                        $skillModel->created_by = $this->user_id;
                        $skillModel->created_on = date('Y-m-d H:i:s');
                    } else {
                        $skillModel->last_updated_by = $this->user_id;
                        $skillModel->last_updated_on = date('Y-m-d H:i:s');
                    }
                    if (!$skillModel->validate() || !$skillModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'skillModel Error',
                        ];
                    }
                    $assignSkillsModel = SkillsUpPostAssignedSkills::findOne(['skill_enc_id' => $skillModel->skill_enc_id, 'post_enc_id' => $this->post_enc_id]);
                    if (!$assignSkillsModel) {
                        $assignSkillsModel = new SkillsUpPostAssignedSkills();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $assignSkillsModel->assigned_skill_enc_id = $utilitiesModel->encrypt();
                        $assignSkillsModel->created_by = $this->user_id;
                        $assignSkillsModel->created_on = date('Y-m-d H:i:s');
                    } else {
                        $assignSkillsModel->is_deleted = 0;
                        $assignSkillsModel->last_updated_by = $this->user_id;
                        $assignSkillsModel->last_updated_on = date('Y-m-d H:i:s');
                    }
                    $assignSkillsModel->skill_enc_id = $skillModel->skill_enc_id;
                    $assignSkillsModel->post_enc_id = $this->post_enc_id;
                    if (!$assignSkillsModel->validate() || !$assignSkillsModel->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'assignSkillsModel Error',
                        ];
                    }
                }
            }
            $transaction->commit();
            return [
                'status' => 200,
                'title' => 'success',
                'message' => 'Data Added successfully..'
            ];
        } catch (Exception $e) {
            $transaction->rollBack();
            return [
                'status' => 201,
                'title' => 'DB Exception',
                'message' => $e->getMessage()
            ];
        }
    }
}