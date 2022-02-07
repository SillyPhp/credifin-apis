<h3>Interview Details</h3>
<ul style="border:0px;">
    <?php if (!empty($interview_start) && $interview_end) { ?>
        <li><i class="far fa-calendar-check"></i>
            <div class="for-flex">    
                <h3>Interview Dates</h3>
                <span><?= date('d-M-y', strtotime($interview_start)); ?> To <?= date('d-M-y', strtotime($interview_end)); ?></span>
            </div>
        </li>
        <li><i class="far fa-clock"></i>
            <div class="for-flex">
                <h3>Interview Time</h3>
                <span><?= date('H:i A', strtotime($interview_start)); ?> To <?= date('H:i A', strtotime($interview_end)); ?></span>
            </div>
        </li>
    <?php } ?>
    <li>
        <i class="fas fa-map-marker-alt"></i>
        <div class="for-flex">
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
            ?></span>
            </div>
            </li>
</ul>