<script id="template_3" type="text/template">
    <div class="r-parent">
        <div class="r-head">
            <div class="user-name">{{name}}</div>
            <div class="user-work">{{title}}</div>
        </div>
        <div class="r-inner">
            <div class="r-left">
                {{#description}}
                <div class="user-profile hed">About</div>
                <div class="user-detail u-txt-new">{{description}}</div>
                {{/description}}
                <div>
                    <div class="user-contact hed">contact</div>
                    <div class="user-detail">
                        <div class="user-email u-txt"><i class="fa fa-envelope"></i> {{email}}</div>
                        <div class="user-num u-txt"><i class="fa fa-phone-square"></i> {{phone}}</div>
                        {{#address}}<div class="user-address u-txt"><i class="fa fa-map-marker"></i> {{address}}</div>{{/address}}
                    </div>
                </div>
                <div>
                    {{#userSkills}}
                    <div class="user-skills hed">skills</div>
                    <div class="user-detail">
                        <ul>
                            <li>{{skill}}</li>
                        </ul>
                    </div>
                    {{/userSkills}}
                </div>
                <div>
                    {{#interests}}
                    <div class="user-interest hed">interest</div>
                    <div class="user-detail">
                        <ul>
                            <li>{{interests}}</li>
                        </ul>
                    </div>
                    {{/interests}}
                </div>
                <div>
                    <div class="user-hobbies hed">Hobbies</div>
                    <div class="user-detail">
                        <ul>
                            {{#hobbies}}
                            <li>{{hobbies}}</li>
                            {{/hobbies}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="r-right">
                <div class="user-working right-head">
                    <div class="heading-set">Work Experience</div>
                    {{#userWorkExperiences}}
                    <div class="user-inner-d">
                        <div class="user-year">
                            <span>{{from_date}}</span> {{#is_current}} - <span> Current</span>{{/is_current}}{{^is_current}}-{{to_date}}{{/is_current}}|
                            <span>{{title}}</span>|
                            <span>{{company}}</span>
                        </div>
                        <div class="user-desc">
                            <ul>
                                <li>{{description}}</li>
                            </ul>
                        </div>
                    </div>
                    {{/userWorkExperiences}}
                </div>
                <div class="user-education right-head">
                    <div class="heading-set">education</div>
                    {{#userEducations}}
                    <div class="user-inner-d">
                        <div class="user-stdy">
                            <span>{{from_date}} - {{to_date}}</span>|
                            <span>{{degree}} {{field}}</span>|
                            <span class="user-uni">{{institute}}</span>
                        </div>
                    </div>
                    {{/userEducations}}
                </div>
                <div class="user-languages right-head">
                    <div class="heading-set">Archievements</div>
                    {{#userAchievements}}
                    <div class="user-inner-d">
                        <div class="projects">{{achievement}}</div>
                    </div>
                    {{/userAchievements}}
                </div>
                <div class="user-languages right-head">
                   {{#language}}<div class="heading-set">languages</div>{{/language}}
                    <div class="user-inner-d">
                        <div class="langs">{{language}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>