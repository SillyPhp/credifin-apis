<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main shadow">
            <div class="app-box">
                <div class="row">
                    <div class="col-md-3">
                        <div class="application-card-img img-main">
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
                    </div>
                    <div class="col-md-9">
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
                        <div class="detail-loc">
                            <div class="application-card-description job-loc">
                                {{#salary}}
                                <h5 class="salary"><i class="fas fa-rupee-sign"></i>&nbsp;{{salary}}</h5>
                                {{/salary}}
                                {{^salary}}
                                <h5 class="salary">Negotiable</h5>
                                {{/salary}}
                                {{#type}}
                                <h5>{{type}}</h5>
                                {{/type}}
                                {{#experience}}
                                <h5><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                                {{/experience}}
                            </div>
                            <div class="clear"></div>
                        </div>
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
                    <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i
                                class="fas fa-plus"></i>&nbsp;</a>
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
}

function getCards(type = 'Jobs',container = '.blogbox', url = window.location.pathname) {
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
                // checkSkills();
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
// function checkSkills(){
//     $('.application-card-main').each(function(){
//        var elems = $(this).find('.after');
//        $(elems).each(function() {
//            console.log($(this).text());
//             if($(this).width() > 100 && $(this).text() != 'Multiple Skills'){
//                 $(this).addClass('hidden');
//             }
//        })
//     });
// }
JS;
$this->registerJs($script);
$this->registerCss('
.application-card-description{
    margin:0 0 0 14px !important;
    width:100% !important;
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
}
.img{
    max-width: 66px;
}
.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    display: block;
    vertical-align: middle;
    padding-left: 12px;
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
    right: 2px !important;
    top: -13px !important;
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
    font-size: 19px;
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
.img-main{
    display: inline-block;
}
.comps-name-1{
    float: none;
    margin: 0px !important;
}
@media only screen and (max-width: 360px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 768px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 974px){
    .salary{ 
        padding-left: 16px;
    }
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}

}
/*cards-box css*/

');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);