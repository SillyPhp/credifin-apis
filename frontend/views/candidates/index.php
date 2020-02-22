<?php
$this->params['header_dark'] = true;

use yii\helpers\Html;
use yii\helpers\Url;

echo $this->render('/widgets/mustache/candidates');
?>
<section>
    <div class="container">
        <div class="col-md-3 col-sm-4 mobile-hidden" id="filters">
            <form>
                <div class="filters">
                    <div class="f-ratings">
                        <div class="filter-head-main">Filter Candidates</div>
                        <div class="overall-box-heading">Select Location</div>
                        <div class="form-group form-md-checkboxes">
                            <div class="md-checkbox-list">
                                <div class="filter-search">
                                    <div class="f-search-loc">
                                        <input type="text" id="locations_search" placeholder="Search"/>
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <div id="locations_search_checked"></div>
                                <div id="locations_search"></div>
                            </div>
                        </div>
                        <div class="overall-box-heading">Select Position</div>
                        <div class="form-group form-md-checkboxes">
                            <div class="md-checkbox-list">
                                <div class="filter-search">
                                    <div class="f-search-loc">
                                        <input type="text" id="job_titles_search" placeholder="Search"/>
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <div id="job_titles_search_checked"></div>
                                <div id="job_titles_search"></div>
                            </div>
                        </div>
                        <div class="overall-box-heading">Select Skills</div>
                        <div class="form-group form-md-checkboxes">
                            <div class="md-checkbox-list">
                                <div class="filter-search">
                                    <div class="f-search-loc">
                                        <input type="text" id="skills_search" placeholder="Search"/>
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <div id="skills_search_checked"></div>
                                <div id="skills_search"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-9">
            <div class="row" id="user_cards"></div>
            <?php
            echo $this->render('/widgets/users/preloaders/candidates');
            ?>
        </div>
        <div class="col-md-12 col-sm-12">
            <div id="cardBlock" class="row work-load blogbox border-top-set m-0 mb-20"></div>
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
    </div>
</section>
<?php
$this->registerCss('
#filters {
	height: 100vh;
	position: sticky;
	position: -webkit-sticky;
	top: 105px;
}

.filter-head-main {
	font-size: 18px;
	font-family: roboto;
	padding: 5px 0px 5px 0;
	font-weight: 500;
	color: #00a0e3;
}

.md-checkbox label>.check {
	top: 0px;
}

#loadMore {
	display: none;
}

.tab-empty {
	padding: 20px;
}

.tab-empty-icon img {
	max-width: 250px;
	margin: 0 auto;
}

.tab-empty-text {
	text-align: center;
	font-size: 35px;
	font-family: lobster;
	color: #999999;
	padding-top: 20px;
}

.shortlist-strip {
	position: absolute;
	top: 0;
	left: 0;
}

.s-strip {
	padding: 5px 10px;
	border: 1px solid #00a0e3;
	border-radius: 0 0 10px 0;
	background: #00a0e3;
	color: #fff;
}

button.viewall-jobs {
	border: none;
}

*:focus {
	outline: none !important;
}

#btn-group1 {
	display: hidden;
}

#btn-group2 {
	display: none;
}

.paid-candidate-container {
	background: #ffffff;
	border-radius: 6px !important;
	overflow: hidden;
	text-align: center;
	margin-bottom: 30px;
	position: relative;
	transition: .4s;
	border: 1px solid #eaeff5;
}

.paid-candidate-container:hover,
.paid-candidate-container:focus {
	transform: translateY(-5px);
	-webkit-transform: translateY(-5px);
	cursor: pointer;
}

.paid-candidate-box-thumb img {
	height: 100%;
}

.com-load-more-btn {
	max-width: 150px;
	margin: 0 auto;
	color: #fff;
	font-size: 14px;
}

.paid-candidate-box {
	text-align: center;
	padding: 20px 10px 15px;
}

.paid-candidate-status {
	position: absolute;
	left: 32px;
	top: 25px;
	background: #01c73d;
	color: #ffffff;
	padding: 4px 18px;
	border-radius: 50px;
	font-weight: 500;
}

.paid-candidate-box-thumb {
	margin-bottom: 30px;
	width: 120px;
	height: 120px;
	margin: 0 auto 25px auto;
	border-radius: 50% !important;
	overflow: hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}

