<?php

use yii\helpers\Url;

?>
<section>
    <div class="row">
        <div class="col-md-6">
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="titleField">Title*</label>
                            <input type="text" name="titleField" id="title" class="form-control">
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label for="datePick">Select Date*</label>
                            <div class="with-icon">
                                <input class="form-control form-control-inline date-picker" name="datepick" size="16"
                                       type="text"
                                       id="datepicker" value=""/>
                                <i class="utouch-icon utouch-icon-user fa fa-calendar-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-grouptimepicker-main">
                            <label for="timepick">From</label>
                            <input type="text" class="form-control timepicker timepicker-24" name="timepick"
                                   id="start-time-1"
                                   placeholder="11:00 AM">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="topic">Topics*</label>
                            <input type="text" name="topic" id="topic" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="file" id="myfile" onchange="doTest()" class="form-control">
                            <span class="error-message">You must select a valid image file! </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="webinar-box">
                <div class="webinar-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>" id="imageIcon">
                </div>
                <div class="web-date" id="datepick"><span class="cont">12</span><br><span class="abs">july</span></div>
                <div class="webinar-details">
                    <div class="show-web-title" id="titleField">Title</div>
                    <div class="webinar-city" id="timepick"><i class="far fa-clock"></i> Time</div>
                    <div class="webinar-desc" id="description">Description</div>
                </div>
                <div class="new-btns">
                    <div class="join-btn naam">
                        <button type="button">Join Event</button>
                    </div>
                    <div class="detail-btn naam">
                        <button type="button">View Details</button>
                    </div>
                    <div class="sharing-btn naam">
                        <button type="button" title="share with friend">Share <i class="fa fa-share-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.error-message{
    display: none;
    color: #ca0b00;
}
 .datepicker>div {
    display: block;
}
.with-icon {
    position: relative;
}
.has-error .with-icon input, .has-error .with-icon textarea {
    border: 1px solid #ff00004d !important;
}
.with-icon .utouch-icon {
    position: absolute !important;
    right: 0px !important;
    top: 10px !important;
    height: 16px !important;
//    border-right: 1px solid #dbe3ec !important;
    z-index: 1 !important;
    transition: all .3s ease !important;
    padding-left: 6px !important;
    padding-right: 8px !important;
}
.utouch-icon {
    transition: all .3s ease !important;
    width: 32px !important;
}
.with-icon input:focus + .utouch-icon, .with-icon textarea:focus + .utouch-icon, .with-icon select:focus + .utouch-icon {
    color: #0083ff !important;
}
.bootstrap-timepicker-hour, .bootstrap-timepicker-minute, .bootstrap-timepicker-meridian{
    display: initial;
    padding: 0;
    background-color: transparent;
}
textarea{
    resize: none;
    height: 100px !important;
}


.new-btns{
    display: flex;
    margin-top: 20px;
    justify-content: center;
}
.naam button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	margin: 0 2px;
	padding: 7px 18px;
	font-size: 16px;
	border-radius: 4px;
	font-family: roboto;
}
.webinar-box{
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    background-color:#fff;
}
.webinar-icon {
    position: relative;
    z-index: 0;
    height: 250px;
    max-width:100%;
}
.webinar-icon img{
    height: 100%;
    width: 100%;
}
.web-date {
	border: 1px solid transparent;
	text-align: center;
	width: 130px;
	height: 130px;
	margin: auto;
	background-color: #00a0e3;
	color: #fff;
	padding: 21px 0;
	border-radius: 100px;
	margin-top: -70px;
    position: relative;
    z-index: 1;
}
.cont{
    font-size: 65px;
    line-height: 50px;
    font-family: roboto;
    font-weight: 600;
}
.abs{
    font-size: 22px;
    text-transform: uppercase;
    font-family: roboto;
}
.show-web-title {
    font-size: 32px;
    text-align: center;
    font-family: roboto;
    font-weight: 600;
    line-height: 35px;
    padding-top: 10px;
}
.webinar-city {
    text-align: center;
    font-size: 16px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
    padding-bottom: 10px;
}
.webinar-desc {
    font-size: 16px;
    font-family: roboto;
    text-align: center;
}
');
$script = <<<JS
    $('.date-picker').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-0m'
    });

    $(document).on('focus', '.timepicker-24', function(){
        $(this).timepicker();
    });
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerCssFile('@backendAssets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<script>
    if (window.FileReader) {
        let reader = new FileReader(), rFilter = /^(image\/jpeg|image\/png|image\/jpg)$/i;
        reader.onload = function (oFREvent) {
            preview = document.getElementById('imageIcon');
            preview.src = oFREvent.target.result;
            preview.style.display = "block"
        }

        function doTest() {

            if (document.getElementById("myfile").files.length === 0) {
                return;
            }
            var file = document.getElementById("myfile").files[0];
            if (!rFilter.test(file.type)) {
                document.querySelector('.error-message').style.display = "block";
                return;
            }
            reader.readAsDataURL(file);
            document.querySelector('.error-message').style.display = "none";
        }
    } else {
        alert("FileReader object not found :( \nTry using Chrome, Firefox or WebKit");
    }

    let inputs = document.querySelectorAll('input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('click', setActive);
    }


    function setActive(e) {
        let activeId = e.currentTarget.getAttribute('name');
        let idField = document.getElementById(activeId);
        let inputField = e.currentTarget;
        console.log(activeId);
        if (activeId === 'timepick' || activeId === 'datepick') {
            e.currentTarget.addEventListener('click', function () {
                idField.innerHTML = inputField.value;
            })
        } else {
            e.currentTarget.addEventListener('keyup', function () {
                idField.innerHTML = inputField.value;
            })
        }
    }
</script>
