<?php
use yii\helpers\Url;

$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

if($type == "jobs"){
    $a_type = "Jobs";
}
if ($type == "internships"){
    $a_type = "Internships";
}
?>
<div class="profile">
    <div id="sticky-anchor"></div>
    <div class="side-menu" id="sticky">
        <div class="profile-sidebar">
            <div class="row">

                <?php if (empty($reviews)) { ?>
                    <div class="col-md-12">
                        <p id="hidder">Click on plus button or <br>drag and drop any<br><?= $type; ?> to review<br>it
                            later on.</p>
                    </div>
                <?php } ?>
            </div>
            <div id="review-internships" style="background-color: #fff;" class="font-georgia">
                <span class="review-list-hint">Drop here to add to review list</span>
                <a href="#" class="review-list-toggler"><i class="fas fa-chevron-up"></i></a>
                <ul id="ilist" class="drop-options connected-sortable droppable-area">
                    <div class="loader-inner-main shadow pt-0">
                        <div class="col-md-3 col-xs-3 pt-10 p-0">
                            <div class="sidebar-logo-main p-0">
                                <div class="loader anim"></div>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-9 pt-5 p-0">
                            <a class="close" href="#">
                                <span aria-hidden="true">×</span>
                            </a>
                            <div class="loader anim org-name"></div>
                            <div class="loader anim post-name"></div>
                        </div>
                    </div>

                </ul>
                <i class="side-loader fas fa-circle-notch fa-spin fa-fw" style="display: none;"></i>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg in" id="pop_up_modal"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<?php
//echo $this->render('/widgets/popup');
$c_user = Yii::$app->user->identity->user_enc_id;
$this->registerCss('
#header > div{width:100% !important;}
.highlight{
    background-color: #CCC !important;
}
.set-scrollbar{
    float:left;
    width:95%;
    margin-right:12px;
}
.side-menu{
    position:fixed;
    top:0%;
    height:100vh;
}
#sticky.stick {
    position: fixed;
    top: 0px;

}
#sticky{
    top:0px;
}
#review-internships{
    height: calc(102vh - 52px);
    overflow-x:hidden;
    position:relative;
    width:218px;
}
@media screen and (max-width: 1240px) and (min-width: 992px) {
    #review-internships{
        width:175px; 
    }
}
.paid {
    border-bottom: 2px solid #FF4500 !important;
}

.unpaid {
    border-bottom: 2px solid #202C45 !important;
}
body {
    background: #F1F3FA;
}
.profile-sidebar {
//    background: #fff;
    padding-top: 30px;
    margin-top: 25px;
}
/* Profile Content */
:focus {
    outline: none;
}
.side-menu {
    position: fixed;
    height: 100%;
//    background-color: #f8f8f8;
//    border-right: 1px solid #e7e7e7;
}
.connected-sortable {
    margin: 0;
    list-style: none;
    width: 100%;
    padding: 0px;
}

