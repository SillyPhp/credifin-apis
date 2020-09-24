<?php
$this->title = Yii::t('frontend', 'Education Loan');
$this->params['header_dark'] = false;

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$EducationalLoanForm = ActiveForm::begin([
    'id' => 'education-loan',
    'fieldConfig' => [
        'template' => '<div class="col-md-12 padd-20"><div class="input-group">{label}{input}{error}</div></div>',
        'labelOptions' => ['class' => 'input-group-text']
    ],
]);
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
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect01">
                                        Choose Country where you want to study
                                    </label>
                                    <select class="custom-select" id="inputGroupSelect01" name="country">
                                        <option selected>Select a Country</option>
                                        <option value="1">USA</option>
                                        <option value="2">Canada</option>
                                        <option value="3">England</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect02">
                                        Current city where you live
                                    </label>
                                    <select class="custom-select" id="inputGroupSelect02" name="city">
                                        <option selected>Select City</option>
                                        <option value="1">USA</option>
                                        <option value="2">Canada</option>
                                        <option value="3">England</option>
                                    </select>
                                </div>
                            </div>


<!--                            <div class="col-md-12 padd-20">-->
<!--                                <div class="input-group">-->
<!--                                    <div class="radio-heading input-group-text">-->
<!--                                        Which degree do you want to pursue-->
<!--                                    </div>-->
<!--                                    <label class="container-radio">Graduation-->
<!--                                        <input type="radio" checked="checked" name="degree">-->
<!--                                        <span class="checkmark"></span>-->
<!--                                    </label>-->
<!--                                    <label class="container-radio">Post Graduation-->
<!--                                        <input type="radio" name="degree">-->
<!--                                        <span class="checkmark"></span>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
                            <?php
                                $EducationalLoan-> degree = [0];
                            ?>
                            <?=
                                $EducationalLoanForm->field($EducationalLoan, 'degree')->radiolist([
                                    0=> 'Graduation',
                                    1=> 'Post Graduation',
                                ],[
                                    'item' => function ($index, $label,$name, $checked, $value){
                                        $return = '<label for="degree-'. $index .'" class="container-radio">'. $label;
                                        $return .= '<input type="radio" id="degree-'. $index .'" name="'. $name .'" value="'.$value.'"'.(($checked) ? 'checked' : '').' />';
                                        $return .= '<span class="checkmark"></span>';
                                        $return .='</label>';
                                        return $return;
                                    }
                                ])
                            ?>
