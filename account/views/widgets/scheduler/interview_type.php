<h4 class="info-text">Select Interview Type </h4>
<div class="row">
    <form>
        <div class="col-sm-10 col-sm-offset-1">
            <div class="col-sm-4 col-sm-offset-2 fixedType">
                <div class="choice" title="Fixed Interviews are for inviting candidates">
                    <input type="radio" id="interview_type_fixed" name="interview_type"
                           value="fixed">
                    <label for="interview_type_fixed" class="icon">
                        <i class="fa fa-link"></i>
                    </label>
                    <h6>Fixed</h6>
                </div>
            </div>
            <div class="col-sm-4 flexibleType">
                <div class="choice" title="Flexible Interviews are for choosing candidates">
                    <input type="radio" id="interview_type_flexible" name="interview_type" value="flexible">
                    <label for="interview_type_flexible" class="icon">
                        <i class="fa fa-unlink"></i>
                    </label>
                    <h6>Flexible</h6>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
$script = <<<JS
var url = new URL(window.location.href);
if (url.searchParams.get('applied_id')) {
    // setTimeout(function (){
    //     $('#interview_type_flexible').prop('checked',true);
        $('.flexibleType .choice *:not(input)').trigger('click');
        // $('#collapseOne_1').addClass('in');
        // $('#interview_type_flexible, .choice').trigger('click');
        // $('#captain').removeClass('active');
        // $('#description').addClass('active');
    // },1000)
}
JS;
$this->registerJs($script);
