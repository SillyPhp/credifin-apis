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

class SkillsUpForm extends Model
{
    public $source_url;
    public $content_type;
    public $image;
    public $title;
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
    public $video_tags;
    public $video_duration;
    public $blog_tags;
    public $video_enc_id;

    public function rules()
    {
        return [
            [['title', 'description', 'source_url', 'source_id', 'skills', 'industry'], 'required'],
            [['skills', 'description', 'title', 'embed_code', 'channel_name', 'channel_id', 'video_id', 'video_tags', 'video_duration', 'blog_tags', 'author', 'industry', 'image', 'image_url', 'short_description', 'content_type'], 'trim'],
            [['source_url'], 'url', 'defaultScheme' => 'http'],
            [['image'], 'safe'],
            ['source_url', 'unique', 'targetClass' => SkillsUpPosts::className(), 'targetAttribute' => ['source_url' => 'post_source_url'], 'message' => 'This link has already been used.'],
            [['image'], 'file', 'extensions' => 'jpg, png, svg', 'skipOnEmpty' => true, 'maxFiles' => 1, 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function save()
    {
        $this->user_id = Yii::$app->user->identity->user_enc_id;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->image = UploadedFile::getInstanceByName('image');
            // saving data into posts table
            $utilitiesModel = new Utilities();
            $model = new SkillsUpPosts();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->post_enc_id = $utilitiesModel->encrypt();
            $model->post_title = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
            $model->post_source_url = $this->source_url;
            $model->post_image_url = $this->image_url;
            $model->source_enc_id = $this->source_id;
            $model->post_description = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->description);
            $model->post_short_summery = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->short_description);
            $utilitiesModel->variables['name'] = $model->post_title;
            $utilitiesModel->variables['table_name'] = ExternalNewsUpdate::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug() . '-' . rand(100000, 999999);
            $model->content_type = $this->content_type;
            if ($this->image) {
                // saving post image
                $model->cover_image_location = \Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->skill_up->cover_image . $model->cover_image_location . '/';
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->cover_image = $utilitiesModel->encrypt() . '.' . $this->image->extension;
                $type = $this->image->type;
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($this->image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $model->cover_image, "public",['params' => ['ContentType' => $type]]);
                $this->image_url = $result['ObjectURL'];
                if (!$result) {
                    throw new \Exception($result);
                }

            }
            $model->created_by = $this->user_id;
            $model->created_on = date('Y-m-d H:i:s');
            if (!$model->validate() || !$model->save()) {
                $transaction->rollBack();
                throw new \Exception(array_values($model->firstErrors));
            }

            $source = SkillsUpSources::findOne(['source_enc_id' => $this->source_id])->name;

            // saving data according to content type
            switch ($this->content_type) {
                case 'News':
                    // saving data for news
                    $externalNewsModel = new ExternalNewsUpdate();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $externalNewsModel->news_enc_id = $utilitiesModel->encrypt();
                    $externalNewsModel->title = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
                    $externalNewsModel->link = $this->source_url;
                    $externalNewsModel->source = $source;
                    $externalNewsModel->description = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->description);
                    $utilitiesModel->variables['name'] = $externalNewsModel->title;
                    $utilitiesModel->variables['table_name'] = ExternalNewsUpdate::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $externalNewsModel->slug = $utilitiesModel->create_slug();
                    $externalNewsModel->image = $model->cover_image;
                    $externalNewsModel->image_location = $model->cover_image_location;
                    $externalNewsModel->status = 1;
                    $externalNewsModel->is_visible = 0;
                    $externalNewsModel->created_by = $this->user_id;
                    $externalNewsModel->created_on = date('Y-m-d H:i:s');
                    if (!$externalNewsModel->validate() || !$externalNewsModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($externalNewsModel->firstErrors)[0]);
                    }

                    // saving skills of assigned news
                    $assignedNewsModel = new SkillsUpPostAssignedNews();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $assignedNewsModel->assigned_enc_id = $utilitiesModel->encrypt();
                    $assignedNewsModel->news_enc_id = $externalNewsModel->news_enc_id;
                    $assignedNewsModel->post_enc_id = $model->post_enc_id;
                    $assignedNewsModel->created_by = $this->user_id;
                    $assignedNewsModel->created_on = date('Y-m-d H:i:s');
                    if (!$assignedNewsModel->validate() || !$assignedNewsModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($assignedNewsModel->firstErrors)[0]);
                    }
                    break;
                case 'Video' :
                    $videosModel = LearningVideos::findOne(['youtube_video_id' => $this->video_id]);
                    if (!$videosModel) {
                        // saving learning videos
                        $videosModel = new LearningVideos();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $videosModel->video_enc_id = $utilitiesModel->encrypt();

                        // check channel if not exists then save
                        if ($this->channel_id) {
                            $channel_enc_id = YoutubeChannels::findOne(['channel_id' => $this->channel_id])->channel_enc_id;
                            if (!$channel_enc_id) {
                                if ($id = $this->saveYoutubeChannel($this, $transaction)) {
                                    $channel_enc_id = $id;
                                } else {
                                    return false;
                                }

                            }
                        }

                        $videosModel->channel_enc_id = $channel_enc_id;
                        $videosModel->title = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
                        $videosModel->cover_image = $this->image_url;
                        $videosModel->description = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->description);
                        $utilitiesModel->variables['name'] = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
                        $utilitiesModel->variables['table_name'] = LearningVideos::tableName();
                        $utilitiesModel->variables['field_name'] = 'slug';
                        $videosModel->slug = $utilitiesModel->create_slug();
                        $videosModel->duration = $this->video_length($this->video_duration);
                        $videosModel->youtube_video_id = $this->video_id;
                        $videosModel->status = 1;
                        $videosModel->is_visible = 0;
                        $videosModel->created_by = $this->user_id;
                        $videosModel->created_on = date('Y-m-d H:i:s');
                        if (!$videosModel->save()) {
                            $transaction->rollBack();
                            throw new \Exception(array_values($videosModel->firstErrors)[0]);
                        }

