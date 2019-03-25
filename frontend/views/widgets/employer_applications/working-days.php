<?php
if(!empty($working_days)) {
    ?>
    <h3>Working Days</h3>
    <div class="week-days">
        <ul>
            <li class="<?= in_array(1, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Monday</span>
                <h2>M</h2>
            </li>
            <li class="<?= in_array(2, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Tuesday</span>
                <h2>T</h2>
            </li>
            <li class="<?= in_array(3, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Wednesday</span>
                <h2>W</h2>
            </li>
            <li class="<?= in_array(4, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Thursday</span>
                <h2>T</h2>
            </li>
            <li class="<?= in_array(5, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Friday</span>
                <h2>F</h2>
            </li>
            <li class="<?= in_array(6, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Saturday</span>
                <h2>S</h2>
            </li>
            <li class="<?= in_array(7, json_decode($working_days)) ? 'active' : '' ?>">
                <span>Sunday</span>
                <h2>S</h2>
            </li>
        </ul>
    </div>
    <?php
    $this->registerCss('
    .week-days ul li{
      position:relative;
      list-style:none;
      display:none;
      width:100px;
      height:100px;
      line-height:100px;
      text-align:center;
      margin-right:5px;
      background-color:#fff !important;
      background-image:none;
      border:1px solid #ddd;
      color:#000;
    }
    .week-days ul li.active{
      color:#fff;
      display:inline-block;
      background-color: #35394F; 
      background-image: linear-gradient(-40deg, #35394F 25%, #787D90);
      border:1px solid #ddd;
    }
    .week-days ul li.active h2{
        color:#fff;
    }
    .week-days ul li span{
      position:absolute;
      top:0px;
      line-height:25px;
      left:0;
      width:100%;
      background-color:#fff;
      box-shadow: 0 1px 5px -2px #393d52;
      
    }
    .week-days ul li.active span{
      background-color:#787E91;
      box-shadow: 0 5px 5px -5px #393d52;
    }
    .week-days ul li h2{
      line-height:115px;
      margin:0px;
    }
');
}