<?php

use yii\helpers\Url;
$this->params['header_dark'] = true;
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name">

                        <input type="text" class="form-control" placeholder="Second Name">

                        <input type="email" class="form-control" placeholder="Email">

                        <input type="tel" class="form-control" placeholder="Contact Number">

                        <input type="text" class="form-control" placeholder="Course Name">

                        <div class="button-form">
                        <button type="submit" class="btn-frm" name="submit button">Submit</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('

.form-control{
    margin: 20px auto;
    width: 320px;
    }
.form-control{
    padding: 6px 12px;
    background-color: #fff;
    border: 2px solid #c2cad8;
    }
.button-form{
    text-align: center;
}
.btn-frm{
    width:100px;
    height:40px;
    background-color: #00a0e3;
    border: 0px solid #c2cad8;
    color: #fff;
    border-radius: 6px;
}
.btn-frm:hover{
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
');