<?php
?>
<div class="row">
    <div class="col-md-12">
        <div class="ques-box">
            <div class="ques">Is Trustpilot a competitior of Reviews Is Trustpilot a competitior of Reviews </div>
            <div class="ans-options">
                <li class="service-list">
                    <input type="checkbox" name="name" id="service" class="checkbox-input services" />
                    <label for="service">Jobs</label>
                    <input type="checkbox" name="name" id="service" class="checkbox-input services" />
                    <label for="service">Internships</label>
                    <input type="checkbox" name="name" id="service" class="checkbox-input services" />
                    <label for="service">Learning</label>
                    <input type="checkbox" name="name" id="service" class="checkbox-input services" />
                    <label for="service">Training</label>
                </li>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.ques-box{
    margin-top:20px;
    box-shadow: 0px 1px 10px 2px #eee !important;
    padding:10px;
    text-align:center;
    background:#00a0e3;
}
.ans-options{
    margin-top: 15px;
}
.ques{
    text-align:center;
    font-size:20px;
    font-family:roboto;
//    font-weight:bold;
    color:#fff
}
.service-list{
 display: inline-block;
}
.service-list label{
   display: inline-block;
   background-color: rgba(255, 255, 255, 1);
//   border: 2px solid rgba(139, 139, 139, .3);
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
   
   width:45%;
   margin:5px;
   float:left;
   text-align:center;
   padding: 8px 12px;
   cursor: pointer;
}
.service-list label::before {
   display: inline-block;
   font-style: normal;
   font-variant: normal;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   font-family: \'Font Awesome 5 Free\';
   font-weight: 900;
   font-size: 12px;
   padding: 2px 6px 2px 2px;
   content: \'067\';
   transition: transform .3s ease-in-out;
}
.service-list input[type=\'checkbox\']:checked + label::before {
   content: \'00c\';
   transform: rotate(-360deg);
   transition: transform .3s ease-in-out;
}
.service-list input[type=\'checkbox\']:checked + label, .service-list label:hover {
//   border: 2px solid #00a0e3;
//   background-color: #00a0e3;
   color: #00a0e3;
   transition: all .2s;
}
.service-list input[type=\'checkbox\'] {
 display: absolute;
}
.service-list input[type=\'checkbox\'] {
 position: absolute;
 opacity: 0;
}
.service-list input[type=\'checkbox\']:focus + label {
// border: 2px solid #00a0e3;
}
')
?>
