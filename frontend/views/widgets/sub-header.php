<div class="secondary-headers on-top">
    <!--        <div class="secondary-headers-left">-->
    <!--            <a href="#">Jobs Near Me | </a>-->
    <!--            <a href="#">  Walk in Interview</a>-->
    <!--        </div>-->
    <div class="secondary-headers-right">
        <?php
//        foreach ($dat as $d){}
        ?>
        <a href="#">Jobs Near Me </a>
        <!--            <a href="#"> | </a>-->
        <a href="#">  Walk in Interview</a>
        <a href="#">  Explore Companies</a>
        <a href="#">  Compare Jobs</a>
    </div>
</div>
<?php
$this->registerCss('
.secondary-headers{
    height: 32px;
    line-height: 30px;
    top: 51px;
    position: fixed;
    transition: margin 500ms;
    background-color: #333333;
    left: 0;
    width: 100%;
    z-index: 999;
    border-bottom: 1px solid #eee;
    border-top: 1px solid #eee;
    transition: all 500ms;
}
.secondary-headers-left, .secondary-headers-right{
    width:auto;
}
.secondary-headers-left{padding-left:80px;float:left;}
.secondary-headers-left a i{font-size:16px;}
.secondary-headers-right{padding-right:50px;float:right;}
.secondary-headers a{
    color:#fff;
    transition: all 500ms;
}
.secondary-headers-right a{
    height: 30px;
    line-height: 30px;
    padding: 0px 15px;
    /* padding: 0px 20px; */
    /* margin-left: 5px; */
}
.secondary-headers a:hover, .secondary-headers.on-top a:hover{color:#00a0e3;}
.secondary-headers.on-top{
    background-color: #0000004d;
    border-color:transparent;
}
.secondary-headers.on-top a{
    color:#fff;
}
@media screen and (max-width: 610px) and (min-width: 0px) {
    .secondary-headers-left{padding-left: 20px;}
}
@media screen and (max-width: 571px) and (min-width: 0px) {
    .secondary-headers-right{padding-right:15px;}
    .secondary-headers-left{padding-left: 10px;}
    .secondary-headers-right a{padding:0px 5px;}
}
@media screen and (max-width: 450px) and (min-width: 0px) {
    .secondary-headers-left{display:none;}
}
');
$this->registerJs('
$(window).scroll(function() {
    if(window.pageYOffset <= 50){
        $(".secondary-headers").addClass("on-top");
    } else{
        $(".secondary-headers").removeClass("on-top");
    }
    // var head_class = $("#header-main .container-fluid");
    // if(!head_class.hasClass("add-padding")){
    //     console.log(1);  
    // }
});
');