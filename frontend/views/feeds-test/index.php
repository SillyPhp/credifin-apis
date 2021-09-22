<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Google One Tap Sign</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
<div id="g_id_onload"
     data-client_id="758339221215-qbm8120ln6a178jbh387s5nb08f1g7ss.apps.googleusercontent.com"
     data-callback="handleCredentialResponse"
     data-your_own_param_1_to_login="any_value"
     data-your_own_param_2_to_login="any_value">
</div>
<script type="text/javascript">
    function handleCredentialResponse(response) {
        if (response.credential){
            var token = parseJwt(response.credential);
            authLogin(token);
        }
        else{
            alert('Server Error');
        }

    }

    function parseJwt (token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        return JSON.parse(jsonPayload);
    };

    function authLogin(token) {
      $.ajax({
          url:'/site/one-tap-auth',
          method:'POST',
          data:token,
          beforeSuccess:function(e)
          {
              console.log('sending you');
          },
          success:function (e) {
                console.log(e);
          }
      })
    }
</script>
</body>
</html>