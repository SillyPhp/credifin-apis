<?php

use yii\helpers\url;

?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="set-sticky">
                    <p class="title ou-head">B-TECH</p>
                    <div class="text">GENERAL - 50%</div>
                    <div class="process-bar general"></div>
                    <div class="text">OBC - 60%</div>
                    <div class="process-bar obc"></div>
                    <div class="text">SC - 90%</div>
                    <div class="process-bar sc"></div>
                    <div class="text">ST - 90%</div>
                    <div class="process-bar st"></div>
                    <div class="text">PWD - 90%</div>
                    <div class="process-bar pwd"></div>
                    <div class="text">EWS - 90%</div>
                    <div class="process-bar ews"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="set-sticky">
                    <p class="title ou-head">M-TECH</p>
                    <div class="text">GENERAL - 50%</div>
                    <div class="process-bar general"></div>
                    <div class="text">OBC - 60%</div>
                    <div class="process-bar obc"></div>
                    <div class="text">SC - 90%</div>
                    <div class="process-bar sc"></div>
                    <div class="text">ST - 90%</div>
                    <div class="process-bar st"></div>
                    <div class="text">PWD - 90%</div>
                    <div class="process-bar pwd"></div>
                    <div class="text">EWS - 90%</div>
                    <div class="process-bar ews"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="set-sticky">
                    <p class="title ou-head">BCA</p>
                    <div class="text">GENERAL - 50%</div>
                    <div class="process-bar general"></div>
                    <div class="text">OBC - 60%</div>
                    <div class="process-bar obc"></div>
                    <div class="text">SC - 90%</div>
                    <div class="process-bar sc"></div>
                    <div class="text">ST - 90%</div>
                    <div class="process-bar st"></div>
                    <div class="text">PWD - 90%</div>
                    <div class="process-bar pwd"></div>
                    <div class="text">EWS - 90%</div>
                    <div class="process-bar ews"></div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.title{
  animation: translate 2s ease;
}
.text{
  font-size: 16px;
  margin:15px 0 5px 0px;
  animation: text 2s ease;
}
/* Processbar*/
.process-bar{
  width: 100%;
  height: 12px;
  background-color: #eee;
  position: relative;
  border-radius: 10px;
}
.process-bar:before{
  content: \'\';
  position: absolute;
  width: 50%;
  height: 12px;
  border-radius: 10px;
  animation: processbar 2s ease-in;
  background-color: #f89872;
}
//.general:before{background-color: #33323a;}
//.obc:before{background-color: #7472f8;}
//.sc:before{background-color: #f58954;}
//.st:before{background-color: #6dc2c6;}
//.pwd:before{background-color: #b1deaa;}
//.ews:before{background-color: #f4c1c6;}
.process-bar:last-child {
    margin-bottom: 20px;
}
/* Animation Title */
@keyframes translate{
  from{
    transform: translate(0,-100px);
  }
  to{
    transform: translate(0);
  }
}
/* End Anamation Title */

/* Animation Text */
@keyframes text{
  from{
    transform: scale(0);
  }
  to{
    transform: scale(1);
  }
}
/* End Animation Text */

/* Animation Wordpress */
@keyframes processbar{
  from{
    width: 0;
  }
  to{
    width: 50%;
  }
}
/* End Animation Wordpress*/
');
