<?php
use yii\helpers\ArrayHelper;
if (!empty($placement_locations)) {
    $location = ArrayHelper::map($placement_locations, 'city_enc_id', 'name');
    $total_vac = 0;
    $str = "";
    $locations = [];
    foreach ($placement_locations as $placements) {
        $total_vac += $placements['positions'];
        array_push($locations, '<a target="_blank" title="View on Google Map" href="http://maps.google.com/maps?q=' . $placements['latitude'] .',' . $placements['longitude'] .'&ll=' . $placements['latitude'] .',' . $placements['longitude'] .'&z=17">' . $placements['name'] . '</a>');
    }
    $str = implode(", ", array_unique($locations));
}
?>
<div class="job-overview">
    <h3>Job Overview</h3>
    <ul>
        <li><i class="fas fa-puzzle-piece"></i>
            <h3>Profile</h3><span><?= $profile_name; ?></span></li>
        <li><i class="fas fa-puzzle-piece"></i>
            <h3>Preferred Industry</h3><span><?= $industry; ?></span></li>
        <li><i class="fas fa-thumbtack"></i>
            <h3>Designation</h3><span><?= $designation; ?></span></li>
        <li><i class="fas fa-suitcase"></i>
            <h3>Job Type</h3><span><?= ucwords($job_type); ?></span></li>
        <li><i class="far fa-money-bill-alt"></i>
            <h3>Offered Salary <?php if ($wage_type == 'Fixed') {
                    echo '(Fixed)';
                } else if ($wage_type == 'Negotiable') {
                    echo '(Negotiable)';
                } ?></h3>
            <span><?= $ammount_value; ?></span></li>
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
        <li><i class="far fa-clock"></i>
            <h3>Experience</h3><span><?= $experience; ?></span></li>
        <li><i class="fas fa-chart-line"></i>
            <h3>Total Vacancies</h3>
            <span><?= (($total_vac) ? $total_vac : 'Not Applicable'); ?></span></li>
        <li><i class="fas fa-map-marker-alt"></i>
            <h3>Locations</h3>
            <span> <?= (($str) ? rtrim($str, ',') : 'Work From Home'); ?></span></li>
    </ul>
</div>