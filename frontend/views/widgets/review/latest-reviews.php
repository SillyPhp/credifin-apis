<?php
use yii\helpers\Url;
?>
<script id="latest-reviews" type="text/template">
<div class="qr-heading">Latest Reviws</div>
<ul>
    <li>
        <div class="quick-review-box">
            <a href="">
                <div class="row">
                    <div class="col-md-3">
                        <div class="qrb-thumb">
                            <a href=""><img src="<?= Url::to('@eyAssets/images/pages/index2/agile.png')?>"></a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="qrb-details">
                            <div class="qr-name"><a href=""> Guru Nanak Institute of Management and Technology </a></div>
                            <div class="qr-stars">
                                <i class="fas fa-calendar-alt"></i> June 04, 2019
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </li>
</ul>
</script>
<?php
$script = <<< JS
function fetch_cards_latest(params,template)
{
    $.ajax({
        url : '/organizations/fetch-data',
        method: "POST",
        data: {params:params},
        success: function(response) {
            if (response.status==200){
            template.append(Mustache.render($('#latest-reviews').html(),response.cards));
            utilities.initials();
            $.fn.raty.defaults.path = '/assets/vendor/raty-master/images';
                $('.average-star').raty({
                   readOnly: true, 
                   hints:['','','','',''],
                  score: function() {
                    return $(this).attr('data-score');
                  }
                });
            }
        }
    });
}
JS;
$this->registerJs($script);
?>