<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
$this->title = Yii::t('frontend', $post['title']);
?>
<section>
    <div class="container mt-30 mb-30 pt-30 pb-30">
        <div class="row">
            <div class="col-md-9 pull-right flip sm-pull-none">
                <div class="media-body">
                    <div class="event-content pull-left flip" style="margin-bottom: 30px;">
                        <h2><?= $this->title; ?></h2>
                    </div>
                </div>
                <div class="blog-posts">
                    <div class="col-md-12">
                        <div class="row list-dashed">
                            <article class="post clearfix mb-30 pb-30">
                                <div class="entry-header">
                                    <?php
                                    if (count($post_media) > 0) {
                                        if (count($post_media) == 1) {
                                            $media_path = Yii::$app->params->upload_directories->posts->media_path . $post_media['media_location'] . DIRECTORY_SEPARATOR . $post_media['media'];
                                            $media = Yii::$app->params->upload_directories->posts->media . $post_media['media_location'] . DIRECTORY_SEPARATOR . $post_media['media'];
                                            
                                                ?>
                                                <div class="post-thumb thumb"><img src="<?= Url::to($media); ?>" alt="<?= $this->title; ?>" class="img-responsive img-fullwidth"></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="post-thumb">
                                                    <div class="gallery-isotope grid-5 masonry gutter-small clearfix" data-lightbox="gallery">
                                                        <?php
                                                        foreach ($post_media as $media) {
                                                            $media_path = Yii::$app->params->upload_directories->posts->media_path . $media['media_location'] . DIRECTORY_SEPARATOR . $media['media'];
                                                            $media = Yii::$app->params->upload_directories->posts->media . $media['media_location'] . DIRECTORY_SEPARATOR . $media['media'];
                                                            if (!file_exists($media_path)) {
                                                                ?>
                                                                <div class="gallery-item">
                                                                    <a href="<?= Url::to($media); ?>" data-lightbox="gallery-item"><img src="<?= Url::to($media); ?>" alt="<?= $this->title; ?>"></a>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            $featured_image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                                            $featured_image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                                            if (!file_exists($featured_image_path)) {
                                                $featured_image = '://placehold.it/330x225';
                                            }
                                        
                                            ?>
                                            <div class="post-thumb thumb"><img src="<?= Url::to($featured_image); ?>" alt="<?= $this->title; ?>" class="img-responsive img-fullwidth"></div>
                                         
                                    </div>
                                   <?php
                                        }
                                        ?>
                                    <div class="clearfix"></div>   
                                    <div class="entry-content border-1px p-20 pr-10">
                                        <p class="mt-10"><?= $post['description']; ?></p>
                                    </div>
                                    <div class="entry-meta media no-bg no-border mt-0 mb-10">
                                        <div class="media-body pl-0">
                                            <div class="event-content pull-left flip">
                                                <h4 class="entry-title text-uppercase font-weight-600 m-0 mt-5"><?= $post['title']; ?></h4>
                                            </div>
                                        </div>
                                    </div>                                                                                                            
                                </article>
                            </div>
<!--                            <div class="comment-box">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h5><?= Yii::t('frontend', 'Leave a Comment'); ?></h5>
                                        <div class="row">
                                            <form role="form" id="comment-form">
                                                <div class="col-sm-6 pt-0 pb-0">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" required name="contact_name" id="contact_name" placeholder="Enter Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" required class="form-control" name="contact_email2" id="contact_email2" placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Enter Website" required class="form-control" name="subject">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <textarea class="form-control" required name="contact_message2" id="contact_message2"  placeholder="Enter Message" rows="7"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-dark btn-flat pull-right m-0" data-loading-text="Please wait...">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="sidebar sidebar-right mt-sm-30">
                        <div class="nav-item">
                            <h4 class="widget-title line-bottom"><?= Yii::t('frontend', 'Post Details'); ?></h4>
                            <span class="text-theme-color-1" style="font-weight:bold"><?= Yii::t('frontend', 'Posted In'); ?>:
                                <?php
                                $count = count($post_categories);
                                $i = 1;
                                foreach ($post_categories as $category) {
                                    ?>
                                    <a href="<?= Url::to('/blog/category/' . $category['slug']); ?>" style="color: #F2184F"><?= $category['name']; ?></a><?= ($i != $count) ? ', ' : ''; ?>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </span>
                            <div class="text-theme-color-1">
                                <span style="font-weight:bold"><?= Yii::t('frontend', 'Posted On'); ?>:</span>
                                <?php $date = strtotime($post['created_on']); ?>
                                <?= date('d', $date); ?>
                                <?= date('M, Y', $date); ?>
                            </div>
                        </div>
                        <div class="widget">
                            <div class="text-theme-color-1" style="font-weight:bold"><?= Yii::t('frontend', 'Tags'); ?>
                                <div class="tags">
                                    <span class="text-theme-color-2">
                                        <?php
                                        foreach ($post_tags as $tag) {
                                            ?>
                                            <a href="<?= Url::to('/blog/tag/' . $tag['slug']); ?>"><?= $tag['name']; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="widget">
                            <h4 class="widget-title line-bottom"><?= Yii::t('frontend', 'Related Posts'); ?></h4>
                            <?php
                            foreach ($similar_posts as $post) {
                                $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                                $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                                if (file_exists($image_path)) {
                                    $image = '://placehold.it/330x200';
                            }
                                    ?>
                                    <div class="widget-image-carousel">
                                        <div class="item">
                                            <img src="<?= Url::to($image); ?>" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['featured_image_title']; ?>">    
                                            <h4 class="entry-title text-white text-uppercase font-weight-600 m-0 mt-5"><a href="<?= Url::to('/blog/' . $post['slug']); ?>"><?= $post['title']; ?></a></h4>
                                            <p><?= $post['excerpt']; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="well">
                                <form action="#">
                                    <div class="input-group">
                                        <h4><?= Yii::t('frontend', 'Want To Subscribe Our GST Rozgar Program'); ?></h4>
                                        <input class="btn btn-lg" name="email" id="email" type="email" placeholder="Your Email" required>
                                        <button class="btn btn-info btn-lg" style="float: right" type="submit"><?= Yii::t('frontend', 'Submit'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <h1><?= Yii::t('frontend', 'Similar Posts'); ?></h1>
                <div class="section-content">
                    <div class="row">
                        <?php
                        foreach ($random_posts as $post) {
                            $path = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'];
                            $image = $path . DIRECTORY_SEPARATOR . $post['featured_image'];
                            if (!file_exists(Yii::$app->basePath . $image)) {
                                $image = 'http://placehold.it/330x200';
                            }
                            $date = strtotime($post['created_on']);
                            ?>
                            <div class="col-sm-6 col-md-3">
                                <article class="post clearfix mb-30 bg-lighter">
                                    <div class="entry-header">
                                        <div class="post-thumb thumb"> 
                                            <a href="<?= Url::to('/blog/' . $post['slug']); ?>"><img src="<?= $image; ?>" width="330" height="200" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['featured_image_title']; ?>" </a>
                                        </div>                    
                                        <div class="entry-date media-left text-center flip bg-theme-colored border-top-theme-color-2-3px pt-5 pr-15 pb-5 pl-15">
                                            <ul>
                                                <li class="font-16 font-weight-600"><?= date('d', $date); ?></li>
                                                <li class="font-12 text-uppercase"><?= date('M, Y', $date); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="entry-content p-15 pt-10 pb-10">
                                        <div class="entry-meta media no-bg no-border mt-0 mb-10">
                                            <div class="media-body pl-0">
                                                <div class="event-content pull-left flip">
                                                    <h4 class="entry-title text-white text-uppercase font-weight-600 m-0 mt-5"><a href="<?= Url::to('/blog/' . $post['slug']); ?>"><?= $post['title']; ?></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?= Url::to('/blog/' . $post['slug']); ?>"><p class="mt-5"><?= $post['excerpt']; ?><a class="text-theme-color-2 font-12 ml-5" href="<?= Url::to('/blog/' . $post['slug']); ?>"> <?= Yii::t('frontend', 'Read More'); ?></a></p></a>
                                    </div>
                                </article>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
        $this->registerCss("
 .widget {
        margin-bottom: 0px !important;
    }
");

        $this->registerJsFile('//platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async']);
        