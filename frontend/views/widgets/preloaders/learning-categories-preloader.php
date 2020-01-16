<?php
$column = 'col-md-2 col-sm-4 col-xs-6';
if (isset($size)) {
    $column = $size;
}
?>
<?php
for($i = 0; $i < 12; $i++){
?>
<div class="<?= $column ?> pr-0 pc-main">
    <div class="newset">
        <div class="preloader-imag">
            <div class="loader anim"></div>
        </div>
    </div>
</div>
<?php
}
$this->registerCss('
.newset{
    text-align:center;
    max-width: 160px;
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
.preloader-imag{
    text-align: right;
}
.preloader-imag .loader{
    min-height:200px;
    width:100%;
}

');
?>
