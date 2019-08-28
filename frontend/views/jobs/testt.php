<?php
$script = <<< JS
var host = 'data.usajobs.gov';  
var userAgent = 'snehkant93@gmail.com';  
var authKey = 'ePz5DRXvkE/1XaIu++wGwe5EzgmvM3jNTbHRe9dGMRM=';    

$.ajax({      
    url: 'https://data.usajobs.gov/api/search?JobCategoryCode=2210',      
    method: 'GET',      
    headers: {          
        //"Host": host,          
        //"User-Agent": userAgent,          
        "Authorization-Key": authKey      
    },
  success:function(response) {
    console.log(response);
}  
});
JS;
$this->registerJs($script);
