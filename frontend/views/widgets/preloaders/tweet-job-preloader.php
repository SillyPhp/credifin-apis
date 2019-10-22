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
$this->registerCss('
.loading-main .tweet-org-logo .loader{
    height:50px;
    width: 50px;
}
.loading-main .tweet-org-description .loader{
    margin-top:5px;
    width:130px;
}
.loading-main .tweet-org-description .loader:nth-child(1){
    height:15px;
    width:100%;
}
.loading-main .posted-tweet{
    background:#fff;
    padding:20px 15px;
    border-radius:0 0 10px 10px; 
}
.loading-main .tweet-org-descriptio .loader{
    text-align:center
}
')
?>