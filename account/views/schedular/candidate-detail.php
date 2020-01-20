<?php
echo $this->render('/widgets/header/secondary-header', [
    'for' => 'ScheduleInterview',
]);
?>


    <h2>Scheduled Interview Selection</h2>
    <div id="calendar"></div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span id="eventTitle"></span></h4>
                </div>
                <div class="modal-body">
                    <!--                <button id="btnDelete" class="btn btn-default btn-sm pull-right">-->
                    <!--                    <span class="glyphicon glyphicon-remove"></span> Remove-->
                    <!--                </button>-->
                    <!--                    <button id="btnUpdate" class="btn btn-default btn-sm pull-right" style="margin-right:5px;">-->
                    <!--                        <span class="glyphicon glyphicon-pencil"></span> Update-->
                    <!--                    </button>-->
                    <p id="profile"></p>
                    <p id="interview_type"></p>
                    <p id="interview_at"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
 #calendar {
    max-width: 900px;
    margin: 40px auto;
  }
  .page-content{
    background-color: #FFF !important;
  }
  .datepicker>div {
    display: block;
}
.bootstrap-timepicker-hour, .bootstrap-timepicker-minute, .bootstrap-timepicker-meridian{
    display: initial;
    padding: 0;
    background-color: transparent;
}
');
$script = <<< JS

var results = {};
var events= null;
var selectedEvent = null;

//interview dates datepicker
$('.date-picker').datepicker({
    format: 'yyyy-mm-dd',
    multidate: false,
    startDate: '-0m'
});
        
//timepicker call for click on timepicker
$(document).on('focus', '.timepicker-24', function(){
    $(this).timepicker();
});

$(document).on('change','.radio1_2',function(){
    if($('#radio1').is(':checked')){
        $('.loc').hide();
    }else if($('#radio2').is(':checked')){
        $('.loc').show();
    }
});

$(document).on('change','.radio3_4',function(){
    if($('#radio3').is(':checked')){
        $('.fixed').show();
        $('.flexible').hide();
    }else if($('#radio4').is(':checked')){
        $('.fixed').hide()  ;
        $('.flexible').show()  ;
    }
});

FetchEventAndRenderCalendar(); 

function FetchEventAndRenderCalendar(){
    events = [];
    $.ajax({
        type: 'GET',
        url: 'get-interview-data',
        async: false,
        success: function(data) {
            data = JSON.parse(data);
            $.each(data, function(i,v) {
                events.push({
                    eventID: v.scheduled_interview_enc_id,
                    title: v.Subject,
                    profile: v.Profile,
                    start: moment(v.Start),
                    end: moment(v.End),
                    color: v.ThemeColor,
                    type:v.interview_type,
                    interview_at:v.interview_at,
                    application_enc_id:v.application_enc_id,
                    designation:v.designation,
                    date_enc_id:v.interview_date_enc_id,
                    time:v.time,
                })
            });
            GenerateCalendar(events);
        }
    })
}

function GenerateCalendar(events){
    $('#calendar').fullCalendar('destroy');
    $('#calendar').fullCalendar({
        contentHeight: 400,
        defaultDate: new Date(),
        // timeFormat: 'h(:mm)a',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay,agenda'
        },
        eventLimit: true,
        eventColor: '#378006',
        events: events,
        eventClick: function (calEvent, jsEvent, view) {
            selectedEvent = calEvent;
            
            $('#myModal #eventTitle').text(calEvent.title + ' - ' + calEvent.designation);
            $('#profile').html('<b>Profile: </b>' + calEvent.profile);
            $('#interview_type').html('<b>Type: </b>' + calEvent.type);
            $('#interview_at').html('<b>Interview At: </b>' + calEvent.interview_at);
            $('#myModal').modal();
        },
        selectable: true,
        select: function(start, end){
            selectedEvent = {
                eventID: 0,
                title: '',
                description: '',
                start: start,
                end: end,
                color: ''
            };
            openAddEditForm();
            $('#calendar').fullCalendar('unselect');
        },
        editable: true,
        eventDrop: function(event){
            var data = {
                EventID: event.eventID,
                Subject: event.title,
                Start: event.start.format('DD/MM/YYYY HH:mm A'),
                End: event.end.format('DD/MM/YYYY HH:mm A'),
                Description: event.description,
                ThemeColor: event.color,
            };
            saveEvent(data);
        }
    })
}

$('#btnUpdate').click(function() {
    openEditForm();
    getDataToUpdate();
});

