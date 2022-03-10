<script id="temp_<?=$webinar_enc_id ?>" type="text/javascript">
    <section class="webinar-three-speaker" id="web-three-speak1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="side-one">
                    <h1>
                        {{name}}
                    </h1>
                    <div class="speakers-detail">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="speaker-title">
                                    <div class="heading">
                                        <h6>Speakers</h6>
                                    </div>
                                    <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                                </div>
                            </div>
                            {{#webinarEvents}}
                            {{#webinarSpeakers}}
                            <div class="col-xs-4">
                                <div class="speaker-img">
                                    {{#speaker_image}}
                                    <img src="{{speaker_image}}">
                                    {{/speaker_image}}
                                </div>
                                <div class="speaker-name">{{speaker_name}}</div>
                                <div class="designation">{{designation}}</div>
                            </div>
                            {{/webinarSpeakers}}
                            {{/webinarEvents}}
                        </div>
                    </div>
                    <div class="avail-share">
                        <a href="/webinar/{{slug}}" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>
                        <div class="share-bar">
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/{{slug}}" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                            <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/{{slug}}" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                            <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                            <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-twitter"><i class="fab fa-twitter"></i></a>
                            <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/{{slug}}" class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="side-two">
                    <div class="side-two-upper">
                        <div class="online-icons">
                            <div class="icons"><i class="fas fa-microphone"></i></div>
                            <div class="icons"><i class="fas fa-play"></i></div>
                            <div class="icons"><i class="fas fa-comment-alt"></i></div>
                            <div class="icons"><i class="fas fa-wifi"></i></div>
                        </div>
                        <div class="heading">
                            ONLINE CONFERENCE
                        </div>
                        <div class="side-two-lines">
                            <span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span><span class="line"></span>
                        </div>
                    </div>
                    <div class="date-time">
                        <div class="date">
                            <div class="prop">DATE</div>
                            <div class="value">{{date}}</div>
                        </div>
                        <div class="time">
                            <div class="prop">TIME</div>
                            <div class="value">{{time}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</script>

<?php $this->registerCss('
    #web-three-speak1 .share-whatsapp{
        color: #25D366 !important;
    }
    #web-three-speak1 .share-bar a.share-whatsapp:hover{
        background-color: #25D366 !important;
        color: #fff !important;
        
    }
    #web-three-speak1{
        background: #150050;
        overflow: hidden;
    }
    #web-three-speak1 .side-one h1 {
        color: #fff;
        font-family: Roboto;
    }
    #web-three-speak1 .speaker-img {
        width: 150px;
        height: 150px;
        background: #fff;
        margin: 15px 0;
    }
    #web-three-speak1 .speaker-img img {
        width:100%;
    }
    #web-three-speak1 .speaker-title h6 {
       color: #fff;
       margin: 0;
       transform: skewX(15deg);
    }
    #web-three-speak1 .speaker-title span {
        width: 8px;
        height: 23px;
        background: #ff5c58;
        display: inline-block;
        margin-bottom: -7px;
        transform: skew(-15deg);
        margin-left: 5px;
    }
    #web-three-speak1 .speaker-title .heading {
        display: inline-block;
        padding: 3px 10px;
        background: #ff5c58;
        transform: skewX(-15deg);
    }
    #web-three-speak1 .designation {
        color: #afafaf;
        font-weight: 700;
    }
    #web-three-speak1 .speaker-name {
        color: #fff;
        font-weight: 700;
        font-size: 16px;
    }
    #web-three-speak1 .icons {
        width: 30px;
        height: 30px;
        display: inline-flex;
        color: #fff;
        background: #ff5c58;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
        margin-left: 15px;
    }
    #web-three-speak1 .online-icons{
        display: flex;
        justify-content: flex-end;
    }
    #web-three-speak1 .heading{
        color: #fff;
        font-size: 25px;
        text-align: right;
        font-weight: 700;
    }
    #web-three-speak1 span.line {
        width: 3px;
        margin-left: 5px;
        height: 75px;
        background: #fff;
        display: inline-block;
        transform: skewX(-24deg);
    }
    #web-three-speak1 .side-two-lines {
        display: inline-block;
        position: absolute;
        right: -215px;
    }
    #web-three-speak1 .date-time {
        margin-top: 100px;
        color: #fff;
        font-weight: 700;
    }
    #web-three-speak1 .date {
        justify-content: flex-end;
    }
    #web-three-speak1 .date, #web-three-speak1 .time {
        display: flex;
        height: 65px;
        margin-bottom: 25px;
    }
    #web-three-speak1 .date-time .prop {
        color: #979797;
    }
    #web-three-speak1 .time div, #web-three-speak1 .date div {
        font-size: 25px;
        line-height: 25px;
        padding: 0 10px;
    }
    #web-three-speak1 .date-time .value {
        border-left: 2px solid #fff;
    }
    #web-three-speak1 .time .value, #web-three-speak1 .date .value {
        align-self: stretch;
        display: flex;
        align-items: flex-end;
    }
    #web-three-speak1 .avail-share{
        margin-bottom: 15px;
    }
    #web-three-speak1 a.register-btn {
        background: #ff5c58;
        border-radius: 27px;
        padding: 15px 30px;
        display: inline-block;
        margin-top: 20px;
        color: #ffffff;
        transition: all linear .3s;
    }
    #web-three-speak1 a.register-btn i{
        transition: all linear .3s;
    }
    #web-three-speak1 a.register-btn:hover{
        color: #fff
        transition: all linear .3s;
    }
    #web-three-speak1 a.register-btn:hover i{
        margin-left: 15px;
        transition: all linear .3s;
    }
    #web-three-speak1 .share-bar {
        margin-top: 20px;
    }
    
    #web-three-speak1 .share-bar a {
        display: inline-block;
        font-size: 18px;
        color: #fff;
        width: 30px;
        border-radius: 4px;
        height: 30px;
        position: relative;
        border-radius: 10px;
        background: #FFFFFF;
        box-shadow: 0px 0px 4px rgb(0 0 0 / 25%);
        border-radius: 11px;
        transition: .2s all ease-in;
        margin-left: 10px;
    }
    
    #web-three-speak1 .share-bar .fab, #web-three-speak1 .share-bar .far {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    #web-three-speak1 .share-bar a:not(.share-fb) {
        margin-left: 7px;
    }
    
    #web-three-speak1 .share-bar a.share-fb {
        color: #3b5998;
    }
    
    #web-three-speak1 .share-bar a.share-twitter {
        color: #1DA1F2;
    }
    
    #web-three-speak1 .share-bar a.share-linkedin {
        color: #25D366;
    }
    
    #web-three-speak1 .share-bar a.tg-tele {
        color: #0088cc;
        border-color: #0088cc;
    }
    
    #web-three-speak1 .share-bar a:hover {
        color: #fff;
        transition: 0.2s all ease-in;
        font-size: 12px;
        border-radius: 20px;
    }
    
    #web-three-speak1 .share-bar a.share-fb:hover {
        background-color: #3b5998;
    }
    
    #web-three-speak1 .share-bar a.share-twitter:hover {
        background-color: #1DA1F2;
    }
    
    #web-three-speak1 .share-bar a.share-linkedin:hover {
        background-color: #25D366;
    }
    
    #web-three-speak1 .share-bar a.tg-tele:hover {
        background-color: #0088cc;
        border-color: #0088cc;
    }
    @media only screen and (max-width: 991px){
        #web-three-speak1 .speaker-img{
            width: 100px;
            height: 100px;
        }
    }
    @media only screen and (max-width: 767px){
        #web-three-speak1 .side-two-upper {
            display: none;
        }
        #web-three-speak1 .date-time{
            margin-top: 0;
        }
        #web-three-speak1 .speaker-name{
            font-size: 13px;
        }
        #web-three-speak1 .designation{
            font-size: 12px;
        }
    }
    @media only screen and (max-width: 425px){
        #web-three-speak1 .time div, .date div {
            font-size: 20px;
            line-height: 25px;
            padding: 0 10px;
        }
        #web-three-speak1 .date, #web-three-speak1 .time {
            display: flex;
            height: 25px;
            margin-bottom: 25px;
        }
        #web-three-speak1 .date {
            justify-content: flex-start;
        }
        #web-three-speak1 .speaker-img{
            width: 80px;
            height: 80px;
        }
    }
');
$script = <<<JS

    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);
?>