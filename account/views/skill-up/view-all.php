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
                            <a href="<?= Url::to('create'); ?>" data-toggle="tooltip"
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
            <td><a href="/skill-up/detail/{{slug}}" target="_blank">{{post_title}}</a></td>
            <td>{{author_name}}</td>
            <td>{{source}}</td>
            <td>{{content_type}}</td>
            <td><a href="{{post_source_url}}"
                   class="src-link" target="_blank">{{post_source_url}}</a>
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
.danger {
    background-color: #d9534f;
}
.add-lead img{width:25px;}
.w50{min-width:50px;}
.w100{min-width:100px;}
.w150{min-width:150px;}
.w200{min-width:200px;}
.w250{min-width:250px;}
.w300{min-width:300px;}
.my-leads-view{ 
    overflow-x: scroll;
    max-width: 100%;
    position:relative;
}
.my-leadd  { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
.my-leadd tr:nth-of-type(even) { 
  background:#f5f5f5; 
}
.my-leadd tr th {
    background-color:#00a0e3;
    color: #fff;
    font-family: Roboto;
    font-weight: 500;
}
.my-leadd td, .my-leadd th { 
  padding: 10px 6px; 
  border: 1px solid #eee; 
  text-align: center; 
  font-family:roboto;
}
.my-leadd td ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    padding:0;
}
.my-leadd td ul li {
    list-style: none;
    margin: 0 5px 2px 0;
}
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
.page-content{padding:0;}
.my-leadd tr:nth-of-type(odd) {
    background: #00a0e3;
    color: #fff;
    margin-bottom: 20px;
}
.my-leadd td, .my-leadd th {
    text-align:left;
}
.my-leadd td ul{
    justify-content: flex-start;
    }
.src-link{
    color:#000;    
    word-break: break-all;
    }
/* Force table to not be like tables anymore */
.my-leadd, thead, tbody, th, td, tr { 
    display: block; 
}

/* Hide table headers (but not display: none;, for accessibility) */
.my-leadd thead tr { 
    position: absolute;
    top: -9999px;
    left: -9999px;
}

.my-leadd tr { border: 1px solid #f5f5f5; }

.my-leadd td { 
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee; 
    position: relative;
    padding-left: 50%; 
    margin: 5px;
}

.my-leadd td:before { 
    position: absolute;
    top: 8px;
    left: 5px;
    width:50%;
    padding-right: 10px;
    font-weight: 500;
}

/*
Label the data
*/
.my-leadd td:nth-of-type(1):before { content: "Date"; }
.my-leadd td:nth-of-type(2):before { content: "Title"; }
.my-leadd td:nth-of-type(3):before { content: "Author Name"; }
.my-leadd td:nth-of-type(4):before { content: "Source Name"; }
.my-leadd td:nth-of-type(5):before { content: "Content Type"; }
.my-leadd td:nth-of-type(6):before { content: "Sourcre Link"; }
.my-leadd td:nth-of-type(7):before { content: "Skills"; }
.my-leadd td:nth-of-type(8):before { content: "Industries"; }
}
@media screen and (max-width: 500px) {
.my-leadd td:before,.my-leadd td{
    font-size:12px;
}
.my-leadd td:before{
    top:0;
}
}
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
let limit = 20;
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
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
var pa = new PerfectScrollbar('.my-leads-view');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
