<?php
?>
<div class="container">
    <div class="row">
       <div id="cards"></div>
    </div>
</div>
<?php
$script = <<< JS
var host = 'data.usajobs.gov';  
var userAgent = 'snehkant93@gmail.com';  
var authKey = 'ePz5DRXvkE/1XaIu++wGwe5EzgmvM3jNTbHRe9dGMRM=';

$.ajax({
  url:'https://data.usajobs.gov/api/search',
  method:'GET',
  data:{
      'JobCategoryCode':2210
  },
  headers: {          
        //"Host": host,          
        //"User-Agent": userAgent,          
        "Authorization-Key": authKey      
    },
  success:function(body) {
    $.each(body.SearchResult.SearchResultItems,function(e) {
      console.log(this);
    })
  }
})
JS;
$this->registerJs($script);
?>