li.draggable-item {
  width: inherit;
  padding: 0px;
  cursor:pointer;
  -webkit-transition: transform .25s ease-in-out;
  -moz-transition: transform .25s ease-in-out;
  -o-transition: transform .25s ease-in-out;
  transition: transform .25s ease-in-out;
  
  -webkit-transition: box-shadow .25s ease-in-out;
  -moz-transition: box-shadow .25s ease-in-out;
  -o-transition: box-shadow .25s ease-in-out;
  transition: box-shadow .25s ease-in-out;
  &:hover {
    cursor: pointer;
  }
}
/* styles during drag */
li.draggable-item.ui-sortable-helper {
  -webkit-box-shadow: 0 0 8px rgba(53,41,41, .8);
  -moz-box-shadow: 0 0 8px rgba(53,41,41, .8);
  box-shadow: 0 0 8px rgba(53,41,41, .8);
  transform: scale(1.015);
  z-index: 100;
}
li.draggable-item.ui-sortable-placeholder {
  -moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;
}
.draggable-item{
    height:61px;
}
#hidder{
    padding:0px 10px;
    padding: 0px 10px;
    text-align: center;
    position: absolute;
    top: 65vh;
    left: 12px;
    z-index: 9;
}
.sidebar-logo-main > canvas{
    margin-left: -5px;
    margin-top: -5px;
    border-radius: 50%;
}
.secondary-top-header{display:none !important;}
.review-list-hint, .review-list-toggler{display:none;}
@media only screen and (max-width: 991px) and (min-width: 768px)  {
    .profile-sidebar {
        margin-top: 40px;
    }
}
@media only screen and (max-width: 991px) {
    .stickyheader{
        display:none;
    }
}
@media only screen and (max-width: 767px) {
    .sidebar-review-bar{
//        display:none;
    }
    #sticky{
        height: 20%;
//        bottom: 0px;
        width: 96%;
        left:2%;
        top: 90.5% !important;
        z-index: 999;
        -moz-transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }
    #hidder{display:none !important;}
    .profile-sidebar{
        padding-top: 0px !important;
        margin-top: 0px !important;
    }
    #review-internships{
        height: 60px !important;
        bottom: 0;
        width: 96% !important;
        left: 2%;
        border-radius: 20px 20px 0px 0px;
        box-shadow: 0px 0px 12px 1px #ddd;
        -moz-transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
        pointer-events: none;
    }
    .review-list-hint{
        text-align: center;
        width: 100%;
        display: block;
        padding: 18px;
    }
    .review-list-toggler{
        position: absolute;
        display: block;
        top: 12px;
        width: 36px;
        height: 36px;
        text-align: center;
        font-size: 20px;
        right: 13px;
        padding: 0px;
        border-radius: 100px;
        box-shadow: 0px 1px 10px 2px #ddd;
        pointer-events: all;
    }
    .review-list-toggler i{
        display: block;
        line-height: 33px;
    }
    .review-open .profile #sticky{
        top: 100px !important;
        height: auto;
    }
    .review-open .profile #sticky .profile-sidebar #review-internships{
        height: calc(100vh - 90px) !important;
        pointer-events: auto;
    }
    .review-open .profile #sticky .profile-sidebar #review-internships .review-list-toggler{
        transform: rotate(-180deg);
    }
    .application-card-main{
        margin-right: 40px;
    }
    .applications-cards-list{padding:0px 15px;}
    #sticky.drag-on{
        top: 75% !important;
    }
    #review-internships.drop-on{
        height: 294px !important;
    }
//    *::-webkit-scrollbar {
//        width: 2em !important;
//    }
//    *::-webkit-scrollbar-track {
//        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3) !important;
//    }
//    *::-webkit-scrollbar-thumb {
//      background-color: darkgrey !important;
//      outline: 1px solid slategrey !important;
//    }
}
li.draggable-item{position:relative;}
.close{
    text-align: center;
    position: absolute;
    right: 20px;
    top: 10px;
    z-index: 99999;
}
');

$script = <<<JS
$('#review-internships').on('scroll',function(){
    if($(this).scrollTop() + $(this).height() >= $(window).height()){
        sidebarpage += 1;
        getReviewList(sidebarpage);
    }
});

function getReviewList(sidebarpage){
    if(draggable === true){
        var type ='$type';
        $.ajax({
            method: "POST",
            url : "/reviewed-applications/review-list?sidebarpage="+sidebarpage,
            data:{type:type},
            success: function(response) {
                reviewlists(response);
                check_list();
                utilities.initials();
            }
        }).done(function(){
            if(review_list_draggable === true) {
                $.each($('.draggable-item'), function(){
                    $(this).draggable({
                        helper: "clone",
                        drag: function() { 
                            $('.ps').addClass('ps-visible');
                         },
                         stop: function() { 
                            $('.ps').removeClass('ps-visible');
                         },
                    });
                });
            }
        });
    }
}

