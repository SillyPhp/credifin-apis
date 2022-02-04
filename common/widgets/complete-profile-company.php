<?php
$industries = json_encode($industries)
?>

<div id="complete-company-profile" class="modal fade-scale plModal" role="dialog">
    <div class="modal-dialog lp-dialog-main">
        <!-- Modal content-->
        <div class="modal-content half-bg-color">
            <button type="button" class="close-lp-modal" onclick="setCookie()" data-dismiss="modal" aria-hidden="true">✕</button>
            <div class="row margin-0">
                <div class="col-md-4 col-sm-4">
                    <div class="lp-modal-text half-bg half-bg-color">
                        <div class="lp-text-box ">
                            <p>Why Complete<br> Your Profile</p>
                            <ul>
                                <li>It improves your visibility in search results.</li>
                                <li>Depicts organization's predominant values and culture.</li>
                                <li>Convincing your audience about the nature of your business.</li>
                            </ul>
                            <div class="lp-icon-top">
                                <!--                                <i class="far fa-check-circle"></i>-->
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                    <circle class="path circle" fill="none" stroke="#00a0e3" stroke-width="8"
                                            stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                    <polyline class="path check" fill="none" stroke="#00a0e3" stroke-width="8"
                                              stroke-linecap="round" stroke-miterlimit="10"
                                              points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-8 col-sm-8 padding-0 lp-bg-log">
                    <div class="lp-fom">
                        <div class="lp-icon-bottom"><i class="fas fa-id-card-alt"></i></div>
                        <h3>Complete Your Profile</h3>
                        <form class="updateCompanyDetails">
                            <?php
                                if(!$companyInfo['logo']){
                            ?>
                            <div class="row dis-none showField">
                                <div class="col-md-12">
                                    <div class="uploadUserImg lp-form posRel">
                                        <div class="displayImg">
                                            <img id="output"
                                                 src="https://via.placeholder.com/350x350?text=Company+Logo">
                                        </div>
                                        <input type="file" accept="image/jpeg, image/png, image/jpg"
                                               data-name="userImg" class="userImg form-control tg-fileinput"
                                               id="userImg">
                                        <label for="userImg" class="upload-icon">
                                            <i class="fas fa-pencil-alt"></i>
                                        </label>
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$companyInfo['website']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="website">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <p class="input-label" for="input">Website</p>
                                        <input type="text" class="lp-skill-input form-control" data-name="website" id="website">
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$companyInfo['mission']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="mission">
                                <div class="col-md-12 mb10 lp-error">
                                    <div class="form-group lp-form ">
                                        <label class="input-label" for="input">Mission</label>
                                        <textarea id="input" data-name="mission" class="lp-skill-input form-control aboutTextarea"></textarea>
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$companyInfo['description']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="description">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <label class="input-label" for="input">About</label>
                                        <textarea id="input" data-name="description" class="lp-skill-input form-control aboutTextarea"></textarea>
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$companyInfo['vision']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="vision">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <label class="input-label" for="input">Vision</label>
                                        <textarea id="input" data-name="vision" class="lp-skill-input form-control aboutTextarea"></textarea>
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$companyInfo['industry_enc_id']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="industry_enc_id">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <p class="input-label" for="input">Select Industry</p>
                                        <div class="cat_wrapper">
                                            <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                            <input type="text" class="lp-skill-input form-control" data-name="industry_enc_id"
                                                   id="industry">
                                        </div>
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$companyInfo['tag_line']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="tag_line">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <p class="input-label" for="input">Company Tag Line</p>
                                        <input type="text" class="lp-skill-input form-control" data-name="tag_line" id="tag_line">
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="showNextQues()" class="saveBtn">Save</button>
                                    <button type="button" onclick="skipToNextQues()" class="skipBtn">Skip</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cropLogoPop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                </div>
                <div class="modal-body">
                    <div id="demo"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary custom-buttons2 vanilla-result">Done</button>
                    <button type="button" class="btn btn-default mr-10" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
#cropLogoPop{
    z-index:99999
}
.uploadUserImg{
    position: relative;
    height: 150px;
    width: 150px !important;
    margin: 0 auto;
    float: unset;
}
.displayImg{
    width: 100%;
    height: 100%;
    overflow: hidden;
    padding-bottom: 10px;
}
.displayImg img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 2px solid #e8ecec;
    border-radius: 10px;
}
.userImg{
    position: absolute;
    visibility: hidden;
    top:0;
    right:0;
    height: 100%;   
}
.upload-icon{
    position: absolute;
    top: -18px;
    right: -17px;
    background: #00a0e3;
    padding: 7px 12px;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
}
.lp-modal-text{
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 450px !important;
}
.lp-dialog-main .modal-content{
    max-width: 60vw;
    height: auto;
}
.lp-fom h3{
    color: #000;  
    margin-top: 0px; 
    margin-bottom: 30px;
}
.lp-icon-top{
    text-align: center;
    font-size: 30px;
    color: #00a0e3    
}
.lp-icon-bottom{
    color: #00a0e3;   
    font-size: 35px;
    line-height: 0;
    margin-bottom: 25px;
}
.lp-text-box{
    background: #fff;
    padding: 20px 10px;
    border-radius: 10px;
    color: #000;
}
.lp-text-box p{
    color: #00a0e3;
    font-size: 18px;
    line-height: 25px;
    margin-bottom: 10px !important;  
}
.lp-text-box ul{
    padding-inline-start: 0px;
}
.lp-text-box ul li{
    position: relative;
    margin-left: 15px;
    line-height: 18px;
    padding: 0;
    margin-bottom: 15px;
    font-family: roboto;
    text-align: left;
    list-style-type: none;
}
.lp-text-box ul li:before{
    content:"\f111";
    margin-left: -11px;
    position: absolute;
    top: 1px;
    font-size: 7px;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: #00a0e3;
}
.lp-skill-input{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 5px 10px !important;
    font-size: 15px;
    border-radius: 7px;
    border: 2px solid #e8ecec;
}

