<?php

use yii\helpers\Url;

?>
<script id="template_9" type="text/template">
    <div class="head-resu">
        <div class="user-d">
            <div class="usr-naam">{{name}}</div>
            <div class="u-description">
                {{#description}}
                <p>{{description}}</p>
                {{/description}}
            </div>
                <div class="eddu-txt">Education</div>
                {{#userEducations}}
                <div class="eddu">
                    <div class="eddu-date">
                        <span>{{from_date}}</span> - <span>{{to_date}}</span> / <span class="edd-name">{{degree}} {{field}}</span>
                    </div>
                    <div class="eddu-location">
                        {{institute}}
                    </div>
                </div>
                {{/userEducations}}
            <div class="work-exp">
                <div class="work-txt">Work Experience</div>
                <div class="inner-work">
                    {{#userWorkExperiences}}
                        <div class="user-tiitle">{{title}}</div>
                        <div class="user-compny">{{company}}</div>
                    <div class="user-daate"><span>{{from_date}}</span> {{#is_current}} / <span> Current</span>{{/is_current}}{{^is_current}}/{{to_date}}{{/is_current}}</div>
                        <div class="user-deescription">{{description}}</div>
                </div>
                    {{/userWorkExperiences}}
            </div>
        </div>
        <div class="contact-info">
            <div class="mail">
                <div class="mail-img">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/3wVg50vYNo82eneJnv4BQBGKXJmWpO.png">
                </div>
                <div class="mail-txt">{{email}}</div>
            </div>
            <div class="call">
                <div class="call-img">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNj7q7wwK1AQpW30A9nXK.png">
                </div>
                <div class="call-txt">{{phone}}</div>
            </div>
            <div class="addresss">
                <div class="addresss-img">
                    <img src="https://www.empoweryouth.com/assets/themes/email/images/6mMpL8zN9QqGOyOeAlMKoAxKOrBbnw.png">
                </div>
                <div class="addresss-txt">{{address}}</div>
            </div>
        </div>
        <div class="skills">
            <div class="skills-txt">Skills</div>
            {{#userSkills}}
            <div class="skills-d">{{skill}}</div>
            <progress id="file" value="32" max="100"> 32%</progress>
            {{/userSkills}}
        </div>
    </div>

</script>
