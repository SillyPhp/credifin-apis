/*!

 =========================================================
 * Material Bootstrap Wizard - v1.0.2
 =========================================================
 
 * Product Page: https://www.creative-tim.com/product/material-bootstrap-wizard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/material-bootstrap-wizard/blob/master/LICENSE.md)
 
 =========================================================
 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

// Material Bootstrap Wizard Functions

var searchVisible = 0;
var transparent = true;
var mobile_device = false;

$(document).ready(function(){

    $.material.init();

    /*  Activate the tooltips      */
    $('[rel="tooltip"]').tooltip();

    // Code for the Validator
    var $validator = $('.wizard-card form').validate({
		  rules: {
		    firstname: {
		      required: true,
		      minlength: 3
		    },
		    lastname: {
		      required: true,
		      minlength: 3
		    },
		    email: {
		      required: true,
		      minlength: 3,
		    }
        },

        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
         }
	});

    // Wizard Initialization
  	$('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next, .icon',
        'previousSelector': '.btn-previous',

        onNext: function(tab, navigation, index) {
            if(index == 2){
                if (!$('#selected_application_id').val()) {
                    if($('#select-application-sch').find('.error-msg').length == 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#select-application-sch').append(output);
                    }
                    return false;
                }
                if (!$('#selected_round_id').val()) {
                    if ($('#select-app-round').find('.error-msg').length == 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#select-app-round').append(output);
                    }
                    return false;
                }
                if ($('.test-multi input[type=hidden]').val() == '') {
                    if($('#select-application-process').find('.error-msg').length == 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#select-application-process').append(output);
                    }
                    return false;
                }
                if(!validate_data()){
                    return false;
                }
                if ($('#datepicker').val() == "") {
                    if ($('#datepicker').parent().children('.error-msg').length == 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#datepicker').parent().append(output);
                    }
                    return false;
                }
                if ($('#main_time_from input').val() == "") {
                    if ($('#main_time_from').children('.error-msg').length == 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#main_time_from').append(output);
                    }
                    return false;
                }
                if ($('#main_time_to input').val() == "") {
                    if ($('#main_time_to').children('.error-msg').length == 0) {
                        var html = $('#error-msg').html();
                        var data = {
                            msg: "This field can't be empty"
                        };
                        var output = Mustache.render(html, data);
                        $('#main_time_to').append(output);
                    }
                    return false;
                }
                var time_from_m = true;
                var time_to_m = true;
                $('.secondary-time-from input').each(function () {
                    if ($(this).val() == "") {
                        if ($(this).parent().children('.error-msg').length == 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $(this).parent().append(output);
                        }
                        time_from_m = false;
                        return false;
                    }
                });
                $('.secondary-time-to input').each(function () {
                    if ($(this).val() == "") {
                        if ($(this).parent().children('.error-msg').length == 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $(this).parent().append(output);
                        }
                        time_to_m = false;
                        return false;
                    }
                });
                if(time_from_m == false || time_to_m == false){
                    return false;
                }
                if($('#specialities-subdata').find('#interview_locations').length > 0) {
                    if (!$('select#interview-location').children("option:selected").val()) {
                        if ($('#interview_locations').find('.error-msg').length == 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $('#interview_locations').append(output);
                        }
                        return false;
                    }
                }
                if($('#specialities-data').find('#number_candidate_cont').length > 0) {
                    if (!$('#candidates').val()) {
                        if ($('#no_cand_cont').find('.error-msg').length == 0) {
                            var html = $('#error-msg').html();
                            var data = {
                                msg: "This field can't be empty"
                            };
                            var output = Mustache.render(html, data);
                            $('#no_cand_cont').append(output);
                        }
                        return false;
                    }
                }
            }
        	var $valid = $('.wizard-card form').valid();
        	if(!$valid) {
        		$validator.focusInvalid();
        		return false;
        	}
        },

        onInit : function(tab, navigation, index){
            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            var $wizard = navigation.closest('.wizard-card');

            $first_li = navigation.find('li:first-child a').html();
            $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
            $('.wizard-card .wizard-navigation').append($moving_div);

            refreshAnimation($wizard, index);

            $('.moving-tab').css('transition','transform 0s');
       },

        onTabClick : function(tab, navigation, index){
            var $valid = $('.wizard-card form').valid();

            if(!$valid){
                return false;
            } else{
                return true;
            }
        },

        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;

            var $wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $($wizard).find('.btn-next').hide();
                $($wizard).find('.btn-finish').show();
            } else {
                $($wizard).find('.btn-next').show();
                $($wizard).find('.btn-finish').hide();
            }

            button_text = navigation.find('li:nth-child(' + $current + ') a').html();

            setTimeout(function(){
                $('.moving-tab').text(button_text);
            }, 150);

            var checkbox = $('.footer-checkbox');

            if( !index == 0 ){
                $(checkbox).css({
                    'opacity':'0',
                    'visibility':'hidden',
                    'position':'absolute'
                });
            } else {
                $(checkbox).css({
                    'opacity':'1',
                    'visibility':'visible'
                });
            }

            refreshAnimation($wizard, index);
        }
  	});


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function(){
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked','true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function(){
        if( $(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked','true');
        }
    });

    $('.set-full-height').css('height', 'auto');

});



 //Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(window).resize(function(){
    $('.wizard-card').each(function(){
        $wizard = $(this);

        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
            'transition': 'transform 0s'
        });
    });
});

function refreshAnimation($wizard, index){
    $total = $wizard.find('.nav li').length;
    $li_width = 100/$total;

    total_steps = $wizard.find('.nav li').length;
    move_distance = $wizard.width() / total_steps;
    index_temp = index;
    vertical_level = 0;

    mobile_device = $(document).width() < 600 && $total > 3;

    if(mobile_device){
        move_distance = $wizard.width() / 2;
        index_temp = index % 2;
        $li_width = 50;
    }

    $wizard.find('.nav li').css('width',$li_width + '%');

    step_width = move_distance;
    move_distance = move_distance * index_temp;

    $current = index + 1;

    if($current == 1 || (mobile_device == true && (index % 2 == 0) )){
        move_distance -= 8;
    } else if($current == total_steps || (mobile_device == true && (index % 2 == 1))){
        move_distance += 8;
    }

    if(mobile_device){
        vertical_level = parseInt(index / 2);
        vertical_level = vertical_level * 38;
    }

    $wizard.find('.moving-tab').css('width', step_width);
    $('.moving-tab').css({
        'transform':'translate3d(' + move_distance + 'px, ' + vertical_level +  'px, 0)',
        'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

    });
}

materialDesign = {

    checkScrollForTransparentNavbar: debounce(function() {
                if($(document).scrollTop() > 260 ) {
                    if(transparent) {
                        transparent = false;
                        $('.navbar-color-on-scroll').removeClass('navbar-transparent');
                    }
                } else {
                    if( !transparent ) {
                        transparent = true;
                        $('.navbar-color-on-scroll').addClass('navbar-transparent');
                    }
                }
        }, 17)

}

function validate_data() {
    if($('#min').val() == ''){
        $('.min-error').text('This field is required.');
        return false;
    }

    if($('#candidates').val() == ''){
        $('.candidate-error').text('This field is required.');
        return false;
    }

    if($('#room').val() == ''){
        $('.room-error').text('This field is required.');
        return false;
    }

    return true;
}

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};
