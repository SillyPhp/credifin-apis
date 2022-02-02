<?php
use yii\helpers\ArrayHelper;
if (!empty($placement_locations)) {
    $location = ArrayHelper::map($placement_locations, 'city_enc_id', 'name');
    $total_vac = 0;
    $str = "";
    $locations = [];
    foreach ($placement_locations as $placements) {
        $total_vac += $placements['positions'];
        array_push($locations, $placements['name']);
    }
    $str = implode(", ", array_unique($locations));
}
?>
<div class="job-overview">
    <h3>Internship Overview</h3>
    <?php
    switch ($placement_offer) {
        case 1:
            $offer = 'Yes';
            break;
        case 0:
            $offer = 'No';
            break;
        default:
            $offer = 'No';
            break;
    }
    ?>
    <ul>
        <li><i class="fas fa-puzzle-piece"></i>
            <div class="for-flex">
                <h3>Profile</h3><span><?= $profile_name; ?></span>
            </div>
        </li>
        <li><i class="fas fa-puzzle-piece"></i>
            <div class="for-flex">
            <h3>Stipend Type</h3><span><?= $wage_type; ?></span>
            </div>
        </li>
        <li><i class="far fa-money-bill-alt"></i>
            <div class="for-flex">
                <h3>Stipend Amount</h3><span><?= (($ammount_value)? $ammount_value : 'N/A') ?></span>
            </div>
        </li>
        <li><i class="fas fa-gift"></i>
            <div class="for-flex">
                <h3>Preplacement Offer</h3><span><?= $offer; ?></span>
            </div>
        </li>
        <?php setlocale(LC_MONETARY, 'en_IN'); ?>
        <li><i class="fas fa-mars-double"></i>
            <div class="for-flex">
                <h3>Gender</h3><span><?php
                switch ($gender) {
                    case 0:
                        echo 'No Preference';
                        break;
                    case 1:
                        echo 'Male';
                        break;
                    case 2:
                        echo 'Female';
                        break;
                    case 3:
                        echo 'Transgender';
                        break;
                    default:
                        echo 'not found';
                }
                ?></span>
            </div>
        </li>
        <li><i class="fas fa-chart-line"></i>
            <div class="for-flex">
                <h3>Total Vacancies</h3><span><?= (($total_vac) ? $total_vac : 'Not Applicable'); ?></span>
            </div>
        </li>
        <li><i class="fas fa-map-marker-alt"></i>
            <div class="for-flex">
                <h3>Locations</h3><span> <?= (($str) ? rtrim($str, ',') : 'Work From Home'); ?></span>
            </div>
        </li>
    </ul>
</div>