<div class="module2-heading">Skills Required</div>
<div class="row padd-10">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="skill_wrapper">
                    <div class="load-suggestions Typeahead-spinner">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <input type="text" id="inputfield" name="inputfield"
                           class="form-control"
                           placeholder="Type required skills and press enter.">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="placeble-area">
                    <div id="shownlist">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="manual_notes">
                    Select from predefined skills list
                </div>
            </div>
        </div>
        <div class="row">
            <div id="suggestionbox">
            </div>
            <?= $form->field($model, 'specialskillsrequired', ['template' => '{input}'])->hiddenInput(['id' => 'specialskillsrequired'])->label(false); ?>
            <?= $form->field($model, 'skillsArray', ['template' => '{input}'])->hiddenInput(['id' => 'skillsArray'])->label(false); ?>
        </div>
    </div>
</div>
<input type="text" name="skill_counter" id="skill_counter" readonly>
<?php
$script = <<< JS
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/skills-data',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#inputfield').val();
             return settings;
        },  
    'cache': true, 
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#inputfield').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      var skillsdata = datum.value;
      var value = datum.id;
      addTags(skillsdata,value);
   });
var count = 0;
function addTags(skillsdata,value){
		var tags = skillsdata.trim();
		var listnews = "";
		var newtags = "";
		var existenttags = getTags();
		if(tags.substr(tags.length - 1) == ","){ 
			tags = tags.substr(0, tags.length -1);	
		}
		if(tags.substr(0,1) == ","){
			tags = tags.substr(1, tags.length);	
		}
		if(tags.indexOf(",") !== -1){
			var artags = tags.split(',');	
			for(var i=0; i<artags.length; i++){
				if((artags[i].trim() !== "")&&($.inArray(artags[i].trim(), existenttags) == -1)){
					listnews = listnews + '<span data-value = "'+value+'">'+artags[i].trim()+'<a href="#" class="fa fa-times"></a></span>';
					existenttags.push(artags[i].trim());
                                    count++;
                                    skill_counter();
                                    scroll_skills();
				}
			}
		}
		else{
                    if($.inArray(tags, existenttags) == -1){
	            listnews = '<span data-value = "'+value+'">'+tags+'<a href="#" class="fa fa-times"></a></span>';
                    count++;
                    skill_counter();
                    scroll_skills();
		}
		}
		$("#shownlist").append(listnews);
		$('#inputfield').val('');
		$('#inputfield').blur(function(){
            $(this).val('');
        });
	}; 
$("#inputfield").keypress(function(e){
        if(e.which == 13){
        skillsdata = $('#inputfield').val();
        if(skillsdata == "")
        {
         return false;
        }
        else{
             addTags(skillsdata,value = "");
            }
        } 
    })
$(document).on('click','#shownlist span a', function(event){
		event.preventDefault();
		var btn = $(this);
		var tag = btn.parent().html().toString();
		tag = tag.substr(0,tag.length-20);
		btn.parent().remove();
                count--;
                skill_counter();
	});   
 var skillsdata = null;
       $(document).on('click','.clickable', function(event){
		event.preventDefault();
                skillsdata = $(this).text();
                var value = $(this).attr('data-value');
                addTags(skillsdata,value);
   });
        
 function getTags(){ //Gets array of existing tags
		var alltags = new Array();
		var i = 0;
		$("#shownlist span").each(function( index ) {
  			alltags[i] = $(this).html().substr(0,$(this).html().length - 36);
			i ++;
		});	
		return alltags;
	};
function setTags(){ //Gets string of existing tags separated by commas
		var texttags = getTags();
		var finaltext = "";
		for(var i=0; i<texttags.length; i++){
			if(finaltext == ""){
				finaltext = texttags[i];	
			}
			else{
				finaltext = finaltext + "," + texttags[i];
			}
		}
		return finaltext;
	}
 function skill_counter()
        {
           if(count == 0)
               {
                 $('#skill_counter').val("");
               }
           else
           {
           $('#skill_counter').val("1");
          }
        }
  function skills_arr()
       {
        var array_val = [];

        $.each($('.placeble-area span'),function(index,value)
        {
        var obj_val = {};
        obj_val = $.trim($(this).text());
        array_val.push(obj_val);
         });
         $('#skillsArray').val(JSON.stringify(array_val));
        };      
  function scroll_skills() {
        $(".placeble-area").animate({ scrollTop: $('.placeble-area').prop("scrollHeight")}, 1000);
    }  
   function skils_update(data) 
        {
      $.ajax({
      url:"/account/categories-list/job-skills",
      data:{data:data},
      method:"post",
      success:function(response)
        {
           var obj = JSON.parse(response);
           var html = [];
     $.each(obj,function()
     { 
      html.push ("<span ><a href='#' class='clickable' data-value = '"+this.skill_enc_id+"'>"  +this.skill+ "</a> </span>");  
         });
                                                
        $("#suggestionbox").html(html);
        }
      });    
        }
var ps = new PerfectScrollbar('#suggestionbox');        
var ps = new PerfectScrollbar('.placeble-area');       
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>