<!--                            <div class="col-md-12 padd-20">-->
<!--                                <div class="input-group">-->
<!--                                    <div class="radio-heading input-group-text">-->
<!--                                        Select a course-->
<!--                                    </div>-->
<!--                                    <ul>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="course" id="law" class="checkbox-input services"/>-->
<!--                                            <label for="law">Law</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="course" id="medicine"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="medicine">Medicine</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="course" id="management"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="management">Management</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="course" id="others"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="others">Others</label>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'course')->radioList([
                                0 => 'Law',
                                1 => 'Medicine',
                                2 => 'Management',
                                3 => 'Engineering',
                                4 => 'Diploma',
                                5 => 'Chartered Accountant',
                                6 => 'Computer Science',
                                7 => 'Others',
                            ],[
                                'item' => function($index, $label, $name, $checked, $value){
                                    $return = '<li class="service-list">';
                                    $return .= '<input type="radio" id="course-'. $index .'" name="'.$name.'" value="'.$value.'" class="checkbox-input services" />';
                                    $return .= '<label for="course-'. $index .'">'. $label ;
                                    $return .='</label></li>';
                                    return $return;
                                }
                            ])
                            ?>
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'number')->textinput([
                                'class' => 'custom-select',
                                'placeholder' => $EducationalLoan->getAttributeLabel('number')
                            ])->label('number');

                            ?>
                            <!--                                    <label for="number" class="input-group-text" >-->
                            <!--                                        Phone Number-->
                            <!--                                    </label>-->
                            <!--                                    <input type="text" class="custom-select" id="number" placeholder="Enter Phone Number">-->

                        </div>

                        <div class="tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="heading-style">Additional Details</h1>
                                </div>
                            </div>

                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'first_name')->textinput([
                                'class' => 'custom-select',
                                'placeholder' => $EducationalLoan->getAttributeLabel('first_name')
                            ]);
                            ?>
                            <!--                                    <label for="number" class="input-group-text">-->
                            <!--                                        Full Name-->
                            <!--                                    </label>-->
                            <!--                                    <input type="text" class="custom-select" id="number" placeholder="Enter Full Name">-->
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'last_name')->textinput([
                                'class' => 'custom-select',
                                'placeholder' => $EducationalLoan->getAttributeLabel('last_name')
                            ])
                            //                           ?>
                            <!--                            <div class="col-md-12 padd-20">-->
                            <!--                                <div class="input-group">-->
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'dob')->textinput([
                                'class' => 'custom-select',
                                'placeholder' => $EducationalLoan->getAttributeLabel('dob')
                            ])
                            ?>
                            <!--                                    <label for="number" class="input-group-text">-->
                            <!--                                        Date Of Birth-->
                            <!--                                    </label>-->
                            <!--                                    <input type="text" class="custom-select" id="number" placeholder="DD/MM/YYYY">-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'email')->textinput([
                                'class' => 'custom-select',
                                'placeholder' => $EducationalLoan->getAttributeLabel('email')
                            ])
                            ?>
                            <!--                            <div class="col-md-12 padd-20">-->
                            <!--                                <div class="input-group">-->
                            <!--                                    <label for="number" class="input-group-text">-->
                            <!--                                        Email Address-->
                            <!--                                    </label>-->
                            <!--                                    <input type="text" class="custom-select" id="number" placeholder="Enter Email Address">-->
                            <!--                                </div>-->
                            <!--                            </div>-->
<!--                            <div class="col-md-12 padd-20">-->
<!--                                <div class="input-group">-->
<!--                                    <label for="number" class="input-group-text">-->
<!--                                        Monthly Income-->
<!--                                    </label>-->
<!--                                    <input type="text" class="custom-select" id="number"-->
<!--                                           placeholder="Enter Monthly Income">-->
<!--                                </div>-->
<!--                            </div>-->
                            <?=
                                $EducationalLoanForm ->field($EducationalLoan , 'monthly_income')->textinput([
                                        'class' => 'custom-select',
                                        'placeholder' => $EducationalLoan->getAttributeLabel('monthly_income')
                                ])
                            ?>
<!--                            <div class="col-md-12 padd-20">-->
<!--                                <div class="input-group ">-->
<!--                                    <div class="radio-heading input-group-text">-->
<!--                                        Gender-->
<!--                                    </div>-->
<!--                                    <label class="container-radio">Male-->
<!--                                        <input type="radio" checked="checked" name="genderRadio">-->
<!--                                        <span class="checkmark"></span>-->
<!--                                    </label>-->
<!--                                    <label class="container-radio">Female-->
<!--                                        <input type="radio" name="genderRadio">-->
<!--                                        <span class="checkmark"></span>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
                            <?php $EducationalLoan->gender = [0]; ?>
                            <?=
                            $EducationalLoanForm->field($EducationalLoan,'gender')->radioList([
                                0=>'Male',
                                1=>'Female'
                            ],[
                                'item' => function($index, $label, $name, $checked, $value){
                                    $return ='<label for="gender-'. $index .'" class="container-radio">'. $label;
                                    $return .='<input type="radio" name="'. $name .'" id="gender-' . $index . '" value="'. $value .'"'. (($checked) ? 'checked' : '') . '/>';
                                    $return .= '<span class="checkmark"></span>';
                                    $return .= '</label>';
                                    return $return;
                                }

                            ])
                            ?>
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'co_borrower')->radioList([
                                0 => 'Father',
                                1 => 'Mother',
                                2 => 'Brother',
                                3 => 'Sister',
                                4 => 'Guardian',
                            ],[
                                'item' => function($index, $label, $name, $checked, $value){
                                    $return = '<li class="service-list">';
                                    $return .= '<input type="radio" id="co_borrower-'. $index .'" name="'.$name.'" value="'.$value.'" class="checkbox-input services" />';
                                    $return .= '<label for="co_borrower-'. $index .'">'. $label ;
                                    $return .='</label></li>';
                                    return $return;
                                }
                            ])
                            ?>
