<?php
$column = 'col-md-3 col-sm-3 col-xs-6';
if (isset($size)) {
    $column = $size;
}
?>
<div class="loading-main">
    <div class="row">
<?php
for ($i = 0; $i < 4; $i++) {
    ?>
    <div class="<?= $column ?>">
        <div class="tweet-org-deatail">
            <div class="tweet-org-logo">
                <div class="loader anim"></div>
            </div>
            <div class="tweet-org-description">
                <div class="loader anim"></div>
                <div class="loader anim"></div>
                <div class="loader anim"></div>
            </div>
        </div>
        <div class="posted-tweet">
            <div class="loader anim"></div>
            <div class="loader anim"></div>
            <div class="loader anim"></div>
            <div class="loader anim"></div>
        </div>
    </div>
    <?php
}
   ?>
    </div>
</div>
<?php

?>