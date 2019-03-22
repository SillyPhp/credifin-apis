<h3>Work Timing</h3>
<div class="time-bar-inner col-md-12">
    <div class="working-time-from">
        <?= date("H:i", strtotime($working_time_from)); ?>
    </div>
    <div class="working-time-title">
        Working Hours
    </div>
    <div class="working-time-to">
        <?= date("H:i", strtotime($working_time_to)); ?>
    </div>
</div>
<?php
$this->registerCss('
.time-bar-inner{
    line-height: 35px;
    border-radius: 35px;
    padding: 4px;
    background-color: #EE7436; 
    background-image: linear-gradient(-40deg, #EA5768, #EE7436 90%);
    border:5px solid #D9DADA;
    color: #fff;
    font-weight: 600;
    font-size: 20px;
    text-align:center;
}
.working-time-from{
    width: 15%;
    float: left;
    background-color: #fff;
    color: #EE7436;
    border-radius: 35px;
}
.working-time-to{
    width: 15%;
    float: right;
    background-color: #fff;
    color: #EE7436;
    border-radius: 35px;
}
.working-time-title{
    width: 70%;
    float: left;
}
');