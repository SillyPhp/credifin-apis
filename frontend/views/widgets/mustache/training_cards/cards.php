<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-6 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}" class="training-card-main">
            {{#city}}
                <span class="training-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}" data-locations="">
                <i class="fas fa-map-marker-alt"></i> {{city}}</span>
            {{/city}}
            {{^city}}
                <span class="training-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}" data-locations="">
                <i class="fas fa-map-marker-alt"></i>&nbsp;All India</span>
            {{/city}}
            <div class="training-flex">
                <div class="training-card-img">
                    <a href="{{organization_link}}" title="{{organization_name}}">
                        {{#logo}}
                        <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{organization_name}}" width="90" height="90"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="training-card-description">
                    <a href="{{link}}" title="{{title}}"><h4 class="training-title">{{title}}</h4></a>
                    <p class="org_name">{{organization_name}}</p>
                    <div class="duration-clock">
                        {{#duration}}
                        <h5><i class="far fa-calendar-alt"></i>&nbsp;{{duration}}</h5>
                        {{/duration}}
                        {{#timings}}
                        <h5><i class="far fa-clock"></i>&nbsp;{{timings}}</h5>
                        {{/timings}}
                        {{#fees}}
                        <h5>Fees: <i class="fas fa-rupee-sign"></i>&nbsp;{{fees}}</h5>
                        {{/fees}}
                        {{^fees}}
                        <h5>N/A</h5>
                        {{/fees}}
                    </div>
                </div>
            </div>
            <div class="training-card-wrapper">
                <a href="{{link}}" class="application-card-open training-detail" target="_blank" title="View Detail">View Detail</a>
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
    var noRows = Math.ceil(cardsLength / 3);
    var j = 0;
    for(var i = 1; i <= noRows; i++){
        $(container).append('' + Mustache.render(card, cards.slice(j, j+3)) + '');
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
                        $('#sticky').addClass('drag-on');
                        $('#review-internships').addClass('drop-on');
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
JS;
$this->registerJs($script);
$this->registerCss('
.training-card-main {
    box-shadow: 0 0 4px 0px rgb(0 0 0 / 20%);
    margin-bottom: 25px;
    padding: 15px 15px 0;
    position: relative;
    border-radius:8px;
}
.training-card-type.location {
    position: absolute;
    right: -1px;
    top: -1px;
    background-color: #63c6f0;
    font-family: "Roboto";
    color: #fff;
    padding: 1px 8px;
    border-radius: 0 8px 0 8px;
}
.training-flex {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
.training-card-img img, .training-card-img canvas {
    width: 90px;
    height: 90px;
    display: inline-block;
}
.training-card-description {
    margin-left: 8px;
}
h4.training-title {
    color: #000;
    font-size: 16px;
    font-family: roboto;
    font-weight: 500;
    margin: 10px 0 0;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-transform:capitalize;
}
p.org_name {
    font-size: 14px;
    font-family: roboto;
    color: #63c6f0;
    font-weight:500;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.duration-clock{height:70px;}
.duration-clock h5 {
    margin: 5px 0;
    font-family: "Roboto";
    font-weight:500;
}
.training-card-wrapper {
    text-align: center;
    padding: 5px 0; 
    border-top: 1px solid #eee;
    margin-top:5px;
}
.training-detail{
    font-family:roboto;
    font-weight:500;
}
.training-detail:hover{
    color:#63c6f0;
    transition:all .1s;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);