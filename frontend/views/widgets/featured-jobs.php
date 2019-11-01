<?php
use yii\helpers\Url;
?>
 <div class="row">
    <div class="col-md-12">
        <div class="widget-heading">
            <span><img src="" alt=""></span>
            <span>Developer Jobs</span>
            <span class="fj-wa" data-toggle="tooltip" title="Join Us on WhatsApp">
                <a href="https://chat.whatsapp.com/JTzFN51caeqIRrdWGneBOi"><i class="fab fa-whatsapp-square"></i></a>
            </span>
        </div>
    </div>
</div>
    <div class="row">
        <?=
            $this->render('/widgets/new-jobs-box',[
                'featured_jobs' => $featured_jobs
            ])
        ?>
    </div>
    <div class="fj-form">
        <div class="row">
            <div class="col-md-6">
                <div class="fj-sub-heading">Get Latest Updates in you inbox</div>
            </div>
            <div class="col-md-6">
                <div class="fj-sub-form">
                    <form id="subs_news">
                        <div class="row">
                            <div class="col-md-9">
                                <input type="text" name="email" class="fj-input" placeholder="Your Email">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="fj-btn">Notify Me</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.widget-heading{
    text-align:center;
    font-size:25px;
    color:#333;
    font-family: roboto;
    position:relative;
    width: fit-content;
}
.fj-wa-wa{
    font-size: 30px;
    text-align: right;
    padding: 20px 0px 0 0;
    color:#333
}
.fj-tw, .fj-wa{
    font-size:25px;
    padding-left:5px;
}
.fj-tw:hover{
    color:#00acee;
}
.fj-wa:hover{
    color: #25D366;
}
.fj-sub-heading{
    font-size: 18px;
    text-transform: capitalize;
    font-family: roboto;
    padding:8px 10px;    
}

.fj-form {
    border:1px solid #eee;
    padding:20px 10px 15px;
    margin:20px 0;
    box-shadow:0 0 10px rgba(0,0,0,.2)
}
.fj-input{
    width:100%;
    padding:10px;
    border:1px solid #eee;
    font-size:15px;
}
.fj-input::placeholder{
    color:#999;
}
.fj-btn{
    color:#fff;
    background:#00a0e3;
    padding:10px 10px;
    border:none;
}
');
$script = <<<JS
$('#subs_news').submit(function(event) {
    event.preventDefault();
     var formData = $(this).serialize();
  $.ajax({
    url: '/site/add-new-subscriber',
    data: formData,
    method: 'POST',
  })
})
JS;
$this->registerJS($script);
?>
