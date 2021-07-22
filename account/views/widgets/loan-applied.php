<?php

use yii\helpers\Url;

?>

    <div class="col-md-12">
        <div class="loan-app-main">
            <div class="loan-mail-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/loan-complete.png') ?>">
            </div>
            <div class="loan-text-data">
                <div class="upper-loan">
                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/party.png') ?>">
                    <h3>Congratulations <span><?= $loan['applicant_name'] ?></span></h3>
                    <p>Your previous loan for <span><?= $loan['course_name'] ?></span>,
                        <span>
                            <?=
                            $loan['years'],
                            $loan['years'] == 1 ? 'st' : ($loan['years'] == 2) ? 'nd' : 'th';
                            ?>
                        </span> year, <span><?=
                            $loan['semesters'],
                            $loan['semesters'] == 1 ? 'st' : ($loan['semesters'] == 2) ? 'nd' : 'th';
                            ?></span> semester
                        has been completed.</p>
                </div>
                <div class="bottom-loan">
                    <p>Apply loan for next semester</p>
                    <a href="javascript:;" id="" class="showLoanModal">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
    <div id="applyModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="apply">
                <div class="apply-illustration">
                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/loan-complete.png'); ?>">
                </div>
                <div class="apply-form">
                    <p class="loan-form-heading">Apply For Education Loan</p>
                    <form id="applyLoanForm">
                        <div class="row">
                            <div class="col-md-12 mb10">
                                <div class="field-first_name">
                                    <label class="formHeading">Loan Amount</label>
                                    <input type="text" class="form-control text-capitalize formVal"
                                         data-type="number"  name="amount">
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb10">
                                <div class="field-first_name">
                                    <label class="formHeading">Year</label>
                                    <select class="form-control text-capitalize formVal" name="year">
                                        <option value="">Select Year</option>
                                        <option value="1">1st Year</option>
                                        <option value="2">2nd Year</option>
                                        <option value="3">3rd Year</option>
                                        <option value="4">4th Year</option>
                                        <option value="5">5th Year</option>
                                    </select>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb10">
                                <div class="field-first_name">
                                    <label class="formHeading">Semester</label>
                                    <select class="form-control text-capitalize formVal" name="semester">
                                        <option value="">Select Semester</option>
                                        <option value="1">1st Semester</option>
                                        <option value="2">2nd Semester</option>
                                        <option value="3">3rd Semester</option>
                                        <option value="4">4th Semester</option>
                                        <option value="5">5th Semester</option>
                                        <option value="6">6th Semester</option>
                                        <option value="7">7th Semester</option>
                                        <option value="8">8th Semester</option>
                                        <option value="9">9th Semester</option>
                                        <option value="10">10th Semester</option>
                                    </select>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt20">
                                <button type="button" data-id="" id="<?= $loan[0]['loan_app_enc_id']?>" class="applyBtn">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php
