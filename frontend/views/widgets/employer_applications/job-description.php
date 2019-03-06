<h3><?= $type.' '.'Description' ?></h3>
<ul>
    <?php
    foreach ($job_description as $job_desc) {
        ?>
        <li> <?php echo ucwords($job_desc['job_description']); ?> </li>

    <?php }
    ?>
</ul>