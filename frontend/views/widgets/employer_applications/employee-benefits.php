<?php
use yii\helpers\Url;
if(!empty($benefits)) {
    ?>
    <h3>Employer Benefits</h3>
    <?php
    $rows = ceil(count($benefits) / 3);
    $next = 0;
    for ($i = 0; $i < $rows; $i++) {
        ?>
        <div class="cat-sec">
            <div class="row no-gape">
                <?php
                for ($j = 0; $j < 3; $j++) {
                    if (!empty($benefits[$next]['benefit'])) {
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="p-category">
                                <div class="p-category-view">
                                    <?php
                                    if (!empty($benefits[$next]['icon'])) {
                                        $benefit_icon = Url::to(Yii::$app->params->upload_directories->benefits->icon . $benefits[$next]['icon_location'] . DIRECTORY_SEPARATOR . $benefits[$next]['icon']);
                                    } else {
                                        $benefit_icon = Url::to('@commonAssets/employee-benefits/plus-icon.svg');
                                    }
                                    ?>
                                    <img src="<?= Url::to($benefit_icon); ?>"/>
                                    <span><?= $benefits[$next]['benefit'] ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    $next++;
                }
                ?>
            </div>
        </div>
        <?php
    }
}
?>