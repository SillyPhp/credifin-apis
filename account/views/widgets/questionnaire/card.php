<?php

use yii\helpers\Url;
use yii\helpers\Json;

$total_questionnaire = count($questionnaire);
$rows = ceil($total_questionnaire / $per_row);
$next = 0;
for ($i = 1; $i <= $rows; $i++) {
    ?>
    <div class="cat-sec">
        <div class="row no-gape">
            <?php
            for ($j = 0; $j < $per_row; $j++) {
                if ($next < $total_questionnaire) {
                    ?>
                    <div class="<?= $col_width; ?>">
                        <div class="p-category">
                            <div class="rt-bttns">
                                <button class="clone-bttn" type="button" onclick="window.open('<?= Url::to('/account/questionnaire/clone/' . $questionnaire[$next]["id"]); ?>', '_blank');">
                                    <i class="fa fa-clone"></i>
                                </button>
                                <button class="edit-bttn" type="button" onclick="window.open('<?= Url::to('/account/questionnaire/edit/' . $questionnaire[$next]["id"]); ?>', '_blank');">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                            </div>
                            <div class="lt-bttn">
                                <button type="button" class="e-bttn delete_questionnaire" value="<?= $questionnaire[$next]['id']; ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                            <a href="<?= Url::to('/questionnaire/view/' . $questionnaire[$next]['id']); ?>">
                                <i class="fa fa-file-text"></i>
                                <span><?= $questionnaire[$next]['questionnaire_name']; ?></span>
                                <p>
                                    <?php
                                    $p = NULL;
                                    foreach (Json::decode($questionnaire[$next]['questionnaire_for']) as $for) {
                                        $p .= used_for($for) . ', ';
                                    }
                                    echo rtrim($p, ', ');
                                    ?>
                                </p>
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

function used_for($n) {
    switch ($n) {
        case 1:
            $a = 'Jobs';
            break;
        case 2:
            $a = 'Internships';
            break;
        case 3:
            $a = 'Training Programs';
            break;
        default:
            $a = 'NA';
    }
    return $a;
}
