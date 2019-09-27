<form id="job_for_colleges">
    <div class="form-group select-app-for">
        <h4>Choose application for</h4>
        <input type="radio" name="college" id="all" value="1"/>
        <label for="all">All Colleges</label>
        <input type="radio" name="college" id="c-select" value="0"/>
        <label for="c-select">Choose Colleges</label>
    </div>
    <div class="college-list hidden">
        <input type="hidden" name="app_id" id="app_id"/>
        <?php
        foreach ($colleges as $clg) {
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="checkbox" class="college-list" name="colleges[]" id="<?= $clg['college_enc_id'] ?>"
                           value="<?= $clg['college_enc_id'] ?>"/>
                    <label for="<?= $clg['college_enc_id'] ?>"><?= $clg['name'] ?></label>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-md-12 text-center">
        <p class="colleges-error"></p>
    </div>
    <div class='m-actions col-md-12'>
        <button type='button' class="btn-default close-m-mo2">Skip</button>
        <button type='submit' id="submit-cl">Submit</button>
    </div>
</form>
<?php
$script = <<< JS
$('#app_id').val($('#app_id_main').val());
var doc_type3 = $('.m-modal').attr('data-key');
if (doc_type3=='Jobs'||doc_type3=='Clone_Jobs'||doc_type3=='Edit_Jobs') {
    var redirect_url3 = '/account/jobs/dashboard';
} else if(doc_type3=="Internships"||doc_type3=='Clone_Internships'||doc_type3=='Edit_Internships') {
    var redirect_url3 = '/account/internships/dashboard';
}
$(".close-m-mo2").on("click", function() {
    $('.m-modal2').attr('class', 'm-modal2');
    $('.m-modal2, .m-cover').addClass("hidden");
    function explode(){
         window.location.replace(redirect_url3); 
    }
    setTimeout(explode, 2000);
});
var valdidate_form = false;
$(document).on('change', 'input[name=college]', function(){
   if($(this).val() == 1){
       console.log(true);
       valdidate_form = true;
       $('.colleges-error').html('');
   } else{
        validate_clg();
   }
});
$(document).on('change', '.college-list', function(){
    validate_clg();
});
function validate_clg(){
    $('.college-list').each(function() {
      if($(this).is(':checked')){
          valdidate_form = true;
          console.log(true, 1);
          $('.colleges-error').html('');
          return false;
      } else {
          valdidate_form = false;
          console.log(false);
          $('.colleges-error').html('Please Select College.');
      }
    })
}
$(document).on('submit', '#job_for_colleges', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    if(valdidate_form){
        console.log('request');
        var me = $('#submit-cl');
        if ( me.data('requestRunning') ) {
            return false;
        }
        me.data('requestRunning', true);
        var url = '/account/jobs/application-colleges-submit';
        var data = $('#job_for_colleges').serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function (){
                $('#submit-cl').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                $('#submit-cl').prop('disabled', true);
            },
            success: function (response) {
                if (response.status == 200) {
                    toastr.success(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                    $('#submit-cl').prop('disabled', false);
                }
                $('#submit-cl').html('Submit');
                function explode(){
                     window.location.replace(redirect_url3); 
                }
                setTimeout(explode, 2000);
            },
            complete: function() {
            me.data('requestRunning', false);
          }
        });
    }
});
JS;
$this->registerJs($script);