<?php

use yii\widgets\Breadcrumbs;
?>
<section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?= $data['background']; ?>">
    <div class="container pt-70 pb-20">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title text-white"><?= $data['title']; ?></h2>
                    <?=
                    Breadcrumbs::widget([
                        'itemTemplate' => "<li>{link}</li>",
                        'activeItemTemplate' => '<li class="active text-gray-silver">{link}</li>',
                        'encodeLabels' => true,
                        'tag' => 'ol',
                        'options' => [
                            'class' => 'breadcrumb text-left text-black mt-10'
                        ],
                        'homeLink' => [
                            'label' => Yii::t('frontend', 'Home'),
                            'url' => Yii::$app->homeUrl,
                        ],
                        'links' => isset($data['links']) ? $data['links'] : [],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>