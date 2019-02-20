<div class="window-popup message-popup">
    <a href="#" class="popup-close">
        <i class="fa fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h3>Select Date and time for Interview</h3>
        </header>
        <div class="content">
            <div class="row">
                <form id="interview_form">
                    <div class="col-md-12">
                        <div class="tab">
                            <div class="form-group">
                                <div class="with-icon">
                                    <select id="candidates" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="300">
                                            <option value="User 1" style="background-image:url(/assets/themes/dashboard/layouts/layout2/img/avatar3_small.jpg);">User 1</option>
                                            <option value="User 2"><canvas class="user-icon" name="ajay" color="#000" width="20" height="20" font="10px"></canvas>User 2</option>
                                            <option value="User 3" selected="selected"><img src="/assets/themes/dashboard/layouts/layout2/img/avatar3_small.jpg" class="interviewer_avatar"/>User 3</option>
                                            <option value="User 4"><canvas class="user-icon" name="aditya" color="#6f0b0b" width="20" height="20" font="10px"></canvas>User 4</option>
                                            <option value="User 5"><img src="/assets/themes/dashboard/layouts/layout2/img/avatar3_small.jpg" class="interviewer_avatar"/>User 5</option>
                                    </select>
                                    <i class="utouch-icon utouch-icon-user fa fa-user"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="with-icon">
                                    <input type="text" class="form-control input-large"
                                           placeholder="Interviewer Email Ids" data-role="tagsinput" id="email">
                                    <i class="utouch-icon utouch-icon-user fa fa-envelope-o"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="with-icon">
                                    <input class="form-control form-control-inline input-medium date-picker"
                                           placeholder="Select Dates For Interview" size="16" type="text"
                                           id="datepicker" value=""/>
                                    <i class="utouch-icon utouch-icon-user fa fa-calendar-o"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="with-icon timepicker-main">
                                    <input type="text" class="form-control timepicker" id="interview_slots"
                                           placeholder="Interview Duration">
                                    <i class="utouch-icon utouch-icon-user fa fa-clock-o"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="with-icon">
                                    <select name="color" class="form-control" id="location">
                                        <option value="">Select Interview Medium</option>
                                        <option>In Place</option>
                                        <option>Conference Call</option>
                                        <option>Phone</option>
                                        <option>Skype</option>
                                        <option>Online</option>
                                        <option>Google Hangouts</option>
                                    </select>
                                    <i class="utouch-icon utouch-icon-user fa fa-check"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="with-icon">
                                    <textarea class="form-control" value="" placeholder="Interview Notes" id="notes"></textarea>
                                    <i class="utouch-icon utouch-icon-user fa fa-pencil"></i>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div id="selected-dates"></div>
                            </div>
                        </div>
                        <div class="row" style="float:right;">
                            <button type="button" class="btn btn-warning" id="previous">Previous</button>
                            <button type="button" class="btn btn-success" id="next">Next</button>
                            <button type="button" class="btn btn-success" id="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </article>

</div>
<?php
$this->registerCss('
#submit{
    display:none;
}
.close_schedule{
    background: #b1b1b1bd;
    border: 0px;
    position: absolute;
    right: -10px;
    top: 0;
    font-size: 35px;
    color: #fff;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 0px 0px 0px 15px !important;
}
    .bootstrap-tagsinput{
        border-radius: 6px;
        background-color: #fff;
    }
    .bootstrap-tagsinput input{
        box-shadow:none !important;
        border-color: transparent;
    }
    .bootstrap-tagsinput input:focus{
        outline: none;
    }
    .input-medium{
        width: 100% !important;
    }
    .time-slots{
        margin: 15px 0px;
    }
    .remove-add{
        line-height: 34px;
        font-size: 20px;
    }
    .date-picker{
        margin: auto;
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #c2cad8;
    }
    .timepicker {
        border-radius: 4px !important;
    }
    textarea{
        resize: none;
    }
    .bootstrap-tagsinput{
        padding: 0px 10px 0px;
    }
    input{
        background-color:#fff;
    }