function reviewlists(response){
        
    $(".loader-inner-main").hide();
    
        var review = $('#review-cards').html();
        $("#ilist").append(Mustache.render(review, response.cards));
}


    init();

    function init() {
        $(".loader-inner-main").show();
        $(".loader-inner-main").hide();

        // $(".droppable-area").sortable({
        //     connectWith: ".connected-sortable",
        //     stack: '.connected-sortable ul'
        // }).disableSelection();
    }


    $('#review-internships').droppable({
        accept: '.application-card-main',
        over: function(event, ui) {
            $('#review-internships').addClass('highlight');
        },
        out: function(event, ui) {
            $('#review-internships').removeClass('highlight');
        },
        drop: function(event, ui) {
            var c_user = "$c_user"
            if(c_user == ""){
                $('#loginModal').modal('show');
            } else{
                $('#ilist').append(widget(ui.draggable));
                var itemid = $.trim(ui.draggable.attr('data-key'));
                var me = ui.draggable.clone();
            }
            $('.side-menu, #review-internships').removeClass('highlight');
            check_list();
        }
    });

function widget(selector) {
    var type = $.trim(selector.find('.application-card-type').text()).toLowerCase();
    var logo = $.trim(selector.find('.application-card-img a img').attr('src'));
    var logo_color = $.trim(selector.find('.application-card-img a canvas').attr('color'));
    var logo_main = $.trim(selector.find('.application-card-img a img').attr('src'));
    var internship = $.trim(selector.find('.application-title').text());
    var company = $.trim(selector.find('.org_name').text());
    var location = $.trim(selector.find('.location').text());
    var period = $.trim(selector.find('.period').text());
    var slug = $.trim(selector.find('.application-card-description a').attr('href'));
    var lastDate = $.trim(selector.find('.lastDate').text());
    var lat = $.trim(selector.find('.location').attr('data-lat'));
    var long = $.trim(selector.find('.location').attr('data-long'));
    var dataId = $.trim(selector.attr("data-id"));
    var dataKey = $.trim(selector.attr("data-key"));
    slug = slug.split('/')[2];
    if(!logo){
       logo = '<canvas class="user-icon image-partners" name="'+company+'" color="'+logo_color+'" width="40" height="40" font="18px"></canvas>';
    }else{
        logo = '<img class="side-bar_logo" src="' + logo + '" height="40px">';
    }
    droppingWidgets(type, logo, logo_main, internship, slug, company, location, period, lastDate, lat, long, dataKey, dataId);
}

function droppingWidgets(type, logo, logo_main, internship, slug, company, location, period, lastDate, lat, long, dataKey, dataId) {
    if ($("#review-internships > ul > li").length == 0) {
        Ajax_call(dataId);
        $("#ilist").append('<li class="draggable-item" data-key="' + dataKey + '" data-id="' + dataId +'" ><a class="close" href="#" data-id="' + dataId + '" aria-label="Close"><span aria-hidden="true">&times;</span></a><div class="opens product set-scrollbar iconbox-border iconbox-theme-colored shadow pb-5"><span id="set-types" type="' + type + '" lat="' + lat + '" long="' + long + '" logo="' + logo_main + '" slug="' + slug + '" company="' + company + '" title="' + internship + '" location="' + location + '" period="' + period + '" lastdate="' + lastDate + '"></span><div class="' + type + '"><div class="col-md-3 col-xs-3 pt-10 p-0"><div class="sidebar-logo-main">' + logo + '</div></div><div class="col-md-9 col-xs-9 pt-5 p-0"><p class="mb-0 text-wrap-ellipsis"><strong>' + internship + '</strong></p><p class="mb-5 text-wrap-ellipsis">' + company + '</p></div></div></div></li>');
        utilities.initials();
        check_list();
    } else {
        var dataArr = [];

        $('ul > li.draggable-item').each(function(i) {
            dataArr.push($(this).attr('data-key'));
        });
        if (jQuery.inArray(dataKey, dataArr) != '-1') {
            return false;
        } else {
            Ajax_call(dataId);
            $("#ilist").append('<li class="draggable-item" data-key="' + dataKey + '" data-id="' + dataId +'" ><a class="close" href="#" data-id="' + dataId + '" aria-label="Close"><span aria-hidden="true">&times;</span></a><div class="opens product set-scrollbar iconbox-border iconbox-theme-colored shadow pb-5"><span id="set-types" type="' + type + '" lat="' + lat + '" long="' + long + '" logo="' + logo_main + '" slug="' + slug + '" company="' + company + '" title="' + internship + '" location="' + location + '" period="' + period + '" lastdate="' + lastDate + '"></span><div class="' + type + '"><div class="col-md-3 col-xs-3 pt-10 p-0"><div class="sidebar-logo-main">' + logo + '</div></div><div class="col-md-9 col-xs-9 pt-5 p-0"><p class="mb-0 text-wrap-ellipsis"><strong>' + internship + '</strong></p><p class="mb-5 text-wrap-ellipsis">' + company + '</p></div></div></div></li>');
            utilities.initials();
            check_list();
        }
    }
}

