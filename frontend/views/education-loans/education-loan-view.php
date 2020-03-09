<?php
$this->title = Yii::t('frontend', 'Education Loan');
$this->params['header_dark'] = false;

use yii\helpers\Url;

?>
    <section class="bg-blue">
        <div class="sign-up-details bg-white" id="sd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-start">
                        <form action="">
                            <div class="tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="heading-style">Education Loan</h1>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Name of Applicant (Student Name)
                                        </label>
                                        <input type="text" class="form-control" id="number" placeholder="Enter Full Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Date Of Birth
                                        </label>
                                        <div class="input-group date" data-provide="datepicker" class="datepicker3">
                                            <input type="text" class="form-control">
                                            <div class="input-group-addon">
                                                <span class=""><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            Choose Country where you want to study
                                        </label>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">India
                                                    <input type="radio" checked="checked" id="india" value="india" onclick="showCountry(this)" name="countryRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Outside India
                                                    <input type="radio" id="othercountry" value="otherCountry" onclick="showCountry(this)" name="countryRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20" id="countryName">
                                    <div class="form-group">
                                        <label for="duration" class="input-group-text">
                                            Enter Country Name
                                        </label>
                                        <input type="text" class="form-control" id="country"
                                               placeholder="Enter Country Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect02">
                                            Current city where you live
                                        </label>
                                        <input type="text" id="cities" name="location" class="form-control"
                                               autocomplete="off" placeholder="City or State"/>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Which degree do you want to pursue
                                        </div>
                                        <select class="form-control">
                                            <option>Diploma</option>
                                            <option>Graduation</option>
                                            <option>Post Graduation</option>
                                            <option>Professional Course</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Course Name
                                        </label>
                                        <input type="text" class="form-control" id="number"
                                               placeholder="Enter Course Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="duration" class="input-group-text">
                                            College / University Name
                                        </label>
                                        <input type="text" class="form-control" id="duration"
                                               placeholder="Enter College or University Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="row">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <label for="datetimepicker6" class="input-group-text">
                                                    Start Date
                                                </label>
                                                <div class="input-group date" data-provide="datepicker" class="datepicker">
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-addon">
                                                        <span class=""><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <label for="datetimepicker7" class="input-group-text">
                                                    End Date
                                                </label>
                                                <div class="input-group date" data-provide="datepicker" class="datepicker2">
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-addon">
                                                        <span class=""><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Phone Number (WhatsApp Preferred)
                                        </label>
                                        <input type="text" class="form-control" id="number"
                                               placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="email" class="input-group-text">
                                            Email Address
                                        </label>
                                        <input type="text" class="form-control" id="email"
                                               placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="heading-style">Additional Details</h1>
                                    </div>
                                </div>


                                <div class="col-md-12 padd-20">
                                    <div class="form-group ">
                                        <div class="radio-heading input-group-text">
                                            Gender
                                        </div>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">Male
                                                    <input type="radio" checked="checked" name="genderRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Female
                                                    <input type="radio" name="genderRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                            Loan Amount Required
                                        </label>
                                        <input type="text" class="form-control" id="annulIncome"
                                               placeholder="Enter Loan Amount">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Who would be your Co-Applicant?
                                        </div>
                                        <ul>
                                            <li class="service-list">
                                                <input type="radio" name="name" id="father"
                                                       class="checkbox-input services"/>
                                                <label for="father">Father</label>
                                            </li>
                                            <li class="service-list">
                                                <input type="radio" name="name" id="mother"
                                                       class="checkbox-input services"/>
                                                <label for="mother">Mother</label>
                                            </li>
                                            <li class="service-list">
                                                <input type="radio" name="name" id="brother"
                                                       class="checkbox-input services"/>
                                                <label for="brother">Brother</label>
                                            </li>
                                            <li class="service-list">
                                                <input type="radio" name="name" id="sister"
                                                       class="checkbox-input services"/>
                                                <label for="sister">Sister</label>
                                            </li>
                                            <li class="service-list">
                                                <input type="radio" name="name" id="guardian"
                                                       class="checkbox-input services"/>
                                                <label for="guardian">Guardian</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="email" class="input-group-text">
                                            Co-Applicant's Name
                                        </label>
                                        <input type="text" class="form-control" id="email"
                                               placeholder="Enter Full Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Your Co-Applicant's employment type ?
                                        </div>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">Salaried
                                                    <input type="radio" checked="checked" name="borrowRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Self-Employed
                                                    <input type="radio" name="borrowRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Non-Working
                                                    <input type="radio" name="borrowRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                            Co-Applicant's Annual Income
                                        </label>
                                        <input type="text" class="form-control" id="annulIncome"
                                               placeholder="Enter Annual Income">
                                    </div>
                                </div>
                                <div id="addAnotherCo">

                                </div>
                                <div class="col-md-12 padd-20 displayFlex" id="addAnotherButton">
                                    <button type="button" class="addAnotherCo input-group-text" onclick="addAnotherCo()"> <i class="fas fa-plus-square"></i> Add Another Co-Applicant</button>
                                </div>
                            </div>

                            <div class="input-group padd-20">
                                <div class="btn-center">
                                    <button type="button" class="button-slide" id="prevBtn" onclick="nextPrev(-1)">
                                        Previous
                                    </button>
                                    <button type="button" class="button-slide" id="nextBtn" onclick="nextPrev(1)">
                                        Next
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="college-logo" id="cl">
            <div class="row">
                <div class="col-md-12">
                    <div class="el-pos-rel">
                        <div class="max-300">
                            <div class="cl-heading">Get the Best Education Loan</div>
                            <div class="cl-text"> We tie up with the best providers in the country to help you plan your
                                education.
                                With offers that provide up to 100% of your required loan amount, planning for your
                                education
                                is now more easier than ever.
                            </div>
                            <div class="cl-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/edu-loan-icon.png') ?>"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