.paid-candidate-box-detail h4 {
	margin-bottom: 4px;
	font-size: 20px;
	text-overflow: ellipsis;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	display: -webkit-inline-box;
	overflow: hidden;
}

.paid-candidate-box-exp {
	display: flex;
	justify-content: center;
}

.paid-candidate-box-detail .desination,
.paid-candidate-box-detail .location,
.paid-candidate-box-exp .desination {
	font-weight: 500;
	font-size: 15px;
	color: #677484;
	height: 27px;
	padding: 5px 20px 0;
	text-overflow: ellipsis;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	display: -webkit-box;
	overflow: hidden;
}

.paid-candidate-box-extra ul {
	margin: 10px 0;
	padding: 0;
	min-height: 74px;
	height: 108px;
	overflow: hidden;
}

.paid-candidate-box-extra ul li {
	list-style: none;
	padding: 3px 15px;
	border: 1px solid #b9c5ce;
	border-radius: 50px !important;
	margin: 2px 0;
	font-weight: 500;
	color: #657180;
	text-overflow: ellipsis;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	display: -webkit-inline-box;
	overflow: hidden;
}

.paid-candidate-box-extra ul li.more-skill {
	color: #ffffff;
	border-color: #1194f7;
}

a.btn.btn-paid-candidate {
	padding: 10px !important;
	display: inline-block;
	width: 100%;
	font-size: 16px;
	font-weight: 500;
	border-radius: 0;
}

a.btn.btn-paid-candidate:hover,
a.btn.btn-paid-candidate:focus {
	background: #00a0e3;
	color: #ffffff;
	-webkit-transition: all .3s ease-in-out;
	-moz-transition: all .3s ease-in-out;
	-o-transition: all .3s ease-in-out;
	-ms-transition: all .3s ease-in-out;
	transition: all .3s ease-in-out;
}

.paid-candidate-box .dropdown {
	position: absolute;
	right: 30px;
	top: 25px;
}

.btn-trans {
	background: transparent;
	border: none;
	font-size: 20px;
	color: #99abb9;
}

.dropdown-menu.pull-right {
	right: 0;
	left: auto !important;
	top: 90% !important;
}

.dropdown-menu.pull-right {
	right: 0;
	border-color: #ebf2f7;
	padding: 0;
	left: auto !important;
	top: 90% !important;
}

.dropdown-menu>a,
.dropdown-menu>button {
	display: block;
	padding: 14px 12px 14px 12px;
	clear: both;
	font-weight: 300;
	line-height: 1.42857143;
	color: #67757c;
	border-bottom: 1px solid #f1f6f9;
	background: transparent;
}

.dropdown-menu>button {
	text-align: left;
	border: none;
	width: 100%;
}

.bt-1 {
	border-top: 1px solid #eaeff5!important;
}

.custom-buttons {
	width: 100%;
	font-size: 10px !important;
	padding: 8px 0px !important;
	margin-bottom: 20px;
}

.dashboard-button a,
.dashboard-button button {
	margin-left: 10px !important;
}


/*----------------------*/

.checkbox-input {
	display: none;
}

.checkbox-label {
	vertical-align: top;
	width: 100%;
	cursor: pointer;
	font-weight: 400;
	margin-bottom: 0px;
}

.p-category-main:hover .checkbox-label:before {
	top: -5px !important;
}

.checkbox-label:before {
	content: "";
	position: absolute;
	top: 80px;
	left: 15px;
	width: 35px;
	height: 35px;
	opacity: 0;
	background-color: #2196F3;
	background-repeat: no-repeat;
	background-size: 30px;
	border-radius: 8px 0;
	//  -webkit-transform: translate(0%, -50%);
	//  transform: translate(0%, -50%);
	transition: all 0.4s ease;
	z-index: 999;
}

.checkbox-input:checked+.checkbox-label:before {
	top: 0;
	opacity: 1;
}

.checkox-input:checked+.checkbox-label {
	transform: translateY(-5px);
	-webkit-transform: translateY(-5px);
	cursor: pointer;
}

.checkbox-input:checked+.checkbox-label .checkbox-text span {
	-webkit-transform: translate(0, -8px);
	transform: translate(0, -8px);
}

.radio_questions {
	max-width: 100%;
	font-size: 18px;
	font-weight: 600;
	line-height: 36px;
	position: relative;
}

.inputGroup {
	background-color: #fff;
	display: block;
	margin: 10px 0;
	position: relative;
}

