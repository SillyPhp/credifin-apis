
<style>
input, textarea, .select, .option-label, .checkbox-label {
  border:1px solid #ddd !important;
}

.form .label, .form .checkbox-input + label, .form .option-input + label, .form .text-input, .form .textarea, .form .select, .customSelect, .form .message, .form .button {
  padding: 0.75em 1em;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  outline: none;
  line-height: normal;
  border-radius: 0;
  border: none;
  background: none;
  display: block;
}

.form .label {
  font-weight: bold;
  color: #000;
  padding-top: 0;
  padding-left: 0;
  letter-spacing: 0.025em;
  font-size: 17px;
  line-height: 1.25;
  position: relative;
  z-index: 100;
  text-align:left;
}
.required .form .label:after, .form .required .label:after {
  content: " *";
  color: #E8474C;
  font-weight: normal;
  font-size: 0.75em;
  vertical-align: top;
}

.form .checkbox-input + label, .form .option-input + label, .form .text-input, .form .textarea, .form .select, .customSelect {
  font: inherit;
  line-height: normal;
  width: 100%;
  box-sizing: border-box;
  background: #fff;
  color: #000;
  position: relative;
}
.form .checkbox-input + label:placeholder, .form .option-input + label:placeholder, .form .text-input:placeholder, .form .textarea:placeholder, .form .select:placeholder, .customSelect:placeholder {
  color: #000;
}
.form .checkbox-input + label:-webkit-autofill, .form .option-input + label:-webkit-autofill, .form .text-input:-webkit-autofill, .form .textarea:-webkit-autofill, .form .select:-webkit-autofill, .customSelect:-webkit-autofill {
  box-shadow: 0 0 0px 1000px #111111 inset;
  -webkit-text-fill-color: #000;
  border-top-color: #111111;
  border-left-color: #111111;
  border-right-color: #111111;
}
.form .checkbox-input + label:not(:focus):not(:active).error, .form .option-input + label:not(:focus):not(:active).error, .form .text-input:not(:focus):not(:active).error, .form .textarea:not(:focus):not(:active).error, .form .select:not(:focus):not(:active).error, .customSelect:not(:focus):not(:active).error, .error .form .checkbox-input + label:not(:focus):not(:active), .form .error .checkbox-input + label:not(:focus):not(:active), .error .form .option-input + label:not(:focus):not(:active), .form .error .option-input + label:not(:focus):not(:active), .error .form .text-input:not(:focus):not(:active), .form .error .text-input:not(:focus):not(:active), .error .form .textarea:not(:focus):not(:active), .form .error .textarea:not(:focus):not(:active), .error .form .select:not(:focus):not(:active), .form .error .select:not(:focus):not(:active), .error .customSelect:not(:focus):not(:active) {
  background-size: 8px 8px;
}
.form:not(.has-magic-focus) .checkbox-input + label:active, .form:not(.has-magic-focus) .option-input + label:active, .form:not(.has-magic-focus) .text-input:active, .form:not(.has-magic-focus) .textarea:active, .form:not(.has-magic-focus) .select:active, .form:not(.has-magic-focus) .customSelect:active, .form:not(.has-magic-focus) .customSelect.customSelectFocus, .form:not(.has-magic-focus) .checkbox-input + label:focus, .form:not(.has-magic-focus) .option-input + label:focus, .form:not(.has-magic-focus) .text-input:focus, .form:not(.has-magic-focus) .textarea:focus, .form:not(.has-magic-focus) .select:focus, .form:not(.has-magic-focus) .customSelect:focus {
  background: #4E4E4E;
}

.form .message {
  position: absolute;
  bottom: 0;
  right: 0;
  z-index: 100;
  font-size: 0.625em;
  color: #000;
}

.form .checkbox-input, .form .option-input {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
}
.form .checkbox-input + label, .form .option-input + label {
  display: inline-block;
  width: auto;
  color: #000;
  position: relative;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  cursor: pointer;
}
.form .checkbox-input:focus + label, .form .option-input:focus + label, .form .checkbox-input:active + label, .form .option-input:active + label {
  color: #000;
}
.form .checkbox-input:checked + label, .form .option-input:checked + label {
  color: green;
}

.form .button {
  font: inherit;
  line-height: normal;
  cursor: pointer;
  background: #E8474C;
  color: white;
  font-weight: bold;
  width: auto;
  margin-left: auto;
  font-weight: bold;
  padding-left: 2em;
  padding-right: 2em;
}
.form .button:hover, .form .button:focus, .form .button:active {
  color: white;
  border-color: white;
}
.form .button:active {
  position: relative;
  top: 1px;
  left: 1px;
}

body {
  padding: 2em;
}

