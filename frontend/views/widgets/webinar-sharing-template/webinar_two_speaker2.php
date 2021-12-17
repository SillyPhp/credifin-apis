<script id="webinar_two_speaker2" type="text/template">
    <section class="webinar-two-speaker2">
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
                {{#webinarEvents}}
                {{#webinarSpeakers}}
                <div class="webinar-img">
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
</section>
</script>

<?php

use yii\helpers\Url;

$this->registerCss('
    .webinar-two-speaker2{
        background: url('.Url::to('@eyAssets/images/pages/webinar-widgets/two-speaker-sharing-bg2.png').');
        background-repeat: no-repeat;
        background-size: cover;
        padding: 90px 0;
        height: 630px;
        width: 1200px;
        margin: auto;
    }
    
    .webinar-two-speaker2 .webinar-text h1 {
        color: #fff;
        font-size: 50px;
        font-family: Roboto;
        margin: 0;
    }
    .webinar-two-speaker2 .webinar-text h3 {
        margin: 0;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-family: Roboto;
        font-size: 23px;
    }
    .webinar-two-speaker2 .webinar-text p {
        font-size: 18px;
        margin: 15px 0;
        line-height: 1.3;
        color: #eee;
    }
    .webinar-two-speaker2 .webinar-text a {
        background: #e3a024;
        color: #fff;
        padding: 7px 17px;
        display: inline-block;
        font-weight: 600;
        font-size: 18px;
        margin-top: 13px;
    }
    .webinar-two-speaker2 .speaker-img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: #fff;
    }
    .webinar-two-speaker2 .speaker-img img{
    width: 100%;
    }
    .webinar-two-speaker2 .speaker-name {
        font-size: 18px;
        margin-top: 10px;
        color: #000;
        font-weight: 600;
        display: inline-block;
        background: #fff;
        padding: 10px 24px;
        transform: translateX(-18px);
    }
    .webinar-two-speaker2 .webinar-img{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .webinar-two-speaker2 .speaker p{
        margin: 0;
    }
    .webinar-two-speaker2 .speaker {
        display: flex;
        align-items: center;
    }
    .webinar-two-speaker2 .desg{
        font-size: 14px;
    }
    .webinar-two-speaker2 .speaker:nth-child(2) .speaker-name{
        transform: translateX(18px);
    }
')?>