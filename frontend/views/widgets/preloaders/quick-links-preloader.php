<?php
$column = 'col-md-3 col-sm-3 col-xs-6';
if (isset($size)) {
    $column = $size;
}
?>

    <div class="loading-main">
        <div class="row">
            <?php
            for ($i = 0; $i < 4; $i++) {
                ?>
                <div class="<?= $column; ?>">
                    <div class="list-heading">
                        <div class="loader anim"></div>
                    </div>
                    <ul class="quick-links" id="searches">
                        <?php
                        for ($j = 0; $j < 4; $j++) {
                            ?>
                            <li>
                                <a>
                                    <div class="loader anim"></div>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <button type="button" class="showHideBtn">
                        <div class="loader anim"></div>
                    </button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<!--    <script id="q-links-popular" type="text/template">-->
<!--        <div class="list-heading">Popular Searches</div>-->
<!--        <ul class="quick-links" id="searches">-->
<!--            {{#.}}-->
<!--            <li class="hide">-->
<!--                <a href="/search?keyword={{name}}" title="{{name}}">-->
<!--                    {{name}}-->
<!--                </a>-->
<!--            </li>-->
<!--            {{/.}}-->
<!--        </ul>-->
<!--        <button type="button" class="showHideBtn">More</button>-->
<!--    </script>-->
<?php
$this->registerCss('
.showHideBtn > .loader.anim{
    width: 50px;
}
.list-heading .loader.anim {
    height: 20px;
}
.loading-main .quick-links  li a .loader{
    margin: 7px 0px;
}
');
$script = <<<JS
function getLocations() {
    $.ajax({
        method: "POST",
        url : window.location.href,
        success: function(response) {
            if(response.status === 200) {
                var location_data = $('#q-links-popular').html();
                $(".head-office").html(Mustache.render(location_data, response.locations));
                
                // renderLocations(response.locations);
            }
        }
    });
}
JS;
$this->registerJs($script);
?>