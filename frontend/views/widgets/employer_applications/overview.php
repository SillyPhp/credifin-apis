<?php
use yii\helpers\ArrayHelper;
if (!empty($placement_locations)) {
    $location = ArrayHelper::map($placement_locations, 'city_enc_id', 'name');
    $str = "";
    $locations = [];
    foreach ($placement_locations as $placements) {
        array_push($locations, $placements["name"]);
    }
    $str = implode(", ", array_unique($locations));
}
if ($type=='Job'):
$salry_duration = ' p.a.';
else:
    $salry_duration = ' p.m.';
endif;
?>
<div class="job-overview">
    <h3>Job Overview</h3>
    <ul>
        <li><i class="fas fa-puzzle-piece"></i>
            <h3>Profile</h3><span><?= $profile_name; ?></span></li>
        <li><i class="fas fa-suitcase"></i>
            <h3>Job Type</h3><span><?= ucwords($job_type); ?></span></li>
        <li><i class="far fa-money-bill-alt"></i>
            <h3>Offered <?= (($type=='Job')? 'Salary' : 'Stipend');
            if ($wage_type == 'Fixed') {
                    echo ' (Fixed)';
                } else if ($wage_type == 'Negotiable'|| $wage_type == 'Performance Based') {
                        echo ' (Negotiable)';
                }
            else if ($wage_type == 'Unpaid') {
                echo ' (Unpaid)';
            }
            ?></h3>
            <span><?= (($ammount_value)?$ammount_value : 'N/A'); ?></span></li>
        <li><i class="fas fa-mars-double"></i>
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
                        echo 'N/A';
                }
                ?></span></li>
        <?php if (!empty($experience)): ?>
        <li><i class="far fa-clock"></i>
            <h3>Experience</h3><span><?= $experience; ?></span></li>
        <?php endif; ?>
        <li><i class="fas fa-map-marker-alt"></i>
            <h3>Locations</h3>
            <span> <?= (($str) ? rtrim($str, ',') : 'Work From Home'); ?></span></li>
        <?php if (!empty($positions)): ?>
        <li><i class="fas fa-chart-line"></i>
            <h3>Total Vacancies</h3>
            <span> <?= $positions ?></span></li>
        <?php endif; ?>
    </ul>
</div>