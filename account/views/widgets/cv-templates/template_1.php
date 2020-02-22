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
                <div class="education-head">Education</div>
                {{#userEducations}}
                <div class="education">
                    <div class="e-date">
                        <span class="edu1">{{from_date}}</span> - <span class="edu2">{{to_date}}</span> / <span class="e-name">{{degree}} {{field}}</span>
                    </div>
                    <div class="e-position">
                        <div class="e-location">{{institute}}</div>
                    </div>
                </div>
                {{/userEducations}}
                <div class="work-head">Work History</div>
                {{#userWorkExperiences}}
                <div class="works">
                    <div class="w-date">
                        <span class="work1">{{from_date}}</span> {{#is_current}} - <span class="work2">current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}} / <span class="w-name">{{title}}</span>
                    </div>
                    <div class="w-position">
                        <div class="w-location">{{company}}</div>
                        <ul>
                            <li>{{description}}</li>
                        </ul>
                    </div>
                </div>
                {{/userWorkExperiences}}
                <div class="r-skills">
                    <div class="skill-head">Skills</div>
                    <div class="skills">
                        {{#userSkills}}
                        <span>{{skill}}</span>,
                        {{/userSkills}}
                    </div>
                    <div class="archievements-head">Achievements</div>
                    <div class="skills">
                            {{#userAchievements}}
                            <div>{{achievement}}</div>
                            {{/userAchievements}}
                    </div>
                </div>
                <div class="hobbies-head">Hobbies</div>
                {{#userHobbies}}
                <div class="u-hobbies">{{hobby}}</div>
                {{/userHobbies}}
                <div class="interest-head">Interest</div>
                {{#userInterests}}
                <div class="u-interest">{{interest}}</div>
                {{/userInterests}}
            </div>
        </div>
    </div>
    </div>
</script>