$user_id = Yii::$app->user->identity->user_enc_id;
$this->registerCss( '
.loan-app-main {
    background: linear-gradient(97.96deg, #330867 -33.18%, #25C1C2 105.68%);
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 30px;
    padding: 30px 10px 40px;
}
.loan-form-heading{
    text-align: center;
    color: #000;
    margin-bottom: 15px !important; 
    font-size: 20px;
    font-family: roboto;
}
.mb10{
    margin-bottom: 10px;
}
.loan-mail-logo {
    flex-basis: 35%;
}
.loan-mail-logo img {
    width: 100%;
}
.loan-text-data {
    flex-basis: 65%;
    margin-left: 50px;
}
.upper-loan img {
    width: 70px;
}
.upper-loan h3 {
    margin: 0 0 5px;
    font-family: lora;
    font-weight: bold;
    font-size:30px;
    color: #fff;
    text-transform: capitalize;
}
.upper-loan p {
    font-family: roboto;
    font-size: 18px;
    font-weight: 400;
    color: #fff;
}
.upper-loan h3 span,
.upper-loan p span{
    color: #ff7803;
}
.bottom-loan p {
    margin: 15px 0 10px !important;
    font-family: roboto;
   color: #fff;
    font-size: 18px;
}
.bottom-loan a {
    background-color: #ff7803;
    border: 2px solid #ff7803;
    color: #fff;
    padding: 6px 25px;
    display: inline-block;
    border-radius: 8px;
    font-family: roboto;
    font-weight: 400;
    font-size: 18px;
    letter-spacing: .3px;
}
.bottom-loan a:hover {
    background: transparent;
    color: #fff;
    transition: .3s ease;
    color: #ff7803;
}
.modal {
    display: none; 
    position: fixed;
    z-index: 9999; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100vh;
    overflow: auto; 
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}
.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    height: 60vh;
    border-radius: 10px;
}
.close {
    position: absolute;
    top:10px;
    right: 10px;
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.apply{
    display: flex;
    align-items: center;
    width: 100%;  
    height: 100%;
    border-radius: 10px;
}
.apply-illustration{
    background: linear-gradient(97.96deg, #330867 -33.18%, #25C1C2 105.68%);
    flex-basis: 50%;
    height: 100%;
    position: relative;
}

.apply-illustration img{
    width: 250px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.apply-form{
    flex-basis: 50%;  
    padding: 0 2rem;
}
.applyBtn{
    margin-top:20px;
    background: #00a0e3;
    padding: 8px 20px;
    border: none;
    font-size: 14px;
    color: #fff;
    line-height: 16px;
    font-weight: 500;
}
.applyBtn:hover{
     background: #00a0e3;
     transition: .5s ease;
}
.new-modal-open{
    overflow: hidden;
}
.errorMsg{
    font-size: 13px;
    display: none;
    color: #df4759;
}
.showError{
    display: block;
}
@media screen and (max-width: 768px) {
    .loan-app-main{
        flex-direction: column;
        text-align: center;
    }
    .loan-mail-logo{
        order: 2;
        margin-top: 40px;
    }
    .loan-mail-logo img{
        max-width: 200px;
    }
    .loan-text-data{
        margin-left: 0px; 
    }
}
');
$script = <<<JS
var modal = document.getElementById("applyModal");
var span = document.getElementsByClassName("close")[0];
$('.showLoanModal').on('click', function() {
  modal.style.display = "block";
  $('body').addClass('new-modal-open');
})
$(span).on('click', function() {
  modal.style.display = "none";
  $('body').removeClass('new-modal-open');
})
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        $('body').removeClass('new-modal-open');
    }
}

$('.applyBtn').on('click', function (e){
    let btn = e.target;
    let loan_id = $(e.target).attr('id');
    let submitForm = document.querySelector('#applyLoanForm');
    let formFields = submitForm.querySelectorAll('.formVal');
    let data = {};
    data['loan_app_id'] = loan_id;
    data['user_id'] = '$user_id';
    for(let i=0; i<formFields.length; i++){
        validations(formFields[i]);
        let fieldVal = formFields[i].value;
        let fieldName = formFields[i].getAttribute('name');
        data[fieldName] = fieldVal;
    }
    let hasError = submitForm.querySelector('.hasError');
    if(hasError){
        return false;
    }
    $.ajax({
        url:'https://ravinder.eygb.me/api/v3/education-loan/refinance',
        data: data,
        method: 'post',
        success: function(response){
           if(response['response']['status'] == 200){
               toastr.success('Loan Application Applied', 'success');
               modal.style.display = "none";
           }else{
               toastr.error('Some Error Occurred', 'error');
           }
        }
    })
})
$('.formVal').on('change', function(event){
    let formFiled = event.target;
    validations(formFiled)
})
function validations(e){
    let fField = e;
    let parentElem = e.parentElement; 
    let errorMsg = parentElem.querySelector('.errorMsg');
    let fieldType = fField.getAttribute('data-type'); 
    let errorType;
    const num = /^[0-9]+$/;
    if(fieldType == 'number' && e.value != ''){
         if(!e.value.match(num)){
             errorType = 'number';
             console.log('agj');
             showError(errorMsg, fField, errorType);
            return false;
         }
    }else{
        hideError(errorMsg, fField)
    }
    
    if(e.value == ''){
        errorType = 'req';
        showError(errorMsg, fField, errorType)  
         return false;
    }else{
       hideError(errorMsg, fField)
    }
}
function showError(errorMsg, fField, errorType){
    // let eMsg;
    // if(errorType == 'number'){
    //     eMsg = 'Please Enter Number';
    // }else{
    //     eMsg = 'This field is required';
    // }
    let eMsg = (errorType == 'number') ? 'Please Enter Number' : 'This field is required';
    errorMsg.classList.add('showError');
    errorMsg.innerText = eMsg;
    fField.classList.add('hasError');   
    return false;
}
function hideError(errorMsg, fField){
    errorMsg.classList.remove('showError');
    errorMsg.innerText = '';
    fField.classList.remove('hasError');
}
JS;
$this->registerJS($script);
?>
