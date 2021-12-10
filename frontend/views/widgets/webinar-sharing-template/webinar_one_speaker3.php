<script id="webinar_one_speaker3" type="text/template">
    <section class="webinar-one-speaker2">
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="webinar-text">
                    <h1>{{name}}</h1>
                    <h3>{{date}}</h3>
                    <h3>{{time}}</h3>
                    <p>{{description}}</p>
                    <a href="/webinar/{{slug}}">Register Now</a>
                </div>
            </div>
            <div class="col-sm-5">
                {{#webinarEvents}}
                {{#webinarSpeakers}}
                    <div class="webinar-img">
                    <div class="speaker-img">
                        <img src="{{speaker_image}}">
                    </div>
                    <div class="speaker-name">
                        <p>{{speaker_name}}</p>
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
    .webinar-one-speaker2{
        background: url('.Url::to('@eyAssets/images/pages/webinar-widgets/one-speaker-sharing-bg3.png').');
        background-repeat: no-repeat;
        background-size: cover;
        padding: 80px 0;
    }
    .webinar-one-speaker2 .row{
        display: flex;
    }
    .webinar-one-speaker2 .webinar-text h1 {
        color: #fff;
        font-size: 38px;
        font-family: Roboto;
        margin: 0;
    }
    .webinar-one-speaker2 .webinar-text h3 {
        margin: 0;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-family: Roboto;
        font-size: 20px;
    }
    .webinar-one-speaker2 .webinar-text p {
        font-size: 14px;
        margin: 15px 0;
        line-height: 1.3;
        color: #eee;
    }
    .webinar-one-speaker2 .webinar-text a {
        background: #e3a024;
        color: #fff;
        padding: 7px 17px;
        display: inline-block;
        font-weight: 600;
        font-size: 16px;
        margin-top: 13px;
    }
    .webinar-one-speaker2 .speaker-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #fff;
    }
    .webinar-one-speaker2 .speaker-img img {
    width: 100%;
    } 
    .webinar-one-speaker2 .speaker-name {
        font-size: 22px;
        margin-top: 10px;
        color: #fff;
        font-weight: 600;
        display: inline-block;
    }
    .webinar-one-speaker2 .webinar-img{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        height: 100%;
    }
')?>