.inputGroup input {
	width: 32px;
	height: 32px;
	order: 1;
	z-index: 2;
	position: absolute;
	right: 30px;
	top: 50%;
	transform: translateY(-50%);
	cursor: pointer;
	visibility: hidden;
}

.inputGroup input:checked~label {
	color: #fff;
	box-shadow: 0 0 10px rgba(0, 0, 0, .3) !important;
}

.inputGroup label {
	padding: 6px 75px 10px 25px;
	width: 96%;
	display: block;
	margin: auto;
	text-align: left;
	color: #3C454C !important;
	cursor: pointer;
	position: relative;
	z-index: 2;
	transition: color 1ms ease-out;
	overflow: hidden;
	border-radius: 8px;
	border: 1px solid #eee;
}

.inputGroup input:checked~label:before {
	transform: translate(-50%, -50%) scale3d(56, 56, 1);
	opacity: 1;
}

.inputGroup input:checked~label:after {
	background-color: #00a0e3;
	border-color: #00a0e3;
}

.filter-btns {
	display: none;
}

.empty {
	text-align: center;
	display: none;
}

.es-btn {
	padding-top: 20px;
	padding-bottom: 20px;
}

.es-btn button {
	background: #00a0e3;
	border: 1px solid #00a0e3;
	padding: 10px 15px;
	border-radius: 5px;
	color: #fff;
	font-family: roboto;
}

.es-btn button:hover {
	box-shadow: 0 0 10px rgba(0, 0, 0, .5);
	transition: .3s all;
	-moz-transition: .3s all;
	-webkit-transition: .3s all;
	-ms-transition: .3s all;
}

.es-text {
	font-family: roboto;
	font-size: 20px;
	padding-top: 20px;
	font-weight: bold;
}

.es-text2 {
	font-family: roboto;
}

.btn_add_new_org {
	margin-top: 15px;
}

.add_new_org1 {
	padding: 10px 15px;
	background: #fff;
	color: #00a0e3;
	border: 2px solid #eee;
	border-radius: 10px;
	font-weight: 500 !important;
	font-family: roboto;
}

.add_new_org1:hover {
	color: #00a0e3;
	font-weight: bold;
	box-shadow: 0 0 10px rgba(0, 0, 0, .3);
}

.search-bar {
	width: 100%;
	background: #fff;
	border-radius: 10px;
	display: flex;
	padding: 5px 5px;
	border: 2px solid #eee;
	color: #bcbaba margin-top:20px;
}

.main-headings {
	text-align: center;
	font-size: 25px;
	padding-bottom: 10px;
	font-family: lora;
}

.s-input {
	width: 94%;
	padding: 10px 15px;
	border: none;
	border-radius: 10px;
	color: #bcbaba;
	font-size: 16px;
	font-family: roboto;
	font-weight: 500;
}

input::placeholder {
	color: #bcbaba;
}

form input[type="text"]:focus {
	outline: none;
	border: none !important;
	box-shadow: none;
}

.s-btn {
	width: 5%;
	padding: 10px 15px;
	border: none;
	background: none;
	color: #bcbaba;
	font-size: 16px;
}

#loading_img {
	display: none;
}

#loading_img img {
	margin-left: auto;
	margin-right: auto;
	display: block;
	width: 100px;
	height: 100px
}

.fader {
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;
	left: 0;
	display: none;
	z-index: 99;
	background-color: #fff;
	opacity: 0.7;
}

#loading_img.show {
	display: block;
	position: fixed;
	z-index: 100;
	opacity: 1;
	background-repeat: no-repeat;
	background-position: center;
	width: 100%;
	height: 100%;
	left: 10%;
	right: 0;
	top: 50%;
}

.padd-0 {
	margin-left: 15px !important;
	margin-right: 15px !important;
}

.cm-btns {
	margin-top: 10px;
	padding-top: 5px;
	border-top: 1px solid #eee;
	text-transform: capitalize;
}

.color-blue a {
	color: #bcbaba;
}

.color-blue a:hover {
	color: #00a0e3;
}

.color-orange a {
	color: #bcbaba;
}

.color-orange a:hover {
	color: #ff7803;
}

.related-company {
	padding-top: 50px;
}

.rh-header {
	background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
	background-size: 100% 300px;
	background-repeat: no-repeat;
	padding: 130px 0 35px 0;
	color: #fff;
	margin-bottom: 20px;
}

