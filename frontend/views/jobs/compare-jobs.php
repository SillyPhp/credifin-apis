<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>

<section>
        <div class="row">
            <div class="col-md-2">
            <?=
            $this->render('/widgets/sidebar-review', [
                'type' => 'jobs',
                'hide_detail' => true
            ]);
            ?>
        </div>


            <div class="col-md-10">
                <table>
                    <tr>
                        <td width="10%" class="boldfont"> Choose Jobs you want to compare</td>
                        <form>
                            <td width="30%" class="empty" id="c1" data-info="">
                                <div id="company_1_btn" class="remove-compare hidden">×</div>
                                <div class='search-box'>
                                    <div class="load-suggestions Typeahead-spinner" id="company_1_spin"
                                         style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input id="company_1" class='form-control' placeholder='Choose Company'
                                           type='text' autocomplete="off">
                                    <input id="company_1_id" class='form-control' type='hidden'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class='search-box'>
                                    <div class="load-suggestions Typeahead-spinner" id="job_1_spin"
                                         style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input id="job_1" class='form-control' placeholder='Choose Job' type='text' autocomplete="off">
                                    <input id="job_1_id" class='form-control' type='hidden'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                            </td>
                            <td width="30%" class="empty" id="c2" data-info="">
                                <div id="company_2_btn" class="remove-compare hidden">×</div>
                                <div class='search-box'>
                                    <div class="load-suggestions Typeahead-spinner" id="company_2_spin"
                                         style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input id="company_2" class='form-control' placeholder='Choose Company'
                                           type='text' autocomplete="off">
                                    <input id="company_2_id" class='form-control' type='hidden'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class='search-box'>
                                    <div class="load-suggestions Typeahead-spinner" id="job_2_spin"
                                         style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input id="job_2" class='form-control' placeholder='Choose Job' type='text' autocomplete="off">
                                    <input id="job_2_id" class='form-control' type='hidden'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                            </td>
                            <td width="30%" class="empty" id="c3" data-info="">
                                <div id="company_3_btn" class="remove-compare hidden">×</div>
                                <div class='search-box'>
                                    <div class="load-suggestions Typeahead-spinner" id="company_3_spin"
                                         style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input id="company_3" class='form-control' placeholder='Choose Company'
                                           type='text' autocomplete="off">
                                    <input id="company_3_id" class='form-control' type='hidden'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                                <div class='search-box'>
                                    <div class="load-suggestions Typeahead-spinner" id="job_3_spin"
                                         style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <input id="job_3" class='form-control' placeholder='Choose Job' type='text' autocomplete="off">
                                    <input id="job_3_id" class='form-control' type='hidden'>
                                    <button class='btn btn-link search-btn'>
                                        <i class='fa fa-search'></i>
                                    </button>
                                </div>
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <th>Selected Jobs</th>
                        <th>
                            <div class="job-name fill">
                                <img id="c1_image" src="">
                            </div>
                        </th>
                        <th>
                            <div class="job-name">
                                <img id="c2_image" src="">
                            </div>
                        </th>
                        <th>
                            <div class="job-name">
                                <img id="c3_image" src="">
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Profile
                        </td>
                        <td id="c1_profile">
                        </td>
                        <td id="c2_profile">
                        </td>
                        <td id="c3_profile">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Title
                        </td>
                        <td id="c1_title">
                        </td>
                        <td id="c2_title">
                        </td>
                        <td id="c3_title">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Designation
                        </td>
                        <td id="c1_designation">
                        </td>
                        <td id="c2_designation">
                        </td>
                        <td id="c3_designation">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Type
                        </td>
                        <td id="c1_type">
                        </td>
                        <td id="c2_type">
                        </td>
                        <td id="c3_type">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Offered Salary
                        </td>
                        <td id="c1_salary">
                        </td>
                        <td id="c2_salary">
                        </td>
                        <td id="c3_salary"`>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Experience
                        </td>
                        <td id="c1_experience">
                        </td>
                        <td id="c2_experience">
                        </td>
                        <td id="c3_experience">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Total Vacancies
                        </td>
                        <td id="c1_vacancy">
                        </td>
                        <td id="c2_vacancy">
                        </td>
                        <td id="c3_vacancy">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Location
                        </td>
                        <td id="c1_plocation">
                        </td>
                        <td id="c2_plocation">
                        </td>
                        <td id="c3_plocation">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Working Days
                        </td>
                        <td id="c1_days">
                        </td>
                        <td id="c2_days">
                        </td>
                        <td id="c3_days">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Work Timing
                        </td>
                        <td id="c1_timings">
                        </td>
                        <td id="c2_timings">
                        </td>
                        <td id="c3_timings">
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Required Knowledge, Skills, and Abilities
                        </td>
                        <td>
                            <ul id="c1_skills">
                            </ul>
                        </td>
                        <td>
                            <ul id="c2_skills">
                            </ul>
                        </td>
                        <td>
                            <ul id="c3_skills">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Job Description
                        </td>
                        <td>
                            <ul id="c1_jd">
                            </ul>
                        </td>
                        <td>
                            <ul id="c2_jd">
                            </ul>
                        </td>
                        <td>
                            <ul id="c3_jd">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Education
                        </td>
                        <td>
                            <ul id="c1_education">
                            </ul>
                        </td>
                        <td>
                            <ul id="c2_education">
                            </ul>
                        </td>
                        <td>
                            <ul id="c3_education">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="boldfont">
                            Interview Locations
                        </td>
                        <td id="c1_ilocation">
                        </td>
                        <td id="c2_ilocation">
                        </td>
                        <td id="c3_ilocation">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
</section>

<?php

echo $this->render('/widgets/mustache/application-card', [
    'type' => 'Jobs',
]);

$this->registerCss('
.side-menu{z-index:9999;}
.invisible{
    display:none;
}
body{
    background-color:#fff !important;
}
#header-main{
    z-index: 99999 !Important;
}
.fil-btn{
    background:#00a0e3;
    border:none;
    color:#fff;
    padding:10px 15px;
    font-size:14px;
    border-radius:8px;
}
.fil-btn:hover{
    box-shadow:0 0 8px rgba(0,0,0,.5);
    transition:.3s all;
}
.slide-right{
    position:fixed;
    left:0;
    top:60px;
    z-index:999;
    font-size:15px;
    max-width:30px;
    padding:15px 6px;
    background:rgba(0,160,227,.7);
    border:none;
    color:#fff;
    border-radius: 0 10px 10px 0;
}
.slide-right span{
  writing-mode: vertical-rl;
  text-align:center;
}
.filter-links{
    padding:10px 20px;
    border:1px solid #eee;
    margin-bottom:20px;
}
.filter-links ul li{
    display:inline;
    padding:0 15px;
}
.filter-links ul li button{
    border:none;
    background:none;
    font-size:14px;
    font-weight:bold;
}
.filter-links ul li button:hover{
    color:#00a0e3;
    transition:.3s ease-in;
}
table{
    width:100%;
}
tr:nth-child(odd){
    background:#f2f2f2;
}
th, td {
  text-align: center;
  padding: 8px;
}
th{
   border:1px solid #e2e1e1;
   padding:15px 20px;
   min-height:100px; 
    position:sticky;
   position: -webkit-sticky; /* Safari */
   top:50px; 
   background:#fff
}
td{
    border:1px solid #e2e1e1;
    padding:15px 20px;
}
.boldfont{
    font-weight:bold;
}
.bgray{
   background:#f2f2f2;
   border:1px solid #e2e1e1;  
}
.btn-abso{
    position:absolute;
    top:0;
    right:0;
}
.btn-abso button{
    background:none;
    border:none;
    color:#000;
    font-size:14px;
}
.btn-abso button:hover{
    color:#00a0e3;
}
/*---Search bar---*/
.search-box {
    display: inline-block;
    width: 100%;
    border-radius: 3px;
    margin-bottom:10px;
    padding: 4px 0px 4px 0px;
    position: relative;
    background: #fff;
    border: 1px solid #ddd;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box.hovered, .search-box:hover, .search-box:active {
    border: 1px solid #aaa;
}
.search-box input[type=text] {
    border: none;
    box-shadow: none;
    display: inline-block;
    padding: 0;
    background: transparent;
}
.search-box input[type=text]:hover, .search-box input[type=text]:focus, .search-box input[type=text]:active {
    box-shadow: none;
}
.search-box .search-btn {
   position: absolute;
    right: 0px;
    top: 0px;
    color: #eee;
    font-size: 20px;
    padding: 5px 10px 5px;
    -webkit-transition: all 200ms ease-in-out;
    -moz-transition: all 200ms ease-in-out;
    transition: all 200ms ease-in-out;
}
.search-box .search-btn:hover {
    color: #fff;
    background-color: #00a0e3;
}
.search-form{
    margin-bottom:0px;
}
.form-control{
    height: 32px;
}
/*---Search bar ends---*/
.job-name{
    text-align:center;
    padding:5px 0 5px;
    position:relative;
}
.sticky-top{
    position:sticky;
   position: -webkit-sticky; /* Safari */
   top:50px;
   background:#fff;
}
.job-name img{
    max-width:70px;
    max-height:70px;
}
.jn{
    padding-top:10px;
    font-size:18px;
}
.module-list ul li{
    border:1px solid #e2e1e1;
    text-align:center;
    padding:10px 10px;
    font-weight:bold;
}
.module-list ul li:nth-child(even){
    background:#eee
}
/*---light box---*/
.lightbox-title, .internLight-title{
//    margin-bottom:15px;
    font-weight: 500;
    font-size: 24px;
    color: #444;
//    border-bottom: 1px solid #ddd;
//    padding:0 0px 15px;
}
.light-box, .internLight{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.8;
    display:none;
    z-index: 2000;
}
.main-inner, .internInner{
    width:100%;
    height:100%;
    display:none;
    background-color: #fff;
    border-radius: 10px;
    position:relative;
    padding:0 20px;
}
.main-inner{
    -webkit-overflow-scrolling: touch;
}
.main-outer, .internOuter{
    width:60%;
    height:70%;
    top:12%;
    left:20%;
    display: none;
    position: fixed;
    overflow:hidden;
    z-index: 2000;
}
@media(min-width : 1500px) {
    .main-outer{
        width: 70%;
        height: 70%;
        top:15%;
        left:15%;
    }
}
.ps__rail-x{
    display:none !important;
}
.ps-visible{
    overflow:visible !important;
    overflow-x:visible !important;
}

.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
//  padding: 8px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.twitter-typeahead{
    width:100%;
}
.twitter-typeahead input, .search-box input[type=text]{
    padding-left:15px;
    padding-right:90px;
}

/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 35px;
    top:1px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 20px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
.b-li-card:before{
    content:"";
    display:block;
    height:100%;
    position:absolute;
    top:0;
    left:0;
    width:95%;
    z-index:99;
    background-color:#ecececba;
}
.remove-compare{
    float: right;
    position: relative;
    margin-top: -10px;
    margin-bottom: 10px;
}
');
$script = <<<JS

    var dropped = [];

    unBlockC1();
     $('#company_2, #job_2, #company_3, #job_3').prop('disabled', true);
    
    function blockC1(){
        if($('#company_1').val() && $('#job_1').val()){
            $('#company_1, #job_1').prop('disabled', true);
        }
    }
    
    function unBlockC1(){
        droppable('#c1');
        $('#company_1_btn').addClass('hidden');
        $('#company_1, #job_1').prop('disabled', false);
    }
    
    function blockC2(){
        if($('#company_2').val() && $('#job_2').val()){
            $('#company_2, #job_2').prop('disabled', true);
        }
    }
    
    function unBlockC2(){
        droppable('#c2');
        $('#company_2_btn').addClass('hidden');
        $('#company_2, #job_2').prop('disabled', false);
    }
    
    function blockC3(){
        if($('#company_3').val() && $('#job_3').val()){
            $('#company_3, #job_3').prop('disabled', true);
        }
    }
    
    function unBlockC3(){
        droppable('#c3');
        $('#company_3_btn').addClass('hidden');
        $('#company_3, #job_3').prop('disabled', false);
    }
    
        var company_search = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '',
            remote: {
                url: '/jobs/get-companies?query={query}',
                wildcard: '{query}',
            },
        });
    
    
        $('#company_1, #company_2, #company_3').typeahead(null, {
            name: 'company_results',
            display: 'name',
            source: company_search,
            hint: true,
            minLength: 1,
            maxItem: 5
        }).on('typeahead:asyncrequest', function() {
            var c_spin = $(this).closest('.search-box').children()[0].getAttribute('id');
            $(c_spin).show();
        }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
            var c_spin = $(this).closest('.search-box').children()[0].getAttribute('id');
            $(c_spin).hide();
        }).on('typeahead:selected typeahead:completed',function(e,datum){
            var e = '#' + $(this).attr('id') + "_id";
            $(e).val(datum.id);           
            var f = '#' + $(this).attr('id');
            findJobInfo(datum.id, f);           
         });
    
    function findJobInfo(id, elem){
        var global = [];
        
        var job_search = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '',
            remote: {
                url: '/jobs/get-jobs',
                prepare: function (query, settings) {
                  settings.type = "POST";
                  settings.data = {
                      q: query,
                      id: id,
                      applications: [$('#c1').attr('data-info'), $('#c2').attr('data-info'), $('#c3').attr('data-info')]
                  };
                  return settings;
                },
                cache:true,
                filter: function(list){
                    global = list;
                    return list;
                }
            }
        });
        
        var job_elem = null;
        
        if(elem === '#company_1'){
            job_elem = '#job_1';
        }else if(elem === '#company_2'){
            job_elem = '#job_2';
        }else if(elem === '#company_3'){
            job_elem = '#job_3';
        }
        var spin_elen = job_elem + '_spin';
        var btn_elen = elem + '_btn';
        
        $(job_elem).typeahead(null, {
            name: 'job_results',
            display: 'name',
            source: job_search,
            hint: true,
            minLength: 1,
            maxItem: 5
        }).on('typeahead:asyncrequest', function() {
            $(spin_elen).show();
        }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
            $(spin_elen).hide();
        }).on('typeahead:selected typeahead:completed',function(e,datum){
            $(elem).prop('disabled', true);
            $(job_elem).prop('disabled', true);
            $(btn_elen).removeClass('hidden');
            addedToReview(datum.application_enc_id, $(this).parentsUntil('td').parent().attr('id'));
         })
         .blur(validateSelection);
        
        function validateSelection(){
            var theIndex = -1;
            if(global){
                for(var i = 0; i < global.length; i++){
                    if(global[i].name == $(this).val()){
                        theIndex = i;
                        break;
                    }
                }
            }
            if(theIndex == -1){
                $(this).val('');
                global = [];
            }
        }
    }
    
    function droppable(elem){
        $(elem).droppable({
            accept: '.draggable-item',
            over: function(event, ui) {
                $(elem).addClass('highlight');
            },
            out: function(event, ui) {
                $(elem).removeClass('highlight');
            },
            drop: function(event, ui) {
                var item_id = $.trim(ui.draggable.attr('data-id'));
                var dropped_elem_id = $(this).attr('id');
                var dropped_elem_data_id = $(this).attr('data-info');
                if(dropped.includes(dropped_elem_data_id)){
                    $('[data-id='+dropped_elem_data_id+']').draggable({disabled:false});
                    $('[data-id='+dropped_elem_data_id+']').removeClass('b-li-card');
                    var index = dropped.indexOf(dropped_elem_data_id);
                    dropped.splice(index, 1);
                }
                
                if(!dropped.includes(item_id)){
                    $('[data-id='+item_id+']').draggable({disabled:true});
                    $('[data-id='+item_id+']').addClass('b-li-card');
                    dropped.push(item_id);
                }
                addedToReview(item_id, dropped_elem_id, true);
                $(elem).removeClass('highlight');
            }
        });
    }

    function findJob(id, elem_id, hasDropped){
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                id: id
            },
            success: function(data){
                if(hasDropped){
                    if(elem_id === "c1"){
                        $('#company_1_btn').removeClass('hidden');
                        $('#company_1').val(data['message']['organization_name']);
                        $('#job_1').val(data['message']['name'] + " - " + data['message']['cat_name']);
                        blockC1();
                    }else if(elem_id === "c2"){
                        $('#company_2_btn').removeClass('hidden');
                        $('#company_2').val(data['message']['organization_name']);
                        $('#job_2').val(data['message']['name'] + " - " + data['message']['cat_name']);
                        blockC2();
                    } else{
                        $('#company_3_btn').removeClass('hidden');
                        $('#company_3').val(data['message']['organization_name']);
                        $('#job_3').val(data['message']['name'] + " - " + data['message']['cat_name']);
                        blockC3();
                    }
                }
                
                if(elem_id === 'c1'){
                    $('#c1').attr('data-info', data['message']['application_enc_id']);
                    if(!$('#c2').attr('data-info')){
                        unBlockC2();
                    }
                }else if (elem_id === 'c2'){
                    $('#c2').attr('data-info', data['message']['application_enc_id']);
                    if(!$('#c3').attr('data-info')){
                        unBlockC3();
                    }
                }else if(elem_id === 'c3'){
                    $('#c3').attr('data-info', data['message']['application_enc_id']);
                }
                
                 var working_days = JSON.parse(data['message']['working_days']);
                 var days = {
                     1 : "Monday",
                     2 : "Tuesday",
                     3 : "Wednesday",
                     4 : "Thursday",
                     5 : "Friday",
                     6 : "Satday",
                     7 : "Sunday",
                 };
                 
                 var d = '';
                 
                 for(var i = 0; i < working_days.length; i++){
                     if(days[working_days[i]]){
                         d += days[working_days[i]] + " ";
                     }
                 }
                 
                 var sum = 0;
                 var plocs = '';
                 
                 for(var i = 0; i < data.message['applicationPlacementLocations'].length; i++){
                     sum += parseInt(data.message['applicationPlacementLocations'][i]['positions']);
                     if(i === data.message['applicationPlacementLocations'].length - 1){
                        var l = data.message['applicationPlacementLocations'][i]['name'];
                     }else{
                        var l = data.message['applicationPlacementLocations'][i]['name'] + ", ";
                     }
                     plocs += l;
                 }
                 
                 var ilocs = '';
                 
                 for(var i = 0; i < data.message['applicationInterviewLocations'].length; i++){
                     if(i === data.message['applicationInterviewLocations'].length - 1){
                        var f = data.message['applicationInterviewLocations'][i]['name'];
                     }else{
                        var f = data.message['applicationInterviewLocations'][i]['name'] + ", ";
                     }
                     ilocs += f;
                 }
                 
                 var assel = assignElems(elem_id);
                 
                if(d){ 
                    document.getElementById(assel.jobs_days_elem).innerHTML = d;
                }
                if(data['message']['timings_from']){
                    document.getElementById(assel.jobs_timings_elem).innerHTML = data['message']['timings_from'] + "-" + data['message']['timings_to'];
                }
                if(plocs){
                    document.getElementById(assel.jobs_plocation_elem).innerHTML = plocs;
                }
                if(ilocs){
                    document.getElementById(assel.jobs_ilocation_elem).innerHTML = ilocs;
                }
                if(sum){
                    document.getElementById(assel.jobs_vacancy_elem).innerHTML = sum;
                }
                if(data['message']['experience']){
                    document.getElementById(assel.jobs_experience_elem).innerHTML = data['message']['experience'];
                }
                if(data['message']['amount']){
                    document.getElementById(assel.jobs_salary_elem).innerHTML = data['message']['amount'];
                }
                if(data['message']['type']){
                    document.getElementById(assel.jobs_type_elem).innerHTML = data['message']['type'];
                }
                if(data['message']['designation']){
                    document.getElementById(assel.jobs_designation_elem).innerHTML = data['message']['designation'];
                }
                if(data['message']['cat_name']){
                    document.getElementById(assel.jobs_profile_elem).innerHTML = data['message']['cat_name'];
                }
                if(data['message']['name']){
                    document.getElementById(assel.jobs_title_elem).innerHTML = data['message']['name'];
                }
                document.getElementById(assel.jobs_image_elem).setAttribute('src', '/assets/common/categories/profile/' + data['message']['icon_png']);
                
                var aer = '';
                for(var i = 0; i < data.message['applicationEducationalRequirements'].length; i++){
                    var p = "<li>- " + data['message']['applicationEducationalRequirements'][i]['educational_requirement'] + "</li>";    
                    aer += p;
                }
                if(aer){
                    document.getElementById(assel.jobs_education_elem).innerHTML = aer;
                }
                
                var apl = '';
                for(var i = 0; i < data.message['applicationJobDescriptions'].length; i++){
                    var t = "<li>- " +  data['message']['applicationJobDescriptions'][i]['job_description'] + "</li>";
                    apl += t;
                }
                if(apl){
                    document.getElementById(assel.jobs_jd_elem).innerHTML = apl;
                }
                
                var as = '';
                for(var i = 0; i < data.message['applicationSkills'].length; i++){
                    var k = "<li>- "  + data['message']['applicationSkills'][i]['skill'] + "</li>";    
                    as += k;
                }
                if(as){
                    document.getElementById(assel.jobs_skills_elem).innerHTML = as;
                }
            }
        })
    }
    
    
    $(document).on('click', '#company_1_btn,#company_2_btn,#company_3_btn', function(e){
        emptyInp(e.target.getAttribute('id'));
    });
    function emptyInp(elem){
                if(elem === "company_1_btn"){
                    $("#job_1").typeahead("destroy");
                    $("#company_1").val("");
                    $("#job_1").val("");
                    removeVals('c1');
                    var dataid = $('#c1').attr('data-info');
                    if(dropped.includes(dataid)){
                        $('[data-id='+dataid+']').draggable({disabled:false});
                        $('[data-id='+dataid+']').removeClass('b-li-card');
                        var index = dropped.indexOf(dataid);
                        dropped.splice(index, 1);
                    
                    }
                    $('#company_2, #job_2').prop('disabled', true);
                    $('#company_3, #job_3').prop('disabled', true);
                    $("#company_1, #job_1").prop('disabled', false);
                    $("#company_1_btn").addClass('hidden');
                }
                if(elem === "company_2_btn"){
                    $("#job_2").typeahead("destroy");
                    $("#company_2").val("");
                    $("#job_2").val("");
                    removeVals('c2');
                    var dataid = $('#c2').attr('data-info');
                    if(dropped.includes(dataid)){
                        $('[data-id='+dataid+']').draggable({disabled:false});
                        $('[data-id='+dataid+']').removeClass('b-li-card');
                        var index = dropped.indexOf(dataid);
                        dropped.splice(index, 1);
                    }
                    $('#company_3, #job_3').prop('disabled', true);
                    $('#company_1, #job_1').prop('disabled', true);
                    $("#company_2, #job_2").prop('disabled', false);
                    $("#company_2_btn").addClass('hidden');
                }
                if(elem === "company_3_btn"){
                    $("#job_3").typeahead("destroy");
                    $("#company_3").val("");
                    $("#job_3").val("");
                    removeVals('c3');
                    var dataid = $('#c3').attr('data-info');
                    if(dropped.includes(dataid)){
                        $('[data-id='+dataid+']').draggable({disabled:false});
                        $('[data-id='+dataid+']').removeClass('b-li-card');
                        var index = dropped.indexOf(dataid);
                        dropped.splice(index, 1);
                    }
                    $('#company_2, #job_2').prop('disabled', true);
                    $('#company_1, #job_1').prop('disabled', true);
                    $("#company_3, #job_3").prop('disabled', false);
                    $("#company_3_btn").addClass('hidden');
                }
    }
    
    function assignElems(elem_id){
        var assigned = {
             jobs_days_elem : elem_id + '_days', 
             jobs_timings_elem : elem_id + '_timings', 
             jobs_plocation_elem : elem_id + '_plocation', 
             jobs_ilocation_elem : elem_id + '_ilocation', 
             jobs_vacancy_elem : elem_id + '_vacancy',
             jobs_experience_elem : elem_id + '_experience', 
             jobs_salary_elem : elem_id + '_salary',
             jobs_type_elem : elem_id + '_type',
             jobs_designation_elem : elem_id + '_designation', 
             jobs_profile_elem : elem_id + '_profile',
             jobs_title_elem : elem_id + '_title', 
             jobs_image_elem : elem_id + '_image', 
             jobs_education_elem : elem_id + '_education', 
             jobs_jd_elem : elem_id + '_jd', 
             jobs_skills_elem : elem_id + '_skills'
        };
        return assigned;
    }
    
    function removeVals(e){
        var assel = assignElems(e);
        document.getElementById(assel.jobs_skills_elem).innerHTML = '';
        document.getElementById(assel.jobs_jd_elem).innerHTML = '';
        document.getElementById(assel.jobs_education_elem).innerHTML = '';
        document.getElementById(assel.jobs_days_elem).innerHTML = '';
        document.getElementById(assel.jobs_timings_elem).innerHTML = '';
        document.getElementById(assel.jobs_plocation_elem).innerHTML = '';
        document.getElementById(assel.jobs_ilocation_elem).innerHTML = '';
        document.getElementById(assel.jobs_vacancy_elem).innerHTML = '';
        document.getElementById(assel.jobs_experience_elem).innerHTML = '';
        document.getElementById(assel.jobs_salary_elem).innerHTML = '';
        document.getElementById(assel.jobs_type_elem).innerHTML = '';
        document.getElementById(assel.jobs_designation_elem).innerHTML = '';
        document.getElementById(assel.jobs_profile_elem).innerHTML = '';
        document.getElementById(assel.jobs_title_elem).innerHTML = '';
        document.getElementById(assel.jobs_image_elem).setAttribute('src', '');
    }

    function addedToReview(item_id, dropped_elem_id, hasDropped = false){
        findJob(item_id, dropped_elem_id, hasDropped);
    }
    
    $(document).on('click', '.search-btn', function(e){
       e.preventDefault(); 
    });
    
    draggable = true;
    review_list_draggable = true;
    var sidebarpage = 1;
    getReviewList(sidebarpage);
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>