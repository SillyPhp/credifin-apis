<?php

use yii\helpers\Url;

?>

<script id="closed-card" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <div class="closed-card-main">
            <div class="closed-icon">
                {{#icon}}
                    <img src="<?= Url::to('@commonAssets/categories/'); ?>{{icon}}" width="50px" height="50"/>
                {{/icon}}
                {{^icon}}
                    <canvas class="user-icon" name="{{name}}" width="50" height="50"
                            color="{{color}}" font="22px"></canvas>
                {{/icon}}
            </div>
            <div class="closed-name">{{name}}</div>
            <div class="closed-date">{{last_date}}</div>
            <div class="closed-buttons">
                <a href="" data-id="{{application_enc_id}}" class="modify-app-date">RE-OPEN</a>
                <a href="/account/jobs/{{application_enc_id}}/clone">CLONE</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>

<?php
$this->registerCss('
.closed-card-main {
    box-shadow: 0 0 3px 2px #eee;
    border-radius: 4px;
    text-align: center;
    padding: 20px;
    margin-bottom: 30px;
}
.closed-name {
    color: #00a0e3;
    font-family: roboto;
    font-size: 16px;
    margin: 10px 0 5px;
    text-transform: capitalize;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-weight: 500;
    height: 22px;
}
.closed-date {
    font-family: roboto;
    font-weight: 500;
}
.closed-icon {
    height: 50px;
    width: 50px;
    margin: 0 auto;
}
.closed-buttons a {
    border: 1px solid #00a0e3;
    font-size: 14px;
    padding: 4px;
    display: inline-block;
    width: 80px;
    margin-top: 10px;
    font-family: roboto;
    border-radius: 4px;
    background-color: #00a0e3;
    color: #fff;
    transition: all .3s;
}
.closed-buttons a:hover{
    color:#00a0e3;
    background-color:#fff;
}
.img-responsive {
    display: block;
    height: auto;
    margin: 0 auto;
    width: 300px;
}
.tab-empty-text {
    font-family: roboto;
    font-size: 22px;
    margin: 20px 0 10px;
    text-align: center;
}
');
$script = <<<JS
let limit = 12;
let page = 1;
let type = '$type';
let loadmorecards = false;
function getClosedCards(){
     $.ajax({
            url: '/account/'+type+'/all-closed-'+ type,
            data: {limit: limit, page: page},
            method: 'post',
            beforeSend: function () {
            },
            success: function (response) {
                if(response['status']== 200){
                 $('.load-more-bttn').show();
                    var q_body = $('#closed-card').html();
                    $("#closed-cards").append(Mustache.render(q_body, response.data.data));
                    if(response['data']['data'].length < limit){
                        loadmorecards = false;
                        $('.load-more-bttn').hide();
                    }else{
                        loadmorecards = true;
                        page = page + 1;
                    }
                } else {
                    $('.load-more-bttn').hide();
                    if(page === 1){
                        $("#closed-cards").html('<div class="tab-empty"><div class="tab-empty-icon"><img src="/assets/themes/ey/images/pages/dashboard/jobsclose.png" class="img-responsive" alt=""/></div><div class="tab-empty-text">No closed '+type+'</div></div>');
                    }
                }
            }
        });
}

getClosedCards();

let loading = true
$(window).animate({scrollTop:0}, '300');
$('body').css('overflow','hidden');
setTimeout(
    function(){
    $('body').css('overflow','inherit');
}, 1300);
$(window).scroll(function() { //detact scroll
    
			if($(window).scrollTop() + $(window).height() >= $(document).height() - 80){ //scrolled to bottom of the page
                if(loading && loadmorecards){
                    loading = false;
                    $('#loadMore').removeClass("loading_more");
                    $('.load-more-text').css('visibility', 'hidden');
                    $('.load-more-spinner').css('visibility', 'visible');
				    getClosedCards();
                    setTimeout(
                        function(){
				            loading = true;
				    }, 1500);
                }
			}
		});
JS;
$this->registerJs($script);
?>