.header {
	text-align: left;
}

.num-companies {
	font-size: 25px;
}

.num-companies span {
	font-weight: bold;
}

.filter-search {
	padding-bottom: 20px;
}

.f-main-heading {
	display: flex;
}

.show-search {
	margin-left: 15px;
	margin-top: 5px;
}

.show-search button {
	background: transparent;
	border: none;
	font-size: 15px;
	color: #666;
	float: right;
}

.show-search button:hover {
	color: #00a0e3;
}

.f-search,
.f-search-loc,
.f-search-1 {
	border: 1px solid #eee;
	padding: 5px 15px;
	border-radius: 10px;
}

.f-search input,
.f-search-loc input,
.f-search-1 input {
	border: none;
	font-size: 14px;
}

.f-search input::placeholder,
.f-search-loc input::placeholder,
.f-search-1 input::placeholder {
	color: #999;
}

.f-search i,
.f-search-loc i,
.f-search-1 i {
	float: right;
	padding-top: 3px;
	color: #999;
}

.fivestars i {
	color: #fd7100 !important;
}

.fourstars i.active {
	color: #fa8f01 !important;
}

.threestars i.active {
	color: #fcac01 !important;
}

.twostars i.active {
	color: #fabf37 !important;
}

.onestars i.active {
	color: #ffd478 !important;
}

.md-checkbox label>.box {
	top: 6px;
	border: 2px solid #ddd;
}

.md-checkbox-list .md-checkbox {
	margin-bottom: -10px;
}

.f-ratings {
	padding: 5px 15px;
	border: 1px solid #eee;
	border-radius: 10px;
	width: 260px;
	overflow-y: scroll;
	height: 500px;
	position: relative;
}

.overall-box-heading {
	font-size: 16px;
	padding-top: 5px;
	font-weight: 500;
	font-family: roboto;
}

.rating-stars {
	font-size: 16px;
	font-weight: lighter;
	padding: 4px;
}

@media only screen and (max-width: 834px) {
	.pos-relative-mobile {
		position: relative;
		overflow: scroll;
	}
	.mobile-hidden {
		display: none;
		position: absolute;
		background: #fff;
		top: 0px;
		right: 0px;
		z-index: 9999;
		border: 1px solid #eee;
		border-top: none;
		border-bottom: none;
		border-right: none;
	}
}
');