                        $this->video_enc_id = $videosModel->video_enc_id;

                        // save video tags
                        if ($this->video_tags) {
                            // saving tags
                            if (!$this->saveVideoTags($this->video_tags, $transaction)) {
                                return false;
                            }
                        }
                    }

                    // saving assigned video skills
                    $postAssignedVideoModel = new SkillsUpPostAssignedVideo();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $postAssignedVideoModel->assigned_enc_id = $utilitiesModel->encrypt();
                    $postAssignedVideoModel->video_enc_id = $videosModel->video_enc_id;
                    $postAssignedVideoModel->post_enc_id = $model->post_enc_id;
                    $postAssignedVideoModel->created_by = $this->user_id;
                    $postAssignedVideoModel->created_on = date('Y-m-d H:i:s');
                    if (!$postAssignedVideoModel->validate() || !$postAssignedVideoModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($postAssignedVideoModel->firstErrors)[0]);
                    }
                    break;
                case  'Podcast':
                    break;
                case  'Blog' :
                case 'Article':
                    $blogType = Categories::find()
                        ->alias('a')
                        ->select(['a.category_enc_id', 'a.name'])
                        ->joinWith(['assignedCategories b' => function ($b) {
                            $b->andWhere(['b.assigned_to' => 'Posts']);
                            $b->andWhere(['b.parent_enc_id' => null]);
                        }], false)
                        ->andWhere(['a.name' => 'Articles'])
                        ->asArray()
                        ->one();

