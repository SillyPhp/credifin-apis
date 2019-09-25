<form id="job_for_colleges">
    <div class="form-group select-app-for">
        <h4>Choose application for</h4>
        <input type="radio" name="college" id="all" value="1"/>
        <label for="all">All Colleges</label>
        <input type="radio" name="college" id="c-select" value="0"/>
        <label for="c-select">Choose Colleges</label>
    </div>
    <div class="college-list hidden">
        <?php
        foreach ($colleges as $clg) {
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="checkbox" name="colleges" id="<?= $clg['college_enc_id'] ?>"
                           value="<?= $clg['college_enc_id'] ?>"/>
                    <label for="<?= $clg['college_enc_id'] ?>"><?= $clg['name'] ?></label>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class='m-actions col-md-12'>
        <button type='submit' id="submit-cl">Submit</button>
    </div>
</form>
<?php
$script = <<< JS
$(document).on('submit', '#job_for_colleges', function (event) {
    var me = $('.submit-colleges');
    event.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }
    me.data('requestRunning', true);
    var url = '/account/jobs/application-colleges-submit';
    var data = $('#job_for_colleges').serialize();
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        beforeSend: function (){
            // $('.sav_benft').prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response.status == 'success') {
                toastr.success(response.message, response.title);
                // $("#select-college-form")[0].reset();
                // $.pjax.reload({container: '#pjax_benefits', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            // $('#select-colleges-modal').modal('toggle');
        },
        complete: function() {
        me.data('requestRunning', false);
      }
    });
});
JS;
$this->registerJs($script);