.saveBtn, .skipBtn{
    background: #00a0e3;
    padding: 10px 15px;
    border: 1px solid #00a0e3;
    font-size: 14px;
    border-radius: 4px;
    margin-top: 20px;
    color: #fff
}
.skipBtn{
    background: transparent;
    border: 1px solid #00a0e3;
    color: #00a0e3;
}.relationList{
    padding:0px;
}
.dis-none{
    display: none;
}
.posRel{
    position: relative;
}
.lp-error .errorMsg{
    display: none;
    color: #CA0B00;
    font-size: 13px !important;
    position: absolute;
    bottom: -18px;
    left: 15px;
    font-size: 13px;
    font-weight: 400 !important;
    margin-bottom: 0px;
 }
.disShow, .lp-error .showError{
    display: block;
}
.lp-radio {
    display: inline-block;
    min-width: 90px;
    text-align: center;
    margin: 0px 10px 0 0;
}
.lp-radio > label {
    width: 100%;
    display: inline-block;
    box-shadow: 0 0 5px rgba(0,0,0,.1);
    border: 2px solid transparent;
    min-width: 150px;
    padding: 18px 0 10px;
    color: #333;
    font-weight:normal;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s; 
    cursor: pointer;
}
.lp-radio > label p{
    margin-bottom: 0px;
    font-size: 16px;
    font-family: roboto;  
}
.lp-radio > label img{
    max-width: 50px;
}
.lp-radio > input[type="radio"]:checked + label, .lp-radio > label:hover {
        box-shadow: 2px 2px 10px rgb(0 0 0 / 10%);
        color: #000;
        transition:.3s ease;
//       border: 2px solid #00a0e3;
}
.lp-radio > input {
    position: absolute;
    opacity: 0;
}
.lp-form{
    text-align: left;
    max-width: 350px;
    margin: 0 auto;
//    float: left;
    width: 100%;
    display: flex;
    flex-direction: column;
}
.lp-form label, .lp-form p{
    margin-bottom: 0px;
    font-family: roboto;
    font-size: 14px;
    font-weight: 500;
}
.half-bg-color{
    background: #00a0e3;
}
.half-bg{
    background-size:cover;
    height:100%;
    border-radius: 5px 0 0 5px;
}
.lp-fom{
    padding:50px 0;
    text-align:center;
    white-space: nowrap;
    height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.lp-text{
   height: 450px; 
}
.updateCompanyDetails{
    max-width: 350px;
    width: 100%;
    margin: 0 auto;
    text-align: center
}
.aboutTextarea{
    min-height: 130px;
    resize: none;
}
.margin-0{
    margin-left:0px !important;
    margin-right: 0px !important
} 
.lp-icon-top svg {
  width: 30px;
  display: block;
  margin: 0px auto 0;
}
.path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
}
.path.circle {
  -webkit-animation: dash 1.9s ease-in-out infinite;
  animation: dash 1.9s ease-in-out infinite;
}
.path.line {
  stroke-dashoffset: 1000;
  -webkit-animation: dash 0.9s 0.35s ease-in-out forwards infinite;
  animation: dash 0.9s 0.35s ease-in-out forwards infinite;
}
.path.check {
  stroke-dashoffset: -100;
  -webkit-animation: dash-check 1.9s 1.35s ease-in-out forwards infinite;
  animation: dash-check 1.9s 1.35s ease-in-out forwards infinite;
}
@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
.fade-scale {
  transform: scale(0);
  opacity: 0;
  -webkit-transition: all .25s linear;
  -o-transition: all .25s linear;
  transition: all .25s linear;
}
.fade-scale.in {
  opacity: 1;
  transform: scale(1);
}
.lp-bg-log{
    background:#fff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0 5px 5px 0;
    min-height:365px;
}
.loginModal.modal.in{
    display:flex !important;
}
.lp-dialog-main{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
}
.close-lp-modal{
    position: absolute;
    right: 0px;
    font-size: 17px;
    color: #FFF;
    opacity: 1;
    top: 0px;
    font-weight: 100;
    background: #00a0e3;
    border: 0;
    outline: 0;
    z-index: 99;
    padding: 0px 5px 5px 9px;
    font-family: "Roboto";
    border-radius: 0 4px 0 10px;
}
@media screen and (max-width: 992px){
    .half-bg{
        border-radius:5px 5px 0 0;
    }
    .lp-bg-log{
        border-radius:0px 5px 5px 0px;
    }
    .rem-input input{
        margin-left:0px;
    }
}
@media screen and (max-width: 767px){
    .rem-input{
        padding-right:15px !important;
    }
    .half-bg{
        display:none;
    }
    .lp-bg-log{
        min-width:300px;
    }
    .f-mail{
        white-space: normal !important;
    }
}
@media screen and(max-width: 550px){
    .lp-bg-log{
        max-width:280px;
    }
}
@media screen and (min-width: 768px){
    .lp-dialog-main {
        width: 750px !important;
        margin: 0px auto;
    }
}
body.modal-open{
    padding-right:0px !important;
}
.error-occcur{
    color:red;
}

