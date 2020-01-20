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
                <button id="btnDelete" class="btn btn-default btn-sm pull-right">
                    <span class="glyphicon glyphicon-remove"></span> Reject
                </button>
                <button id="btnAccept" class="btn btn-default btn-sm pull-right" style="margin-right:5px;">
                    <span class="glyphicon glyphicon-pencil"></span> Accept
                </button>
                <p id="pDetails"></p>
                <label><b>Select Time: &nbsp;</b></label>
                <select id="time_slots">

                </select>
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
');
$script = <<< JS

var events= null;
var selectedEvent = null;

FetchEventAndRenderCalendar();

function FetchEventAndRenderCalendar(){
    events = [];
    $.ajax({
        type: 'GET',
        url: 'get-events',
        async: false,
        success: function(data) {
            data = JSON.parse(data);
            $.each(data, function(i,v) {
                events.push({
                    eventID: v.EventId,
                    title: v.Subject,
                    profile: v.Profile,
                    start: moment(v.Start),
                    end: moment(v.End),
                    color: v.ThemeColor,
                    type:v.type,
                    date_time_enc_id:v.date_time,
                    applied_application_enc_id:v.applied_application_enc_id,
                    interview_candidate_enc_id:v.interview_c_enc_id,
                    process_field_id:v.process_field_enc_id,
                    status:v.status,
                    time:v.time,
                    designation:v.designation,
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
            if(calEvent.status == 2){
                $('#btnAccept').text('Already Applied');
                $('#btnAccept').attr("disabled", true);
                $('#btnAccept').css("pointer-events", "none");
                $('#time_slots').attr("disabled", true);
                $('#time_slots').css("pointer-events", "none");
                $('#btnDelete').hide();
            }else if(calEvent.status == 3){
                $('#btnAccept').text('Rejected');
                $('#btnAccept').attr("disabled", true);
                $('#btnAccept').css("pointer-events", "none");
                $('#time_slots').attr("disabled", true);
                $('#time_slots').css("pointer-events", "none");
                $('#btnDelete').hide();
            }else{
                $('#btnAccept').attr("disabled", false);
                $('#btnDelete').show();
                $('#btnAccept').text('Accept');
                $('#time_slots').attr("disabled", false);
                $('#time_slots').css("pointer-events", "auto");
            }
            $('#myModal #eventTitle').text(calEvent.title + ' - ' + calEvent.designation);
            $('#pDetails').html('<b>Profile: </b>' + calEvent.profile);
            $('#time_slots').empty();
            
            $.each(calEvent.time , function (index) {
                var date = calEvent.time[index]['date'];
                var time = calEvent.time[index]['time'];
                $("#time_slots").append('<optgroup label='+ date +'>');
                    $.each(time,function(index) {
                      $("#time_slots").append(GetOption(time[index]['from'],time[index]['to'], time[index]['interview_date_timing_enc_id']));
                    })
                $("#time_slots").append('<optgroup>');
                    
                });
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

function GetOption(from,to, value) {
    return "<option value = '" + value + "'>" + from + " - " + to + "</option>"
}


$('#btnAccept').click(function() {
    acceptInterview();
});

function acceptInterview(){
    
    var date_time_enc_id = $('#time_slots').val();
    
    if(selectedEvent != null){
        $.ajax({
        type: 'POST',
        url: 'change-status',
        data:{
            date_enc_id:date_time_enc_id, 
            scheduled_interview_enc_id:selectedEvent.eventID, 
            candidate_interview_id: selectedEvent.interview_candidate_enc_id,
            applied_app_id:selectedEvent.applied_application_enc_id,
            process_id:selectedEvent.process_field_id,
            type:selectedEvent.type,
            status:2,
            },
        async: false,
        success: function(data) {
           $('#myModal').modal('hide');
           if(data.status == 200){
               toastr.success(data.message,'success');
               FetchEventAndRenderCalendar();
           }else{
               toastr.error(data.message,'error');
           }
        }
    });
        
    }
}

$('#btnDelete').click(function() {
  if(selectedEvent != null && confirm('Are you sure?')){
      $('#myModal').modal('hide');
      var date_time_enc_id = $('#time_slots').val();
      $.ajax({
        type: 'POST',
        url: 'change-status',
        data: {
            date_enc_id:date_time_enc_id, 
            scheduled_interview_enc_id:selectedEvent.eventID, 
            candidate_interview_id: selectedEvent.interview_candidate_enc_id,
            applied_app_id:selectedEvent.applied_application_enc_id,
            process_id:selectedEvent.process_field_id,
            type:selectedEvent.type,
            status:3,
        },
        success: function(data) {
             if(data.status == 200){
               toastr.success(data.message,'success');
               FetchEventAndRenderCalendar();
           }else{
               toastr.error(data.message,'error');
           }
        }
      })
  }
});

$('#dtp1, #dtp2').datetimepicker({
    format: 'DD/MM/YYYY HH:mm A'
});

function openAddEditForm(){
    if(selectedEvent != null){
        $('#hdEventID').val(selectedEvent.eventID);
        $('#txtSubject').val(selectedEvent.title);
        $('#txtStart').val(selectedEvent.start.format('DD/MM/YYYY HH:mm A'));
        $('#txtEnd').val(selectedEvent.end.format('DD/MM/YYYY HH:mm A'));
        $('#txtDescription').val(selectedEvent.description);
        $('#ddThemeColor').val(selectedEvent.color);
    }
    $('#myModal').modal('hide');
    $('#myModalSave').modal();
}

$('#btnSave').click(function() {
    if ($('#txtSubject').val().trim() == "") {
        alert('Subject required');
        return;
    }
    if($('#txtStart').val().trim() == "") {
        alert('Start date required');
        return;
    }
    if ($('#txtEnd').val().trim() == "") {
        alert('End date required');
        return;
    }
    else {
        var startDate = moment($('#txtStart').val(), "DD/MM/YYYY HH:mm A").toDate();
        var endDate = moment($('#txtEnd').val(), "DD/MM/YYYY HH:mm A").toDate();
        if (startDate > endDate) {
            alert('Invalid end date');
            return;
        }
    }
    var data = {
        EventID: $('#hdEventID').val(),
        Subject: $('#txtSubject').val().trim(),
        Start: $('#txtStart').val().trim(),
        End: $('#txtEnd').val().trim(),
        Description: $('#txtDescription').val(),
        ThemeColor: $('#ddThemeColor').val(),
    };
    SaveEvent(data);
})

function SaveEvent(data){
    $('#myModalSave').modal('hide');
    // $.ajax({
    //     type: 'POST',
    //     url: '/account/home/save-event',
    //     data: data,
    //     success: function(data) {
    //         if(data.status){
    //             FetchEventAndRenderCalendar();
    //             $('#myModalSave').modal('hide');
    //         }
    //     },
    //     error: function() {
    //         alert('failed');
    //     }
    // })
}
JS;
$this->registerJs($script);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css');
$this->registerCssFile('@eyAssets/fullcalendar/fullcalendar.min.css');
$this->registerJsFile('@eyAssets/fullcalendar/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/fullcalendar/fullcalendar.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
