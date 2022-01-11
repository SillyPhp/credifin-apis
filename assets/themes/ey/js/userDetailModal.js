 function openUserDetailsModal(){
    $.ajax({
        url: 'account/resume-builder/user-detail-modal',
        method: 'Post',
        data:  {'_csrf-common':$('meta[name="csrf-token"]').attr('content')},
        success: function(response){
            console.log(response);
        }
    })
 }

 openUserDetailsModal();