<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<button id="sign-in-or-out-button">Sign In</button>
<script>
    var GoogleAuth;
    var scope = 'https://www.googleapis.com/auth/youtube.force-ssl';
    function handleClientLoad(){
        gapi.load('client:auth2', initClient);
    }
    function initClient(){
        var discoveryUrl = 'https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest';
        gapi.client.init({
            'apiKey' : 'AIzaSyAdCmg9wt5Odp1Cd9KN3SFOKkvvec2YGGQ',
            'discoveryDocs' : [discoveryUrl],
            'clientId' : '758339221215-ikqvaf2jovrtpak660192ipobhf4ujd3.apps.googleusercontent.com',
            'scope' : scope
        }).then(function () {
            GoogleAuth = gapi.auth2.getAuthInstance();
            GoogleAuth.isSignedIn.listen(updateSigninStatus);
            var user = GoogleAuth.currentUser.get();
            setSigninStatus();
            $('#sign-in-or-out-button').click(function () {
                handleAuthClick();
            });
        });
    }
    function handleAuthClick(){
        if(GoogleAuth.isSignedIn.get()){
            GoogleAuth.signOut();
        }else{
            GoogleAuth.signIn();
        }
    }
    function setSigninStatus(isSignedIn){
        var user = GoogleAuth.currentUser.get();
        var isAuthorised = user.hasGrantedScopes(scope);
        if(isAuthorised){
            $('#sign-in-or-out-button').html('Sign Out');
            console.log(user);
        }else{
            $('#sign-in-or-out-button').html('Sign In');
        }
    }
    function updateSigninStatus(isSignedIn){
        setSigninStatus();
    }
</script>
<script async defer src="https://apis.google.com/js/api.js"
        onload="this.onload=function(){};handleClientLoad()"
        onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>