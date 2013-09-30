//facebook connection

fbAsyncInit = function() {
    FB.init({
        appId   : '422446111188481',
        oauth   : true,
        status  : true, // check login status
        cookie  : true, // enable cookies to allow the server to access the session
        xfbml   : true // parse XFBML
    });
    isLoaded = true;

};


function fb_logff(){
    FB.logout(function(response) {
        window.location.reload();//reload the page, if the user logoff
    });

}
function fb_login (){
    FB.login(function(response) {

        if (response.authResponse) {
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID

            FB.api('/me', function(response) {

                window.location.reload();//reload the page if the uer login

            });

        } else {
            //user hit cancel button

        }
    }, {
        scope: 'publish_stream,email'
    });
}
(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
}());