/* Top Radio filter css ends */
.datepicker>div {
    display: block;
}
.multiselect-container li a label input[type="checkbox"] {
    display: none;
}
.dropdown-menu>li.active:hover>a, .dropdown-menu>li.active>a, .dropdown-menu>li:hover>a{
    background-color: #337ab7;
    color: #fff;
}
.multiselect.dropdown-toggle.btn.btn-default{
    border: 0px;
    padding-top: 4px;
    width: 100%;
    text-align: left;
    background-color:#fff !important;
}
.multiselect.dropdown-toggle.btn.btn-default:hover, .multiselect.dropdown-toggle.btn.btn-default:focus, .multiselect.dropdown-toggle.btn.btn-default:active{
    background-color:#fff;
}
.multiselect.dropdown-toggle.btn.btn-default b.caret{
    float: right;
    margin-top: 6px;
}
.btn-group.open .multiselect-container.dropdown-menu{
    left:51px;
}
/* Modal light box css starts */
.tab{
    display: none;
}
/* Modal light box css ends */
/*Modal css starts */
.content-wrapper {
    position: relative;
    display: block;
    max-width: 560px;
    margin: 100px auto;
    padding: 1.5rem 3.5rem;
    background-color: white;
    border-radius: 10px;
//    box-shadow: 0px -15px 0px 0px rgba(69, 74, 79, 0.5), 15px -30px 0px 0px rgba(69, 74, 79, 0.5), 30px -45px 0px 0px rgba(69, 74, 79, 0.5), 45px -60px 0px 0px rgba(69, 74, 79, 0.5);
    transition: transform 0.25s;
    transition-delay: 0.15s;
}
.content-wrapper .modal-header {
    position: relative;
    width: 100%;
    margin: 0;
    padding: 0 0 0.25rem;
    margin-bottom: 10px;
    text-align:center;
}
.content-wrapper .modal-header h2 {
    font-size: 1.5rem;
    font-weight: bold;
}
.content-wrapper .content {
    position: relative;
    display: block;
    text-align:center;
}
.action {
    position: relative;
    width: 100%;
    height: 53px;
    padding: 0.625rem 1.25rem;
    border: none;
    background-color: slategray;
    border-radius: 0.25rem;
    color: white;
    font-size: 0.87rem;
    font-weight: 300;
    overflow: hidden;
    z-index: 1;
    background-color: #e74c3c;
}
.action:before {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 0%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.2);
    transition: width 0.25s;
    z-index: 0;
}
.action:hover:before {
    width: 100%;
}
.with-icon {
    position: relative;
}
.has-error .with-icon input, .has-error .with-icon textarea {
    border: 1px solid #ff00004d !important;
}
.has-success .form-control {
    border-color: transparent !important;
}
.multiselect-native-select .btn-group, .bootstrap-tagsinput, #interview_form input, #interview_form textarea, #interview_form select{
    padding: 13px 40px;
    border: 1px solid transparent;
    transition: all .3s ease;
    font-size: 16px;
    color: #273f5b;
    margin-bottom: 20px;
    border-radius: 50px!important;
    height:53px;
    background-color: #fff;
    box-shadow: 0 0 30px 0 rgba(18, 25, 33, 0.15)!important;
    width: 100% !important;
    outline: none !important;
    padding-left: 50px !important;
}
#interview_form input:focus, #interview_form textarea:focus{
    -webkit-box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25);
    box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25);
