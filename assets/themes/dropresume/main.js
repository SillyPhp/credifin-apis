console.log(result);

 var jobProfile = JSON.parse(result['job_profile']);
 var jobprofileresult = [];
 Object.entries(jobProfile).forEach(([key, value]) => {
    jobprofileresult.push({'label': key, 'value':value})
 });

var jobTitle = JSON.parse(result['job_title']);
var jobtitleesult = [];
Object.entries(jobTitle).forEach(([key, value]) => {
    jobtitleesult.push({'label': key, 'value':value})
});

var joblocation = JSON.parse(result['location']);
var joblocationresult = [];
Object.entries(joblocation).forEach(([key, value]) => {
    joblocationresult.push({'label': key, 'value':value})
});

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
            choices		: jobprofileresult,
            description	: 'Please select your job profile',
            required	: true,
            errorMsg	: '<b style="color:#900;">Select the choices.</b>'
        },
        {
            question 	: 'Select Job Title',
            answerType	: 'checkbox2',
            formName	: 'job_title',
            choices		: jobtitleesult,
            description	: 'Please select job titles that you are interested in and press next button',
            required	: true,
            errorMsg	: '<b style="color:#900;">Select between 1-2 choices.</b>'
        },
        {
            question 	: 'Preffered Location',
            answerType	: 'checkbox2',
            formName	: 'locations',
            choices		: joblocationresult,
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