#countryName{
    display: none;
}
.float-right{
    float:right;
    padding-top: 3px;
    color: #333 !important;
}
.addAnotherCo{
    background: none;
    border:none;
    margin-bottom:20px;
}
.addAnotherCo:hover{
    color:#00a0e3;
    transition: .3s ease;
}
.displayInline li{
    display:inline-block;
    padding-right:20px;
}
.cl-icon img{
    margin-top: 30px;
    max-height: 300px;
}
.form-start{
    max-width:400px;
    margin: 0 auto;
}
.custom-select:active{
    border:none;
}
.btn-center{
    text-align:center;
}
.btn-center button{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-left: 5px;
    background: #fff;
    border:none;
}
.btn-center button:hover{
    background-color: #00a0e3;
    color: #fff;
}
.max-300{
    max-width:350px;
    margin:0 auto;
}
.sign-up-details {
    padding: 60px 25px 0 25px;
    background: linear-gradient(to bottom, #e9f5f5 0%, #fefefe 100%);
    min-height: 100%;
    width:50vw;
    position:absolute;
    min-height:100vh;
}
.college-logo {
    margin-left:50vw;
    padding:60px 25px 0 25px;
    text-align:center;
    color:#000;
    width:50vw;
    min-height:100vh;
    position:fixed;
    background:#00a0e3;
}
@media only screen and (max-width: 500px){
    .sign-up-details{
        width:70vw;
    }
    .college-logo{
        width:30vw;
        margin-left:70vw;
    }
    .cl-heading{
        font-size:10px;
        display:none;
    }
    .cl-text{
        font-size: 8px;
        display:none;
    }
    .cl-icon img{
        margin-top:35vh
    }
}
#footer{
    display:none;
}
.pro-btn{
    background:#ff7803;
    border:#ff7803;
    padding:10px 20px;
    color:#fff;
}
.cl-text{
    font-size:16px;
    color:#fff
}
.cl-heading{
    color:#fff;
    font-size:20px;
    padding-top:30px;
    font-weight:bold;
}
.footer{
    margin-top:0px !important;
}
.bg-white{
    background:#fff;
}
//.bg-blue{
//    background:#00a0e3;
//}
.input-group-text{
    font-weight: bold;
    font-family: lora;
    color: #000;
    font-size: 15px;
}
.head-padding{
    padding-top:50px;
}
.radio-heading{
    padding-bottom:10px;
}
form label {
    font-family: lora, sans-serif;
    font-size: 14px;
    font-weight: normal;
    margin-bottom: 0px;
}
.input-group{
    width:100%;
}
.custom-select{
    padding:10px 5px;
    width:100%;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom:1px solid #eee;
    font-size:14px;
    color:#999;
}
.container-radio {
  display: block;
  position: relative;
  padding-left: 29px;
  margin-bottom: 5px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.container-radio input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.checkmark {
    position: absolute;
    top: 3px;
    left: 0;
    height: 22px;
    width: 22px;
    background-color: #eee;
    border-radius: 50%;
}

.container-radio:hover input ~ .checkmark {
  background-color: #ccc;
}

.container-radio input:checked ~ .checkmark {
  background-color: #2196F3;
}
.checkmark:after {
  content: "";
  position: absolute;
  display: none;    
}

/* Show the indicator (dot/circle) when checked */
.container-radio input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container-radio .checkmark:after {
 	top: 6px;
    left: 6px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: white;
}
.service-list{
     display: inline-block;
     min-width: 110px;
     margin-left:3px;
}
.service-list label{
   width: 100%;
   display: inline-block;
   background-color: rgba(255, 255, 255, .9);
   border: 1px solid rgba(139, 139, 139, .3);
   color: #333;
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
}
.service-list label {
   padding: 8px 12px;
   cursor: pointer;
   text-align: center;
}
.service-list label::before {
   display: inline-block;
   font-style: normal;
   font-variant: normal;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   font-family: Font Awesome 5 Free ;
   font-weight: 900;
   font-size: 12px;
   padding: 2px 6px 2px 2px;
   content: "067";
   transition: transform .3s ease-in-out;
}
.service-list input[type="radio"]:checked + label::before {
   content: "00c";
   transform: rotate(-360deg);
   transition: transform .3s ease-in-out;
}
.service-list input[type="radio"]:checked + label, .service-list label:hover {
   border: 1px solid #00a0e3;
   background-color: #00a0e3;
   color: #fff;
   transition: all .2s;
}
.service-list input[type="radio"] {
 display: absolute;
}
.service-list input[type="radio"] {
 position: absolute;
 opacity: 0;
}
.service-list input[type="radio"]:focus + label {
 border: 1px solid #00a0e3;
}

');
$script = <<<JS
    getCourseList(id = 0);
    $(document).on('click', '.edu', function(event) {
        var id = $(this).attr('id');
        getCourseList(id);
    });

    function getCourseList(id) {
        $.ajax({
            url : '/site/course-list',
            method : 'POST',
            data : {id: id},
            success : function(res) {
            var html = []; 
            $.each(res,function(index,value)
                  {
                   html.push('<li class="service-list"><input type="radio" name="name" id="law" class="checkbox-input services" /><label for="law">'+value+'</label></li>');
                 });
             $('#courses').html(html);   
            }
        });
    }
    $('.datepicker, .datepicker2, .datepicker3').datepicker({
    format: 'mm/dd/yyyy',
    startDate: '-3d'
});
JS;
$this->registerJs($script);
?>

    <script>
        function matchHeight() {
            var divHeight = document.getElementById('sd').offsetHeight;
            document.getElementById('cl').style.height = (divHeight + "px");
        }

        window.onload = matchHeight();

        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab);

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
                x[n + 1].style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            console.log(x[currentTab])
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            matchHeight();

            if (currentTab >= x.length) {
                document.getElementById("regForm").submit();
                return false;
            }
            showTab(currentTab);
        }

        function showCountry(ths){
            let radioValue = ths.value;
            const countryName = document.getElementById('countryName');
            if(radioValue == 'otherCountry'){
                countryName.style.display = "block";
            }else{
                countryName.style.display = "none";
            }
        }


        var coApplicant = ['<div class="col-md-12 padd-20 display-flex"><span class="input-group-text">Other Co-Applicant\'s Details</span><button type="button" class="addAnotherCo input-group-text float-right" onclick="RemoveAnotherCo(this)"> Cancel</button>\n' +
        '                                    </div>\n' +
        '                                    <div class="col-md-12 padd-20">\n' +
        '                                        <div class="form-group">\n' +
        '                                            <div class="radio-heading input-group-text">\n' +
        '                                                Who would be your Co-Applicant?\n' +
        '                                            </div>\n' +
        '                                            <ul>\n' +
        '                                                <li class="service-list">\n' +
        '                                                    <input type="radio" name="coapplicant" id="father"\n' +
        '                                                           class="checkbox-input services"/>\n' +
        '                                                    <label for="father">Father</label>\n' +
        '                                                </li>\n' +
        '                                                <li class="service-list">\n' +
        '                                                    <input type="radio" name="name" id="mother"\n' +
        '                                                           class="checkbox-input services"/>\n' +
        '                                                    <label for="mother">Mother</label>\n' +
        '                                                </li>\n' +
        '                                                <li class="service-list">\n' +
        '                                                    <input type="radio" name="name" id="brother"\n' +
        '                                                           class="checkbox-input services"/>\n' +
        '                                                    <label for="brother">Brother</label>\n' +
        '                                                </li>\n' +
        '                                                <li class="service-list">\n' +
        '                                                    <input type="radio" name="name" id="sister"\n' +
        '                                                           class="checkbox-input services"/>\n' +
        '                                                    <label for="sister">Sister</label>\n' +
        '                                                </li>\n' +
        '                                                <li class="service-list">\n' +
        '                                                    <input type="radio" name="name" id="guardian"\n' +
        '                                                           class="checkbox-input services"/>\n' +
        '                                                    <label for="guardian">Guardian</label>\n' +
        '                                                </li>\n' +
        '                                            </ul>\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                    <div class="col-md-12 padd-20">\n' +
        '                                        <div class="form-group">\n' +
        '                                            <label for="email" class="input-group-text">\n' +
        '                                                Co-Applicant\'s Name\n' +
        '                                            </label>\n' +
        '                                            <input type="text" class="form-control" id="email"\n' +
        '                                                   placeholder="Enter Full Name">\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                    <div class="col-md-12 padd-20">\n' +
        '                                        <div class="form-group">\n' +
        '                                            <div class="radio-heading input-group-text">\n' +
        '                                                Your Co-Applicant\'s employment type ?\n' +
        '                                            </div>\n' +
        '                                            <ul class="displayInline">\n' +
        '                                                <li>\n' +
        '                                                    <label class="container-radio">Salaried\n' +
        '                                                        <input type="radio" checked="checked" name="borrowRadio">\n' +
        '                                                        <span class="checkmark"></span>\n' +
        '                                                    </label>\n' +
        '                                                </li>\n' +
        '                                                <li>\n' +
        '                                                    <label class="container-radio">Self-Employed\n' +
        '                                                        <input type="radio" name="borrowRadio">\n' +
        '                                                        <span class="checkmark"></span>\n' +
        '                                                    </label>\n' +
        '                                                </li>\n' +
        '                                                <li>\n' +
        '                                                    <label class="container-radio">Non-Working\n' +
        '                                                        <input type="radio" name="borrowRadio">\n' +
        '                                                        <span class="checkmark"></span>\n' +
        '                                                    </label>\n' +
        '                                                </li>\n' +
        '                                            </ul>\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                    <div class="col-md-12 padd-20">\n' +
        '                                        <div class="form-group">\n' +
        '                                            <label for="annulIncome" class="input-group-text">\n' +
        '                                                Co-Applicant\'s Annual Income\n' +
        '                                            </label>\n' +
        '                                            <input type="text" class="form-control" id="annulIncome"\n' +
        '                                                   placeholder="Enter Annual Income">\n' +
        '                                        </div>\n' +
        '                                    </div>'];

        function addAnotherCo(){
            var textnode = document.createElement("div");
            textnode.setAttribute('class', 'coapplicant');
            textnode.innerHTML = coApplicant;
            document.getElementById('addAnotherCo').appendChild(textnode);

            let coapplicants = document.getElementsByClassName('coapplicant');
            if(coapplicants.length > 1){
                document.getElementById('addAnotherButton').style.display = "none"
            }
        }
        function RemoveAnotherCo(ths) {
            ths.closest('.coapplicant').remove();
            let coapplicants = document.getElementsByClassName('coapplicant');
            console.log(coapplicants)
            if(coapplicants.length < 2){
                document.getElementById('addAnotherButton').style.display = "block"
            }
        }
    </script>

<?php
//$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);