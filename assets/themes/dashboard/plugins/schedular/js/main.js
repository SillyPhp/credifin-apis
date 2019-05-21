(function($) {

    var form = $("#signup-form");
    // form.steps({
    //     headerTag: "h3",
    //     bodyTag: "fieldset",
    //     transitionEffect: "slideLeft",
    //     labels: {
    //         previous : 'Previous',
    //         next : 'Next <i class="zmdi zmdi-long-arrow-down"></i>',
    //         finish : 'Submit',
    //         current : ''
    //     },
    //     titleTemplate : '<span class="title">#title#</span>',
    //     onInit : function (event, currentIndex) { 
    //         // Suppress (skip) "Warning" step if the user is old enough.
    //     },
    //     onStepChanging: function (event, currentIndex, newIndex)
    //     {
    //         form.validate().settings.ignore = ":disabled,:hidden";
    //         return form.valid();
    //     },
    //     onFinishing: function (event, currentIndex)
    //     {
    //         form.validate().settings.ignore = ":disabled";
    //         return form.valid();
    //     },
    //     onFinished: function (event, currentIndex)
    //     {
    //         alert('Sumited');
    //     },
    //     onStepChanged: function (event, currentIndex, priorIndex)
    //     {

         
    //     }
    // });

    

    // $('.panel-group .panel-default').on('click', function() {
    //     $('.panel-group').find('.active').removeClass("active");
    //     $(this).addClass("active");
    // });
    $('.panel').on('show.bs.collapse', function (e) {
        $(this).addClass('active');
    })
    $('.panel').on('hide.bs.collapse', function (e) {
        $(this).removeClass('active');
    })
    // jQuery(this).toggleClass('isOpen');

    jQuery.extend(jQuery.validator.messages, {
        required: "",
        remote: "",
        email: "",
        url: "",
        date: "",
        dateISO: "",
        number: "",
        digits: "",
        creditcard: "",
        equalTo: ""
    });

function load_script(){
    $(".acc-wizard").accwizard({
        addButtons  : true,
        nextText : 'Next',
        nextClasses : 'au-btn',
        backClasses : 'au-btn au-btn-back'
    });
    $('#rounds').parent().append('<ul id="newrounds" class="select-list" name="rounds"></ul>');
    $('#rounds option').each(function(){
        var background = $(this).data('url');
        $('#newrounds').append('<li value="' + $(this).val() + '"><img src="'+ background +'" alt="">'+$(this).text()+'</li>');
    });
    $('#rounds').remove();
    $('#newrounds').attr('id', 'rounds');
    $('#rounds li').first().addClass('init');
    $("#rounds").on("click", ".init", function() {
        $(this).closest("#rounds").children('li:not(.init)').toggle();
    });
    
    var allOptions = $("#rounds").children('li:not(.init)');
    $("#rounds").on("click", "li:not(.init)", function() {
        allOptions.removeClass('selected');
        $(this).addClass('selected');
        $("#rounds").children('.init').html($(this).html());
        allOptions.toggle();
    });

    $('#location').parent().append('<ul id="newlocation" class="select-list" name="location"></ul>');
    $('#location option').each(function(){
        var background = $(this).data('url');
        $('#newlocation').append('<li value="' + $(this).val() + '"><img src="'+ background +'" alt="">'+$(this).text()+'</li>');
    });
    $('#location').remove();
    $('#newlocation').attr('id', 'location');
    $('#location li').first().addClass('init');
    $("#location").on("click", ".init", function() {
        $(this).closest("#location").children('li:not(.init)').toggle();
    });
    
    var allOptions2 = $("#location").children('li:not(.init)');
    $("#location").on("click", "li:not(.init)", function() {
        allOptions2.removeClass('selected');
        $(this).addClass('selected');
        $("#location").children('.init').html($(this).html());
        allOptions2.toggle();
    });

    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        multidate: true,
        startDate: '-0m'
    });

    $('.test-multi').dropdown({
        // useLabels: false,
        maxSelections: 3,
        placeholder: 'any'
    });
}

    // $('#locations').parent().append('<ul id="newlocations" class="select-list" name="locations"></ul>');
    // $('#locations option').each(function(){
    //     var background = $(this).data('url');
    //     $('#newlocations').append('<li value="' + $(this).val() + '"><img src="'+ background +'" alt="">'+$(this).text()+'</li>');
    // });
    // $('#locations').remove();
    // $('#newlocations').attr('id', 'locations');
    // $('#locations li').first().addClass('init');
    // $("#locations").on("click", ".init", function() {
    //     $(this).closest("#locations").children('li:not(.init)').toggle();
    // });
    
    // var allOptions3 = $("#locations").children('li:not(.init)');
    // $("#locations").on("click", "li:not(.init)", function() {
    //     allOptions2.removeClass('selected');
    //     $(this).addClass('selected');
    //     $("#locations").children('.init').html($(this).html());
    //     allOptions3.toggle();
    // });

    

    $(document).on('focus', '.timepicker-24', function(){
        $(this).timepicker();
    });

    $(document).on('change', '#all-dates', function(){
        check_all_dates();
    });

    function check_all_dates(){
        var check = $('#all-dates');
        if(check.is(":not(:checked)")){
            var date_picker_value = $('#datepicker').val();
            if(date_picker_value != ''){
                addTimes();
            }
            else{
                alert('Interview dates is empty');
                check.prop('checked', true);
                return false;
            }
        } else{
            $('#selected-dates').html("");
        }
    }

    function convert(str) {
        var mnths = {
                Jan: "01",
                Feb: "02",
                Mar: "03",
                Apr: "04",
                May: "05",
                Jun: "06",
                Jul: "07",
                Aug: "08",
                Sep: "09",
                Oct: "10",
                Nov: "11",
                Dec: "12"
            },
            date = str.split(" ");
    
        return [date[2], mnths[date[1]], date[3]].join("-");
    }
        
    var dates = [];
    var dates_count;
    function addTimes() {
        dates = [];
        //        var time_intervals = [];
        var the_date = $('.date-picker').datepicker('getDates');
        for (var j = 0; j < the_date.length; j++) {
            var s_date = convert(the_date[j].toString());
            dates.push({
                date: s_date
            });
        }
        dates_count = dates.length;
        var time_slots = $('#dates').html();
        var noRows = Math.ceil(dates_count / 2);
        var j = 0;
        for(var i = 0; i < noRows; i++){
            $('#selected-dates').append('<div class="row">' + Mustache.render(time_slots, dates.slice(j, j+2))+ '</div>');
            // $(this).closest('div').prev('#times-container').append('<div class="row">' + Mustache.render(time_slots)+ '</div>');
            j+=2;
        }
        //        var time_l = $('.time-slots').length;
        //        for(var i = 1; i<= time_l; i++){
        //            time_intervals.push({'start' : $('#start-time-'+i).val(), 'end': $('#end-time-'+i).val()});
        //        }
    }

    $(document).on('click', '#add-more', function(e){
        e.preventDefault();
       $(this).closest('div').prev('#times-container').append(Mustache.render($('#add-more-d').html()));
    });

    $(document).on('click', '.remove-add', function(){
        $(this).closest('#added-date').remove();
    });

    $(document).on('click', '#add-more-interviewers', function(e){
        e.preventDefault();
       $('#more-interviewers').append(Mustache.render($('#add-more-interviewers-detail').html()));
    });

    $(document).on('click', '.remove-added-interviewers', function(){
        $(this).closest('.added-interviewers').remove();
    });

    $('input[name= "mode"]').on('change',function(){
        var sl_type = $(this).attr("value");
        if(sl_type=='1'){
            $('#interview_locations').show();
        } else if(sl_type=='2'){
            $('#interview_locations').hide();
        }
    });

    $(document).on('change', 'input[name= "interview_type"]',function(){
        $('.choice').removeClass('active');
        $(this).parent('.choice').addClass('active');
        var interview_type = $(this).attr("value");
        if(interview_type=='fixed'){
            $('#description').html(Mustache.render($('#fixed_tab').html()));
            load_script();
            // $('#fixed_tab').show();
            // $('#flexible_tab').hide();
        } else if(interview_type=='flexible'){
            $('#description').html(Mustache.render($('#flexible_tab').html()));
            load_script();
            // $('#flexible_tab').show();
            // $('#fixed_tab').hide();
        }
    });

})(jQuery);