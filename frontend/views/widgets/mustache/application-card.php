<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main">
            {{#city}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;{{city}}
                </span>
            {{/city}}
            {{^city}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;All India
                </span>
            {{/city}}
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="{{organization_link}}">
                        {{#logo}}
                        <img src="{{logo}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{organization_name}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="{{link}}"><h4 class="application-title">{{title}}</h4></a>
                    {{#salary}}
                    <h5><i class="fa fa-inr"></i>&nbsp;{{salary}}</h5>
                    {{/salary}}
                    {{^salary}}
                    <h5>Negotiable</h5>
                    {{/salary}}
                    {{#type}}
                    <h5>{{type}}</h5>
                    {{/type}}
                    {{#experience}}
                    <h5><i class="fa fa-clock-o"></i>&nbsp;{{experience}}</h5>
                    {{/experience}}
                </div>
            </div>
            {{#last_date}}
            <h6 class="col-md-5 pl-20 custom_set2 text-center">
                Last Date to Apply
                <br>
                {{last_date}}
            </h6>
            <h4 class="col-md-7 org_name text-right pr-10">
                {{organization_name}}
            </h4>
            {{/last_date}}
            {{^last_date}}
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{organization_name}}</h4>
            </div>
            {{/last_date}}
            <div class="application-card-wrapper">
                <a href="{{link}}" class="application-card-open">View Detail</a>
                <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$script = <<<JS
let loader = false;
let draggable = false;
let page = 0;
function renderCards(cards){
    var card = $('#application-card').html();
    var cardsLength = cards.length;
    if(cardsLength%3 !==0 && loader === true) {
        $('#loadMore').hide();
    }
    var noRows = Math.ceil(cardsLength / 3);
    var j = 0;
    for(var i = 1; i <= noRows; i++){
        $(".blogbox").append('<div class="row">' + Mustache.render(card, cards.slice(j, j+3)) + '</div>');
        j+=3;
    }
}

function getCards(type = 'Jobs') {
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
        url : window.location.pathname,
        data: data,
        beforeSend: function(){
           $('.loader-main').show();
           $('.load-more-text').css('visibility', 'hidden');
           $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
            $('.loader-main').hide();
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(response.status === 200) {
                renderCards(response.cards);
                utilities.initials();
            } else {
                if(loader === true) {
                    if(page === 1) {
                        $(".blogbox").append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
                    }
                    $('#loadMore').hide();
                }
            }
        }
    }).done(function(){
        if(draggable === true) {
            $.each($('.application-card-main'), function(){
                $(this).draggable({
                    helper: "clone",
                });
            });
        }
    });
}

function addToReviewList(){
    if(loader === false){
        $(document).on('click','.application-card-add', function(event){
             event.preventDefault();
            var itemid = $(this).closest('.application-card-main').attr('data-id');
            $.ajax({
                url: "/jobs/item-id",
                method: "POST",
                data: {'itemid': itemid},
                beforeSend:function(){
        //            $('.loader-aj-main').fadeIn(1000);  
                },
                success: function (response) {
        //        $('.loader-aj-main').fadeOut(1000);
                    if (response.status == '200' || response == 'short') {
                        toastr.success('Added to your Review list', 'Success');
                    } else if (response == 'unshort') {
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
        });
    }
}
JS;
$this->registerJs($script);
$this->registerCss('
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);