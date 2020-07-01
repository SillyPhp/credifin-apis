<?php
$column = 'col-lg-6 col-md-6';
if (isset($size)) {
    $column = $size;
}
?>
    <div class="row">
        <?php
            for($i = 0; $i < 6; $i++){
        ?>
        <div class="<?= $column ?>">
            <div class="job-listing wtabs">
                <div class="preloader-job-title-sec">
                    <div class="preloader-c-logo">
                        <div class="loader anim"></div>
                    </div>
                    <h3>
                        <div class="loader anim"></div>
                    </h3>
                    <div class="preloader-wtabs-com-name">
                        <div class="loader anim"></div>
                    </div>
                    <div class="preloader-job-lctn">
                        <div class="loader anim"></div>
                    </div>
                </div>
                <div class="preloader-job-style-bx">
                    <span class="preloader-job-is"><div class="loader anim"></div></span>
                </div>
            </div><!-- Job -->
        </div>
                <?php
            }
                ?>
    </div>
<?php
$this->registerCss('
.preloader-c-logo {
    float: left;
    width: 130px;
    height: 80px;
    text-align: center;
    position: relative;
}
.preloader-c-logo > div {
    float: none;
    display: inline-block;
    max-width: 80px;
    height:100%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}
.preloader-job-title-sec h3 {
    display: table;
    margin: 0;
    margin-bottom: 0px;
    margin-bottom: 7px;
    margin-top: 3px;
}
.preloader-job-title-sec h3 .loader{
    height:18px;
}
.preloader-wtabs-com-name{
    display: table;
    float: none;
    padding-top:12px;
}
.preloader-job-listing.wtabs .job-lctn {
    display: inline;
    width: 100%;
    font-size: 13px;
}
.preloader-job-lctn {
    display: table-cell;
    vertical-align: middle;
    font-family: open Sans;
    padding-top:10px;
    line-height: 23px;
    width: 25%;
}
.preloader-job-style-bx {
    float: left;
    width: 30%;
    position: absolute;
    right: 0px;
    bottom: 0;
    padding: 15px;
}
.preloader-job-is {
    display: table-cell;
    float: right;
    border-radius:4px
    width: 108px;
    margin: 9px 0;
}
.preloader-job-is .loader{
    width:108px;
    height:30px;
}
');
