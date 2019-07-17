<?php
$script = <<< JS
var companies = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
        url: '/reviews/search-org?query=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  },
});
$('#search_company').typeahead(null, {
  name: 'search_companies',
  displayKey: "name",
  limit: 5,      
  source: companies,
  templates: {
    suggestion: function(data) {
        var result =  '<div class="suggestion_wrap"><a href="/'+data.review_link+'">'
            +'<div class="logo_wrap">'
            +( data.logo  !== null ?  '<img src = "'+data.logo+'">' : '<canvas class="user-icon" name="'+data.name+'" width="50" height="50" color="'+data.color+'" font="30px"></canvas>')
            +'</div>'
            +'<div class="suggestion">'
            +'<p class="tt_text">'+data.name+'</p><p class="tt_text category">' +data.business_activity+ "</p></div></a></div>"
 return result;
},
    empty: ['<div class="no_result_display"><div class="no_result_found">Sorry! No results found</div><div class="add_org"><a href="#" class="add_new_org">Add New Organizatons</a></div></div>'],
},
}).on('typeahead:asyncrequest', function() {
    $('.load-suggestions').show();
}).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    utilities.initials();
    $('.load-suggestions').hide();
}).on('typeahead:selected',function(e,datum) {
    window.location.replace('/'+datum.review_link+'');
});
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);