<h3 class="mt-30"><?= (($text)?$text:'Required Knowledge, Skills, and Abilities') ?></h3>
<div class="tags-bar">
    <?php foreach ($skills as $job_skill) { ?>
        <a href="<?= '/' .$job_skill['skill'] . '-' .strtolower($type) . 's';?>" class="skill-chips"><?= strtoupper($job_skill['skill']); ?> </a>
    <?php } ?>
</div>