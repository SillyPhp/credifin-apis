<h3>Interview Details</h3>
<ul style="border:0px;">
    <?php if (!empty($interview_start) && $interview_end) { ?>
        <li><i class="fa fa-calendar-check-o"></i>
            <h3>Interview Dates</h3>
            <span><?= date('d-M-y', strtotime($interview_start)); ?> To <?= date('d-M-y', strtotime($interview_end)); ?></span>
        </li>
        <li><i class="fa fa-clock-o"></i>
            <h3>Interview Time</h3>
            <span><?= date('H:i A', strtotime($interview_start)); ?> To <?= date('H:i A', strtotime($interview_end)); ?></span>
        </li>
    <?php } ?>
    <li><i class="fa fa-map-marker"></i>
        <h3>Interview Locations</h3><span> <?php
            if (!empty($interview_locations))
            {
                $str2 = "";
                $locations = [];
                foreach ($interview_locations as $loc) {
                    array_push($locations , '<a target="_blank" title="View on Google Map" href="https://www.google.com/maps/?q=' . $loc['interview_lat'] .',' . $loc['interview_long'] .'">' . $loc['name'] . '</a>');
                }
                $str2 = implode(", ", array_unique($locations));
                echo rtrim($str2, ',');
            }
            else
            {
                echo 'Online/Skype/Telephonic';
            }
            ?></span></li>
</ul>