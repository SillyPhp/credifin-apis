<div class="light-box"></div>
<div class="main-outer">
    <div class="main-inner">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <h2 class="text-center">Select Date and time for Interview</h2>
                    <a class="close_schedule">&times;</a>
                    <div class="tab">
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-4">Interviewer</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control input-large" data-role="tagsinput" id="email"> </div>
                            </div>
                            <div class="form-group">
                                <label for="color" class="control-label col-md-4">Select Color</label>
                                <div class="col-md-8">
                                    <select name="color" class="form-control" id="color" style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                        <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                        <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                        <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                        <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                        <option style="color:#000;" value="#000">&#9724; Black</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Select Interview Date</label>
                                <div class="col-md-8">
                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" id="datepicker" value="" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-4">Select Inteview Duration</label>
                                <div class="col-md-8">
                                    <select name="interview_slots" class="form-control" id="interview_slots" style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <option>15 minutes</option>
                                        <option>30  minutes</option>
                                        <option>45 minutes</option>
                                        <option>60 minutes</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="color" class="control-label col-md-4">Medium</label>
                                <div class="col-md-8">
                                    <select name="color" class="form-control" id="location" style="background-color: #eef1f5; ">
                                        <option value="">Choose</option>
                                        <option>In Place</option>
                                        <option>Conference Call</option>
                                        <option>Phone</option>
                                        <option>Skype</option>
                                        <option>Online</option>
                                        <option>Google Hangouts</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Notes</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" value="" id="notes" style="background-color: #eef1f5; "></textarea>
                                </div>
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
                </form>
            </div>
        </div>
    </div>
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
a:hover{
    text-decoration:none;
}

.page-container-bg-solid .page-content{
        background-color: #fff;
    }
    .bootstrap-tagsinput{
        border-radius: 6px;
        background-color: #eef1f5;
    }
    .timepicker{
        background-color: #eef1f5;
    }
    .bootstrap-tagsinput input{
        box-shadow:none !important;
        border-color: transparent;
        background-color: #eef1f5;
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
        background-color: #eef1f5;
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

/* Top Radio filter css ends */
.datepicker>div {
    display: block;
}
/* Modal light box css starts */
.form {
    padding: 0 16px;
    max-width: 750px;
    margin: 15px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}
.form h2{
    margin-bottom:15px;
}
.light-box{
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
.main-inner{
    width:100%;
    height:100%;
    display:none;
    background-color: #fff;
    border-radius: 10px !important;
    position:relative;
    padding: 0px 25px;
    padding-bottom: 20px;
    overflow:hidden;
}
.main-outer{
    width:60%;
    height:80%;
    top:10%;
    left:20%;
    display: none;
    position: fixed;
    overflow:hidden;
    z-index: 2000;
    background-color: #fff;
    border-radius: 10px !important;
}
.main-inner form {
    padding: 0 16px;
    max-width: 750px;
    margin: 15px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}
.main-inner form h2{
    margin-bottom:15px;
}
@media(min-width : 1500px) {
    .main-outer{
        width: 50%;
        height: 70%;
        top:15%;
        left:25%;
    }
}
.tab{
    display: none;
}
/* Modal light box css ends */
');
$script = <<<JS
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
        
   function showTab(n){
        var x = document.getElementsByClassName('tab');
        x[n].style.display = "block";
        if(n==0){
            document.getElementById('previous').style.display = "none";
        }else{
            document.getElementById('previous').style.display = "inline";
        }
        if(n==(x.length-1)){
            document.getElementById('next').style.display = "none";
            document.getElementById('submit').style.display = "inline";
//            document.getElementById('next').innerHTML = 'Submit';
        }else{
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
        
    $(document).on('focus', '.timepicker', function(){
        $(this).timepicker(); 
    });
        
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        multidate: true,
        startDate: '-0m'
    });
        
    function convert(str) {
            var mnths = { 
                Jan:"01", Feb:"02", Mar:"03", Apr:"04", May:"05", Jun:"06",
                Jul:"07", Aug:"08", Sep:"09", Oct:"10", Nov:"11", Dec:"12"
            },
            date = str.split(" ");

            return [ date[2], mnths[date[1]], date[3] ].join("-");
        }
        
    var dates = [];
        
    function addTimes() {
            dates=[];
//        var time_intervals = [];
        var the_date = $('.date-picker:first').datepicker('getDates');
        for(var j=0; j<the_date.length; j++){
            var s_date = convert(the_date[j].toString());
            dates.push({date: s_date});
        }
        
        $('#selected-dates').append(Mustache.render($('#dates').html(), dates));
//        var time_l = $('.time-slots').length;
//        for(var i = 1; i<= time_l; i++){
//            time_intervals.push({'start' : $('#start-time-'+i).val(), 'end': $('#end-time-'+i).val()});
//        }
    }
    

        $('#schedule-interview').click(function (e) {
            e.preventDefault();
            $('.light-box').fadeIn(500);
            $('.main-inner').fadeIn(1000);
            $('.main-outer').fadeIn(1000);
        });
        $('.close_schedule').click(function () {
            $('.light-box').fadeOut(500);
            $('.main-inner').fadeOut(1000);
            $('.main-outer').fadeOut(1000);
        });
        $(document).bind('keydown', function (e) {
            if (e.which == 27) {
                $('.light-box').fadeIn(500);
                $('.main-inner').fadeIn(1000);
                $('.main-outer').fadeIn(1000);
            }
        });
        
        
         $(document).on('click', '.city_label', function(){
           var city_id = $(this).find('input').attr('id');
            
            $.ajax({
                url : 'application-process' ,
                method : 'POST' ,
                data : {city_id:city_id} ,
                success : function(data)
                {
                    $.pjax.reload({container: '#pjax_filters', async: false});
//                    JSON_parse(data);
        console.log(data);
                    }
            });
        });        
var ps = new PerfectScrollbar('.main-inner');
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-colorpicker/css/colorpicker.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
//$this->registerCssFile('https://fonts.googleapis.com/css?family=Dosis|Indie+Flower|Mali|Titillium+Web');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/plugins.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/components.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('http://davidstutz.de/bootstrap-multiselect/dist/css/bootstrap-multiselect.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('http://davidstutz.de/bootstrap-multiselect/dist/js/bootstrap-multiselect.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="dates" type="text/template">
    {{#.}}
    <div class="form-group">

        <label class="control-label col-md-3">{{date}}</label>

        <div class="col-md-9">
            <div class="row">
                <div id="row1" class="row time-slots">
                    <div class="col-md-5">
                        <div class="input-group timepicker-main">
                            <input type="text" class="form-control timepicker timepicker-24" id="start-time-1" placeholder="from">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h5>-</h5>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group timepicker-main">
                            <input type="text" class="form-control timepicker timepicker-24" id="end-time-1"  placeholder="to">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="times-container"></div>
        <div class="col-md-9 col-md-offset-3">
            <a href="#" id="add-more"><i class="fa fa-plus-circle"></i> Add more</a>
        </div>
    </div>
    {{/.}}
</script>

<script id="add-more-d" type="text/template">
    <div style="padding:0px;margin-top:15px;" id="added-date" class='col-md-9 col-md-offset-3'>
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
