<?php
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
switch ([$controller_id, $action_id]){
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
                        <a href="{{organization_link}}" title="{{organization_name}}">
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
                        <a href="{{organization_link}}" title="{{organization_name}}" style="text-decoration:none;">
                            <h4 class="org_name comp-name org_name">{{organization_name}}</h4>
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
                        <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                        </span>
                    {{/city}}
                    </span>
                    <div class="detail-loc application-card-description">
                        <div class="job-loc">
                            {{#salary}}
                            <h5 class="salary">{{salary}}</h5>
                            {{/salary}}
                            {{^salary}}
                            <h5 class="salary">Negotiable</h5>
                            {{/salary}}
                            {{#type}}
                            <h5 class="salary">{{type}}</h5>
                            {{/type}}
                            {{#experience}}
                            <h5 class="salary"><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                            {{/experience}}
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="tag-box">
                            <div class="tags">
                                {{#skill}}
                                <span class="after">{{.}}</span>
                                {{/skill}}
                                {{^skill}}
                                <span class="after">Multiple Skills</span>
                                {{/skill}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="application-card-wrapper">
                    <a href="{{link}}" class="application-card-open" title="View Detail">View Detail</a>
                    <a href="#" class="<?= $btn_id ?>" title="Add to Review List">&nbsp;<i class="fas fa-plus"></i>&nbsp;</a>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$c_user = Yii::$app->user->identity->user_enc_id;
$script = <<<JS
let loader = false;
let draggable = false;
let review_list_draggable = false;
let page = 0;
function renderCards(cards, container){
    var card = $('#application-card').html();
    var cardsLength = cards.length;
    if(cardsLength%3 !==0 && loader === true) {
        $('#loadMore').hide();
    }
    for(var i=0; i<cards.length; i++){
        if(cards[i].skill != null){
            cards[i].skill = cards[i].skill.split(',')
        } else {
            cards[i].skill = [];
        }
    }
    var noRows = Math.ceil(cardsLength / 3);
    var j = 0;
    for(var i = 1; i <= noRows; i++){
        $(container).append('<div class="row">' + Mustache.render(card, cards.slice(j, j+3)) + '</div>');
        j+=3;
    }
    checkSkills();
    // showSkills();
}

function getCards(type = 'Jobs',container = '.blogbox', url = window.location.pathname, location = "") {
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
    data['location'] = location;
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
            } else {
                if(loader === true) {
                    if(page === 1) {
                        $(container).append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
                    }
                    $('#loadMore').hide();
                    load_more_cards = false;
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

function checkSkills(){
    $('.application-card-main').each(function(){
       var elems = $(this).find('.after');
       var i = 0;
       $(elems).each(function() {
            if($(this).width() > 100 && $(this).text() != 'Multiple Skills' || i >= 2){
                $(this).addClass('hidden');
            }
            i++;
       });
       var skillsMain = $(this).find('.tags');
       var hddn = $(this).find('.after.hidden');
       var hasMore = $(this).find('span.more-skills');
       if(hddn.length != 0){
           if(elems.length === hddn.length){
               $(elems[0]).removeClass('hidden');
               var countMore = hddn.length - 1;
               if(countMore != 0 && hasMore.length == 0){
                   skillsMain.append('<span class="more-skills">+ ' + countMore + '</span>');
               }
           } else if(hasMore.length == 0) {
                skillsMain.append('<span class="more-skills">+ ' + hddn.length + '</span>');
           }
       }
    });
}
JS;
$this->registerJs($script);
$this->registerCss('
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
    padding-top: 15px;
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
}
.salary{ 
    padding-left: 16px;
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