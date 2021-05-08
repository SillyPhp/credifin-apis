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
');
$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.min.css');
$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.orange-coral.min.css');
//$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.midnight-blue.min.css');
//$this->registerCssFile('@eyAssets/evo-calendar/css/evo-calendar.royal-navy.min.css');
$this->registerJsFile('@eyAssets/fullcalendar/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/evo-calendar/js/evo-calendar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/evo-calendar/js/demo.js', ['depends' => [\yii\web\JqueryAsset::className()]]);