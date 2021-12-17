<script id="webinar_three_speaker1" type="text/javascript">
    <section class="webinar-three-speaker1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="webinar-text">
                    <h1>{{name}}</h1>
                    <p>{{description}}</p>
                </div>
                <div class="webinar-speaker-images">
                    <div class="row">
                        {{#webinarEvents}}
                        {{#webinarSpeakers}}
                            <div class="col-xs-4">
                                <div class="speaker">
                                    <img src="{{speaker_image}}">
                                    <p>{{speaker_name}}</p>
                                </div>
                            </div>
                        {{/webinarSpeakers}}
                        {{/webinarEvents}}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="webinar-time">
                    <div class="date">
                        <div class="title">
                            DATE
                        </div>
                        <div class="value">
                            {{date}}
                        </div>
                    </div>
                    <div class="time">
                        <div class="title">
                            TIME
                        </div>
                        <div class="value">
                            {{time}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</script>

<?php

use yii\helpers\Url;

$this->registerCss('
.speaker img {
width: 100%;
}
    .webinar-three-speaker1 {
        background: url(/assets/themes/ey/images/pages/webinar-widgets/three-speaker-sharing-bg1.png), #150050;
        background-repeat: no-repeat;
        background-size: 100%;
        padding: 90px 50px;
        height: 630px;
        width: 1200px;
        margin: auto;   
        display: flex;
    }
    .webinar-three-speaker1 .container{
        padding: 50px 0 !important;
    }
    .webinar-three-speaker1 .row{
        display: flex;
        align-items: flex-end;
    }
    .webinar-three-speaker1 .webinar-text h1 {
        color: #fff;
        font-size: 50px;
        font-family: Roboto;
        margin: 0;
    }
    .webinar-three-speaker1 .webinar-text h3 {
        margin: 0;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-family: Roboto;
        font-size: 23px;
    }
    .webinar-three-speaker1 .webinar-text p {
        font-size: 18px;
        margin: 15px 0;
        line-height: 1.3;
        color: #eee;
    }
    .webinar-three-speaker1 .webinar-text a {
        background: #e3a024;
        color: #fff;
        padding: 7px 17px;
        display: inline-block;
        font-weight: 600;
        font-size: 18px;
        margin-top: 13px;
    }
    .webinar-three-speaker1 .speaker-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #fff;
    }
    .webinar-three-speaker1 .webinar-speaker-images {
        margin-top: 30px;
    }
    .webinar-three-speaker1 .speaker img {
        min-width: 100px;
        height: 100px;
        background: #fff;
    }
    .webinar-three-speaker1 .speaker-name {
        font-size: 18px;
        margin-top: 10px;
        color: #000;
        font-weight: 600;
        display: inline-block;
        background: #fff;
        padding: 10px 24px;
        transform: translateX(-18px);
    }
    .webinar-three-speaker1 .webinar-img{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .webinar-three-speaker1 .speaker p{
        margin: 0;
        color:white;
    }
    .webinar-three-speaker1 .desg{
        font-size: 14px;
    }
    .webinar-three-speaker1 .speaker:nth-child(2) .speaker-name{
        transform: translateX(18px);
    }
    .webinar-three-speaker1 .date {
        justify-content: flex-end;
    }
    .webinar-three-speaker1 .speaker {
        display: flex;
        flex-direction: column;
    }
    .webinar-three-speaker1 .date, .webinar-three-speaker1 .time {
        display: flex;
        font-size: 30px;
        color: #fff;
        font-weight: 600;
        align-items: center;
    }
    .webinar-three-speaker1 .date > div:nth-child(1), .webinar-three-speaker1 .time > div:nth-child(1) {
        border-right: 2px solid #eee;
    }
    .webinar-three-speaker1 .date > div, .webinar-three-speaker1 .time > div {
        padding: 17px 14px;
        margin: 15px 0;
    }
    .webinar-three-speaker1 .title {
        align-self: normal;
    }
')?>