<?php
$column = 'col-md-4 col-sm-6';
if (isset($size)) {
    $column = $size;
}
?>
<div class="row">
    <?php
        for($i = 0; $i < 6; $i++){
    ?>
    <div class="<?= $column ?>">
        <div class="preloader-service-box">
            <div class="preloader-ser-icons">
                <div class="loader anim"></div>
            </div>
            <div class="preloader-ser-heading">
                <div class="loader anim"></div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>
<?php
$this->registerCss('
.preloader-service-box{ 
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    width: 95%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
}
.preloader-ser-icons{
    text-align:center;
}
.preloader-ser-icons > div{
    height: 75px; 
    width: 75px;
    border-radius:20px;
    margin:0 auto;
}
.preloader-ser-heading {
    text-align:center;
    padding-top:15px
}
.preloader-ser-heading > div{
    text-align:center;
    margin:0 auto;
}
')
?>
