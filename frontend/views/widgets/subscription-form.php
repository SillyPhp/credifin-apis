<form id="subscription-form-footer" class="newsletter-form">
    <div class="row">
        <div class="form-group col-md-12">
            <input id="form_first_name" name="first_name" placeholder="First Name" class="form-control" type="text" autocomplete="off" required>
        </div>
        <div class="form-group col-md-12">
            <input id="form_last_name" name="last_name" placeholder="Last Name" class="form-control" type="text" autocomplete="off" required>
        </div>
    </div>
    <div class="form-group">
        <input type="email" name="email" placeholder="Your Email" class="form-control input-lg font-16" data-height="45px" autocomplete="off" id="mce-EMAIL-footer" required>
    </div>   
        <div class="form-group">
         <button data-height="45px" class="btn bg-theme-color-2 text-white btn-xs m-0 font-14" type="submit">Subscribe</button>
        </div> 
    
</form>
<?php
$this -> RegisterCss('
    .bttn-sub{
        margin-top:10px;
    }
');
$script = <<< JS
$('#subscription-form-footer').submit(function (event) {
    $('.form-group').removeClass('has-error'); // remove the error class
    $('.help-block').remove(); // remove the error text
    var formData = $(this).serialize();
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url: '/add-new-subscriber', // the url where we want to POST
        data: formData, // our data object
        dataType: 'json', // what type of data do we expect back from the server
        encode: true
    })
        .done(function (data) {
            var form = $('#subscription-form-footer');
            var response = '';
            form.children(".alert").remove();
            if (data.status == 200) {
                form[0].reset();
                response = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + data.message + '</div>';
            } else {
                response = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + data.message + '</div>';
            }
            form.prepend(response);
        })

        // using the fail promise callback
        .fail(function (data) {
        });
    event.preventDefault();
});
JS;
$this->registerJs($script);