.form {
  max-width: 40em;
  margin: 0 auto;
  position: relative;
  display: flex;
  flex-flow: row wrap;
  justify-content: space-between;
  align-items: flex-end;
}
.form .field {
  width: 100%;
  margin: 0 0 1.5em 0;
}
@media screen and (min-width: 40em) {
  .form .field.half {
    width: calc(50% - 1px);
  }
}
.form .field.last {
  margin-left: auto;
}
.form .textarea {
  max-width: 100%;
}
.form .select {
  text-indent: 0.01px;
  text-overflow: "" !important;
}
.form .select::-ms-expand {
  display: none;
}
.form .checkboxes, .form .options {
  padding: 0;
  margin: 0;
  list-style-type: none;
  overflow: hidden;
}
.form .checkbox, .form .option {
  float: left;
  margin: 1px;
}

.customSelect {
  pointer-events: none;
}
.customSelect:after {
  content: "";
  pointer-events: none;
  width: 0.5em;
  height: 0.5em;
  border-style: solid;
  border-color: white;
  border-width: 0 3px 3px 0;
  position: absolute;
  top: 50%;
  margin-top: -0.625em;
  right: 1em;
  -webkit-transform-origin: 0 0;
          transform-origin: 0 0;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
}
.customSelect.customSelectFocus:after {
  border-color: white;
}

.magic-focus {
  position: absolute;
  z-index: 0;
  width: 0;
  pointer-events: none;
  background: rgba(0, 0, 0, 0.2);
  transition: top 0.2s, left 0.2s, width 0.2s;
  -webkit-backface-visibility: hidden;
          backface-visibility: hidden;
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  will-change: top, left, width;
  -webkit-transform-origin: 0 0;
          transform-origin: 0 0;
}

</style>
<form action='' class='form'>
  <p class='field required'>
    <label class='label required' for='name'>Full name</label>
    <input class='text-input' id='name' name='name' required type='text' placeholder="Name">
  </p>
  <p class='field required half'>
    <label class='label' for='email'>E-mail</label>
    <input class='text-input' id='email' name='email' required type='email'>
  </p>
  <p class='field half'>
    <label class='label' for='phone'>Phone</label>
    <input class='text-input' id='phone' name='phone' type='phone'>
  </p>
  <p class='field half required error'>
    <label class='label' for='login'>Login</label>
    <input class='text-input' id='login' name='login' required type='text'>
  </p>
  <p class='field half required'>
    <label class='label' for='password'>Password</label>
    <input class='text-input' id='password' name='password' required type='password'>
  </p>
  <div class='field'>
    <label class='label'>Checkbox</label>
    <ul class='checkboxes'>
      <li class='checkbox'>
        <input class='checkbox-input' id='choice-10' name='choice' type='checkbox' value='0'>
        <label class='checkbox-label' for='choice-10'>Football</label>
      </li>
      <li class='checkbox'>
        <input class='checkbox-input' id='choice-11' name='choice' type='checkbox' value='1'>
        <label class='checkbox-label' for='choice-11'>Basketball</label>
      </li>
      <li class='checkbox'>
        <input class='checkbox-input' id='choice-12' name='choice' type='checkbox' value='2'>
        <label class='checkbox-label' for='choice-12'>Volleyball</label>
      </li>
      <li class='checkbox'>
        <input class='checkbox-input' id='choice-13' name='choice' type='checkbox' value='3'>
        <label class='checkbox-label' for='choice-13'>Golf</label>
      </li>
    </ul>
  </div>
  <div class='field'>
    <label class='label'>Radiooo</label>
    <ul class='options'>
      <li class='option'>
        <input class='option-input' id='option-0' name='option' type='radio' value='0'>
        <label class='option-label' for='option-0'>React</label>
      </li>
      <li class='option'>
        <input class='option-input' id='option-1' name='option' type='radio' value='1'>
        <label class='option-label' for='option-1'>Vue</label>
      </li>
      <li class='option'>
        <input class='option-input' id='option-2' name='option' type='radio' value='2'>
        <label class='option-label' for='option-2'>Angular</label>
      </li>
      <li class='option'>
        <input class='option-input' id='option-3' name='option' type='radio' value='3'>
        <label class='option-label' for='option-3'>Riot</label>
      </li>
      <li class='option'>
        <input class='option-input' id='option-4' name='option' type='radio' value='4'>
        <label class='option-label' for='option-4'>Polymer</label>
      </li>
    </ul>
  </div>
  <p class='field'>
    <label class='label' for='about'>About</label>
    <textarea class='textarea' cols='50' id='about' name='about' rows='4'></textarea>
  </p>
  <p class='field half'>
    <label class='label' for='select'>Position</label>
    <select class='select' id='select'>
      <option selected value=''></option>
      <option value='ceo'>CEO</option>
      <option value='front-end'>Front-end developer</option>
      <option value='back-end'>Back-end developer</option>
    </select>
  </p>
  <p class='field half'>
    <input class='button' type='submit' value='Send'>
  </p>
</form>
<?php

$script = <<<JS

JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/view-questionnaire.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.customSelect/0.5.1/jquery.customSelect.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
