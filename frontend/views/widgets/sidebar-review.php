<?php
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="profile">
    <div id="sticky-anchor"></div>
    <div class="side-menu" id="sticky">
        <div class="profile-sidebar">
            <div class="row">

                <?php if (empty($reviews)) { ?>
                    <div class="col-md-12">
                        <p id="hidder">Click on plus button or <br>drag and drop any<br><?= $type; ?> to review<br>it later on.</p>
                    </div>
                <?php } ?>
            </div>
            <div id="review-internships" style="background-color: #fff;" class="font-georgia">
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
                <i class="side-loader fa fa-circle-o-notch fa-spin fa-fw" style="display: none;"></i>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
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
    height: calc(100vh - 40px);
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
  cursor:move;
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
    height:58px;
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
');

$script = <<<JS
//var internships = ;
var sidebarpage = 0;
//$(document).ready(function () {
        
    $.ajax({
        method: "GET",
        url : "/jobs/review-list?sidebarpage="+sidebarpage,
        success: function(response) {
            reviewlists(response);
            check_list();
        }
    });
                
function reviewlists(response){
        
    $(".loader-inner-main").hide();
    
        var review = $('#review-cards').html();
        $("#ilist").append(Mustache.render(review, response.cards));
}


    init();

    function init() {
        $(".loader-inner-main").show();
        $(".loader-inner-main").hide();

        $(".droppable-area").sortable({
            connectWith: ".connected-sortable",
            stack: '.connected-sortable ul'
        }).disableSelection();
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
            $('#ilist').append(widget(ui.draggable));
            var itemid = $.trim(ui.draggable.attr('data-key'));
            var me = ui.draggable.clone();
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
    var lastDate = $.trim(selector.find('.lastDate').text());
    var lat = $.trim(selector.find('.location').attr('data-lat'));
    var long = $.trim(selector.find('.location').attr('data-long'));
    var dataId = $.trim(selector.attr("data-id"));
    var dataKey = $.trim(selector.attr("data-key"));
    if(!logo){
       logo = '<canvas class="user-icon image-partners" name="'+company+'" color="'+logo_color+'" width="40" height="40" font="18px"></canvas>';
    }else{
        logo = '<img class="side-bar_logo" src="' + logo + '" height="40px">'
    }
    droppingWidgets(type, logo, logo_main, internship, company, location, period, lastDate, lat, long, dataKey, dataId);
}

function droppingWidgets(type, logo, logo_main, internship, company, location, period, lastDate, lat, long, dataKey, dataId) {
    if ($("#review-internships > ul > li").length == 0) {
        Ajax_call(dataId);
        $("#ilist").append('<li class="draggable-item" data-key="' + dataKey + '" data-id="' + dataId +'" ><div class="opens product set-scrollbar iconbox-border iconbox-theme-colored shadow pb-5"><span id="set-types" type="' + type + '" lat="' + lat + '" long="' + long + '" logo="' + logo_main + '" company="' + company + '" title="' + internship + '" location="' + location + '" period="' + period + '" lastdate="' + lastDate + '"></span><div class="' + type + '"><div class="col-md-3 col-xs-3 pt-10 p-0"><div class="sidebar-logo-main">' + logo + '</div></div><div class="col-md-9 col-xs-9 pt-5 p-0"><p class="mb-0"><strong>' + internship + '</strong><a class="close" href="#" data-id="' + dataId + '" aria-label="Close"><span aria-hidden="true">&times;</span></a></p><p class="mb-5">' + company + '</p></div></div></div></li>');
        utilities.initials();
    } else {
        var dataArr = [];

        $('ul > li.draggable-item').each(function(i) {
            dataArr.push($(this).attr('data-key'));
        });
        if (jQuery.inArray(dataKey, dataArr) != '-1') {
            return false;
        } else {
            Ajax_call(dataId);
            $("#ilist").append('<li class="draggable-item" data-key="' + dataKey + '" data-id="' + dataId +'" ><div class="opens product set-scrollbar iconbox-border iconbox-theme-colored shadow pb-5"><span id="set-types" type="' + type + '" lat="' + lat + '" long="' + long + '" logo="' + logo_main + '" company="' + company + '" title="' + internship + '" location="' + location + '" period="' + period + '" lastdate="' + lastDate + '"></span><div class="' + type + '"><div class="col-md-3 col-xs-3 pt-10 p-0"><div class="sidebar-logo-main">' + logo + '</div></div><div class="col-md-9 col-xs-9 pt-5 p-0"><p class="mb-0"><strong>' + internship + '</strong><a class="close" href="#" data-id="' + dataId + '" aria-label="Close"><span aria-hidden="true">&times;</span></a></p><p class="mb-5">' + company + '</p></div></div></div></li>');
            utilities.initials();
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
        if (data == 'error') {
            alert('Please Login first..');
        }
    });
}

$(document).on('click', '.application-card-add', function(event) {
    widget($(this).closest('.application-card-main'));
    event.preventDefault();
    check_list();
    var itemid = $(this).closest('.application-card-main').attr('data-id');
});

$(document).on('click', '.close', function(event) {
    event.preventDefault();
    $(this).closest('.draggable-item').remove();
    check_list();
    var itemid = $(this).attr('data-id');
    Ajax_call(itemid);
});

function check_list() {
    if (!$('#ilist').html().length > 0) {
        $('#hidder').slideDown();
    } else {
        $('#hidder').slideUp();
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

   //});

JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<script id="review-cards" type="text/template">
    {{#.}}
    <li class="draggable-item" data-id="{{application_id}}" data-key="{{data_key}}" >
    <div class="opens product set-scrollbar iconbox-border iconbox-theme-colored shadow pb-5">
    <span id="set-types" type="{{type}}" lat="{{latitude}}" long="{{longitude}}" logo="{{logo}}" company="{{org_name}}" title="{{title}}" location="{{city}}" period="" lastdate=""></span>
    <div class="col-md-3 col-xs-3 pt-10 p-0">
    <div class="sidebar-logo-main">
        {{#logo}}
            <img class="side-bar_logo" src="{{logo}}" height="40px">
        {{/logo}}
        {{^logo}}
            <canvas class="user-icon" name="{{org_name}}" width="40" height="40" color="{{color}}" font="22px"></canvas>
        {{/logo}}
    </div>
    </div>
    <div class="col-md-9 col-xs-9 pt-5 p-0">
    <p class="mb-0">
    <strong>{{title}}</strong>
    <a class="close" data-id="{{application_id}}" href="#" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </a>
    </p>
    <p class="mb-5">{{org_name}}</p>
    </div>
    </div>
    </li>
    {{/.}}
</script>