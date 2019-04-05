//
//  var jobProfile = JSON.parse(result['job_profile']);
//  var jobprofileresult = [];
//  Object.entries(jobProfile).forEach(([key, value]) => {
//     jobprofileresult.push({'label': key, 'value':value})
//  });
//
// var jobTitle = JSON.parse(result['job_title']);
// var jobtitleesult = [];
// Object.entries(jobTitle).forEach(([key, value]) => {
//     jobtitleesult.push({'label': key, 'value':value})
// });
//
// var joblocation = JSON.parse(result['location']);
// var joblocationresult = [];
// Object.entries(joblocation).forEach(([key, value]) => {
//     joblocationresult.push({'label': key, 'value':value})
// });
var hostname = window.location.hostname;
var user_profile = 'https://' + hostname + "/user/" + result["username"];
var popup = new ideaboxPopup({
    background: '#234b8f',
    popupView: 'full',
    endPage: {
        msgTitle : 'You can Update Your Profile.',
        msgDescription : '<a href='+user_profile+' class="up-btn">Update Profile',
        showCloseBtn: true,
        closeBtnText : 'Close All',
        inAnimation: 'zoomIn'
    },
    onFinish : function(){
        if(this.values["experience"]) {
            $.ajax({
                type: 'POST',
                async: false,
                url: '/account/resume/candidate-application',
                data: this.values,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.message == 200) {
                        toastr.success('Your Application has been forwarded to company', 'You have successfully applied');
                    } else {
                        toastr.error('System Error', 'Failed in Applying');

                    }
                }
            });
        }
    },
    data: [
        {
          question : 'Select Type:',
          answerType: 'radio2',
          formName : 'application_type',
          choices: [
              {label: 'Jobs', value: 'Jobs'},
              {label: 'Internships', value: 'Internships'},
          ],
          description: 'Please select what you want to apply for',
          required: true,
          errorMsg : '<b style="color:#900;">Select the choices</b>'
        },
        {
            question 	: 'Relevant Experience',
            answerType	: 'radio',
            formName	: 'experience',
            choices		: [
                { label : 'No Experince', value : 'no' },
                { label : '<1 Year', value : 'less than one' },
                { label : '1 Year', value : 'one' },
                { label : '2-3 Years', value : 'two to three' },
                { label : '3-5 Years', value : 'three to five' },
                { label : '5-10 Years', value : 'five to ten' },
                { label : '10-20 Years', value : 'ten to twenty' },
                { label : '20+ Years', value : 'twenty above' },
            ],
            description	: 'How much experience do you have?',
            nextLabel : 'Apply Now',
            required	: true,
            errorMsg	: '<b style="color:#900;">Select your experience.</b>'

        },

    ]
});

document.getElementById("fab-message-open").addEventListener("click", function (e) {
    if($('#dropcv').val() == 'no'){
        $('#existsModal').modal('toggle');
    }else if($('#loggedIn').val())
        popup.open();
    else
        $('#myModal').modal('toggle');
});