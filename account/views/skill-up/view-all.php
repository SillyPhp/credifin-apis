<?php

use yii\helpers\Url;

?>

    <section>
        <div class="col-md-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">My Contributions</span>
                    </div>
                    <div class="actions">
                        <div class="set-im">
                            <a href="<?= Url::to('/skills-up'); ?>" data-toggle="tooltip"
                               title="Add More"
                               class="add-lead">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="my-leads-view">
                        <table class="my-leadd">
                            <thead>
                            <tr>
                                <th class="w100">Date</th>
                                <th class="w250">Title</th>
                                <th class="w200">Author Name</th>
                                <th class="w150">Source Name</th>
                                <th class="w150">Content Type</th>
                                <th class="w300">Source Link</th>
                                <th class="w300">Skills</th>
                                <th class="w200">Industries</th>
                            </tr>
                            </thead>
                            <tbody id="feeds">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="loading">
        <a href="#" id="loadMore"
           class="ajax-paginate-link btn btn-border btn-more btn--primary load-more loading_more">
            <span class="load-more-text">Load More</span>
            <svg class="load-more-spinner" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg"
                 stroke="currentColor">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="2">
                        <circle cx="8.90684" cy="50" r="5">
                            <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50"
                                     calcMode="linear" repeatCount="indefinite"></animate>
                            <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5"
                                     calcMode="linear" repeatCount="indefinite"></animate>
                        </circle>
                        <circle cx="25.0466" cy="8.99563" r="5">
                            <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5"
                                     values="5;50;50;5" calcMode="linear"
                                     repeatCount="indefinite"></animate>
                            <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27"
                                     values="27;49;5;27" calcMode="linear"
                                     repeatCount="indefinite"></animate>
                        </circle>
                        <circle cx="47.0466" cy="46.0044" r="5">
                            <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50"
                                     calcMode="linear" repeatCount="indefinite"></animate>
                            <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s"
                                     values="49;5;27;49" calcMode="linear"
                                     repeatCount="indefinite"></animate>
                        </circle>
                    </g>
                </g>
            </svg>
        </a>
    </div>

    <script id="feed-list" type="text/template">
        {{#.}}
        <tr>
            <td>{{date}}</td>
            <td>{{post_title}}</td>
            <td>{{author_name}}</td>
            <td>{{source}}</td>
            <td>{{content_type}}</td>
            <td><a href="<{{post_source_url}}"
                   class="src-link">{{post_source_url}}</a>
            </td>
            <td>
                <ul>
                    <li>{{skills}}</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>{{industries}}</li>
                </ul>
            </td>
        </tr>
        {{/.}}
    </script>

<?php
$this->registerCss('
/* owl Slider css ends */
/*Load more button css starts*/
.ajax-paginate-link .load-more-spinner {
    margin: -15px 0 0 -15px;
    visibility: hidden;
    position: absolute;
    display: block;
    width: 30px;
    height: 30px;
    left: 50%;
    top: 50%;
}
.btn--primary.btn-border {
    display: block;
    position:relative;
    background-color: transparent;
    color: #0083ff;
    fill: #0083ff;
    border-color: #0083ff;
    padding: 16px 56px !important;
    border-radius: 50px;
    transition: all .3s ease;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 900;
    line-height: 1;
    margin: auto;
    width: 240px;
}
.load-more-spinner:not(:root){
    overflow: hidden;
}
/*Load more button css ends*/
');
$script = <<< JS
let loadmore = true;
let page = 1;
let limit = 5;
let loading = true


function feeds(){
    $.ajax({
            url: 'get-list',
            type: 'post',
            data: {limit:limit,page:page},
            success: function (response) {
                $('#loadMore').addClass("loading_more");
                $('.loader-main').hide();
                $('.load-more-text').css('visibility', 'visible');
                $('.load-more-spinner').css('visibility', 'hidden');
                
                if(response['status'] !== 200){
                    $('#loadMore').hide();
                    loadmore = false;
                }else{
                    var template = $('#feed-list').html();
                    var rendered = Mustache.render(template,response['data']);
                    $('#feeds').append(rendered);
                    page += 1
                    
                    if(response['data'].length < limit){
                        $('#loadMore').hide();
                        loadmore = false;
                    }
                }
            }
    })

}

$( document ).ready(function() {
    feeds();
});


setTimeout(
    function(){
        loading = true;
    }, 900);

$(window).scroll(function() { //detact scroll
			if($(window).scrollTop() + $(window).height() >= $(document).height()){ //scrolled to bottom of the page
				
                if(loadmore && loading){
                    loading = false;
                    $('#loadMore').removeClass("loading_more");
                    $('.load-more-text').css('visibility', 'hidden');
                    $('.load-more-spinner').css('visibility', 'visible');
				    feeds();
				    setTimeout(
                        function(){
				            loading = true;
				    }, 500);
                }
			}
		});
JS;
$this->registerJs($script);
