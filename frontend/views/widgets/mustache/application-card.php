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
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
                 class="application-card-main">
                <div class="app-box">
                    <div class="app-card-main">
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
                        <div class="ji-city">
                            {{#city}}
                            <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                                  data-long="{{longitude}}"><i class="fas fa-map-marker-alt"></i>&nbsp;{{city}}
                                </span>
                            {{/city}}
                            {{^city}}
                            <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                                  data-long="{{longitude}}" data-locations=""><i
                                        class="fas fa-map-marker-alt"></i>&nbsp;Work From Home
                                </span>
                            {{/city}}
                        </div>
                        <div class="side-description" data-slug="{{application_slug}}">
                            <div class="ji-title">
                                <a href="{{link}}" title="{{title}}" class="application-title capitalize">
                                    {{title}}
                                </a>
                            </div>
                            <div class="ji-orgname">
                                <a href="{{link}}" target="_blank" title="{{organization_name}}">
                                    <h4 class="org_name comp-name org_name">{{{organization_name}}}</h4>
                                </a>
                            </div>
                            <div class="ji-salarydata">
                                {{#salary}}
                                <h5 class="salary">{{salary}}</h5>
                                {{/salary}}
                                {{^salary}}
                                {{#sal}}
                                <h5 class="salary"><a href="{{link}}" target="_blank"><i
                                                class="far fa-money-bill-alt"></i> View In Details</a></h5>
                                {{/sal}}
                                {{^sal}}
                                <h5 class="salary">Undisclosed</h5>
                                {{/sal}}
                                {{/salary}}
                                {{#type}}
                                <h5 class="salary">{{type}}</h5>
                                {{/type}}
                                {{#experience}}
                                <h5 class="salary"><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                                {{/experience}}
                                {{#sector}}
                                <h5 class="salary"><i class="fas fa-puzzle-piece"></i> : {{sector}}</h5>
                                {{/sector}}
                            </div>
                        </div>
                    </div>
                    <div class="application-card-bottom">
                        <?php
                        if (!Yii::$app->user->isGuest) {
                            ?>
                        {{#unclaimed_organization_enc_id}}
                        <?php
                        if (Yii::$app->user->identity->organization->organization_enc_id) {
                            ?>
                            <a href="javascript:;" class="ji-apply disabled no-anim" title="Apply Now">Apply Now</a>
                            <?php
                        } else {
                            ?>
                            <a href="{{link}}" target="_blank" class="ji-apply" title="Apply Now">Apply Now</a>
                        <?php
                        }
                        ?>
                        {{/unclaimed_organization_enc_id}}
                        {{^unclaimed_organization_enc_id}}
                            {{#applied}}
                            <a href="javascript:;" class="ji-apply no-anim" title="Applied">Applied</a>
                            {{/applied}}
                            {{^applied}}
                                <a href="javascript:;" data-app="{{application_id}}" data-org="{{organization_enc_id}}" class="ji-apply <?= ((Yii::$app->user->identity->organization->organization_enc_id) ? 'disabled no-anim' : 'applyApplicationNow')?> {{application_id}}-apply-now" title="<?= ((Yii::$app->user->identity->organization->organization_enc_id) ? 'Login as Candidate' : 'Apply Now')?>">Apply Now</a>
                            {{/applied}}
                        {{/unclaimed_organization_enc_id}}
                        <?php
                        } else{
                        ?>
                            <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ji-apply" title="Apply Now">Apply Now</a>
                        <?php
                        }
                        ?>
                        <a href="{{link}}" class="application-card-open" target="_blank" title="View Detail">View Detail</a>
                        <a href="javascript:;" class="<?= $btn_id ?> ji-plus-btn" title="Add to Review List">&nbsp;<i
                                    class="fas fa-plus"></i>&nbsp;</a>
                        <a href="javascript:;" class="share-b" title="Share">&nbsp;<i class="fas fa-share-alt"></i>&nbsp</a>
                        <div class="sharing-links">
                            <div class="inner">
                                <div class="fb">
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . Url::to('{{share_link}}', 'https')); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="j-facebook j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                       title="Share on Facebook">
                                        <span><i class="fab fa-facebook-f"></i></span></a>
                                </div>
                                <div class="wts-app">
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . Url::to('{{share_link}}', 'https')); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="j-whatsapp share_btn tt" type="button" data-toggle="tooltip"
                                       title="Share on Whatsapp">
                                        <span><i class="fab fa-whatsapp"></i></span>
                                    </a>
                                </div>
                                <div class="tw">
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . Url::to('{{share_link}}', 'https')); ?>', '_blank', 'width=800,height=400,left=200,top=100');"

                                       class="j-twitter share_btn tt" type="button" data-toggle="tooltip"
                                       title="Share on Twitter">
                                        <span><i class="fab fa-twitter"></i></span></a>
                                </div>
                                <div class="linkd">
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . Url::to('{{share_link}}', 'https')); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                       title="Share on LinkedIn">
                                        <span><i class="fab fa-linkedin"></i></span></a>
                                </div>
                                <div class="male">
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('mailto:?&body=' . Url::to('{{share_link}}', 'https')); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                       title="Share via E-Mail">
                                        <span><i class="far fa-envelope"></i></span></a>
                                </div>
                                <div class="tele">
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://t.me/share/url?url=' . Url::to('{{share_link}}', 'https')); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                       title="Share on Telegram">
                                        <span><i class="fab fa-telegram-plane"></i></span></a>
                                </div>
                                <div class="copy-app-link">
                                    <a href="javascript:;" class="clipb tt detail-clipboard" type="button" data-toggle="tooltip"
                                       title="Copy Link" data-link="{{link}}">
                                        <i class="fas fa-clipboard"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
    <div class="modal fade bs-modal-lg in" id="job-apply-widget-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="applyModalData">

            </div>
        </div>
    </div>
    <div class="modal fade bs-modal-lg in" id="job-resume-widget-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="appResumeModalData">

            </div>
        </div>
    </div>
<?php
echo $this->render('/widgets/employer_applications/applied-modal-common');
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
let grand_parent;
let internships_parent;
let page = 0;
function renderCards(cards, container){
    var card = $('#application-card').html();
    var cardsLength = cards.length;
    if(cardsLength%3 !==0 && loader === true) {
        $('#loadMore').css('display','none');
    }
    // var noRows = Math.ceil(cardsLength / 3);
    // var j = 0;
    // for(var i = 1; i <= noRows; i++){
        let allDataRow = $('<div class="row"></div>').append(Mustache.render(card, cards));
        $(container).append(allDataRow);
        // $(container).append('<div class="row">' + Mustache.render(card, cards.slice(j, j+3)) + '</div>');
        // j+=3;
    // }
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
                            if(grand_parent){
                                $(grand_parent).addClass('hidden');
                            }
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
            sticky_relocate();
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

$(document).on('click', '.applyApplicationNow', function() {
    $('#applyModalData').html('<div class="p-20"><i class="fas fa-circle-notch fa-spin fa-fw"></i> Loading...</div>')
    let app_id = $(this).attr('data-app');
    let org_id = $(this).attr('data-org');
    $('#job-apply-widget-modal').modal('show');
     $.ajax({
            method: "POST",
            url : "/jobs/application-apply-modal",
            data:{app_id:app_id,org_id:org_id},
            success: function(response) {
                $('#applyModalData').html(response);
            }
    })
})

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
$(document).on('click', '.share-b', function(){
    let parentElem = $(this).parentsUntil('.app-box').parent();
    $(parentElem).find('.sharing-links').toggleClass('moveright');
    });

$(document).on('mouseleave', '.app-box', function(){
    $(this).find('.sharing-links').removeClass('moveright');
});
$(document).on('click', '.detail-clipboard',function (event) {
            event.preventDefault();
            var link = window.location.hostname + $(this).attr('data-link');
            CopyClipboard(link, true, "Link copied");
        });
function CopyClipboard(value, showNotification, notificationText) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val(value).select();
        document.execCommand("copy");
        temp.remove();
        toastr.success("", "Link Copy to Clipboard");
    }
JS;
$this->registerJs($script);
$this->registerCss('
.ji-apply.disabled{
    cursor:not-allowed;
} 
.moveright{right:13% !important;}
.app-box {
    text-align: left;
    padding: 22px 0 0;
    border-radius: 8px;
    position: relative;
    background: #fff;
    overflow: hidden;
    box-shadow: 0 0 8px 0px #c7c7c7;
}
.app-card-main {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    padding:0 10px;
    min-height:124px;
}
.job-fill {
    padding: 2px 10px !important;
    background-color: #63c6f0 !important;
    color: #fff !important;
    border-radius: 0px 8px 0px 8px !important;
    position: absolute !important;
    right: 0px !important;
    top: 0px !important;
    max-width: 200px;
    letter-spacing: .3px;
    font-size: 12px;
}
.application-card-img {
    display: inline-block;
//    box-shadow: 0 0 8px 0px #eee;
//    border-radius: 50%;
    overflow: hidden;
    min-width: 90px;
    text-align: center;
    line-height: 85px;
    height: 90px;
    width: 90px;
    margin-top:10px;
}
.application-card-img img, .application-card-img canvas {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.ji-title a {
    color: black;
    font-size: 16px;
    font-family:roboto;
    font-weight: 500;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.salary{ 
    font-family:roboto;
    text-transform: capitalize;
    font-size:14px;
    font-weight:500 !important;
    margin:5px 0 0;
}
.application-card-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #ececec;
    margin-top: 5px;
    padding-right: 10px;
    width:100%;
    position:relative;
}
.ji-apply, .ji-apply:focus {
    font-family: Roboto;
    background-color: #ff7803;
    color: #fff;
    padding: 4px 0px;
    font-weight: 500;
    text-align: center;
    display: inline-block;
    width: 35%;
    transition:all .2s;
}
.ji-apply:hover{
    color: #fff;
    transform:scale(1.1);
}
.no-anim:hover{
    transform:scale(1);
}
.application-card-open {
    width: 35%;
    text-align: center;
    font-weight: 500;
    font-family: Roboto;
    display: inline-block;
    padding: 4px 0;
}
.application-card-open:hover {
    color: #00a0e3;
    transition: all .1s;
    transform:scale(1.1);
}
.ji-plus-btn, .ji-plus-btn:focus{
    color: #ff7803;
    width: 10%;
    text-align: center;
}
.ji-plus-btn:hover{
    color:#ff7803;
    transform:scale(1.2);
    transition:all .1s;
    }
.share-b, .share-b:focus{
    color: #00a0e3;
    width: 10%;
    text-align: center;
}
.share-b:hover{
    color:#00a0e3;
    transform:scale(1.2);
    transition:all .1s;
    }
.sharing-links {
    width: calc(100% - 12%);
    height:100%;
    position: absolute;
    right: -90%;
    top: 0px;
    text-align: center;
    background-color: #fff;
    padding: 3px 4px;
    transition:all .5s;
}
.salary, .comp-name, .salary a{
    display: -webkit-box !important;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.side-description {
    width: calc(100% - 105px);
    margin-left:15px;
    position:relative;
    min-height:123px;
}
.city
{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.application-card-main {
    margin-bottom: 20px !important;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
.img{
    max-width: 66px;
}
.inner {
    display: flex;
    justify-content:right;
}
.wts-app i, .fb i, .tw i, .linkd i, .male i, .tele i, .copy-app-link i{
    width: 25px;
    text-align: center;
    border-radius: 50px;
    height: 25px;
    font-size: 14px;
    margin: 0 5px;
    border: 1px solid transparent;
    padding-top: 5px;
    transition:all .3s;
}
.fb i {color: #236dce;}
.fb i:hover {background-color: #236dce;}
.tw i{color: #1c99e9;}
.tw i:hover{background-color: #1c99e9;}
.linkd i{color: #0e76a8;}
.linkd i:hover{background-color: #0e76a8;}
.male i{color: #BB001B;}
.male i:hover{background-color: #BB001B;}
.tele i{color: #0088cc;}
.tele i:hover{background-color: #0088cc;}
.wts-app i{color:#4FCE5D;}
.wts-app i:hover{background-color:#4FCE5D;}
.copy-app-link i{color:#22577A;}
.copy-app-link i:hover{background-color:#22577A;}
.wts-app i:hover, .linkd i:hover, .tw i:hover, .fb i:hover, .male i:hover, .tele i:hover, .copy-app-link i:hover{
	color: #fff;
}
.share-b:hover .sharing-links, .sharing-links:hover{display:block !Important;}
/*cards-box css*/
@media screen and (max-width: 1250px) and (min-width: 992px) {
    .wts-app i, .fb i, .tw i, .linkd i, .male i, .tele i, .copy-app-link i{
        width: 22px;
        height: 22px;
        font-size: 14px;
        margin: 0px 5px;
        padding-top:2px;
    }
    .sharing-links{padding:1px;}
}
@media screen and (max-width: 768px) {
    .inner{justify-content:center;}
}
@media screen and (max-width: 550px) {
  .ji-apply, .application-card-open{
    font-size:12px;
    padding:6px 0;
}
 .wts-app i, .fb i, .tw i, .linkd i, .male i, .tele i, .copy-app-link i{
        font-size: 14px;
        margin: 0px 2px;
        padding-top:3px;
    }
}

');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);