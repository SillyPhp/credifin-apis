<h3 class="mt-30"><?= (($text)?$text:'Required Knowledge, Skills, and Abilities') ?></h3>
<div class="tags-bar">
    <?php foreach ($skills as $job_skill) { ?>
        <span><?= strtoupper($job_skill['skill']); ?> </span>
    <?php } ?>
</div>