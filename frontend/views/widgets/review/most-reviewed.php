<script id="most-reviewed" type="text/template">
<div class="qr-heading">Most Reviewed</div>
<ul>
    <li>
        <div class="quick-review-box">
            <div class="row">
                <div class="col-md-3">
                    <div class="qrb-thumb">
                        <a href=""><img src="<?= Url::to('@eyAssets/images/pages/index2/agile.png')?>"></a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="qrb-details">
                        <div class="qr-name"><a href=""> Agile Finserv </a></div>
                        <div class="qr-stars">
                            <i class="fa fa-users"></i> 3
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>
</script>
<?php
$script = <<< JS
function fetch_cards_most(params)
{
    $.ajax({
        url : '/organizations/fetch-review-cards',
        method: "POST",
        data: {params:params},
        success: function(response) {
            if (response.status==200){
            template.append(Mustache.render($('#most-reviewed').html(),response.cards));
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
?>