//    color: #0083ff !important;
    outline: 0 !important;
}
#interview_form .bootstrap-tagsinput input{
    box-shadow: none !important;
    padding: 0 !important;
    height: auto !important;
    padding-left: 5px !important;
    margin-bottom: 0px;
    width: auto !important;
}
.bootstrap-tagsinput input:focus{
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
}
.bootstrap-tagsinput{
    text-align:left;
    min-height: 53px;
    height: auto;
}
.with-icon .utouch-icon {
    position: absolute !important;
    left: 12px !important;
    top: 18px !important;
    height: 16px !important;
    border-right: 1px solid #dbe3ec !important;
    z-index: 1 !important;
    transition: all .3s ease !important;
    padding-left: 6px !important;
    padding-right: 8px !important;
}
.utouch-icon {
    transition: all .3s ease !important;
    width: 32px !important;
}
//.with-icon input:focus + .utouch-icon, .with-icon textarea:focus + .utouch-icon, .with-icon select:focus + .utouch-icon {
//    color: #0083ff !important;
//}
textarea {
    height: 120px !important;
    border-radius: 30px !important;
}
.window-popup, .window-popup2 {
    opacity: 0;
    visibility: hidden;
    background-color: #66b5ff;
    position: fixed;
    top: 0;
    width: calc(100% + 20px);
    height: 100%;
    -webkit-transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -o-transition: opacity .5s ease, transform .5s ease, scale .6s ease;
    transition: opacity .0s ease, transform .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
    z-index: 50;
    right: -17px;
}
.window-popup.open {
    opacity: 1;
    z-index: 999999;
    visibility: visible;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    overflow: auto;
    background-color: #000000ba;
}
.popup-close {
    border-radius: 0 0 0 30px;
    background-color: #131a22;
    width: 80px;
    height: 80px;
    font-size: 40px;
    text-align: center;
    line-height: 80px;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 99999;
    transition: all .0s ease;
}
.sc_remove::-webkit-scrollbar { width: 0 !important }
.sc_remove { -ms-overflow-style: none; overflow: hidden; overflow: -moz-scrollbars-none; }
/*Modal css ends */
');
$script = <<<JS
    $('#candidates').multiselect();

    $(document).on('click', '#schedule-interview', function () {
        $('.window-popup').addClass('open');
        $('body').toggleClass('sc_remove');
    });

    $(document).on('click', '.popup-close', function (e) {
        e.preventDefault();
        $('.window-popup').removeClass('open');
        $('#interview_form')[0].reset();
        $('body').toggleClass('sc_remove');
    });

    var currentTab = 0;

    showTab(currentTab);
   
    $('#previous').on('click', function(){
        $('#selected-dates').html('');
        nextPrev(-1);
    });
   
    $('#next').on('click', function(){
        var date_picker_value = $('#datepicker').val();
        if(date_picker_value != ''){
            nextPrev(1);
        }
        else{
            return false;
        }
    });
        
    function nextPrev(n){
        var x = document.getElementsByClassName('tab');
        if(n==1){
            addTimes();
        }
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if(currentTab >= x.length){
            return false;
        }
        showTab(currentTab);
    }
        
    function showTab(n) {
        var x = document.getElementsByClassName('tab');
        x[n].style.display = "block";
        if (n == 0) {
            document.getElementById('previous').style.display = "none";
        } else {
            document.getElementById('previous').style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById('next').style.display = "none";
            document.getElementById('submit').style.display = "inline";
            //            document.getElementById('next').innerHTML = 'Submit';
        } else {
            document.getElementById('next').style.display = "inline";
            document.getElementById('submit').style.display = "none";
            //            document.getElementById('next').innerHTML = 'Next';
        }
    }
        
    $(document).on('click', '#add-more', function(){
       $(this).closest('div').prev('#times-container').append(Mustache.render($('#add-more-d').html()));
    });
        
    $(document).on('click', '.remove-add', function(){
        $(this).closest('#added-date').remove()
    });
        
    $(document).on('focus', '.timepicker-24', function(){
        $(this).timepicker(); 
    });
    
    $(document).on('focus', '#interview_slots', function(){
        $(this).timepicker({
            stepping:15,
            showMeridian:false,
            defaultTime: '00:00:00'
        }); 
    });
        
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        multidate: true,
        startDate: '-0m'
    });
        
    function convert(str) {
        var mnths = {
                Jan: "01",
                Feb: "02",
                Mar: "03",
                Apr: "04",
                May: "05",
                Jun: "06",
                Jul: "07",
                Aug: "08",
                Sep: "09",
                Oct: "10",
                Nov: "11",
                Dec: "12"
            },
            date = str.split(" ");
    
        return [date[2], mnths[date[1]], date[3]].join("-");
    }
        
    var dates = [];
        
    function addTimes() {
        dates = [];
        //        var time_intervals = [];
        var the_date = $('.date-picker:first').datepicker('getDates');
        for (var j = 0; j < the_date.length; j++) {
            var s_date = convert(the_date[j].toString());
            dates.push({
                date: s_date
            });
        }
    
        $('#selected-dates').append(Mustache.render($('#dates').html(), dates));
        //        var time_l = $('.time-slots').length;
        //        for(var i = 1; i<= time_l; i++){
        //            time_intervals.push({'start' : $('#start-time-'+i).val(), 'end': $('#end-time-'+i).val()});
        //        }
    }
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/plugins.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/components.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('http://davidstutz.de/bootstrap-multiselect/dist/css/bootstrap-multiselect.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="dates" type="text/template">
    {{#.}}
    <div class="form-group">

        <div class="col-md-12 text-center"><h4>{{date}}</h4></div>

        <div class="col-md-12">
            <div class="row">
                <div id="row1" class="row time-slots">
                    <div class="col-md-5">
                        <div class="input-group timepicker-main">
                            <input type="text" class="form-control timepicker timepicker-24" id="start-time-1"
                                   placeholder="from">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h5>-</h5>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group timepicker-main">
                            <input type="text" class="form-control timepicker timepicker-24" id="end-time-1"
                                   placeholder="to">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="times-container"></div>
        <div class="col-md-12 text-left">
            <a href="#" id="add-more"><i class="fa fa-plus-circle"></i> Add more</a>
        </div>
    </div>
    {{/.}}
</script>

<script id="add-more-d" type="text/template">
    <div style="padding:0px;margin-top:15px;" id="added-date" class='col-md-12'>
        <div class='col-md-5'>
            <div class='input-group timepicker-main'>
                <input type='text' class='form-control timepicker timepicker-24' placeholder='from'>
            </div>
        </div>
        <div class='col-md-1'>
            <h5>-</h5>
        </div>
        <div class='col-md-5'>
            <div class='input-group timepicker-main'>
                <input type='text' class='form-control timepicker timepicker-24' placeholder='to'>
            </div>
        </div>
        <div class='col-md-1'>
            <a class='remove-add'>
                <i class='fa fa-times'></i>
            </a>
        </div>
    </div>
</script>
