<?php
use yii\helpers\Url;
?>
<script id="careers-card" type="text/template">
    {{#.}}
    <div class=" col-md-3 col-sm-3">
        <div class="job-listing">
            <a href="{{link}}">
                <div class="job-title-sec">
                    <div class="pos-rel">
                        <div class="c-logo">
                            <a href="">
                                <img src="<?= Url::to('@commonAssets/categories/'); ?>{{icon}}" alt=""/>
                            </a>
                        </div>
                    </div>
                    <div class="job-title">
                        <a href="{{link}}" title="">
                            {{title}}
                        </a>
                    </div>
                    <div class="job-exp">{{experience}}</div>
                    <div class="job-lctn"><i class="fa fa-map-marker"></i>
                        {{#city}}
                            {{city}}
                        {{/city}}
                        {{^city}}
                            All India
                        {{/city}}
                    </div>
                    <div class="apply-job-btn">
                        <a href="{{link}}">Apply</a>
                    </div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>
<?php
$this->registerCss('
.job-listing{
    border:1px solid #eee;
    padding:10px 15px;
    border-radius:10px;
    margin-bottom: 10px;
}
.job-title-sec{
    text-align:center;
}
.job-listing:hover{
    box-shadow:0 0 10px rgba(0,0,0,.3);
    transition:.3s ease-in-out ;
}
.c-logo {
    width: 100px;
    height:125px;
    text-align: center;
    position:relative;
    margin:0 auto;
}
.c-logo img {
    float: none;
    display: inline-block;
    max-width: 80px;
    position:absolute;
    top:50%;
    transform: translate(-50%, -50%);
}
.job-title a{
    font-size:16px;
    color:#00a0e3;
}
.apply-job-btn{
    padding-top:20px;
}
.apply-job-btn a{
    background:#00a0e3;
    padding:8px 15px;
    border:none;
    border-radius:5px;
    color:#fff;
    font-size:14px;
}
');
$script = <<<JS
let loader = false;
let draggable = false;
let page = 0;
function renderCards(cards, container){
    var card = $('#careers-card').html();
    var cardsLength = cards.length;
    // if(cardsLength%3 !==0 && loader === true) {
    //     $('#loadMore').hide();
    // }
    var noRows = Math.ceil(cardsLength / 4);
    var j = 0;
    for(var i = 1; i <= noRows; i++){
        $(container).append('<div class="row">' + Mustache.render(card, cards.slice(j, j+4)) + '</div>');
        j+=4;
    }
}

function getCareersCards(type = 'Jobs',container = '.blogbox', url = window.location.pathname) {
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
           // $('.load-more-text').css('visibility', 'hidden');
           // $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
            // $('.loader-main').hide();
            // $('.load-more-text').css('visibility', 'visible');
            // $('.load-more-spinner').css('visibility', 'hidden');
            if(response.status === 200) {
                renderCards(response.cards, container);
                utilities.initials();
            } else {
                if(loader === true) {
                    if(page === 1) {
                        $(container).append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
                    }
                    // $('#loadMore').hide();
                }
            }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