function Ajax_call(itemid) {
    $.ajax({
        method: "POST",
        url: "/jobs/item-id",
        data: {
            'itemid': itemid
        }
    }).done(function(data) {
        check_list();
        if(data.status == 200){
            toastr.success(data.message, 'Success');
        } else if(data.status == 201) {
            toastr.error(data.message, 'Error');
        } else if (data.status == 'short') {
            toastr.success(data.message, 'Reviewed Success');
        } else if (data.status == 'unshort') {
            toastr.success(data.message, 'Unreviewd Success');
        } else if (data == 'error') {
            alert('Please Login first..');
        }
    });
}

$(document).on('click', '.application-card-add', function(event) {
    var c_user = "$c_user";
    if(c_user == ""){
        $('#loginModal').modal('show');
    } else{
        widget($(this).closest('.application-card-main'));
        event.preventDefault();
        check_list();
        var itemid = $(this).closest('.application-card-main').attr('data-id');
    }
});

$(document).on('click', '.close', function(event) {
    event.preventDefault();
    $(this).closest('.draggable-item').remove();
    check_list();
    var itemid = $(this).attr('data-id');
    Ajax_call(itemid);
});

function check_list() {
    if($('#ilist').find('li').length > 0){
        $('#hidder').slideUp();
    } else {
        $('#hidder').slideDown();
    }
}

function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var footer_top = $("#footer").offset().top;
    var div_top = $('#sticky-anchor').offset().top;
    var div_height = $("#sticky").height();

    var padding = 20; // tweak here or get from margins etc

    if (window_top + div_height > footer_top - padding)
        $('#sticky').css({
            top: (window_top + div_height - footer_top + padding) * -1
        })
    else if (window_top > div_top) {
        $('#sticky').addClass('stick');
        $('#sticky').css({
            top: 0
        })
    } else {
        $('#sticky').removeClass('stick');
    }
}

$(function() {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

var ps = new PerfectScrollbar('#review-internships');
$(document).on('click', '.review-list-toggler', function() {
    $('.sidebar-review-bar').toggleClass('review-open');
});
   //});

JS;
if(!$hide_detail) {
$this->registerJs("
$(document).on('click','li.draggable-item .opens', function(){
    var data_main = $(this).children('span');
    $('#pop_up_modal').modal('toggle');
    $('#pop_up_modal').load('/jobs/job-detail?eaidk='+ data_main.attr('slug') + '&type=$a_type');
});
");
}
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<script id="review-cards" type="text/template">
    {{#.}}
    <li class="draggable-item" data-id="{{application_id}}" data-key="{{data_key}}">
        <a class="close" data-id="{{application_id}}" href="#" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </a>
        <div class="opens product set-scrollbar iconbox-border iconbox-theme-colored shadow pb-5">
            <span id="set-types" type="{{type}}" slug="{{slug}}" lat="{{latitude}}" long="{{longitude}}" logo="{{logo}}"
                  company="{{org_name}}" title="{{title}}" location="{{city}}" period="" lastdate=""></span>
            <div class="col-md-3 col-xs-3 pt-10 p-0">
                <div class="sidebar-logo-main">
                    {{#logo}}
                    <img class="side-bar_logo" src="{{logo}}" height="40px">
                    {{/logo}}
                    {{^logo}}
                    <canvas class="user-icon" name="{{org_name}}" width="40" height="40" color="{{color}}"
                            font="22px"></canvas>
                    {{/logo}}
                </div>
            </div>
            <div class="col-md-9 col-xs-9 pt-5 p-0">
                <p class="mb-0 text-wrap-ellipsis">
                    <strong>{{title}}</strong>
                </p>
                <p class="mb-5 text-wrap-ellipsis">{{org_name}}</p>
            </div>
        </div>
    </li>
    {{/.}}
</script>