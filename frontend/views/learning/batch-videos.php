<?php
$this->title = 'test';
?>
<form action="">
    <div class="form-group">
        <input type="text" class="form-control" id="channel_id" placeholder="Enter Channel Id">
        <button type="button" class="btn main-blue-btn btn-md btn-block" style="margin-top: 10px;" id="btnSubmit">Submit</button>
    </div>

</form>

<?php
$script = <<< JS
    var all_results = [];

    $('#btnSubmit').click(function() {
      
        var channel_id = $('#channel_id').val();
        
        if(channel_id != ''){
            $.ajax({        
                type:'GET',
                url:'https://www.googleapis.com/youtube/v3/search?channelId='+ channel_id +'&order=date&part=snippet&type=video&key=AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk&maxResults=50',
                async:false,
                success: function(response) {
                    var items = response.items;
                    for(var i=0; i<items.length; i++){
                        var id = items[i]['id']['videoId'];
                        var video_info = {};
                        $.ajax({
                            type:'GET',
                            async:false,
                            url:'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id='+id+'&key=AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk',
                            success: function(response) {
                              video_info['title'] = response['items'][0]['snippet']['title'];
                              video_info['description'] = response['items'][0]['snippet']['description'];
                              video_info['cover_image'] = response['items'][0]['snippet']['thumbnails']['high']['url'];
                              video_info['link'] = id;
                              video_info['tags'] = response['items'][0]['snippet']['tags'];
                              video_info['duration'] = response['items'][0]['contentDetails']['duration'];
                            }
                        });
                        all_results.push(video_info);
                    }
                    
                    if(response['nextPageToken']){
                        getVideos(response['nextPageToken'],channel_id);
                    }
                    
                    if(all_results.length > 50){
                        var n = Math.floor(all_results.length/50);
                        var more = all_results%50;
                        var k = 0;
                        for(var t = 0; t < n; t++){
                            console.log(all_results.slice(k,k+50));
                            // saveVideos(all_results.slice(k,k+50));
                            k+=50;
                        }
                        if(more > 0){
                            console.log(all_results.slice(k,k+more));
                            // saveVideos(all_results.slice(k,k+more));
                        }
                    }else{
                        saveVideos(all_results);
                    }
                }
            })
        }else{
            toastr.error('Please Enter Channel Id','error');
        }
    });
    
    function saveVideos(d){
        $.ajax({
           type:'POST',
           url:'save-video-data',
           data:{data:d},
           success:function(res) {
             if(res.status == 200){
                 toastr.success('success',res.message);
             }else {
                 toastr.error('error','There is and error');
             }
           } 
        });
    }
    
function getVideos(nextPageToken = null,c_id) {
  $.ajax({        
        type:'GET',
        url:'https://www.googleapis.com/youtube/v3/search?channelId='+ c_id +'&order=date&part=snippet&type=video&key=AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk&maxResults=50&pageToken='+nextPageToken,
        async:false,
        success: function(response) {
            var items = response.items;
            for(var i=0; i<items.length; i++){
                var id = items[i]['id']['videoId'];
                var video_info = {};
                $.ajax({
                    type:'GET',
                    async:false,
                    url:'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id='+id+'&key=AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk',
                    success: function(response) {
                      video_info['title'] = response['items'][0]['snippet']['title'];
                      video_info['description'] = response['items'][0]['snippet']['description'];
                      video_info['cover_image'] = response['items'][0]['snippet']['thumbnails']['high']['url'];
                      video_info['link'] = id;
                      video_info['tags'] = response['items'][0]['snippet']['tags'];
                      video_info['duration'] = response['items'][0]['contentDetails']['duration'];
                    }
                });
                all_results.push(video_info);
            }
            if(response['nextPageToken']){
                getVideos(response['nextPageToken'],c_id);
            }else{
                return ;
            }
        }
  });
                    
}
 
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

