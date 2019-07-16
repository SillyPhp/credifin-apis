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
                    <span class="glyphicon glyphicon-remove"></span> Remove
                </button>
                <button id="btnAccept" class="btn btn-default btn-sm pull-right" style="margin-right:5px;">
                    <span class="glyphicon glyphicon-pencil"></span> Accept
                </button>
                <p id="pDetails"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="myModalSave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Save Event</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" id="hdEventID" value="0"/>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" id="txtSubject" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Start</label>
                        <div class="input-group date" id="dtp1">
                            <input type="text" id="txtStart" class="form-control"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group" id="divEndDate" style="display:none">
                        <label>End</label>
                        <div class="input-group date" id="dtp2">
                            <input type="text" id="txtEnd" class="form-control"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="txtDescription" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Theme Color</label>
                        <select id="ddThemeColor" class="form-control">
                            <option value="">Default</option>
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="black">Black</option>
                            <option value="green">Green</option>
                        </select>
                    </div>
                    <button type="button" id="btnSave" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
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
                    interview_candidate_enc_id:v.interview_c_enc_id
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
            $('#myModal #eventTitle').text(calEvent.title);
            var d = $('<div/>');
            d.append($('<p/>').html('<b>Start:</b>' + calEvent.start.format("DD-MMM-YYYY HH:mm a")));
            d.append($('<p/>').html('<b>End:</b>' + calEvent.end.format("DD-MMM-YYYY HH:mm a")));
            d.append($('<p/>').html('<b>Profile:</b>' + calEvent.profile));
            $('#myModal #pDetails').empty().html(d);
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

$('#btnAccept').click(function() {
    acceptInterview();
});

function acceptInterview(){
    if(selectedEvent != null){
        console.log(selectedEvent);
        $.ajax({
        type: 'POST',
        url: 'candidate-accepted',
        data:{date_enc_id:selectedEvent.date_time_enc_id, interview_candidate_enc_id: selectedEvent.interview_candidate_enc_id, scheduled_interview_enc_id:selectedEvent.eventID, applied_app_id:selectedEvent.applied_application_enc_id},
        async: false,
        success: function(data) {
           $('#myModal').modal('hide');
        }
    });
        
    }
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
    console.log(data);
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
