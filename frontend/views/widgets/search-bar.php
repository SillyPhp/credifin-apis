<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

$type = Yii::$app->getRequest()->getQueryParam('type');
if (!($type == 'role' || $type == 'industry' || $type == 'location')) {
    $type = NULL;
}
?>
<div class="col-md-12">
    <div class="overlay-white-9">
        <div id="header-search">
            <?php // if ($type) : ?>
            <form action="/service/searched-through-ajax?type=<?= $type; ?>" >
                <?php // endif; ?>
                <!--<nav class="navbar" data-spy="affix" data-offset-top="5">-->
                <div class="set-scroll-fixed mb-20">
                    <div class="row content-search">
                        <div class="col-md-4 col-xs-6 ">
                            <div class="input-group">
                                <input type="text" name="field" placeholder="Job Title, Keywords or Company Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="input-group">
                                <input type="text" name="duration" placeholder="Minimum Salary Per Month" class="form-control">
                                <?php if ($type) : ?>
                                    <input type="hidden" name="type" value="<?= $type; ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="input-group">
                                <input type="text" id="cities" name="city" class="form-control" autocomplete="off" placeholder="City or State"/>
                                <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12 text-center">
                            <!--<button type="submit" class="btn search-button btn_effect" id="searchbtn">-->
                            <input type="submit" class="form-control submit-next hvr-float" id="form_control_1" value="Search">
<!--                                <i class="fa fa-search">
                                </i> Search-->
                            <!--</button>-->
                        </div>
                    </div>
                </div>
                <!--</nav>-->
                <div class="row">
                    <div class="col-md-12 options">
                    </div>
                </div>
                <?php
//                if ($category) {
                echo $this->render('/widgets/search-bar-category-options', [
                    'type' => 'mustache-category-options',
                    'search_type' => $type
                ]);
//                }
                ?>
            </form>
            <div id="search_preview" class="col-md-12">

            </div>

        </div>
    </div>
</div>
<?php
$this->registerCss('
.preview_tags{
    position:relative;
    padding: 8px 10px;
    background-color: #f5f5f5;
    margin: 5px;
    display:inline-block;
    border-radius: 8px;
    box-shadow: 0px 1px 4px 2px #DDD;
}
.preview_tags a{
    position: absolute;
    right: -5px;
    top: -6px;
    width: 16px;
    height: 17px;
    background-color: #fb236a;
    color: #fff;
    border-radius: 50%;
    text-align: center;
    font-size: 10px;
    font-weight: 200;
}
.content-search {
    position: relative;
    background-color: #666666;
    padding: 16px;
    top: 15% !important;
    z-index: 99;
    margin-top: 10px;
    padding-top: 15px;
}
.stickyheader{
    position: fixed;
    top: -100%;
    width: 80.8%;
    margin-top: 0;
    border-bottom: 1px solid #ccc;
    z-index: 999;
    -webkit-box-shadow: 0 8px 5px -6px #ccc;
    -moz-box-shadow: 0 8px 5px -6px #ccc;
    box-shadow: 0 8px 5px -6px #ccc;
    background-color:#fff;
}
//.affix{
//    top: 50px;
//    width: 82.5%;
//    background-color:#fff;
//    z-index: 9999 !important;
//}
.content-search{
    background-color: transparent !important;
    padding:0px 16px !important;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
//  padding: 8px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.twitter-typeahead{
    width:100%;
}
.search-button{
    width:100%;
    background-color: #ed4303 !important;
    color: #fff;
}
.checkbox-label {
    display: inline-block;
    vertical-align: top;
    position: relative;
    width: 100% !important;
    text-align: center;
    cursor: pointer;
    font-size: 16px;
    color: #241d1d;
    font-weight: bold;
    margin: 10px 0px;
    background: #fff;
    border-bottom: 3px solid #ff7803;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 5px;
    -moz-box-shadow: inset 0 0 0 0 black;
    -webkit-box-shadow: inset 0 0 0 0 white;
    box-shadow: inset 0 0 0 0 white;
    -moz-transition: all 0.4s ease;
    -o-transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
}
.checkbox-label:before {
    content: "";
    position: absolute;
    top: 100%;
    left: 3%;
    width: 30px;
    height: 30px;
    opacity: 0;
    background-image: url(/assets/themes/ey/images/pages/jobs/icon1.png);
    background-position: center;
    background-repeat: no-repeat;
    background-size: 24px;
    border-top: none !important;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    -moz-transform: translate(0%, -50%);
    -ms-transform: translate(0%, -50%);
    -webkit-transform: translate(0%, -50%);
    transform: translate(0%, -50%);
    -moz-transition: all 0.4s ease;
    -o-transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
}

.checkbox-text {
    height: 120px;
    line-height: 120px;
    text-align: center;
}
.checkbox-text--title {
    display: inline-block;
    vertical-align: middle;
    line-height: 25px;
    width: 80%;
}
.checkbox-input {
    display: none;
}
.checkbox-input:checked + .checkbox-label {
    -moz-box-shadow: inset 0px -5px 0 0 #ff7803;
    -webkit-box-shadow: inset -5px 0px 0 0 #ff7803;
    box-shadow: inset 0px -5px 0 0 #ff7803;
}
.checkbox-input:checked + .checkbox-label:before {
    top: 0;
    opacity: 1;
}
');
$script = <<<JS
        
var searchelem = document.getElementById("search_preview");    
var getParams = function (url) {
	var params = {};
	var parser = document.createElement('a');
	parser.href = url;
	var query = parser.search.substring(1);
	var vars = query.split('&');
	for (var i = 4; i < vars.length; i++) {
		var pair = vars[i].split('%5B%5D=');
                pair[0] = "" + pair[0] + "" + i;
		params[pair[0]] = decodeURIComponent(pair[1]);
	}
	return params;
};
        var results = [];
        $(document).ready(function(){
        if(Object.keys(getParams(window.location.href))[0]!=""){
            $.each(getParams(window.location.href), function(name, value) {
                value = value.split('+').join(" ");
                if(!($.trim(value)==="")){
                    results.push(value);
       
                    $("#search_preview").append("<span class='preview_tags'>"+ value +"<a href='#'><i class='fa fa-close'></i></a></span>");
                }
            });
        }
        });
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.Typeahead-spinner').hide();
  });
        