.cat_wrapper .Typeahead-spinner{
    position: absolute;
    right: 20px;
    top: 47%;
    font-size: 18px;
    display:none;
}
.typeahead,.tt-query{
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
#industry{
    background: #fff;
    border: 2px solid #e8ecec;
    font-size: 13px;
    color: #101010;
    line-height: 24px;
    border-radius: 8px;
    margin-bottom: 10px;
    width: 100%;
}

.twitter-typeahead{
    width:100%;
}

.form-control.tt-hint {
  color: #999;
  opacity: 0 !important;
}
.tt-menu {
  width: 98%;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
              margin-top: 0px;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
');

$script = <<< JS
function setCookie() {
    let date = new Date();
    date.setTime(date.getTime() + (24 * 60 * 60 * 1000));
    let maxAge = 24 * 60 * 60 * 1000;
    const expires = "expires=" + date.toUTCString();
    document.cookie = "CompanyProfile=CompanyProfile; expires="+expires+"; max-age="+maxAge+"; path=/";
}

let industries2 = '$industries';

var industries = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   local: JSON.parse(industries2)
});
industries.initialize();
$('#industry').typeahead(null,{
    name: 'industry',
    value: 'value',
    displayKey: 'text',
    limit: 6,
    hint: false,
    minLength: 3,
    source: industries
}).on('typeahead:asyncrequest', function() {
    $('.cat_wrapper .Typeahead-spinner').show();
}).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.cat_wrapper .Typeahead-spinner').hide();
}).on('typeahead:selected',function(e, datum){
    $('#industry').attr('data-id', datum.value)
})

