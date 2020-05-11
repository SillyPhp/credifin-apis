<h3>Education</h3>
<ul>
    <?php
    foreach ($educational_requirements as $qualification) {
        ?>
        <li> <?php echo ucwords($qualification['educational_requirement']); ?> </li>
    <?php } ?>
</ul>