var loadIncre = 2;
$(document).ready(function () {
    $(".work-load").slice(0, 3).show();
    
    $('.loader-main').slideDown();
    setTimeout(function() { $(".loader-main").hide(); 
        $(".work-load:hidden").slice(0, 1).fadeIn();
        if ($(".work-load:hidden").length == 0) {
            $(".btn-div").fadeOut('slow');
            $("#loadMore").show();
        }
    }, 2000);
    
    if ($(".blogbox:hidden").length != 0) {
        $(".loader-main").show(); 
    }
        
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        
        $(function(){
            $('a').each(function(){
                $(this).attr('href', $(this).attr('href')+loadIncre);
            });
        });
        $('.loader-main').slideDown();
        
        loadIncre = loadIncre + 1;
        setTimeout(function() { $(".loader-main").hide(); 
            $(".work-load:hidden").slice(0, 1).fadeIn();
            if ($(".work-load:hidden").length == 0) {
                $(".btn-div").fadeOut('slow');
            }
        }, 2000);
        
        
    });
});
        
$("form").submit(function(e) {
    e.preventDefault();
        
    var form = $(this);
    var url = form.attr('action');
    
    var params = form.serialize();

    var urlToSend = "" + url + params + "";
    var urlToDisplay = "/service/searched-results?" + params +"";

    window.history.pushState("object or string", "Jobs", urlToDisplay);
        
    var req = function(){
//        var result = ajax(methodToBe, urlToSend);
//        var resp = result["responseJSON"];
        
        $.ajax({
            method: "GET",
            url : urlToSend,
            beforeSend: function(){
                $('.cards > div').remove();
                $("#search_preview > span").remove();
                $('.loader-main').show();
                $('.load-more-text').css('visibility', 'hidden');
                $('.load-more-spinner').css('visibility', 'visible');
            },
            success: function(response) {
                $('.loader-main').hide();
                $('.load-more-text').css('visibility', 'visible');
                $('.load-more-spinner').css('visibility', 'hidden');
                if(response.status == 200) {
                    var jobCard = $('#application-card').html();
                    for(var i=0; i<response.cards.length;i++){
                        $(".cards").append(Mustache.render(jobCard, response.cards[i]));
                    }
                }
            }
        }).done(function(){
            $.each($('.application-card-main'), function(){
                $(this).draggable({
                    helper: "clone",
                });
            });
            
            var results = [];
            if(Object.keys(getParams(window.location.href))[0]!=""){
                $.each(getParams(window.location.href), function(name, value) {
                    value = value.split('+').join(" ");
                    if(!($.trim(value)==="")){
                        results.push(value);

                        $("#search_preview").append("<span class='preview_tags'>"+ value +"<a href='#'><i class='fa fa-close'></i></a></span>");
                    }
                });
            }
    });
        
        
    }
    foo(req);       
        
});
        
    function foo(req){
        req();
    }
        
$(window).scroll(function () {
    if( $(window).scrollTop() > $('.set-scroll-fixed').offset().top + 120 && !($('.set-scroll-fixed').hasClass('stickyheader'))){
        $('.set-scroll-fixed').addClass('stickyheader').animate({"top":"50px"}, 1000);
    } else if ($(window).scrollTop() == 0){
        $('.set-scroll-fixed').removeClass('stickyheader').css({"top":"-100%"});
    }
});
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
