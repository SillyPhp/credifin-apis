<script id="webinar_two_speaker1" type="text/javascript">
    <section class="webinar-two-speaker1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="webinar-text">
                    <h1>{{name}}</h1>
                    <h3>{{date}}</h3>
                    <h3>{{time}}</h3>
                    <p>{{description}}</p>
                    <a href="/webinar/{{slug}}">Register Now</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    {{#webinarEvents}}
                    {{#webinarSpeakers}}
                <div class="webinar-img col-md-6">
                        <div class="speaker">
                            <div class="speaker-img">
                                {{#speaker_image}}
                                    <img src="{{speaker_image}}">
                                {{/speaker_image}}
                            </div>
                            <div class="speaker-name">
                                <p>Speaker Name</p>
                                <p class="desg">{{speaker_name}}</p>
                            </div>
                        </div>
                                    </div>
                    {{/webinarSpeakers}}
                    {{/webinarEvents}}
                                    </div>
            </div>
        </div>
    </div>
</section>
</script>

<?php

use yii\helpers\Url;

$this->registerCss('
    .webinar-two-speaker1{
        background: url('.Url::to('@eyAssets/images/pages/webinar-widgets/two-speaker-sharing-bg1.png').');
        background-repeat: no-repeat;
        background-size: cover;
        padding: 50px 0;
        width: 1200px;
        height: 630px;
        margin: auto;
        padding: 90px 0;
    }
    .webinar-two-speaker1 .container{
        padding: 50px;
    }
    .webinar-two-speaker1 .col-sm-6{
        padding: 100px 0;
    }
    .webinar-two-speaker1 .webinar-text h1 {
        color: #fff;
        font-size: 50px;
        font-family: Roboto;
        margin: 0;
    }
    .webinar-two-speaker1 .webinar-text h3 {
        margin: 0;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-family: Roboto;
        font-size: 23px;
    }
    .webinar-two-speaker1 .webinar-text p {
        font-size: 18px;
        margin: 15px 0;
        line-height: 1.3;
        color: #eee;
    }
    .webinar-two-speaker1 .webinar-text a {
        background: #e3a024;
        color: #fff;
        padding: 7px 17px;
        display: inline-block;
        font-weight: 600;
        font-size: 18px;
        margin-top: 13px;
    }
    .webinar-two-speaker1 .speaker-img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: #fff;
        overflow: hidden;
    }
    .webinar-two-speaker1 .speaker-img  img {
    width:100%;
    }
    .webinar-two-speaker1 .speaker-name {
        font-size: 18px;
        margin-top: 10px;
        color: #000;
        font-weight: 600;
        display: inline-block;
        background: #fff;
        padding: 10px 24px;
        transform: translateX(-18px);
    }
    .webinar-two-speaker1 .webinar-img{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .webinar-two-speaker1 .speaker p{
        margin: 0;
    }
    .webinar-two-speaker1 .speaker {
        display: flex;
        align-items: center;
    }
    .webinar-two-speaker1 .desg{
        font-size: 14px;
    }
    .webinar-two-speaker1 .speaker:nth-child(2) .speaker-name{
        transform: translateX(18px);
    }
')?>