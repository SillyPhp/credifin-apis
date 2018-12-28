<?php

use yii\helpers\Url;

$total_processes = count($processes);
$rows = ceil($total_processes / $per_row);
$next = 0;
for ($i = 1; $i <= $rows; $i++) {
    ?>
    <div class="cat-sec">
        <div class="row no-gape">
            <?php
            for ($j = 0; $j < $per_row; $j++) {
                if ($next < $total_processes) {
                    ?>
                    <div class="<?= $col_width; ?>">
                        <div class="p-category">
                            <div class="rt-bttns">
                                <button class="clone-bttn" type="button">
                                    <i class="fa fa-clone"></i>
                                </button>
                                <button class="edit-bttn" type="button">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                            </div>
                            <div class="lt-bttn">
                                <button type="button" class="e-bttn">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                            <a href="<?= Url::to('/interview-process/view/' . $processes[$next]['id']); ?>">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/execution.png'); ?>">
                                <span><?= $processes[$next]['process_name']; ?></span>
                            </a>
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