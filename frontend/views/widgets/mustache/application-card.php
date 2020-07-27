<?php
use yii\helpers\Url;

$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$baseUrl = Url::base(true);
switch ([$controller_id, $action_id]) {
    case ['site', 'load-data'] :
    case ['jobs', 'index'] :
    case ['jobs', ''] :
        $btn_id = 'featured-application-card-add';
        break;
    default :
        $btn_id = 'application-card-add';
}
?>
    <script id="application-card" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
                 class="application-card-main shadow">
                <div class="app-box">
                    <div class="row">
                        <div class="application-card-img">
                            <a href="{{organization_link}}" target="_blank" title="{{organization_name}}">
                                {{#logo}}
                                <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                                {{/logo}}
                                {{^logo}}
                                <canvas class="user-icon" name="{{organization_name}}" width="80" height="80"
                                        color="{{color}}" font="35px"></canvas>
                                {{/logo}}
                            </a>
                        </div>
                        <div class="comps-name-1 application-card-description">
                            <span class="skill">
                                <a href="{{link}}" title="{{title}}" class="application-title capitalize org_name">
                                    {{title}}
                                </a>
                            </span>
                            <a href="{{link}}" target="_blank" title="{{organization_name}}"
                               style="text-decoration:none;">
                                <h4 class="org_name comp-name org_name">{{{organization_name}}}</h4>
                            </a>
                        </div>
                        {{#city}}
                        <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                              data-long="{{longitude}}">
                             <i class="fas fa-map-marker-alt"></i>&nbsp;{{city}}
                        </span>
                        {{/city}}
                        {{^city}}
                        <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                              data-long="{{longitude}}"
                              data-locations="">
                        <i class="fas fa-map-marker-alt"></i>&nbsp;Work From Home
                        </span>
                        {{/city}}
                        </span>
                        <div class="detail-loc application-card-description">
                            <div class="job-loc">
                                {{#salary}}
                                <h5 class="salary">{{salary}}</h5>
                                {{/salary}}
                                {{^salary}}
                                {{#sal}}
                                <h5 class="salary"><a href="{{link}}" target="_blank"><i
                                                class="far fa-money-bill-alt"></i> View In Details</a></h5>
                                {{/sal}}
                                {{^sal}}
                                <h5 class="salary">Negotiable</h5>
                                {{/sal}}
                                {{/salary}}
                                {{#type}}
                                <h5 class="salary">{{type}}</h5>
                                {{/type}}
                                {{#experience}}
                                <h5 class="salary"><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                                {{/experience}}
                                {{#sector}}
                                <h5 class="salary"><i class="fas fa-puzzle-piece"></i>: {{sector}}</h5>
                                {{/sector}}
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="{{link}}" class="application-card-open" target="_blank" title="View Detail">View
                            Detail</a>
                        <a href="#" class="<?= $btn_id ?>" title="Add to Review List">&nbsp;<i class="fas fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$c_user = Yii::$app->user->identity->user_enc_id;
$script = <<< JS
function gitHubJobs() {
  $.ajax({
  method: 'POST',
  url: '/jobs/git-jobs',
  dataType:"json",
  beforeSend: function(){
           $('.load-more-text').css('visibility', 'hidden');
           $('.load-more-spinner').css('visibility', 'visible');
        },
  success: (res) => {
            $('.loader-main').hide();
            $('#loadMore').addClass("loading_more");
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            renderCards(res, '.blogbox');
            utilities.initials();
  } 
})
} 
let loader = false;
let draggable = false;
let review_list_draggable = false;
let return_message = false;
let jobs_parent;
let internships_parent;
let page = 0;
function renderCards(cards, container){
    var card = $('#application-card').html();
    var cardsLength = cards.length;
    if(cardsLength%3 !==0 && loader === true) {
        $('#loadMore').hide();
    }
    var noRows = Math.ceil(cardsLength / 3);
    var j = 0;
    for(var i = 1; i <= noRows; i++){
        $(container).append('<div class="row">' + Mustache.render(card, cards.slice(j, j+3)) + '</div>');
        j+=3;
    }
}

function getCards(type = 'Jobs',container = '.blogbox', url = window.location.pathname, location = "", limit = "", dataType = "") {
    let data = {};
    page += 1;
    const searchParams = new URLSearchParams(window.location.search);
    if(searchParams.has('page')) {
        searchParams.set("page", page);
    } else {
        searchParams.append("page", page);
    }
    for(var pair of searchParams.entries()) {
        data[pair[0]] = pair[1];                                                                                                                                                                                                              ; 
    }
    data['type'] = type;
    if(location !== ""){
        data['location'] = location; 
    }
    if(limit !== ""){
        data['limit'] = limit;
    }
    if(dataType !== ""){
        data['dataType'] = dataType;
    }
    $.ajax({
        method: "POST",
        url : url,
        data: data,
        beforeSend: function(){
           // $('.loader-main').show();
           $('.load-more-text').css('visibility', 'hidden');
           $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
            $('.loader-main').hide();
            $('#loadMore').addClass("loading_more");
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(response.status === 200) { 
                renderCards(response.cards, container);
                utilities.initials();
                localStorage.setItem("displayCity", response.cards[0]['city']);
            } else {
                if(loader === true) {
                    if(page === 1) {
                        $(container).append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
                    }
                    $('#loadMore').hide();
                    load_more_cards = false;
                } else {
                    if(return_message === true){
                        if(type === 'Jobs'){
                            $(jobs_parent).addClass('hidden');
                        } else {
                            $(internships_parent).addClass('hidden');
                        }
                        if($(jobs_parent).hasClass('hidden') && $(internships_parent).hasClass('hidden')){
                            $(jobs_parent).html('<h2 class="text-center">There are no Jobs or Internships in this Company</h2>');
                            $(jobs_parent).removeClass('hidden');
                        }
                    }
                }
            }
        }
    }).done(function(){
        if(draggable === true) {
            $.each($('.application-card-main'), function(){
                $(this).draggable({
                    helper: "clone",
                    drag: function() {
                        var default_elem = $('.application-card-main.ui-draggable.ui-draggable-handle:first-child').width();
                        $('.ui-draggable-dragging').css('width', default_elem + 'px');
                        $('#sticky').addClass('drag-on');
                        $('#review-internships').addClass('drop-on');
                        utilities.initials();
                     },
                     stop: function() { 
                        $('#sticky').removeClass('drag-on');
                        $('#review-internships').removeClass('drop-on');
                     },
                });
            });
        } else {
            var displayCity = localStorage.getItem("displayCity");
            $('#prefer-heading').html('Jobs in ' + displayCity);
            var viewbtn = $('#view-all-application');
            var dis_link = "$baseUrl" + "/jobs-in-";
            viewbtn.prop('href',dis_link + displayCity)
            $('#featured-head').show();
        }
    });
}

$(document).on('click', '.featured-application-card-add', function(event) {
    event.preventDefault();
    var c_user = "$c_user";
    if(c_user === ""){
        $('#loginModal').modal('show');
    } else{
        var itemid = $(this).closest('.application-card-main').attr('data-id');
        getFeaturedCard(itemid);
    }
});

function getFeaturedCard(itemid) {
    $.ajax({
        method: "POST",
        url: "/jobs/item-id",
        data: {'itemid': itemid}
    }).done(function(data) {
        if(data.status === 200){
            toastr.success(data.message, 'Success');
        } else if(data.status === 201) {
            toastr.error(data.message, 'Error');
        } else if (data.status === 'short') {
            toastr.success(data.message, 'Reviewed Success');
        } else if (data.status === 'unshort') {
            toastr.success(data.message, 'Unreviewd Success');
        } else if (data === 'error') {
            toastr.info('Please Login first..');
        }
    });
}


function addToReviewList(){
    if(loader === false){
        $(document).on('click','.application-card-add', function(event){
            event.preventDefault();
            var c_user = "$c_user"
            if(c_user == ""){
                $('#loginModal').modal('show');
                return false;
            }
            var itemid = $(this).closest('.application-card-main').attr('data-id');
            $.ajax({
                url: "/jobs/item-id",
                method: "POST",
                data: {'itemid': itemid},
                beforeSend:function(){
        //            $('.loader-aj-main').fadeIn(1000);  
                },
                success: function (response) {
                    if (response.status == '200' || response.status == 'short') {
                        toastr.success('Added to your Review list', 'Success');
                    } else if (response.status == 'unshort') {
                        toastr.success('Delete from your Review list', 'Success');
                    } else {
                        toastr.error('Please try again Later', 'Error');
                    }
                }
            });
        });
    }
}

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
function checkSkills(){
    $('.application-card-main').each(function(){
       var elems = $(this).find('.after');
       var skillsMain = $(this).find('.tags');
       $(elems).sort(function (a, b) {
            return $(a).width() > $(b).width() ? 1 : -1;  
        }).appendTo(skillsMain);
    });
    checkSkills2();
}
function checkSkills2(){
    var parent_card_main = $('.application-card-main').width() / 3;
    $('.application-card-main').each(function(){
       var elems = $(this).find('.after');
       var skillsMain = $(this).find('.tags');
       var i = 0;
       $(elems).each(function() {
            if($(this).width() > parent_card_main && $(this).text() != 'Multiple Skills' || i >= 3){
                $(this).addClass('hidden');
            }
            i++;
       });
       var hddn = $(this).find('.after.hidden');
       var hasMore = $(this).find('span.more-skills');
       if(hddn.length != 0){
           if(elems.length === hddn.length){
               $(elems[0]).removeClass('hidden');
               var lg_skills = $(elems[0]).width();
               var parent_card = $(elems[0]).parentsUntil('.application-card-main').parent().width() - 60;
               var countMore = hddn.length - 1;
               if(countMore != 0 && hasMore.length == 0){
                   skillsMain.parent().append('<span class="more-skills">+ ' + countMore + '</span>');
               } else if(hasMore.length != 0){
                   skillsMain.parent().children('.more-skills').show();
               }
               if(lg_skills >= parent_card){
                   $(elems[0]).parent().css('display','inherit');
                    $(elems[0]).addClass('lg-skill');
                    $(elems[0]).parent().parent().children('.more-skills').hide();
               } else {
                   $(elems[0]).parent().css('display','inline-block');
               }
           } else if(hasMore.length == 0) {
                skillsMain.parent().append('<span class="more-skills">+ ' + hddn.length + '</span>');
           }
       }
    });
}
JS;
$this->registerJs($script);
$this->registerCss('
.text-center{font-family:roboto;}
.city
{
text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.application-card-description h5{
    margin-top:0px !important;
    margin-bottom: 8px !important;
}
.application-card-main {
    background-color: transparent !important;
    margin-bottom: 20px !important;
    border-radius: 10px;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
.app-box {
    text-align: left;
    padding: 10px;
    border-radius: 10px;
    position:relative;
    background:#fff;
    height:170px;
}
.img{
    max-width: 66px;
}
.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    padding-left: 15px;
    padding-top: 20px;
}
.org_name{display:block;}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.detail-loc{
    margin-top:5px;
}
.location{
    margin-right: 4px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;

}
.city, .city i{
    color: #fff;
}
.show-responsive{
    display:none;
}

.job-fill{
    padding: 5px 10px 4px !important;
    margin: 3px !important;
    background-color:#ff7803 !important;
    color: #fff !important;
    border-radius: 0px 10px 0px 10px !important;
    float: right !important;
    position:absolute !important;
    right: -4px !important;
    top: -3px !important;
    max-width:255px;
}
.clear{
    clear:both;
}
.sal{
    margin-right: 5px;
}
.salary{
    font-family:roboto;
}
.tag-box{
    border-top: 1px solid lightgray;
    padding-left:15px;
    padding-top:10px;
}
.tags{
    font-size: 17px;
    color:gray;
    font-family: Georgia !important;
    display:inline-block;
}
.after{
    padding-right: 25px;
    padding-left: 16px;
}
.after{
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 3px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}
.after::after{
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
.city-box{
    padding-bottom:5px;
}
.ADD-more{
    background-color: #eeeeee;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
}
.more-skills{
    background-color: #00a0e3;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    display:inline-block;
}
.salary{ 
    padding-left: 16px;
    text-transform: capitalize;
}
.lg-skill{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}
@media only screen and (max-width: 974px){
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}
}
/*cards-box css*/
');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);