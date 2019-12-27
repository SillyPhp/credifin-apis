<script id="resume_template" type="text/template">
                    <div class="r-main">
                        <div class="r-left">
                            <div class="user-name">kulwinder Singh</div>
                            <div class="p-info-head">Personal Information</div>
                            <div class="p-info">
                                <div class="r-phone-no">
                                    <div class="ph-head">Phone</div>
                                    <div class="ph-inner">894621465</div>
                                </div>
                                <div class="r-email">
                                    <div class="e-head">E-mail</div>
                                    <div class="e-inner">ljahdlas@gajlkkas.com</div>
                                </div>
                                <div class="r-birth">
                                    <div class="b-head">Date Of Birth</div>
                                    <div class="b-inner">15/7/2000</div>
                                </div>
                            </div>
                            <div class="p-info-head">Skills</div>
                            <div class="r-skills">
                                <div class="r-skill">HTML</div>
                                <div class="r-skill">CSS</div>
                                <div class="r-skill">BOOTSTRAP</div>
                            </div>
                            <div class="p-info-head">Languages</div>
                            <div class="r-languages">
                                <div class="r-lang">hindi</div>
                                <div class="r-lang">Punjabi</div>
                                <div class="r-lang">english</div>
                            </div>
                        </div>
                        <div class="r-right">
                            <div class="r-info">
                                <div class="r-head">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer
                                    took a galley of type and scrambled it to make a type specimen book. It has survived not
                                    only
                                    five centuries, but also the leap into electronic typesetting
                                </div>
                                <div class="info-head">Experience</div>
                                <div class="e-main">
                                    <div class="e-record">
                                        <div class="e-date">
                                            <span>15/45/2140</span> - <span class="set-to">15/45/2140</span>
                                        </div>
                                        <div class="e-loc">
                                            <div class="loc-name">Barista</div>
                                            <div class="loc-pos">manager</div>
                                        </div>
                                    </div>
                                    <div class="e-record">
                                        <div class="e-date">
                                            <span>15/45/2140</span> - <span class="set-to">15/45/2140</span>
                                        </div>
                                        <div class="e-loc">
                                            <div class="loc-name">mac'd</div>
                                            <div class="loc-pos">manager</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-head">Education</div>
                                <div class="e-main">
                                    <div class="e-record">
                                        <div class="ed-date">
                                            <span>15/45/2140</span> - <span class="set-to">15/45/2140</span>
                                        </div>
                                        <div class="ed-loc">
                                            <div class="loc-name">BBA</div>
                                            <div class="loc-pos">GNIMT</div>
                                        </div>
                                    </div>
                                    <div class="e-record">
                                        <div class="ed-date">
                                            <span>15/45/2140</span> - <span class="set-to">15/45/2140</span>
                                        </div>
                                        <div class="ed-loc">
                                            <div class="loc-name">MCA</div>
                                            <div class="loc-pos">GNIMT</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-head">Hobbies & Interest</div>
                                <div class="e-main">
                                    <div class="hobbies">singing, listening music, games</div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    border: 1px solid #592222;
    display:flex;
}
.r-left {
    width: 230px;
    display: inline-block;
    background-color:#592222;
    color:#fff;
}
.r-right {
    width: 470px;
    display: inline-block;
}
.user-name {
    font-size: 30px;
    padding: 20px;
    text-align: center;
    text-transform: capitalize;
}
.p-info-head {
    text-align: center;
    font-size: 18px;
    background: #8f2f2f;
    color:#fff;
}
.p-info, .r-skills, .r-languages{
    padding: 10px 20px 20px 20px;
}
.r-phone-no, .r-email, .r-birth {
    margin-bottom: 10px;
}
.ph-head, .e-head, .b-head {
    font-size: 17px;
    font-weight: 500;
    font-family: roboto;
}
.ph-inner, .e-inner, .b-inner, .r-skill, .r-lang, .e-date, .e-loc, .ed-date, .ed-loc, .hobbies {
    font-size: 15px;
    font-family: roboto;
}
.r-head {
    padding: 10px 20px;
    text-align: justify;
    font-family: roboto;
}
.info-head {
    padding: 2px 10px;
    font-size: 17px;
    font-weight: 500;
    font-family: roboto;
    background-color:#592222;
    margin: 0px 10px;
    color:#fff;
}
.e-main {
    padding: 10px 20px;
}
.e-date, .ed-date {
    display: inline-block;
}
.e-loc, .ed-loc{
    padding: 0px 0px 0px 30px;
    font-size: 16px;
    font-weight: 500;
    text-transform: capitalize;
}
.e-record {
    display: flex;
    padding-bottom:15px;
}
.set-to{
    display:block;
}
");