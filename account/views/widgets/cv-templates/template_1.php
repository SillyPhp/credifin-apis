<script id="resume_template" type="text/template">
<section>
    <div class="r-main">
        <div class="r-head">
            <div class="r-name">{{name}}</div>
            <div class="r-work">Profession</div>
            <div class="r-address">Address: <span>chd</span></div>
        </div>
        <div class="r-center">
            <div class="r-object">lhlifa dmlkasjklm;as ;lm;dkas;ldkas;ldmasdkamd;ask;lk ;lkas;ld das;kd;lakd ;askd;ada;ldk;dk a;ld c;djfkjsf;k kcds;l rwjf;jwe;lfk;ldk;lekd;lk;ldfke;lwkf;lk;lmd;fml;we;lew mcwe;l</div>
            <div class="r-points">
                <div class="r-skills">
                    <div class="skill-head">Skills</div>
                    <div class="skills">
                        <ul>
                            <li>time management</li>
                            <li>web designing</li>
                            <li>photoshop</li>
                        </ul>
                    </div>
                    <div class="work-head">Work History</div>
                    <div class="works">
                        <div class="w-date">
                            <span class="work1">12/45/74</span> - <span class="work2">current</span>
                        </div>
                        <div class="w-position">
                            <div class="w-name">assistant manager</div>
                            <div class="w-location">company name</div>
                            <ul>
                                <li>organized all new hire,security and temporary paperwork</li>
                                <li>organized all new hire,security and temporary paperwork</li>
                            </ul>
                        </div>
                    </div>
                    <div class="works">
                        <div class="w-date">
                            <span class="work1">12/45/74</span> - <span class="work2">12/47/96</span>
                        </div>
                        <div class="w-position">
                            <div class="w-name">assistant manager</div>
                            <div class="w-location">company name</div>
                            <ul>
                                <li>organized all new hire,security and temporary paperwork</li>
                                <li>organized all new hire,security and temporary paperwork</li>
                            </ul>
                        </div>
                    </div>
                    <div class="works">
                        <div class="w-date">
                            <span class="work1">12/45/74</span> - <span class="work2">12/47/96</span>
                        </div>
                        <div class="w-position">
                            <div class="w-name">assistant manager</div>
                            <div class="w-location">company name</div>
                            <ul>
                                <li>organized all new hire,security and temporary paperwork</li>
                                <li>organized all new hire,security and temporary paperwork</li>
                            </ul>
                        </div>
                    </div>
                    <div class="education-head">Education</div>
                    <div class="education">
                        <div class="e-date">
                            <span class="edu1">12/45/74</span> - <span class="edu2">12/47/96</span>
                        </div>
                        <div class="e-position">
                            <div class="e-name">BCA</div>
                            <div class="e-location">Gnimt clg,ldh</div>
                        </div>
                    </div>
                    <div class="archievements-head">Achievements</div>
                    <div class="education">
                        <div class="e-date">
                            <span class="edu1">12/45/74</span>
                        </div>
                        <div class="e-position">
                            <div class="e-name">cricket cup</div>
                            <div class="e-location">Gnimt clg,ldh</div>
                        </div>
                    </div>
                    <div class="hobbies-head">Hobbies</div>
                    <div class="u-hobbies">Playing Cricket, Watching Movies</div>
                    <div class="interest-head">Interest</div>
                    <div class="u-interest">web designing, photoshop</div>
                </div>
            </div>
        </div>
    </div>
</section>
</script>
<?php
$script = <<< JS
function fetchTemplateData(template,loader) {
  $.ajax({
  url:'/account/resume-builder/get-data',
  method:'Post',
  datatype:"json",
  beforeSend: function(){
      if (loader) {
            $('.img_load').css('display','block');
        }
      },
  success:function(response) {
      $('.img_load').css('display','none');
      if(response.status === 200) {
          template.append(Mustache.render($('#resume_template').html(),response.data));
          utilities.initials();
      }
  }   
  })
}
JS;
$this->registerJs($script);
$this->registerCss("
.r-main {
    max-width: 700px;
    margin: 0 auto;
    border: 1px solid #373D48;
}
.r-head {
    padding: 20px;
    background-color: #373D48;
    color: #fff;
    font-family: roboto;
}
.r-name {
    font-size: 30px;
    font-weight: 500;
    text-transform: capitalize;
}
.r-work {
    font-size: 22px;
}
.r-address {
    font-size: 18px;
    border-top: 1px solid #fff;
    padding: 15px 0px 0px 0px;
}
.r-center {
    padding: 20px;
    font-family: roboto;
}
.r-object {
    font-size: 16px;
    text-align: justify;
    padding-bottom:15px;
}
.skill-head, .work-head, .education-head, .archievements-head, .hobbies-head, .interest-head {
    font-size: 18px;
    font-weight: 500;
    padding: 15px 0px 5px 0px;
}
.skills > ul > li{
    list-style:inside;
    font-size: 16px;
    text-transform: capitalize;
}
.works, .education{
    display:flex;
    padding-bottom:15px;
}
span.work2, span.edu2 {
    display: block;
}
.w-date, .e-date {
    font-size: 16px;
    font-weight: 400;
}
.w-position, .e-position {
    padding: 0px 0px 0px 30px;
    text-transform: capitalize;
    font-weight: 500;
}
.w-name, .e-name {
    font-size: 16px;
}
.w-location, .e-location {
    font-size: 16px;
    font-weight: 400;
}
.w-position > ul > li{
    list-style:inside;
    font-weight:400;
}
.u-hobbies, .u-interest {
    font-size: 16px;
}
");