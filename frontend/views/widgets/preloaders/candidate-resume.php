<?php
$column = 'col-md-3 col-sm-6';
if (isset($size)) {
    $column = $size;
}
?>
    <div class="loading-main">
        <div class="row">
            <?php
            for ($i = 0; $i < 4; $i++) {
                ?>
                <div class="<?= $column ?> loader-padding">
                    <div class="main-box">
                        <div class="short">
                            <div class="loader anim"></div>
                        </div>
                        <div class="short-dp">
                            <div class="loader anim"></div>
                        </div>
                        <div class="short-name">
                            <div class="loader anim"></div>
                        </div>
                        <div class="short-desc">
                            <div class="loader anim"></div>
                        </div>
                        <div class="short-skills">
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                        </div>
                        <div class="short-location">
                            <div class="loader anim"></div>
                            <div class="loader anim"></div>
                        </div>
                        <div class="short-view">
                            <div class="loader anim"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
$this->registerCss('
.main-box {
    border: 1px solid #eee;
    border-radius: 7px;
    position: relative;
    height: 395px;
}
.loader-padding{
    margin-bottom:20px;
}
.short{
    position: absolute;
    top: 0;
    left: 0;
}
.short .loader{
    width:100px;
    height:25px;
    border-radius: 5px 0;
}
.hello{
    width:100%
}
.short-dp .loader {
    width: 120px;
    height: 120px;
    border-radius: 100px;
    margin: 0 auto;
    margin-top: 25px;
}
.short-name .loader{
    width: 190px;
    height: 22px;
    margin: 0 auto;
    margin-top: 20px;
}
.short-desc .loader{
    width: 150px;
    height: 18px;
    margin: 0 auto;
    margin-top: 5px;
}
.short-skills{
    margin-top: 15px;
    text-align: center;
    padding: 3px;
    }
.short-skills .loader{
    width: 100px;
    height: 20px;
    margin: 0 auto;
    border-radius:8px;
    margin-top:3px;
    display: inline-block;
}
.short-location{
    margin: 31px 0 10px 0;
    text-align: center;
}
.short-location .loader{
    width: 100px;
    height: 23px;
    display: inline-block;
}
.short-view {
    width: 100%;
    border-top: 1px solid #eee;
    padding: 9px 0;
}
.short-view .loader{
    width: 100px;
    height: 20px;
    margin: 0 auto;
}
.anim {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeHolderAnim;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: linear-gradient(to right, #ECEFF1 8%, #DBE2E5 18%, #ECEFF1 33%);
        background-size: auto;
    background-size: 40rem 1rem;
    position: relative;
}
.loader {
    display: block;
    position: relative;
    width: 150px;
    height: 10px;
    background-color: #ECEFF1;
    border-radius: 4px;
}

@keyframes placeHolderAnim {
    0% { background-position: -12rem 0; }
    100% { background-position: 12rem 0; }
}
')
?>