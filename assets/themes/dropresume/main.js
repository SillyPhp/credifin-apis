var hostname = window.location.hostname;
var user_profile = 'https://' + hostname + "/" + result["username"];
var popup = new ideaboxPopup({
    background: '#234b8f',
    popupView: 'full',
    endPage: {
        msgTitle: 'You can Update Your Profile.',
        msgDescription: '<a href=' + user_profile + ' class="up-btn">Update Profile',
        showCloseBtn: true,
        closeBtnText: 'Close All',
        inAnimation: 'zoomIn'
    },
    onFinish: function () {
        this.values['org_id'] = org_id;
        this.values['is_claim'] = is_claim;
        if (this.values["experience"]) {
            $.ajax({
                type: 'POST',
                async: false,
                url: '/account/resume/candidate-application',
                data: this.values,
                success: function (response) {
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
            question: 'Select Type:',
            answerType: 'radio2',
            formName: 'application_type',
            choices: [
                {label: 'Jobs', value: 'Jobs'},
                {label: 'Internships', value: 'Internships'},
            ],
            description: 'Please select what you want to apply for',
            required: true,
            errorMsg: '<b style="color:#900;">Select the choices</b>'
        },
        {
            question: 'Relevant Experience',
            answerType: 'radio',
            formName: 'experience',
            choices: [
                {label: 'No Experince', value: '0'},
                {label: '<1 Year', value: '1'},
                {label: '1 Year', value: '2'},
                {label: '2-3 Years', value: '3'},
                {label: '3-5 Years', value: '4'},
                {label: '5-10 Years', value: '5'},
                {label: '10-20 Years', value: '6'},
                {label: '20+ Years', value: '7'},
            ],
            description: 'How much experience do you have?',
            nextLabel: 'Apply Now',
            required: true,
            errorMsg: '<b style="color:#900;">Select your experience.</b>'

        },

    ]
});

document.getElementById("fab-message-open").addEventListener("click", function (e) {
    if ($('#loggedIn').val() == '') {
        $('#loginModal').modal('show');
    } else if ($('#org').val() == '') {
        $('#myModal').modal('toggle');
    } else if ($('#dropcv').val() == 'no') {
        $('#existsModal').modal('toggle');
    } else {
        popup.open();
    }
});