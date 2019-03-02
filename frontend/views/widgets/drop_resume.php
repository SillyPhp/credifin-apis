<?php
use yii\helpers\Url;
?>
    <div id="fab-message-open" class="fab-message" style="">
        <img src="<?= Url::to('@eyAssets/images/pages/company-profile/CVbox2.png') ?>">
        <div class="fab-hover-message" style="">
            <div class="fab-hover-image">
                <img src="<?= Url::to('@eyAssets/images/pages/company-profile/cv.png') ?>">
            </div>
        </div>
    </div>

    <div class="empty-field">
        <input type="hidden" id="loggedIn" value="<?= (!Yii::$app->user->isGuest) ? 'yes' : '' ?>">
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p>Please Login to your empower youth profile or Sign Up </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.fab-message{
    position:fixed;
    bottom: 20px;
    cursor:pointer;
    right:20px;
    z-index:9999;
    color: #fff;
    font-size: 20px;
    border-radius: 50%;
    width:100px;
    height:80px;
    line-height: 60px;
    text-align: center;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}
#fab-message-open:hover .fab-hover-message{
  -webkit-animation-name: example1; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
    -webkit-animation-iteration-count: infinite; /* Safari 4.0 - 8.0 */
    animation-name: example1;
    opacity:1;
    animation-duration: 2s;
    animation-iteration-count: 2;
}
@-webkit-keyframes example1 {
  0%   { right:6px; bottom:120px;}
  100%  { right:6px; bottom:55px;}
}
@keyframes example1{
  0%   {right:6px; bottom:120px;}
  100%  {right:6px; bottom:55px;}
}
.fab-hover-message{
    bottom: 120px;
    right: 6px;
    color:#222;
    opacity: 0; 
    position: absolute;
    font-size: 18px; 
    padding: 15px;
     border-radius: 3px;
     z-index:9; 
}
.fab-hover-image img{
    width:85px;
    height:85px;
}
.i-review-question-title{
    color:#fff;
}
.i-review-box{
    color:#fff;
}
');
$script = <<<JS
 var popup = new ideaboxPopup({
        background: '#234b8f',
        popupView: 'full',
        endPage: {
            msgTitle : 'Profile has been updated',
            msgDescription : 'Thanks for submitting your profile',
            showCloseBtn: true,
            closeBtnText : 'Close All',
            inAnimation: 'zoomIn'
        },
        data: [
           {
                    question 	: 'Select Job Profile',
                    answerType	: 'radio2',
                    //database field name
                    formName	: 'job_profile',
                    //values from database
                    choices		: [
                            { label : 'Information Technology', value : 'Information Technology' },
                            { label : 'Marketing', value : 'Marketing' },
                            { label : 'Green', value : 'GREEN' },
                            { label : 'Yellow', value : 'YELLOW' }
                    ],
                    description	: 'Please select your job profile',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select the choices.</b>'
            },
           {
                    question 	: 'Select Job Title',
                    answerType	: 'checkbox2',
                    formName	: 'job_title',
                    choices		: [
                            { label : 'Frontend Developer', value : 'Frontend Developer' },
                            { label : 'Backend Developer', value : 'Backend Developer' },
                            { label : 'Graphic Designer', value : 'Graphic Designer' },
                            { label : 'SEO', value : 'SEO' }
                    ],
                    description	: 'Please select job titles that you are interested in and press next button',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select between 1-2 choices.</b>'
            },
          {
                    question 	: 'Preffered Location',
                    answerType	: 'checkbox2',
                    formName	: 'locations',
                    choices		: [
                            { label : 'Ludhiana', value : 'Ludhiana' },
                            { label : 'Jalandhar', value : 'Jalandhar' },
                            { label : 'Chandigarh', value : 'Chandigarh' },
                            { label : 'Amritsar', value : 'Amritsar' },
                            { label : 'United States', value : 'USA' },
                            { label : 'England', value : 'EN' },
                            { label : 'Spain', value : 'ESP' },
                            { label : 'Turkey', value : 'TUR' },
                            { label : 'Argentina', value : 'ARG' },
                            { label : 'India', value : 'END' },
                            { label : 'Brazi', value : 'BRA' },
                            { label : 'French', value : 'FRA' },
                            { label : 'Germany', value : 'DEU' },
                            { label : 'Greece', value : 'GRC' },
                            { label : 'Hong Kong', value : 'HKG' },
                            { label : 'Italy', value : 'ITA' },
                            { label : 'South Korea', value : 'KOR' },
                            { label : 'United Kingdom', value : 'GBR' },
                            { label : 'Russia', value : 'RUS' }
                    ],
                    description	: 'Please select your preffered location and press next button',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
            },
            {
                question 	: 'Experience',
                answerType	: 'radio2',
                formName	: 'experience',
                choices		: [
                        { label : 'No Experince', value : 'No' },
                        { label : '<1 Year', value : '0' },
                        { label : '1 Year', value : '1' },
                        { label : '2-3 Years', value : '2-3' },
                        { label : '3-5 Years', value : '3-5' },
                        { label : '5-10 Years', value : '5-10' }, 
                        { label : '10+ Years', value : '10+' },
                ],
                description	: 'How much experience do you have?',
                nextLabel : 'Apply Now',
                required	: true,
                errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
            
             },
            {
                question: '<h2 style="color: #fff; font-weight: 900;">You have applied with your empower youth profile </h2>',
                answerType: 'updatebtn',
                formName : 'is_applied',
                 choices		: [
                     {label: 'http://www.eygb.me/user/ajay'}
                 ],
                description: '',
                nextLabel : 'Finish',
            },
        ]
    });
    
    document.getElementById("fab-message-open").addEventListener("click", function (e) {
        if($('#loggedIn').val())
            popup.open();
        else
            $('#myModal').modal('toggle');
    });
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_add_resume.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');