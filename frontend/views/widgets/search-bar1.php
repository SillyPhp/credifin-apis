<?php
use yii\helpers\Url;
Yii::$app->view->registerJs('var _type = "' . $type . '"', \yii\web\View::POS_HEAD);
?>
<div class="col-md-12">
    <div class="overlay-white-9">
        <div id="header-search">
            <form class="form-inline" action="/" method="GET" id="search_bar_form">
                <div class="set-scroll-fixed mb-20">
                    <div class="row content-search">
                        <div class="col-md-5 col-xs-12 col-sm-6">
                            <div class="input-group">
                                <span style="width: 40px;" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <?php
                                    if(Yii::$app->request->get('keyword')){
                                ?>
                                <input type="text" id="keywords" name="keyword" value="<?=str_replace("-"," ",Yii::$app->request->get('keyword')); Yii::$app->request->get('company');?>" class="form-control">
                                        <?php }else{ ?>
                                        <input type="text" id="keywords" name="keyword" placeholder="<?= (($placeholder)?$placeholder:'Job Title or Keywords or Company') ?>" class="form-control">
                                        <?php }?>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12 col-sm-6">
                            <div class="input-group display-flex">
                                <span class="input-group-addon set-heights"><i class="fas fa-map-marker-alt fa-lg"></i></span>
                                <?php
                                if(Yii::$app->request->get('location')){
                                    ?>
                                    <input type="text" name="location" id="cities" value="<?=str_replace("-"," ",Yii::$app->request->get('location'))?>" class="form-control">
                                <?php }else{ ?>
                                    <input type="text" name="location" id="cities" placeholder="Location" class="form-control">
                                <?php }?>
                                <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12 col-sm-6 text-center">
                            <input type="submit" class="form-control submit-next hvr-float search-button" id="form_control_1" value="Search">
                        </div>
                    </div>
                </div>
                <?php
                if ($category) {
                    echo $this->render('search-bar-categories', [
                        'category_type' => $category,
                        'designations' => $designations,
                        'industry' => $industry,
                        'locations' => $locations,
                    ]);
                }
                ?>
            </form>
            <div id="search_preview">
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.twitter-typeahead input{
    width:100% !important;
}
#header-search{height:55px;}
.input-group{
    width: 100%;
    margin-bottom:10px;
}
.input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group{
    height: 45px;
}
.display-flex{
    display: inline-flex !important;
}
.set-heights{
    line-height:31px;
}
.preview_tags{
    position:relative;
    padding: 8px 10px;
    background-color: #f5f5f5;
    margin: 5px;
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
    width: 80.3%;
    margin-top: 0;
    border-bottom: 1px solid #ccc;
    z-index: 999;
    -webkit-box-shadow: 0 8px 5px -6px #ccc;
    -moz-box-shadow: 0 8px 5px -6px #ccc;
    box-shadow: 0 8px 5px -6px #ccc;
    background-color:#fff;
}
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
    background-color: #ed4303 !important;
    color: #fff;
    border-color: transparent;
    border-radius: 4px;
    width:100% !important;
}
@media only screen and (max-width: 991px) {
    #header-search {
        height: 110px;
    }
    .stickyheader {
        width: 69.3%;
    }
    .twitter-typeahead input{
        width:100% !important;
    }
}
@media only screen and (max-width: 767px) {
    .stickyheader {
        width: auto;
        position: relative !important;
        top: 0 !important;
        background-color: transparent;
        border-bottom: none !important;
        box-shadow: none;
    }
    #header-search {
        height: 225px;
    }
    .set-heights {
        padding-right: 30px;
    }
}
@media screen and (max-width: 1160px) and (min-width: 992px) {
    .twitter-typeahead input{
        max-width:165px;
    }
    .twitter-typeahead .tt-menu{
        max-width:165px;
    }
}
');
$script = <<< JS
$(document).on('submit','#search_bar_form',function(e) {
  e.preventDefault();
  var cname = $('#cities').val().trim().replace(/[^a-z0-9\s]/gi, ''); 
  var kname = $('#keywords').val().trim().replace(/[^a-z0-9\s]/gi, '');
  if (cname =="" && kname =="")
      {
          window.location.assign('/jobs/list');
      }
  if (cname&&kname)  
      {
          window.location.assign('/'+kname.replace(/\s+/g, '-')+'-'+_type+'-in-'+cname.replace(/\s+/g, '-'));
      }
  else if (cname) 
      {
          window.location.assign('/'+_type+'-in-'+cname.replace(/\s+/g, '-'));
      }
  else if (kname)
      {
          window.location.assign('/'+kname.replace(/\s+/g, '-')+'-'+_type);
      } 
})     
var searchelem = document.getElementById("search_preview");    
var getParams = function (url) {
	var params = {};
	var parser = document.createElement('a');
	parser.href = url;
	var query = parser.search.substring(1);
	var vars = query.split('&');
	for (var i = 3; i < vars.length; i++) {
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
                if(!($.trim(value)==="") && value != "undefined"){
                    results.push(value);
       
                    $("#search_preview").append("<span class='preview_tags'>"+ value +"<a href='#'><i class='fas fa-times'></i></a></span>");
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
   cache:true,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
      $('.Typeahead-spinner').hide();
  });
        
$(window).scroll(function () {
    if( $(window).scrollTop() > $('.set-scroll-fixed').offset().top + 120 && !($('.set-scroll-fixed').hasClass('stickyheader'))){
        $('.set-scroll-fixed').addClass('stickyheader').animate({"top":"60px"}, 1000);
    } else if ($(window).scrollTop() == 0){
        $('.set-scroll-fixed').removeClass('stickyheader').css({"top":"-100%"});
    }
});
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
