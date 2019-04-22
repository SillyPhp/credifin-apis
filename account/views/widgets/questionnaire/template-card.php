<?php
use yii\helpers\Url;
use yii\helpers\Json;
$total_questionnaire = count($questionnaire);
$next = 0;
if (!empty($total_questionnaire)) {
    ?>
    <div class="cat-sec">
        <div class="row no-gape">
            <?php
            for ($j = 0; $j < $total_questionnaire; $j++) {
                if ($next < $total_questionnaire) {
                    ?>
                    <div class="box-main-col <?= $col_width; ?>">
                        <div class="p-category">
                            <div class="click question-click <?= (($questionnaire[$next]["is_bookmared"])?'active active-2 active-3':'') ?>">
                                <span class="fa <?= (($questionnaire[$next]["is_bookmared"])?'fa-star':'fa-star-o') ?>"></span>
                                <div class="ring"></div>
                                <div class="ring2"></div>
                                <input type="hidden" value="<?=$questionnaire[$next]["id"]; ?>">
                            </div>
                            <div class="rt-bttns">
                                <a class="clone-bttn set-right-align two copy_content_questionnaire" href=""  value="<?=$questionnaire[$next]["id"]; ?>">
                                    <i class="fa fa-files-o"></i>
                                </a>
                            </div>
                            <a href="#" onclick="window.open('<?= Url::to('/account/templates/questionnaire' . DIRECTORY_SEPARATOR . $questionnaire[$next]["id"]); ?>/view', '_blank');" >
                                <i class="fa fa-file-text"></i>
                                <span><?= $questionnaire[$next]['questionnaire_name']; ?></span>
                                <p>
                                    <?php
                                    $p = NULL;
                                    foreach (Json::decode($questionnaire[$next]['questionnaire_for']) as $for) {
                                        $p .= used_for($for) . ', ';
                                    }
                                    echo rtrim($p, ', ');
                                    ?>
                                </p>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                $next++;
            }
            ?>
        </div>
    </div>
    <?php
} else { ?>
    <h3>No Questionnaire To Display</h3>
<?php }
$script = <<<JS
//bookmark template 
$(document).on('click','.question-click',function() {
    var que_template_id = $(this).find('input').val();
	if (!$(this).find('span').hasClass("fa-star")) {
		$(this).addClass('active');
		$(this).addClass('active-2');
		$(this).find('span').addClass('fa-star');
		$(this).find('span').removeClass('fa-star-o');
		$(this).addClass('active-3');
		run_ajax(que_template_id,url='/account/templates/questionnaire/bookmark-questionnaire-template');
	}
	else 
	    {
	    $(this).removeClass('active');
		$(this).removeClass('active-2');
		$(this).find('span').removeClass('fa-star');
		$(this).find('span').addClass('fa-star-o');
		$(this).removeClass('active-3');
		run_ajax(que_template_id,url='/account/templates/questionnaire/bookmark-questionnaire-template');
	    }
});
//assignt template to organizations
$(document).on('click','.copy_content_questionnaire',function(e) {
  e.preventDefault();
  var que_template_id = $(this).attr('value');
  if (window.confirm("Do You Want To Use this Questionaire For Your Jobs And Internships?"))
      {
          run_ajax(que_template_id,url='/account/templates/questionnaire/assign-questionnaire-template');
      }
})

function run_ajax(id,url) {
  $.ajax({
  url:url,  
  data:{id:id},
  method:'post',
  success:function(res)
  {
     if (res.status=='200')
         {
            toastr.success(res.message, res.title); 
         }
     else {
       toastr.error(res.message, res.title);    
     }
  }
  });
}
JS;
$this->registerCss("
.click {
font-size: 33px;
    color: rgba(0,0,0,.5);
    width: 38px;
    height: 38px;
    margin: 0 auto;
    /* margin-top: 20px; */
    position: absolute;
    cursor: pointer;
    right: 10px;
    top: 17px;
}
.click span {
	margin-left: 4px;
	margin-top: 3px;
	z-index: 999;
	position: absolute;
}

span:hover {
	opacity: 0.8;
}

span:active {
	transform: scale(0.93,0.93) translateY(2px)
}

.ring, .ring2 {
	opacity: 0;
	background: grey;
	width: 1px;
	height: 1px;
	position: absolute;
	top: 19px;
	left: 18px;
	border-radius: 50%;
	cursor: pointer;
}
.clone-bttn
{
display:block;
left:0;
width: fit-content;
    font-size: 19px;
    top: 7px;
}
.active > span, .active-2 > span {
	color: #F5CC27 !important;
}

.active-2 .ring {
	width: 45px !important;
    height: 36px !important;
    top: -7px !important;
    left: -4px !important;
    position: absolute;
    border-radius: 50%;
    opacity: 1 !important;
}

.active-2 .ring {
	background: #F5CC27 !important;
}

.active-2 .ring2 {
	background: #fff !important;
}

.active-3 .ring2 {
	width: 45px !important;
    height: 42px !important;
    top: -10px !important;
    left: -4px !important;
    position: absolute;
    border-radius: 50%;
    opacity: 1 !important;
}

.info {
	font-family: 'Open Sans', sans-serif;
	font-size: 12px;
	font-weight: 600;
	text-transform: uppercase;
	white-space: nowrap;
	color: grey;
	position: relative;
	top: 30px;
	left: -46px;
	opacity: 0;
	transition: all 0.3s ease;
}

.info-tog {
	color: #F5CC27;
	position: relative;
	top: 45px;
	opacity: 1;
}
");
$this->registerJs($script);
function used_for($n)
{
    switch ($n) {
        case 1:
            $a = 'Jobs';
            break;
        case 2:
            $a = 'Internships';
            break;
        default:
            $a = 'NA';
    }
    return $a;
}