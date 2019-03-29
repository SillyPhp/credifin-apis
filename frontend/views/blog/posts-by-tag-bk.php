<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

<section>
    <div class="container">
        <div class="section-content">
            <div class="row">
                <?php
                foreach ($posts as $post) {
                    $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                    $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                    if (!file_exists($image_path)) {
                        $image = '//placehold.it/330x200';
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
                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>"><p class="mt-5"><?= $post['excerpt']; ?><a class="text-theme-color-2 font-12 ml-5" href="<?= Url::to('/blog/' . $post['slug']); ?>"> Read More</a></p>
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