<script id="template_1" type="text/template">
    <div class="r-main">
        <div class="r-head">
            <div class="r-name">{{name}}</div>
            <div class="r-work">{{phone}}</div>
            <div class="r-work">{{email}}</div>
            {{#address}}
            <div class="r-address">Address: <span>{{address}}</span></div>
            {{/address}}
        </div>
        <div class="r-center">
            {{#description}}
            <div class="r-object">{{description}}</div>
            {{/description}}
            <div class="r-points">
                <div class="r-skills">
                    <div class="skill-head">Skills</div>
                    <div class="skills">
                        <ul style="padding-left: 18px;">
                            {{#userSkills}}
                            <li>{{skill}}</li>
                            {{/userSkills}}
                        </ul>
                    </div>
                    <div class="work-head">Work History</div>
                    {{#userWorkExperiences}}
                    <div class="works">
                        <div class="w-date">
                            <span class="work1">{{from_date}}</span> {{#is_current}} - <span class="work2">current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}
                        </div>
                        <div class="w-position">
                            <div class="w-name">{{title}}</div>
                            <div class="w-location">{{company}}</div>
                            <ul style="padding-left: 0px;">
                                <li>{{description}}</li>
                            </ul>
                        </div>
                    </div>
                    {{/userWorkExperiences}}
                    <div class="education-head">Education</div>
                    {{#userEducations}}
                    <div class="education">
                        <div class="e-date">
                            <span class="edu1">{{from_date}}</span> - <span class="edu2">{{to_date}}</span>
                        </div>
                        <div class="e-position">
                            <div class="e-name">{{degree}} {{field}}</div>
                            <div class="e-location">{{institute}}</div>
                        </div>
                    </div>
                    {{/userEducations}}
                    <div class="archievements-head">Achievements</div>
                    <div class="skills">
                        <ul style="padding-left: 18px;">
                            {{#userAchievements}}
                            <li>{{achievement}}</li>
                            {{/userAchievements}}
                        </ul>
                    </div>
                    </div>
                    {{#hobbies}}
                    <div class="hobbies-head">Hobbies</div>
                    <div class="u-hobbies">{{hobbies}}</div>
                    {{/hobbies}}
                    {{#interests}}
                    <div class="interest-head">Interest</div>
                    <div class="u-interest">{{interests}}</div>
                    {{/interests}}
                </div>
            </div>
        </div>
    </div>
</script>