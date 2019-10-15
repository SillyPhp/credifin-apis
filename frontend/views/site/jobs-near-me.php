<?php
$this->title = Yii::t('frontend', 'Jobs Near Me');
$this->params['header_dark'] = true;

use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-2 col-sm-3">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'jobs',
        ]);
        ?>
    </div>
    <div class="col-md-10 col-sm-9 set-map-container">
        <script id="marker-content-template" type="text/x-handlebars-template"></script>
        <div class="my-large-container mb-20">
            <div class="row">
                <div class="col-md-12 mb-20">
                    <div class="overlay-map">
                        <div class="map-canvas">
                        </div>
                    </div>
                    <br/>
                    <div>
                        <nav class="navbar-search" data-spy="affix" data-offset-top="679">
                            <div class="col-md-12 search-box-border-shadow">
                                <form>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_3"/>
                                                <label for="form_control_3">City</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_1"/>
                                                <label for="form_control_1">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_2"/>
                                                <label for="form_control_2">Job Title</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="range-slider mt-10">
                                                <div class="p-bar-main">
                                                    <input class="range-slider__range" type="range" value="2" min="0" max="50">
                                                <span class="range-slider__value">0</span>
                                                    <span class="p-bar"></span>
                                                </div>
                                                <h5>Set distance between search location.</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-right pt-10">
                                            <svg version="1.1" class="svg-filters">
                                            <defs>
                                            <filter id="filter-goo-2">
                                                <feGaussianBlur in="SourceGraphic" stdDeviation="7" result="blur" />
                                                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                                                <feComposite in="SourceGraphic" in2="goo" />
                                            </filter>
                                            </defs>
                                            </svg>
                                            <button id="component-2" class="button button--2" style="filter: url('#filter-goo-2')">
                                                Search
                                                <span class="button__bg"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>

            <?php
            for ($i = 1; $i <= 3; $i++) {
                ?>
                <div class="row work-load blogbox">
                    <div class="col-md-4">
                        <div class="product iconbox-border iconbox-theme-colored shadow">
                            <span class="tag-sale color-o " style="background:#202C45 !important;">
                                Unpaid
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                    </a> 
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title"> 
                                        <strong>
                                            Web Designer
                                        </strong>
                                    </h4>
                                    <h5 class="location" lats="30.899238" longs="75.824059">
                                        <i class="fa fa-map-marker">
                                        </i> United states Of America
                                    </h5>
                                    <h5 class="period">
                                        <i class="fa fa-clock-o">
                                        </i> 4 Months
                                    </h5>
                                </div>
                                <div class="btn-add-to-cart-wrapper">
                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                                    </a>
                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                        <i class="fa fa-plus">
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <hr class="hr">   
                            <h6 class="pull-left pl-20 custom_set2" align="center">
                                <strong>
                                    Last Date to Apply
                                </strong>
                                <br>
                                <span class="lastDate">20 Feb, 2018</span>
                            </h6>
                            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                                <strong>
                                    DSB EduTech
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product shadow iconbox-border iconbox-theme-colored">
                            <span class="tag-sale color-o pl-20 pr-20 ">
                                Paid
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/8032b0b9-ae8a-43a1-a8fa-df1c258add83.png">
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title"> 
                                        <strong>
                                            Web Developer
                                        </strong>
                                    </h4>
                                    <h5 class="location" lats="30.888254" longs="75.844421">
                                        <i class="fa fa-map-marker">
                                        </i>  Delhi
                                    </h5>
                                    <h5 class="period">
                                        <i class="fa fa-clock-o">
                                        </i> 5 Months
                                    </h5>
                                </div>
                                <div class="btn-add-to-cart-wrapper">
                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                                    </a>
                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                        <i class="fa fa-plus">
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <hr class="hr">
                            <h6 class="pull-left pl-20 custom_set2" align="center">
                                <strong>
                                    Last Date to Apply
                                </strong>
                                <br>
                                <span class="lastDate">20 May, 2018</span>
                            </h6>
                            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                                <strong>
                                    DSB EduTech
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product iconbox-border iconbox-theme-colored shadow">
                            <span class="tag-sale color-o " style="background:#202C45 !important;">
                                Unpaid
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                    </a> 
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title"> 
                                        <strong>
                                            Finance Manager
                                        </strong>
                                    </h4>
                                    <h5 class="location" lats="30.896725" longs="75.846170">
                                        <i class="fa fa-map-marker">
                                        </i> Ludhiana
                                    </h5>
                                    <h5 class="period">
                                        <i class="fa fa-clock-o">
                                        </i> 3 Months
                                    </h5>
                                </div>
                                <div class="btn-add-to-cart-wrapper">
                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                                    </a>
                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                        <i class="fa fa-plus">
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <hr class="hr">   
                            <h6 class="pull-left pl-20 custom_set2" align="center">
                                <strong>
                                    Last Date to Apply
                                </strong>
                                <br>
                                <span class="lastDate">20 June, 2018</span>
                            </h6>
                            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                                <strong>
                                    Empower Youth
                                </strong>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php
            }
            for ($i = 1; $i <= 3; $i++) {
                ?>
                <div class="row work-load blogbox" style="display: none;">
                    <div class="col-md-4">
                        <div class="product iconbox-border iconbox-theme-colored shadow">
                            <span class="tag-sale color-o " style="background:#202C45 !important;">
                                Unpaid
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                    </a> 
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title"> 
                                        <strong>
                                            Web Designer
                                        </strong>
                                    </h4>
                                    <h5 class="location" lats="30.899238" longs="75.824059">
                                        <i class="fa fa-map-marker">
                                        </i> United states Of America
                                    </h5>
                                    <h5 class="period">
                                        <i class="fa fa-clock-o">
                                        </i> 4 Months
                                    </h5>
                                </div>
                                <div class="btn-add-to-cart-wrapper">
                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                                    </a>
                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                        <i class="fa fa-plus">
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <hr class="hr">   
                            <h6 class="pull-left pl-20 custom_set2" align="center">
                                <strong>
                                    Last Date to Apply
                                </strong>
                                <br>
                                <span class="lastDate">20 Feb, 2018</span>
                            </h6>
                            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                                <strong>
                                    DSB EduTech
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product shadow iconbox-border iconbox-theme-colored">
                            <span class="tag-sale color-o pl-20 pr-20 ">
                                Paid
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/8032b0b9-ae8a-43a1-a8fa-df1c258add83.png">
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title"> 
                                        <strong>
                                            Web Developer
                                        </strong>
                                    </h4>
                                    <h5 class="location" lats="30.888254" longs="75.844421">
                                        <i class="fa fa-map-marker">
                                        </i>  Delhi
                                    </h5>
                                    <h5 class="period">
                                        <i class="fa fa-clock-o">
                                        </i> 5 Months
                                    </h5>
                                </div>
                                <div class="btn-add-to-cart-wrapper">
                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                                    </a>
                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                        <i class="fa fa-plus">
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <hr class="hr">
                            <h6 class="pull-left pl-20 custom_set2" align="center">
                                <strong>
                                    Last Date to Apply
                                </strong>
                                <br>
                                <span class="lastDate">20 May, 2018</span>
                            </h6>
                            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                                <strong>
                                    DSB EduTech
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product iconbox-border iconbox-theme-colored shadow">
                            <span class="tag-sale color-o " style="background:#202C45 !important;">
                                Unpaid
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                    </a> 
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title"> 
                                        <strong>
                                            Finance Manager
                                        </strong>
                                    </h4>
                                    <h5 class="location" lats="30.896725" longs="75.846170">
                                        <i class="fa fa-map-marker">
                                        </i> Ludhiana
                                    </h5>
                                    <h5 class="period">
                                        <i class="fa fa-clock-o">
                                        </i> 3 Months
                                    </h5>
                                </div>
                                <div class="btn-add-to-cart-wrapper">
                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS
                                    </a>
                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                        <i class="fa fa-plus">
                                        </i>
                                    </a>
                                </div>
                            </div>
                            <hr class="hr">   
                            <h6 class="pull-left pl-20 custom_set2" align="center">
                                <strong>
                                    Last Date to Apply
                                </strong>
                                <br>
                                <span class="lastDate">20 June, 2018</span>
                            </h6>
                            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                                <strong>
                                    Empower Youth
                                </strong>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row blogbox loader-main" style="display: none;">
                <div class="col-md-4">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                        <span class="tag-load pl-20 pr-20 ">
                            <div class="loader anim"></div>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <div class="loader anim"></div>
                                </a>
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title">
                                    <strong><div class="loader anim"></div></strong>
                                </h4>
                                <h5>
                                    <i class="locations"><div class="loader anim"></div></i>
                                </h5>
                                <h5>
                                    <i class="periods"><div class="loader anim"></div></i>
                                </h5>
                            </div>
                        </div>
                        <hr class="hr">
                        <div class="col-md-6">
                            <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                <br>
                                <div class="last-date">
                                    <div class="loader anim"></div>
                                </div>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h4 class="pull-right pt-20 custom_set" align="center">
                                <strong>
                                    <div class="loader anim"></div>
                                </strong>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                        <span class="tag-load pl-20 pr-20 ">
                            <div class="loader anim"></div>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <div class="loader anim"></div>
                                </a>
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title">
                                    <strong><div class="loader anim"></div></strong>
                                </h4>
                                <h5>
                                    <i class="locations"><div class="loader anim"></div></i>
                                </h5>
                                <h5>
                                    <i class="periods"><div class="loader anim"></div></i>
                                </h5>
                            </div>
                        </div>
                        <hr class="hr">
                        <div class="col-md-6">
                            <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                <br>
                                <div class="last-date">
                                    <div class="loader anim"></div>
                                </div>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h4 class="pull-right pt-20 custom_set" align="center">
                                <strong>
                                    <div class="loader anim"></div>
                                </strong>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                        <span class="tag-load pl-20 pr-20 ">
                            <div class="loader anim"></div>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <div class="loader anim"></div>
                                </a>
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title">
                                    <strong><div class="loader anim"></div></strong>
                                </h4>
                                <h5>
                                    <i class="locations"><div class="loader anim"></div></i>
                                </h5>
                                <h5>
                                    <i class="periods"><div class="loader anim"></div></i>
                                </h5>
                            </div>
                        </div>
                        <hr class="hr">
                        <div class="col-md-6">
                            <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                <br>
                                <div class="last-date">
                                    <div class="loader anim"></div>
                                </div>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h4 class="pull-right pt-20 custom_set" align="center">
                                <strong>
                                    <div class="loader anim"></div>
                                </strong>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-div" align="center">
                <a href="#" id="loadMore" class="btn btn-primary loadmorebtn" align="center"style="color:white">
                    <h4>Load More 
                        <i class="fa fa-angle-down">
                        </i>
                    </h4>
                </a>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
*:focus{
    outline:none;
}    
.loadmorebtn{
    padding:5px 20px !important;
}    
.search-box-border-shadow{
    border: 1px solid transparent;
    box-shadow: 0px 4px 9px 0px #EEE;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
}
.side-menu{
    z-index:9;
}
.form-group.form-md-line-input{margin-bottom:0px !important;}
.search-box-border-shadow form{
    padding: 0px 20px 0px 20px;
    margin-bottom:0px;
}
.search-box-header{
    background-color: #55c6d3;
    padding: 2px 30px;
    border-radius: 8px 8px 0px 0px;
}
.search-box-header h3{
    color:#fff;
    margin: 8px 0px;
}
.overlay-map{
    width:100%;
    height:640px;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
.set_logo{
//    display: table-cell;
    vertical-align: middle;
    height: 73px !important;
}
.product *:not(i) {
    font-family: Georgia !important;
}
.product {
    padding: 0px 10px 10px 10px;
    margin-bottom: 10px !important;
    margin-top: 0px !important;
}
.color-o {
    background: #FF4500 !important;
}
.hr {
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.custom_set {
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.custom_set2 {
    margin-bottom: 0px !important;
}
.map-canvas {
    height: 100%;
}
.map-canvas div:first-child{z-index:999;}
.my-large-container{
    max-width: 1500px !important;
//    padding-left: 15px;
//    padding-right: 15px;
    margin:auto;
}
//.set-map-container{
//    padding-left:100px;
//}
.button--2{
    -webkit-font-smoothing: antialiased;
    background-color: #222;
    border: none;
    display: inline-block;
    font-family: "Montserrat", sans-serif;
    font-size: 0.85em;
    font-weight: 700;
    text-decoration: none;
    user-select: none;
    letter-spacing: 0.1em;
    color: white;
    padding: 20px 40px;
    text-transform: uppercase;
    -webkit-transition: background-color 0.1s ease-out;
    -moz-transition: background-color 0.1s ease-out;
    transition: background-color 0.1s ease-out;
}
.button--2:hover{
    background-color: #2CD892;
    color: #fff;
}
.button--2:focus{
    outline: none;
    color: #fff;
}
.safari .button, .safari
.button__bg {
    -webkit-filter: none !important;
    filter: none !important;
}
.button--2 .button__bg {
    content: "";
    position: absolute;
}
.button__bg {
    transform: translateZ(0);
    outline: 90px solid transparent !important;
    background: #00a0e3;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
    -webkit-transition: background 0.1s ease-out;
    -moz-transition: background 0.1s ease-out;
    transition: background 0.1s ease-out;
    /*border-radius: 40px;*/
}
.button--2 {
    outline: 90px solid transparent !important;
    position: relative;
    z-index: 0;
    background-color: transparent;
}
.button--2 .left, .button--2 .right {
    position: absolute;
    width: 25px;
    height: 25px;
    border-radius: 15px;
    background: #00a0e3;
    -webkit-transition: background 0.1s ease-out;
    -moz-transition: background 0.1s ease-out;
    transition: background 0.1s ease-out;
    top: 50%;
    margin-top: -12px;
    z-index: -2;
}
.button--2 .left.left, .button--2 .right.left {
    left: 0;
}
.button--2 .left.right, .button--2 .right.right {
    right: 0;
}
.button--2:hover {
    background-color: transparent;
}
.button--2:hover:before, .button--2:hover span {
    background-color: #ff7803;
}
.svg-filters {
    position: absolute;
    visibility: hidden;
    width: 1px;
    height: 1px;
}
.si-content {
    overflow: visible;
}
.custom-close {
    position: absolute;
    top: 0;
    right: -36px;
    width: 36px;
    height: 36px;
    -webkit-transition: background-color 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    transition: background-color 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    border: 0;
    background-color: rgba(68, 67, 62, 0.8);
    color: #fff;
    font-size: 1.5em;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
    cursor: pointer;
}
.si-content-wrapper {
    padding: 0px;
    overflow: visible;
}
.set_logo img{
    width: 96px;
    height: 73px;
}
.company {
    height: auto;
    width: auto;
}
.si-content .product{
    margin-bottom: 0px !important;
}
.range-slider {
  width: 100%;
}
.range-slider__range {
  -webkit-appearance: none;
//  width: calc(100% - (73px)) !important;
  width:100% !important;
  height: 10px;
  border-radius: 5px;
  background: #d7dcdf;
  outline: none;
  padding: 0;
  margin: 0;
  display: initial !important;
}
.range-slider__range::-webkit-slider-thumb {
  -webkit-appearance: none;
          appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #00a0e3;
  cursor: pointer;
  transition: background .15s ease-in-out;
}
.range-slider__range::-webkit-slider-thumb:hover {
  background: #ff7803;
}
.range-slider__range:active::-webkit-slider-thumb {
  background: #00a0e3;
}
.range-slider__range::-moz-range-thumb {
  width: 20px;
  height: 20px;
  border: 0;
  border-radius: 50%;
  background: #2c3e50;
  cursor: pointer;
  transition: background .15s ease-in-out;
}
.range-slider__range::-moz-range-thumb:hover {
  background: #00a0e3;
}
.range-slider__range:active::-moz-range-thumb {
  background: #00a0e3;
}
.range-slider__range:focus::-webkit-slider-thumb {
  box-shadow: 0 0 0 3px #fff, 0 0 0 6px #00a0e3;
}

.range-slider__value {
  display: inline-block;
//  position: relative;
  position: absolute;
  width: 60px;
  color: #fff;
  line-height: 20px;
  text-align: center;
  border-radius: 3px;
  background: #00a0e3;
  padding: 5px 10px;
  margin-left: 8px;
  top: 0;
  right: -72px;
}
.range-slider__value:after {
  position: absolute;
  top: 8px;
  left: -7px;
  width: 0;
  height: 0;
  border-top: 7px solid transparent;
  border-right: 7px solid #00a0e3;
  border-bottom: 7px solid transparent;
  content: "";
}
::-moz-range-track {
  background: #d7dcdf;
  border: 0;
}

input::-moz-focus-inner,
input::-moz-focus-outer {
  border: 0;
}
.p-bar-main{
    position:relative;
    width:80%;
}
#loadMore {
    text-align: center;
    background-color: #202c45;
    color: #fff !important;
    border-width: 0 0px 0px 0;
    border-radius: 12px;
    border-style: solid;
    border-color: #fff;
    box-shadow: 0 6px 10px #868686 !important;
    transition: all 600ms ease-in-out;
    -webkit-transition: all 600ms ease-in-out;
    -moz-transition: all 600ms ease-in-out;
    -o-transition: all 600ms ease-in-out;
}
#loadMore:hover {
    background-color: #f08340;
    color: #fff;
}
#loadMore h4{
    color:#fff !important;
}
.btn-div{
    margin-top: 20px;
    padding-top: 20px;
    margin-bottom: 20px;
}
.product .tag-load .anim{
  max-width:30%;
  float:right;
}
.set_logo .anim{
  max-width:96px;
  height:73px;
  margin-left:10px;
}
.icon-box-title strong .anim{
  max-width:100%;
  height:15px;
}
.locations .anim{
  max-width:60%;
}
.periods .anim{
  max-width:40%;
}
.custom_set2 strong .anim{
  max-width:80%;
  margin:auto;
}
.last-date .anim{
  max-width:60%;
  margin:auto;
}
.custom_set strong .anim{
  max-width:80%;
  height:18px;
  float:right;
}
.loader {
    display: block;
    position:relative;
    width: 160px;
    height: 10px;
    background-color: #ECEFF1;
    border-radius: 4px;
}
.anim {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeHolderAnim;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: linear-gradient(to right, #ECEFF1 8%, #DBE2E5 18%, #ECEFF1 33%);
    background-size: 40rem 1rem;
    position: relative;
}
@keyframes placeHolderAnim {
    0% { background-position: -12rem 0; }
    100% { background-position: 12rem 0; }
}
.affix {
    top: 51px;
    -moz-top:52px;
    width: 84.6%;
    z-index: 999 !important;
}
@-moz-document url-prefix() {
   .affix{
       top: 52px;
   }
}
@media screen and (min-device-width: 991px) and (max-device-width: 1160px) {
    .set-map-container{
        padding-left:40px;
    }
}
@media only screen and (max-width: 991px) {
    .affix{
        position:relative;
        width:100%;
        top:0px;
    }
}
');
$script = <<< JS
 let types='', newLat='', lat=0, lon=0, titles='', locations='', lastDates='', periods=0, companys='', logos='';
           $(function() {
            var mapStyle = [{'featureType': 'all', 'elementType': 'geometry.fill', 'stylers': [{'weight': '2.00'}]}, {'featureType': 'all', 'elementType': 'geometry.stroke', 'stylers': [{'color': '#9c9c9c'}]}, {'featureType': 'all', 'elementType': 'labels.text', 'stylers': [{'visibility': 'on'}]}, {'featureType': 'landscape', 'elementType': 'all', 'stylers': [{'color': '#f2f2f2'}]}, {'featureType': 'landscape', 'elementType': 'geometry.fill', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'landscape.man_made', 'elementType': 'geometry.fill', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'poi', 'elementType': 'all', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'road', 'elementType': 'all', 'stylers': [{'saturation': -100}, {'lightness': 45}]}, {'featureType': 'road', 'elementType': 'geometry.fill', 'stylers': [{'color': '#eeeeee'}]}, {'featureType': 'road', 'elementType': 'labels.text.fill', 'stylers': [{'color': '#7b7b7b'}]}, {'featureType': 'road', 'elementType': 'labels.text.stroke', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'road.highway', 'elementType': 'all', 'stylers': [{'visibility': 'simplified'}]}, {'featureType': 'road.arterial', 'elementType': 'labels.icon', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'transit', 'elementType': 'all', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'water', 'elementType': 'all', 'stylers': [{'color': '#46bcec'}, {'visibility': 'on'}]}, {'featureType': 'water', 'elementType': 'geometry.fill', 'stylers': [{'color': '#c8d7d4'}]}, {'featureType': 'water', 'elementType': 'labels.text.fill', 'stylers': [{'color': '#070707'}]}, {'featureType': 'water', 'elementType': 'labels.text.stroke', 'stylers': [{'color': '#ffffff'}]}];
            
            $(document).on("click",".opens", function () {
                types = $(this).find('#set-types').attr('type');
                lat = $(this).find('#set-types').attr('lat');
                lon = $(this).find('#set-types').attr('long');
                titles = $(this).find('#set-types').attr('title');
                locations =  $(this).find('#set-types').attr('location');
                lastDates = $(this).find('#set-types').attr('lastdate');
                periods = $(this).find('#set-types').attr('period');
                companys =  $(this).find('#set-types').attr('company');
                logos = $(this).find('#set-types').attr('logo');
            });

            var myLatLng = new google.maps.LatLng(lat=30.900430, lon=75.826821);
            // Create the map
            var map = new google.maps.Map($('.map-canvas')[0], {
                zoom: 14,
                styles: mapStyle,
                center: myLatLng
            });
        
            // Add a custom marker
            var markerIcon = {
                path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                fillColor: '#e25a00',
                fillOpacity: 0.95,
                scale: 3,
                strokeColor: '#fff',
                strokeWeight: 3,
                anchor: new google.maps.Point(12, 24)
            };
            var marker = new google.maps.Marker({
                map: map,
                icon: markerIcon,
                position: myLatLng
            });

            // Set up handle bars
            var template = Handlebars.compile($('#marker-content-template').html());

            // Set up a close delay for CSS animations
            var info = null;
            var closeDelayed = false;
            var closeDelayHandler = function() {
                $(info.getWrapper()).removeClass('active');
                setTimeout(function() {
                    closeDelayed = true;
                    info.close();
                }, 300);
            };

            // Add a Snazzy Info Window to the marker
            info = new SnazzyInfoWindow({
                marker: marker,
                wrapperClass: 'custom-window',
                offset: {
                    top: '-72px'
                },
                edgeOffset: {
                    top: 50,
                    right: 60,
                    bottom: 50
                },
                border: false,
                closeButtonMarkup: '<button type="button" class="custom-close">&#215;</button>',
                callbacks: {
                    beforeOpen: function() {
                        this.setContent(setMarketContent());
                    },
                    open: function() {
                        $(this.getWrapper()).addClass('open');
                    },
                    afterOpen: function() {
                        var wrapper = $(this.getWrapper());
                        wrapper.addClass('active');
                        wrapper.find('.custom-close').on('click', closeDelayHandler);
                    },
                    beforeClose: function() {
                        if (!closeDelayed) {
                            closeDelayHandler();
                            return false;
                        }
                        return true;
                    },
                    afterClose: function() {
                        var wrapper = $(this.getWrapper());
                        wrapper.find('.custom-close').off();
                        wrapper.removeClass('open');
                        closeDelayed = false;
                        marker.setVisible(false);
                    }
                }
            });
            marker.setVisible(false);
            // Open the Snazzy Info Window
        
            $(document).on("click", '.opens' , function(){
                changeMarkerPosition(marker);
                marker.setVisible(true);
                info.open();
                
            });
            
            function changeMarkerPosition(marker) {
                var latlng = new google.maps.LatLng(lat, lon);
                marker.setPosition(latlng);
                map.setCenter(latlng);
            }

            function setMarketContent() {
                return '<div style="width:400px;" class="product shadow iconbox-border iconbox-theme-colored"><span class="type tag-sale color-o pl-20 pr-20 ">'+types+'</span><div class="row"><div class="col-md-4 col-xs-4 pt-5" ><a href="#" class="icon set_logo"><img class="logo" src="'+logos+'"></a></div><div class="col-md-8 col-xs-8 pt-20"><h4 class="title icon-box-title"><strong>'+titles+'</strong></h4><h5><i class="location fa fa-map-marker" lat="'+lat+'" long="'+lon+'"> '+locations+'</i></h5><h5><i class="period fa fa-clock-o"> '+periods+'</i></h5></div><div class="btn-add-to-cart-wrapper"><a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS</a><a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#"><i class="fa fa-plus"></i></a></div></div><hr class="hr"><h6 class="pull-left pl-20 custom_set2" align="center"><strong>Last Date to Apply</strong><br><div class="lastDate">'+lastDates+'</div></h6><h4 class="company pull-right pr-10 pt-20 custom_set" align="center"><strong>'+companys+'</strong></h4></div>';
            }
        info.close();
        });
        
function getRandom(min, max){
  return Math.random() * (max - min) + min;
}

var isSafari = /constructor/i.test(window.HTMLElement);
var isFF = !!navigator.userAgent.match(/firefox/i);

if (isSafari) {
  document.getElementsByTagName('html')[0].classList.add('safari');
}

// Remove click on button for demo purpose
Array.prototype.slice.call(document.querySelectorAll('.button'), 0).forEach(function(bt) {
  bt.addEventListener('click', function(e) {
    e.preventDefault();
  });
});

// Button 2
initBt2();        

function initBt2() {
  var bt = document.querySelectorAll('#component-2')[0];
  var filter = document.querySelectorAll('#filter-goo-2 feGaussianBlur')[0];
  var particleCount = 12;
  var colors = ['#DE8AA0', '#8AAEDE', '#FFB300', '#60C7DA']

  bt.addEventListener('click', function() {
    var particles = [];
    var tl = new TimelineLite({onUpdate: function() {
      filter.setAttribute('x', 0);
    }});
    
    tl.to(bt.querySelectorAll('.button__bg'), 0.6, { scaleX: 1.05 });
    tl.to(bt.querySelectorAll('.button__bg'), 0.9, { scale: 1, ease: Elastic.easeOut.config(1.2, 0.4) }, 0.6);

    for (var i = 0; i < particleCount; i++) {
      particles.push(document.createElement('span'));
      bt.appendChild(particles[i]);

      particles[i].classList.add(i % 2 ? 'left' : 'right');
      
      var dir = i % 2 ? '-' : '+';
      var r = i % 2 ? getRandom(-1, 1)*i/2 : getRandom(-1, 1)*i;
      var size = i < 2 ? 1 : getRandom(0.4, 0.8);
      var tl = new TimelineLite({ onComplete: function(i) {
        particles[i].parentNode.removeChild(particles[i]);
        this.kill();
      }, onCompleteParams: [i] });

      tl.set(particles[i], { scale: size });
      tl.to(particles[i], 0.6, { x: dir + 20, scaleX: 3, ease: SlowMo.ease.config(0.1, 0.7, false) });
      tl.to(particles[i], 0.1, { scale: size, x: dir +'=25' }, '-=0.1');
      if(i >= 2) tl.set(particles[i], { backgroundColor: colors[Math.round(getRandom(0, 3))] });
      tl.to(particles[i], 0.6, { x: dir + getRandom(60, 100), y: r*10, scale: 0.1, ease: Power3.easeOut });
      tl.to(particles[i], 0.2, { opacity: 0, ease: Power3.easeOut }, '-=0.2');
    }
  });
}
        
        
var rangeSlider = function(){
  var slider = $('.range-slider'),
      range = $('.range-slider__range'),
      value = $('.range-slider__value');
    
  slider.each(function(){

    value.each(function(){
      var value = $(this).prev().attr('value');
      $(this).html(value + ' KM');
    });

    range.on('input', function(){
      $(this).next(value).html(this.value + ' KM');
      $(this).css('background','linear-gradient(90deg, #00a0e3 ' + this.value*2 + '%, #d7dcdf 0%)');
    });
  });
};

rangeSlider();
        
$(document).ready(function () {
    $(".work-load").slice(0, 3).show();
    if ($(".blogbox:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $('.loader-main').slideDown();
        setTimeout(function() { $(".loader-main").hide(); 
            $(".work-load:hidden").slice(0, 1).fadeIn();
        if ($(".work-load:hidden").length == 0) {
            $(".btn-div").fadeOut('slow');
        }
        }, 2000);
    });
});

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
$this->registerCssFile('@eyAssets/css/jobs-map/snazzy-info-window.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/snazzy-info-window.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jobs-near-me/TweenMax.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