$script = <<<JS
    var load_more_cards = true;
    var loading = true;
    var offset = 0;
    var url;
    $(document).ready(function() {
        loading = false;
        url = '/candidates'+ window.location.search;
        getUserCards(0, url, 'append');
        setTimeout(
            function() {
                $('.loading-main').css('display', 'none');
            }, 1000);
    });
    
    $(document).on('click', '#loadMore', function(event) {
        event.preventDefault();
        if (loading) {
            loading = false;
            url = '/candidates'+ window.location.search;
            getUserCards(offset, url, 'append');
        }
    });
    
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - ($('#footer').height() + 335)) { //scrolled to bottom of the page
            if (load_more_cards && loading) {
                loading = false;
                url = '/candidates'+ window.location.search;
                getUserCards(offset, url, 'append');
            }
        }
    });
    
    var ps = new PerfectScrollbar('.f-ratings');
    //Jobs salary slider
    $("#rangess").ionRangeSlider({
        skin: "round",
        type: "double",
        min: 5000,
        max: 100000,
        from: 5000,
        to: 30000,
        grid: true
    });
    
    
    
    
    
    
    // filter code start from here
    
    function swipe(ths, thsCls) {
        var selectedCheck = ths.closest('.md-checkbox');
        selectedCheck.remove();
        if(ths.is(":checked")){
            $('div#'+thsCls+'_search_checked').append(selectedCheck);
        } else {
            $('div#'+thsCls+'_search').prepend(selectedCheck);
        }
    }
    
    var exp_params;
    $(document).on('change', 'input[type=checkbox]', function() {
        load_more_cards = true;
        $('#user_cards').html(" ");
        $('.loading-main').show();
        exp_params = [];
        var ths = $(this);
        var thsVal = ths.attr('value');
        var thsCls = ths.attr('class');
        swipe(ths, thsCls);
        var params = unescape(window.location.search.substring(1));
        var cls_loc = params.match(/locations=/g);
        var cls_jt = params.match(/job_titles=/g);
        var cls_sk = params.match(/skills=/g);
        if(!params){
            params = 'locations=&job_titles=&skills=';
        }
//        if(!cls_jt || !cls_loc || !cls_sk) {
//            if(!params){
//                params = thsCls +'=';
//            } else {
//                params = params + '&'+ thsCls +'=';
//            }
//        }
        var p = [];
        $.each(params.split("&"),function(index,value) {
            exp_params.push(value);
            $.each(value.split("="),function(i,v) {
                p.push(v);
            });
        });
        $.each(p, function(i,v) {
            if(v == thsCls){
                var str = p[i+1];
                var str_arr = [];
                $.each(str.split(","),function(index,value) {
                    str_arr.push(value);
                });
                var new_str = "";
                if(str_arr.includes(thsVal)){
                    $.each(str_arr,function(index, value) {
                        if(value != thsVal){
                            if(new_str == ""){
                                new_str = value;
                            } else {
                                new_str = new_str+','+value;
                            }
                        }
                    });
                } else {
                    if(str){
                        new_str = str +','+thsVal;
                    } else {
                        new_str = thsVal;
                    }
                }
                p[i+1] = new_str;
            }
        });
        var cur_params = "?";
        $.each(p,function(i, v) {
            if(i === 0){
                cur_params = cur_params + v;
            } else {
                if(i % 2 === 0){
                    cur_params = cur_params + '&' + v;
                } else {
                    cur_params = cur_params + '=' + v;
                }
            }
        });
        history.pushState('data', 'title', cur_params);
        var cur_url = '/candidates'+ window.location.search;
        offset = 0;
        getUserCards(offset, cur_url, 'html');
        // loading = true;
        // load_more_cards = true;
    });
    
    var xhr;
    $(document).ready(function() {
        $(document).on('keyup', 'input[type=text]', function() {
            var ths = $(this);
            var id = ths.attr('id').slice(0,-7);
            var val = ths.val();
            url = '/candidates/get-checkbox-list' + window.location.search;
            loadCheckboxList(url, val, id);
        });
    });
    
    function getFilterList(){
        $.ajax({
           url:'/candidates/get-filter-list' + window.location.search,
           type: 'POST',
           success: function (response) {
               $.each(response, function(i, v) {
                    if(i === 'list'){
                        $.each(v, function(indx, vlue) {
                            var cls = indx;
                            var html = []; 
                            var div = $('div#'+cls+'_search');
                            $.each(vlue, function(index, value) {
                                html.push('<div class="md-checkbox"> <input type="checkbox" value="'+value+'" id="21sdf2da4'+value+'1gt54re06" class="'+cls+'"> <label for="21sdf2da4'+value+'1gt54re06"> <span></span> <span class="check"></span> <span class="box"></span><div class="fivestars rating-stars">'+value+'</div> </label></div>');
                            });
                            div.html(html);
                        });
                    } else {
                        $.each(v, function(indx, vlue) {
                            var cls = indx;
                            var html = []; 
                            var div = $('div#'+cls+'_search_checked');
                            $.each(vlue, function(index, value) {
                                html.push('<div class="md-checkbox"> <input type="checkbox" value="'+value+'" id="21sdf2da4'+value+'1gt54re06" class="'+cls+'" checked> <label for="21sdf2da4'+value+'1gt54re06"> <span></span> <span class="check"></span> <span class="box"></span><div class="fivestars rating-stars">'+value+'</div> </label></div>');
                            });
                            div.html(html);
                        });
                    }
               });
           }
        });
        
    }
    
    $(document).ready(function() {
        getFilterList();
    });
    
    function loadCheckboxList(url, val, cls) {
        if(val && xhr && xhr.readyState != 4) {
            xhr.abort();
        }
        xhr = $.ajax({
            url:url,
            type: 'POST',
            data: {name:val,id:cls},
            success: function (response) {
                var div = $('div#'+cls+'_search');
                // var obj = JSON.parse(res);
                var obj = response;
                var html = [];
                $.each(obj,function(index,value) {
                    html.push('<div class="md-checkbox"> <input type="checkbox" value="'+value+'" id="21sdf2da4'+value+'1gt54re06" class="'+cls+'"> <label for="21sdf2da4'+value+'1gt54re06"> <span></span> <span class="check"></span> <span class="box"></span><div class="fivestars rating-stars">'+value+'</div> </label></div>');
                });
                div.html(html);
            }
        });
    }

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