<!--                            <div class="col-md-12 padd-20">-->
<!--                                <div class="input-group">-->
<!--                                    <div class="radio-heading input-group-text">-->
<!--                                        Who would be your co-borrower?-->
<!--                                    </div>-->
<!--                                    <ul>-->

<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="name" id="father"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="father">Father</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="name" id="mother"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="mother">Mother</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="name" id="brother"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="brother">Brother</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="name" id="sister"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="sister">Sister</label>-->
<!--                                        </li>-->
<!--                                        <li class="service-list">-->
<!--                                            <input type="radio" name="name" id="guardian"-->
<!--                                                   class="checkbox-input services"/>-->
<!--                                            <label for="guardian">Guardian</label>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->

                            <!--                            <div class="col-md-12 padd-20">-->
                            <!--                                <div class="input-group">-->
                            <!--                                    <div class="radio-heading input-group-text">-->
                            <!--                                        Your Co-borrower's employment type ?-->
                            <!--                                    </div>-->
                            <!--                                    <label class="container-radio">Salaried-->
                            <!--                                        <input type="radio" checked="checked" name="borrowRadio">-->
                            <!--                                        <span class="checkmark"></span>-->
                            <!--                                    </label>-->
                            <!--                                    <label class="container-radio">Self-Employed-->
                            <!--                                        <input type="radio" name="borrowRadio">-->
                            <!--                                        <span class="checkmark"></span>-->
                            <!--                                    </label>-->
                            <!--                                    <label class="container-radio">Non-Working-->
                            <!--                                        <input type="radio" name="borrowRadio">-->
                            <!--                                        <span class="checkmark"></span>-->
                            <!--                                    </label>-->
                            <!--                                </div>-->
                            <!--                            </div>-->

                            <?php $EducationalLoan->co_borrower_emp = [0]; ?>
                            <?=
                            $EducationalLoanForm->field($EducationalLoan, 'co_borrower_emp')->radioList([
                                0 => 'Salaried',
                                1 => 'Self-Employed',
                                2 => 'Non-Working'
                            ], [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $return = '<label for="weekday-' . $index . '" class="container-radio">' . $label;
                                    $return .= '<input type="radio" name="' . $name . '" id="weekday-' . $index . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '/>';
                                    $return .= '<span class="checkmark"></span>';
                                    $return .= '</label>';
                                    return $return;
                                }
                            ])
                            ?>
                        </div>


                        <div class="input-group padd-20">
                            <div class="btn-center">
                                <button type="button" class="button-slide" id="prevBtn" onclick="nextPrev(-1)">
                                    Previous
                                </button>
                                <button type="button" class="button-slide" id="nextBtn" onclick="nextPrev(1)">Next
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
                <div class="max-300">
                    <div class="cl-heading">Get the Best Education Loan</div>
                    <div class="cl-text"> We tie up with the best providers in the country to help you plan your
                        education.
                        With offers that provide up to 100% of your required loan amount, planning for your education
                        is now more easier than ever.
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<?php
$this->registerCss('
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
    text-transform: capitalize;
}
.head-padding{
    padding-top:50px;
}
.padd-20{
    padding-top:30px;
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
 min-width: 120px;
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

JS;
$this->registerJs($script);
?>

<script>

    function matchHeight() {
        // var leftDiv =  document.getElementById('cl');
        var divHeight = document.getElementById('sd').offsetHeight;
        console.log(divHeight);
        document.getElementById('cl').style.height = (divHeight + "px");
        console.log(document.getElementById('cl').offsetHeight)
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

</script>