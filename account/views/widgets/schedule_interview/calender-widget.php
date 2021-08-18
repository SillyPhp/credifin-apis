<div class="console-log">
    <div class="log-content">
        <div class="--noshadow" id="demoEvoCalendar"></div>
    </div>
</div>
<?php
$this->registerCss('
.evo-calendar{
    z-index: 0 !important;
}
button.icon-button>span.bars{
    overflow:visible !important;
}
.royal-navy .calendar-sidebar>span#sidebarToggler{
    padding-top:4px;
}
.event-container>.event-icon>div[class^="event-bullet-"], .event-indicator>.type-bullet>div[class^="type-"]{
    background-color: #ff9665;
}
.calendar-inner{
    max-width: calc(100% - 560px);
}
.calendar-events{
    width: 360px;
    padding: 70px 10px 60px 20px;
}
.sidebar-hide .calendar-inner {
    max-width: calc(100% - 360px);
}
@media screen and (max-width: 1515px) {
    tr.calendar-header .calendar-header-day {
        padding: 10px 5px;
        font-size: 17px;
    }
    tr.calendar-body .calendar-day .day{
        height: 40px;
        width: 40px;
        padding:0px;
        line-height: 40px;
    }
    .calendar-inner{
        padding: 80px 30px;
    }
}
@media screen and (max-width: 1375px) {
    tr.calendar-header .calendar-header-day {
        font-size:15px;
    }
    tr.calendar-body .calendar-day .day{
        padding:0px;
        height: 35px;
        font-size: 16px;
        width: 35px;
        line-height: 35px;
    }
    .calendar-inner {
        max-width: calc(100% - 460px);
        margin-left: 160px;
    }
    .calendar-events {
        width: 300px;
    }
    .calendar-sidebar{
        width: 160px;
    }
}
@media screen and (max-width: 1280px) {
    tr.calendar-header .calendar-header-day, tr.calendar-body .calendar-day {
        padding: 10px 0px;
    }
    tr.calendar-header .calendar-header-day {
        font-size: 14px;
    }
    .calendar-inner {
        padding: 70px 20px 105px 20px;
    }
}
');
$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.min.css');
$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.orange-coral.min.css');
//$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.midnight-blue.min.css');
//$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.royal-navy.min.css');
$this->registerJsFile('@eyAssets/fullcalendar/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/evo-calendar/js/evo-calendar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/evo-calendar/js/demo.js', ['depends' => [\yii\web\JqueryAsset::className()]]);