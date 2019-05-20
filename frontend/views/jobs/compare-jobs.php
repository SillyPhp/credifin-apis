<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>

    <div style="position: fixed;width: 100%;z-index: 99;top: 110px;right: 0; border-right:1px solid #ddd;">
        <div class="row row-offcanvas active">
            <div class="sidebar-offcanvas sidebar">
                <?=
                $this->render('/widgets/sidebar-review', [
                    'type' => 'jobs',
                ]);
                ?>
            </div>
            <a type="button" id="change" class="btn btn-collapse btn-" data-toggle="offcanvas"><i
                        class="glyphicon glyphicon-chevron-down"></i> <span id="change-text">Review List</span></a>
        </div>
    </div>

    <section>
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <table>
                        <tr>
                            <td width="10%" class="boldfont"> Choose Jobs you want to compare</td>
                            <form>
                                <td width="30%" class="empty" id="c1">
                                    <div class='search-box'>
                                        <div class="load-suggestions Typeahead-spinner company1-spin"
                                             style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input id="company_1" class='form-control' placeholder='Choose Company'
                                               type='text'>
                                        <input id="company_1_id" class='form-control' type='hidden'>
                                        <button class='btn btn-link search-btn'>
                                            <i class='fa fa-search'></i>
                                        </button>
                                    </div>
                                    <div class='search-box'>
                                        <div class="load-suggestions Typeahead-spinner job1-spin"
                                             style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input id="job_1" class='form-control' placeholder='Choose Job' type='text'>
                                        <input id="job_1_id" class='form-control' type='hidden'>
                                        <button class='btn btn-link search-btn'>
                                            <i class='fa fa-search'></i>
                                        </button>
                                    </div>
                                </td>
                                <td width="30%" class="empty" id="c2">
                                    <div class='search-box'>
                                        <div class="load-suggestions Typeahead-spinner company2-spin"
                                             style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input id="company_2" class='form-control' placeholder='Choose Company'
                                               type='text'>
                                        <input id="company_2_id" class='form-control' type='hidden'>
                                        <button class='btn btn-link search-btn'>
                                            <i class='fa fa-search'></i>
                                        </button>
                                    </div>
                                    <div class='search-box'>
                                        <div class="load-suggestions Typeahead-spinner job2-spin"
                                             style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input id="job_2" class='form-control' placeholder='Choose Job' type='text'>
                                        <input id="job_2_id" class='form-control' type='hidden'>
                                        <button class='btn btn-link search-btn'>
                                            <i class='fa fa-search'></i>
                                        </button>
                                    </div>
                                </td>
                                <td width="30%" class="empty" id="c3">
                                    <div class='search-box'>
                                        <div class="load-suggestions Typeahead-spinner company3-spin"
                                             style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input id="company_3" class='form-control' placeholder='Choose Company'
                                               type='text'>
                                        <input id="company_3_id" class='form-control' type='hidden'>
                                        <button class='btn btn-link search-btn'>
                                            <i class='fa fa-search'></i>
                                        </button>
                                    </div>
                                    <div class='search-box'>
                                        <div class="load-suggestions Typeahead-spinner job3-spin"
                                             style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <input id="job_3" class='form-control' placeholder='Choose Job' type='text'>
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
                                    <img id="job1_image" src="">
                                </div>
                            </th>
                            <th>
                                <div class="job-name">
                                    <img id="job2_image" src="">
                                </div>
                            </th>
                            <th>
                                <div class="job-name">
                                    <img id="job3_image" src="">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Job Profile
                            </td>
                            <td id="job1_profile">
                            </td>
                            <td id="job2_profile">
                            </td>
                            <td id="job3_profile">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Designation
                            </td>
                            <td id="job1_designation">
                            </td>
                            <td id="job2_designation">
                            </td>
                            <td id="job3_designation">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Job Type
                            </td>
                            <td id="job1_type">
                            </td>
                            <td id="job2_type">
                            </td>
                            <td id="job3_type">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Offered Salary
                            </td>
                            <td id="job1_salary">
                            </td>
                            <td id="job2_salary">
                            </td>
                            <td id="job3_salary"`>
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Experience
                            </td>
                            <td id="job1_experience">
                            </td>
                            <td id="job2_experience">
                            </td>
                            <td id="job3_experience">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Total Vacancies
                            </td>
                            <td id="job1_vacancy">
                            </td>
                            <td id="job2_vacancy">
                            </td>
                            <td id="job3_vacancy">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Location
                            </td>
                            <td id="job1_plocation">
                            </td>
                            <td id="job2_plocation">
                            </td>
                            <td id="job3_plocation">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Working Days
                            </td>
                            <td id="job1_days">
                            </td>
                            <td id="job2_days">
                            </td>
                            <td id="job3_days">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Work Timing
                            </td>
                            <td id="job1_timings">
                            </td>
                            <td id="job2_timings">
                            </td>
                            <td id="job3_timings">
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Required Knowledge, Skills, and Abilities
                            </td>
                            <td>
                                <ul id="job1_skills">
                                </ul>
                            </td>
                            <td>
                                <ul id="job2_skills">
                                </ul>
                            </td>
                            <td>
                                <ul id="job3_skills">
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Job Description
                            </td>
                            <td>
                                <ul id="job1_jd">
                                </ul>
                            </td>
                            <td>
                                <ul id="job2_jd">
                                </ul>
                            </td>
                            <td>
                                <ul id="job3_jd">
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Education
                            </td>
                            <td>
                                <ul id="job1_education">
                                </ul>
                            </td>
                            <td>
                                <ul id="job2_education">
                                </ul>
                            </td>
                            <td>
                                <ul id="job3_education">
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="boldfont">
                                Interview Locations
                            </td>
                            <td id="job1_ilocation">
                            </td>
                            <td id="job2_ilocation">
                            </td>
                            <td id="job3_ilocation">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

<?php

echo $this->render('/widgets/mustache/application-card', [
    'type' => 'Jobs',
]);

$this->registerCss('
.invisible{
    display:none;
}
body{
    background-color:#fff !important;
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
/*---light box end---*/
@media screen and (min-width: 768px) {
  .row-offcanvas {
    position: relative;
    left: 235px;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas.active {
    left: 0;
    max-width:300px;
  }
  .row-offcanvas .sidebar-offcanvas {
    position: absolute;
    top: 0;
    left: -220px;
    width: 230px;
  }
}
@media screen and (max-width: 767px) {
  .row-offcanvas {
    left: 0;
    position: relative;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas.active {
    left: 50%;
  }
  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 50%;
    left: -50%;
  }
}
.sidebar {
  padding: 10px 25px 10px 12px;
  margin-top: -20px;
  border-radius: 0px 10px 10px 0px;
}
.sidebar h3{
    margin-top:10px;
}
.btn-collapse {
  position: absolute;
  padding: 8px 12px;
  border-radius: 0px 0px 10px 10px;
  top: 20px;
  left: 0;
  margin-left: -26px;
  background: rgba(51, 122, 183, 0.7);
  color:#fff;
  transform: rotate(-90deg);
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.row-offcanvas.active .btn-collapse {
    top:30px;
  left: 0px;
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.row-offcanvas.active .btn-collapse i {
  transform: rotate(180deg);
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
');
$script = <<<JS

    var added_classes = [];

    if(!added_classes.includes('c1')){
        $('#company_2, #company_3, #job_2, #job_3').attr('readonly', true);
    }
    
    var added = {
        jobs: []
    };
    
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
        $('.company1-spin').show();
    }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
        $('.company1-spin').hide();
    }).on('typeahead:selected typeahead:completed',function(e,datum){
        $('#company_1_id').val(datum.id);
        findJobInfo(datum.id);           
     });

    function findJobInfo(id){
        
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
                      applications: added.jobs
                  };
                  return settings;
                }
            }
        });
        
        $('#job_1, #job_2, #job_3').typeahead(null, {
            name: 'job_results',
            display: 'name',
            source: job_search,
            hint: true,
            minLength: 1,
            maxItem: 5
        }).on('typeahead:asyncrequest', function() {
            $('.job1-spin').show();
        }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
            $('.job1-spin').hide();
        }).on('typeahead:selected typeahead:completed',function(e,datum){
            $('#job_1_id').val(datum.application_enc_id);
            addedToReview(datum.application_enc_id, $(this).parent().parent().parent());
         });
    }
 
    $('[data-toggle=offcanvas]').click(function () {
     $('.row-offcanvas').toggleClass('active');
    });  
 
    $(document).on('click', '#change',function() {
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
    });

    $('.empty').droppable({
        accept: '.draggable-item',
        over: function(event, ui) {
            $('.empty').addClass('highlight');
        },
        out: function(event, ui) {
            $('.empty').removeClass('highlight');
        },
        drop: function(event, ui) {
            var item_id = $.trim(ui.draggable.attr('data-id'));
            var dropped_elem_id = $(this).attr('id');
            addedToReview(item_id, dropped_elem_id);
            $('.empty').removeClass('highlight');
        }
    });

    function findJob(id){
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                id: id
            },
            success: function(data){
                console.log(data);
                
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
                 
                 
                $('#job1_days').html(d);
                $('#job1_timings').html(data['message']['timings_from'] + "-" + data['message']['timings_to']);
                $('#job1_plocation').html(plocs);
                $('#job1_ilocation').html(ilocs);
                $('#job1_vacancy').html(sum);
                $('#job1_experience').html(data['message']['experience']);
                $('#job1_salary').html(data['message']['amount']);
                $('#job1_type').html(data['message']['type']);
                $('#job1_designation').html(data['message']['designation']);
                $('#job1_profile').html(data['message']['name']);
                $('#job1_image').attr('src', '/assets/common/categories/profile/' + data['message']['icon_png']);
                
                var aer = '';
                for(var i = 0; i < data.message['applicationEducationalRequirements'].length; i++){
                    var p = "<li>- " + data['message']['applicationEducationalRequirements'][i]['educational_requirement'] + "</li>";    
                    aer += p;
                }
                $('#job1_education').html(aer);
                
                var apl = '';
                for(var i = 0; i < data.message['applicationJobDescriptions'].length; i++){
                    var t = "<li>- " +  data['message']['applicationJobDescriptions'][i]['job_description'] + "</li>";
                    apl += t;
                }
                $('#job1_jd').html(apl);
                
                var as = '';
                for(var i = 0; i < data.message['applicationSkills'].length; i++){
                    var k = "<li>- "  + data['message']['applicationSkills'][i]['skill'] + "</li>";    
                    as += k;
                }
                $('#job1_skills').html(as);
            }
        })
    }

    function addedToReview(item_id, dropped_elem_id){
        $('[data-id='+item_id+']').draggable({disabled:true});
        console.log(dropped_elem_id);
        findJob(item_id);
    }   

    draggable = true;
    var sidebarpage = 1;
    getReviewList(sidebarpage);
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>