function countFields(){
    let fieldsArr = [];
    let cpForm = document.querySelector('.updateCompanyDetails')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    if(fieldsArr.length){
        fieldsArr[0].classList.add('disShow');
        fieldsArr[0].classList.remove('showField')
        if(fieldsArr.length == 1){
            cpForm.querySelector('.skipBtn').style.display = "none";
        }
    }
}
countFields()
showNextQues = () =>{
    let fieldsArr = [];
    let cpForm = document.querySelector('.updateCompanyDetails')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);
    }
    let disShow = cpForm.querySelector('.disShow');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex];
    if(toActive){
        toActive.classList.remove('showField');
    }
    let inputVal =  disShow.querySelectorAll('.form-control')
    let val = {};
    let valObj = '';
     if(inputVal.length > 0){
         for(let i = 0; i < inputVal.length; i++){
            let inputParent = getParentUntillLpForm(inputVal[i]);
            let errorMsg = inputParent.querySelector('.errorMsg');
            let field_data_name = inputVal[i].getAttribute('data-name');
            if(inputVal[i].value != '' || field_data_name == 'industry_enc_id'){
                console.log(inputVal[i], 'inputVal[i]');
                if(field_data_name == 'industry_enc_id'){
                    let str = $('#industry').attr('data-id');
                    valObj = str;
                }else{
                    let str = inputVal[i].value
                    valObj = str;
                }                
                val['name'] = field_data_name;
                val['value'] = valObj;
                val['pk'] = field_data_name; 
            }else{
                errorMsg.classList.add('showError');
                errorMsg.innerHTML = "This field can not Be empty";
                return false;    
            }
        }
     }
       sendData(disShow, toActive, val);
}
function sendData(disShow, toActive, val){
    $.ajax({
        url:'/organizations/update-profile',
        method: 'post',
        data: val,
        success: function (response){
            if(response == true){
                if(disShow && toActive){
                    disShow.classList.remove('disShow')
                    if(disShow.classList.contains('showField')){
                        disShow.classList.remove('showField')
                    }
                    toActive.classList.add('disShow');
                }else{
                    $('#complete-company-profile').modal('hide');
                }
            }else{
                disShow.classList.add('showField')
            }
        }
    })
}
function getParentUntillLpForm(elem){
    let parElem = $(elem).parentsUntil('.lp-error').parent();
    if (parElem.length > 0){
        return parElem[0];
    }else{
        parElem = $(elem).parent();
        return parElem[0];
    }
}
skipToNextQues = () => {
    let fieldsArr = [];
    let cpForm = document.querySelector('.updateCompanyDetails')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    let disShow = cpForm.querySelector('.disShow');
    disShow.classList.add('showField');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex]; 
    if(disShow){
        disShow.classList.remove('disShow')
    }
    toActive.classList.add('disShow');
}
$(".tg-fileinput").change(function() {
    console.log('hello');
    readURL(this);
});
let croppieContainer = document.querySelector('.croppie-container');
if(croppieContainer){
    croppieContainer.classList.remove('croppie-container')
}
var cropLogoPop = document.querySelector('#cropLogoPop');
var el = cropLogoPop.querySelector('#demo');
console.log(el);
var vanilla = new Croppie(el, {
    viewport: { width: 400, height: 400 },
    boundary: { width: 500, height: 500 },
    enforceBoundary: false,
    showZoomer: true,
    enableZoom: true,
    // enableExif: true,
    mouseWheelZoom: true,
    maxZoomedCropWidth: 10,
    // enableOrientation: true
});
function readURL(input) {
    console.log('enter');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#cropLogoPop').modal('show');
        var rawImg = e.target.result;
        setTimeout(function() {
            renderCrop(rawImg);
        }, 500);
      $('#output').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    
  }
}
function renderCrop(img){
    vanilla.bind({
        url: img,
        points: [20,20,20,20]
        // orientation: 4
    });
}

cropLogoPop.querySelector('.vanilla-result').addEventListener('click', function (ev) {
    vanilla.result({
        type: 'base64',
        // format:'jpeg',
    }).then(function (data) {
        $.ajax({
            url: "/organizations/update-logo",
            method: "POST",
            data: {data:data},
            beforeSend:function(){
                $('.vanilla-result').html("<i class='fas fa-circle-notch fa-spin fa-fw'></i>");
                $('.vanilla-result').prop('disabled', true);
            },
            success: function (response) {
                $('.vanilla-result').html('Done');
                $('.vanilla-result').prop('disabled', false);
                $('#cropImagePop').modal('hide');
                if (response.title == 'Success') {
                    // toastr.success(response.message, response.title);
                    $('#output').attr('src', data);
                } else {
                    // toastr.error(response.message, response.title);
                }
            }
        });
    });
});


JS;
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs($script);
?>