function getDataToUpdate(){
    if(selectedEvent != null){
        $.ajax({
        type: 'POST',
        url: 'get-data-to-update',
        data:{
            scheduled_interview_enc_id:selectedEvent.eventID, 
            type:selectedEvent.type,
            application_enc_id:selectedEvent.application_enc_id,
            },
        async: false,
        success: function(data) {
           $('#myModal').modal('hide');
           data = JSON.parse(data);
           $('#candidate_number').val(data.data_to_update[0]['number_of_candidates']);
            
                //Clear the HTML Select DropdownList
                $("#app-process option").remove();
         
                //Loop through array and add options
                $.each(data.application_process, function (index) {
                    $("#app-process").append(GetOption(data.application_process[index].field_name, data.application_process[index].field_enc_id));
                });
                
                //set value in dropdownlist
                $('#app-process').val(data.data_to_update[0]['process_field_enc_id']);
                
                //check value and set value to radio box
                val = data.data_to_update[0]['interview_mode'];
                if(val == 1){
                    $('#radio1').prop('checked',true);
                }else if(val == 2){
                    $('#radio2').prop('checked',true);
                }
                
                //check interview type and set value
                type = data.data_to_update[0]['interview_type'];
                if(type == 'fixed'){
                    $('#radio3').prop('checked',true);
                }else if(type == 'flexible'){
                    $('#radio4').prop('checked',true);
                }
                
                //Clear the HTML Select DropdownList
                $("#location option").remove();
         
                //Loop through array and add options
                $.each(data.application_location, function (index) {
                    $("#location").append(GetOption(data.application_location[index].name, data.application_location[index].interview_location_enc_id));
                });
                
                //setting value to location
                $('#location').val(data.data_to_update[0]['interview_location_enc_id'])
                
                if($('#radio1').is(':checked')){
                    $('.loc').hide();
                }
                
                if($('#radio3').is(':checked')){
                    $('.flexible').hide();
                }else if($('#radio4').is(':checked')){
                    $('.fixed').hide();
                }
                
                var ids = [];
                $.each(data.data_to_update[0]['interviewCandidates'],function(index) {
                  ids.push(data.data_to_update[0]['interviewCandidates'][index].applied_application_enc_id);
                });
                
                $.each(data.applied_candidates,function (index){
                    $('.multi_drop_down').append(getData(data.applied_candidates[index].full_name,data.applied_candidates[index].applied_application_enc_id,data.applied_candidates[index].image));
                });
                
                //set drop down
                $('.test-multi').dropdown({
                    // maxSelections: 3,
                    placeholder: 'any',
                    onChange: function (value, text, selectedItem) {
                                results.selected_candidate = value;
                                if($('#select-app-round').find('.error-msg').length > 0){
                                    $('#select-app-round').find('.error-msg').remove();
                                }
                            }
                });
                
                $('.test-multi').dropdown('set selected',ids);
                
                
        }
    });
        
    }
}

function GetOption(text, value) {
    return "<option value = '" + value + "'>" + text + "</option>"
}

function getData(name,application_id,image){
    return "<div class='item' data-value='"+ application_id +"'><img src='"+ image +"' class='af flag'>"+ name +"</div>"
}

$('#btnDelete').click(function() {
  if(selectedEvent != null && confirm('Are you sure?')){
      console.log('Delete Clicked');
      $('#myModal').modal('hide');
      // $.ajax({
      //   type: 'POST',
      //   url: '/account/dashboard/delete-event',
      //   data: {
      //       'eventID' : selectedEvent.eventID
      //   },
      //   success: function(data) {
      //       if(data.status){
      //          FetchEventAndRenderCalendar(); 
      //          $('#myModal').modal('hide');
      //       }
      //   },
      //   error: function() {
      //       alert('failed');
      //   }
      // })
  }
})

function openEditForm(){
    if(selectedEvent != null){
        $('#eventId').val(selectedEvent.eventID);
        $('#txtSubject').val(selectedEvent.title +' - '+ selectedEvent.profile);
        $('#txtStart').val(selectedEvent.start.format('DD/MM/YYYY HH:mm A'));
        $('.setDate').val(selectedEvent.start.format('DD-MM-YYYY'));
        $('#date_enc_id').val(selectedEvent.date_enc_id);
        $('#time_enc_id').val(selectedEvent.date_timing_enc_id);
        $('#time_from').val(selectedEvent.from);
        $('#time_to').val(selectedEvent.to);
        
    }
    $('#myModal').modal('hide');
    $('#myModalSave').modal();
}

$('#btnSave').click(function() {
    var data = $('#form-data').serialize();
    SaveEvent(data);
});

function SaveEvent(data){
    $('#myModalSave').modal('hide');
    $.ajax({
        type: 'POST',
        url: 'update-data',
        data: data,
        success: function(data) {
            console.log(data);
            if(data){
                toastr.success('Updated','success');
            }else{
                toastr.error('an error occurred','error');
            }
        },
    })
}
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerCssFile('@backendAssets/plugins/schedular/css/semantic.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css');
$this->registerCssFile('@eyAssets/fullcalendar/fullcalendar.min.css');
$this->registerJsFile('@eyAssets/fullcalendar/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/fullcalendar/fullcalendar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/semantic.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);