//                    $blog_skills = Skills::find()
//                        ->select(['skill'])
//                        ->where(['skill_enc_id' => $this->skills])
//                        ->asArray()
//                        ->all();
//
//                    $skills = [];
//                    foreach ($blog_skills as $skill) {
//                        array_push($skills, $skill['skill']);
//                    }


                    $postModel = new Posts();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $postModel->post_enc_id = $utilitiesModel->encrypt();
                    $postModel->title = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
                    $utilitiesModel->variables['name'] = $postModel->title;
                    $utilitiesModel->variables['table_name'] = Posts::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $postModel->slug = $utilitiesModel->create_slug();
                    $postModel->description = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->description);
                    $meta_arr = array_unique($this->skills);
                    $meta = implode(", ", $meta_arr);
                    $meta_str = ucwords($meta);
                    $postType = PostTypes::findOne(['post_type' => 'Post']);
                    $postModel->post_type_enc_id = $postType->post_type_enc_id;
                    $postModel->meta_keywords = $meta_str;
                    // Save Featured Image
                    $postModel->featured_image_location = $model->cover_image_location;
                    $postModel->featured_image = $model->cover_image;
                    $postModel->featured_image_title = $postModel->featured_image_alt = $this->image->baseName;
                    $postModel->status = 'Active';
                    $postModel->is_visible = 0;
                    $postModel->created_by = $this->user_id;

                    if (!$postModel->validate() || !$postModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($postModel->firstErrors)[0]);
                    }

                    // save post categories
                    $postCategoriesModel = new PostCategories();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $postCategoriesModel->post_category_enc_id = $utilitiesModel->encrypt();
                    $postCategoriesModel->post_enc_id = $postModel->post_enc_id;
                    $postCategoriesModel->category_enc_id = $blogType['category_enc_id'];
                    $postCategoriesModel->created_by = $this->user_id;
                    $postCategoriesModel->created_on = date('Y-m-d H:i:s');
                    if (!$postCategoriesModel->validate() || !$postCategoriesModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($postCategoriesModel->firstErrors)[0]);
                    }

                    // post assigned blog
                    $assignedBlogModel = new SkillsUpPostAssignedBlogs();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $assignedBlogModel->assigned_enc_id = $utilitiesModel->encrypt();
                    $assignedBlogModel->blog_post_enc_id = $postModel->post_enc_id;
                    $assignedBlogModel->post_enc_id = $model->post_enc_id;
                    $assignedBlogModel->created_by = $this->user_id;
                    $assignedBlogModel->created_on = date('Y-m-d H:i:s');
                    if (!$assignedBlogModel->validate() || !$assignedBlogModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($assignedBlogModel->firstErrors)[0]);
                    }
                    break;
                case 'Course':
                    $courses = new Courses();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $courses->course_enc_id = $utilitiesModel->encrypt();
                    $courses->source_enc_id = $this->source_id;
                    $courses->title = preg_replace('/[^ -\x{2122}]\s+|\s*[^ -\x{2122}]/u', '', $this->title);
                    $courses->url = $this->source_url;
                    $courses->image = $this->image_url;
                    $courses->is_paid = 0;
                    $courses->price = 0.00;
                    $courses->last_updated_by = $this->user_id;
                    $courses->last_updated_on = date('Y-m-d H:i:s');
                    if (!$courses->validate() || !$courses->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($courses->firstErrors)[0]);
                    }

                    $skillsUpCourse = new SkillsUpPostAssignedCourses();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsUpCourse->assigned_enc_id = $utilitiesModel->encrypt();
                    $skillsUpCourse->course_enc_id = $courses->course_enc_id;
                    $skillsUpCourse->post_enc_id = $model->post_enc_id;
                    $skillsUpCourse->created_by = $this->user_id;
                    $skillsUpCourse->created_on = date('Y-m-d H:i:s');
                    $skillsUpCourse->last_updated_on = date('Y-m-d H:i:s');
                    $skillsUpCourse->last_updated_by = $this->user_id;
                    if (!$skillsUpCourse->validate() || !$skillsUpCourse->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($skillsUpCourse->firstErrors)[0]);
                    }
                    break;
            }

            // save author
            if ($this->author) {
                $web_link = null;
                if ($this->video_id && $this->channel_id) {
                    $web_link = 'https://www.youtube.com/channel/' . $this->channel_id;
                    $authorModel = Authors::findOne(['name' => $this->author, 'website' => $web_link]);
                } else {
                    $authorModel = Authors::findOne(['name' => $this->author]);
                }
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
                        throw new \Exception(array_values($authorModel->firstErrors)[0]);
                    }
                }

                $skillsUpAuthorsModel = SkillsUpAuthors::findOne(['post_enc_id' => $model->post_enc_id, 'author_enc_id' => $authorModel->author_enc_id]);
                if (!$skillsUpAuthorsModel) {
                    $skillsUpAuthorsModel = new SkillsUpAuthors();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsUpAuthorsModel->skills_up_author_enc_id = $utilitiesModel->encrypt();
                    $skillsUpAuthorsModel->post_enc_id = $model->post_enc_id;
                    $skillsUpAuthorsModel->author_enc_id = $authorModel->author_enc_id;
                    $skillsUpAuthorsModel->created_by = $this->user_id;
                    $skillsUpAuthorsModel->created_on = date('Y-m-d H:i:s');
                    if (!$skillsUpAuthorsModel->validate() || !$skillsUpAuthorsModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($skillsUpAuthorsModel->firstErrors)[0]);
                    }
                }
            }

            // saving embed code
            if ($this->embed_code) {
                // saving embed code
                $embedModel = new SkillsUpEmbedPosts();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $embedModel->embed_enc_id = $utilitiesModel->encrypt();
                $embedModel->body = $this->embed_code;
                $embedModel->created_by = $this->user_id;
                $embedModel->created_on = date('Y-m-d H:i:s');
                if (!$embedModel->validate() || !$embedModel->save()) {
                    $transaction->rollBack();
                    throw new \Exception(array_values($embedModel->firstErrors)[0]);
                }

                // saving skills up assigned embeds
                $embedAssignedModel = new SkillsUpPostAssignedEmbeds();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $embedAssignedModel->assigned_enc_id = $utilitiesModel->encrypt();
                $embedAssignedModel->embed_enc_id = $embedModel->embed_enc_id;
                $embedAssignedModel->post_enc_id = $model->post_enc_id;
                $embedAssignedModel->created_by = $this->user_id;
                $embedAssignedModel->created_on = date('Y-m-d H:i:s');
                if (!$embedAssignedModel->validate() || !$embedAssignedModel->save()) {
                    $transaction->rollBack();
                    throw new \Exception(array_values($embedAssignedModel->firstErrors)[0]);
                }
            }

            // save feed industries
            if (!empty($this->industry)) {
                foreach ($this->industry as $inds) {
                    $postAssignedIndustriesModel = new SkillsUpPostAssignedIndustries();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $postAssignedIndustriesModel->assigned_industry_enc_id = $utilitiesModel->encrypt();
                    $postAssignedIndustriesModel->industry_enc_id = $inds;
                    $postAssignedIndustriesModel->post_enc_id = $model->post_enc_id;
                    $postAssignedIndustriesModel->created_by = $this->user_id;
                    $postAssignedIndustriesModel->created_on = date('Y-m-d H:i:s');
                    if (!$postAssignedIndustriesModel->validate() || !$postAssignedIndustriesModel->save()) {
                        $transaction->rollBack();
                        throw new \Exception(array_values($postAssignedIndustriesModel->firstErrors)[0]);
                    }
                }
            }

            // save feed skills
            if (!empty($this->skills)) {
                $skills = array_unique($this->skills);

                foreach ($skills as $skill) {

                    $this->saveSkills($skill, $model->post_enc_id, $transaction);

                }
            }

            $transaction->commit();

            return ['status' => 200];

        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => $e->getMessage()];
        }
    }

    private function saveSkills($skill_name, $post_id, $transaction)
    {
        $skill = Skills::findOne(['skill' => $skill_name]);

        if ($skill) {
            $postAssignedSkills = new SkillsUpPostAssignedSkills();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $postAssignedSkills->assigned_skill_enc_id = $utilitiesModel->encrypt();
            $postAssignedSkills->skill_enc_id = $skill->skill_enc_id;
            $postAssignedSkills->post_enc_id = $post_id;
            $postAssignedSkills->created_by = $this->user_id;
            $postAssignedSkills->created_on = date('Y-m-d H:i:s');
            if (!$postAssignedSkills->validate() || !$postAssignedSkills->save()) {
                $transaction->rollBack();
                throw new \Exception(array_values($postAssignedSkills->firstErrors)[0]);
            }
        } else {
            $skills = new Skills();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $skills->skill_enc_id = $utilitiesModel->encrypt();
            $skills->skill = $skill_name;
            $skills->created_by = $this->user_id;
            $skills->created_on = date('Y-m-d H:i:s');
            if (!$skills->validate() || !$skills->save()) {
                $transaction->rollBack();
                throw new \Exception(array_values($skills->firstErrors)[0]);
            }

            $postAssignedSkills = new SkillsUpPostAssignedSkills();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $postAssignedSkills->assigned_skill_enc_id = $utilitiesModel->encrypt();
            $postAssignedSkills->skill_enc_id = $skills->skill_enc_id;
            $postAssignedSkills->post_enc_id = $post_id;
            $postAssignedSkills->created_by = $this->user_id;
            $postAssignedSkills->created_on = date('Y-m-d H:i:s');
            if (!$postAssignedSkills->validate() || !$postAssignedSkills->save()) {
                $transaction->rollBack();
                throw new \Exception(array_values($postAssignedSkills->firstErrors)[0]);
            }

        }
    }

    private function saveYoutubeChannel($data, $transaction)
    {
        $utilitiesModel = new Utilities();
        $youtubeModel = new YoutubeChannels();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $youtubeModel->channel_enc_id = $utilitiesModel->encrypt();
        $youtubeModel->author_enc_id = $this->user_id;
        $youtubeModel->channel_title = $data->channel_name;
        $youtubeModel->channel_id = $data->channel_id;
        $youtubeModel->created_by = $this->user_id;
        if (!$youtubeModel->validate() || !$youtubeModel->save()) {
            $transaction->rollBack();
            throw new \Exception(array_values($youtubeModel->firstErrors)[0]);
        } else {
            return $youtubeModel->channel_enc_id;
        }
    }

    private function saveVideoTags($tags, $transaction)
    {
        $tags = explode(",", trim($tags));
        $tags = array_intersect_key($tags, array_unique(array_map('strtolower', $tags)));
        foreach ($tags as $tag) {

            // checking tag exists or not
            $tag_id = Tags::findOne(['name' => $tag])->tag_enc_id;

            // if tag not exists then saving
            if (!$tag_id) {

                // calling save function
                if ($id = $this->saveTag($tag, $transaction)) {
                    $tag_id = $id;
                } else {
                    $transaction->rollBack();
                    return false;
                }

                // save assigned tags
                if (!$this->saveAssignedTags($tag_id, $transaction)) {
                    return false;
                }

                // save learning video tag
                if (!$this->saveLearningVideoTags($tag_id, $transaction)) {
                    return false;
                }
            } else {

                // check assigned id
                $assign_tag_id = AssignedTags::findOne(['tag_enc_id' => $tag_id, 'assigned_to' => 2, 'is_deleted' => 0])->assigned_tag_enc_id;

                if (!$assign_tag_id) {
                    // save assigned tags
                    if (!$this->saveAssignedTags($tag_id, $transaction)) {
                        return false;
                    }
                }

                // save learning video tag
                if (!$this->saveLearningVideoTags($tag_id, $transaction)) {
                    return false;
                }
            }
        }
        return true;
    }

    private function saveTag($tag_name, $transaction)
    {
        $tag = new Tags();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $tag->tag_enc_id = $utilitiesModel->encrypt();
        $tag->name = $tag_name;
        $utilitiesModel->variables['name'] = $tag_name;
        $utilitiesModel->variables['table_name'] = Tags::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $tag->slug = $utilitiesModel->create_slug() . '-' . rand(100000, 999999);
        $tag->created_by = $this->user_id;
        $tag->created_on = date('Y-m-d H:i:s');
        if (!$tag->save()) {
            $transaction->rollBack();
            throw new \Exception(array_values($tag->firstErrors)[0]);
        }
        return $tag->tag_enc_id;
    }

    private function saveAssignedTags($tag_id, $transaction)
    {
        $assigned_tag = new AssignedTags();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assigned_tag->assigned_tag_enc_id = $utilitiesModel->encrypt();
        $assigned_tag->tag_enc_id = $tag_id;
        $assigned_tag->assigned_to = 2;
        $assigned_tag->status = 'Approved';
        $assigned_tag->created_by = $this->user_id;
        $assigned_tag->created_on = date('Y-m-d H:i:s');
        if (!$assigned_tag->save()) {
            $transaction->rollBack();
            throw new \Exception(array_values($assigned_tag->firstErrors)[0]);
        }

        return $assigned_tag->assigned_tag_enc_id;
    }

    private function saveLearningVideoTags($tag_id, $transaction)
    {
        $video_tag = new LearningVideoTags();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $video_tag->video_tag_enc_id = $utilitiesModel->encrypt();
        $video_tag->video_enc_id = $this->video_enc_id;
        $video_tag->tag_enc_id = $tag_id;
        $video_tag->created_by = $this->user_id;
        $video_tag->created_on = date('Y-m-d H:i:s');
        if (!$video_tag->save()) {
            $transaction->rollBack();
            throw new \Exception(array_values($video_tag->firstErrors)[0]);
        }

        return true;
    }

    private function video_length($youtube_time)
    {
        $duration = new \DateInterval($youtube_time);
        return $duration->h . ':' . $duration->i . ':' . $duration->s;
    }

}