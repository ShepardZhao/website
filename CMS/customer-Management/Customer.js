$(document).ready(function(){
    var CurrentDomain=window.location.origin;

    // onready go to the tab requested in the page hash
   $(function(){setTimeout(gotoHashTab(),1000);});

 var gotoHashTab = function (customHash) {
        var hash = customHash || location.hash;
        var hashPieces = hash.split('?'),
            activeTab = $('[href=' + hashPieces[0] + ']');
        activeTab && activeTab.tab('show');
                setTimeout(gotoHashTab,1000);
        
    }
    gotoHashTab();
    // when the nav item is selected update the page hash
    $('.nav a').on('shown', function (e) {
        window.location.hash = e.target.hash;
    })

    // when a link within a tab is clicked, go to the tab requested
    $('.tab-pane a').click(function (event) {
        if (event.target.hash) {
            gotoHashTab(event.target.hash);
        }
    });

/****************************************Common Ajax*****************************/
    function CommonAJAX(data,infoid){
    var request = $.ajax({
        url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
        type: "POST",
        data:data,
        dataType: "html"
    });

    request.done(function( msg ) {

        if(msg==='Updated successfully'){
            $('<div class="alert alert-info">Updated successfully</div>').insertBefore($(infoid)).fadeIn(200);
            setTimeout(function(){$('.alert-info').fadeOut(); },3000);
        }
        else if(msg==='Changed password successfully'){
            $('<div class="alert alert-info">Changed Password successfully</div>').insertBefore($(infoid)).fadeIn(200);
            setTimeout(function(){$('.alert-info').fadeOut(); },3000);
        }
        else if(msg==='Updated error'){
            $('<div class="alert alert-info">Updated Error</div>').insertBefore($(infoid)).fadeIn(200);
            setTimeout(function(){$('.alert-info').fadeOut(); },3000);

        }
        else if(msg==='fail'){

            $('<div class="alert alert-info">The old password is not match to your input</div>').insertBefore($(infoid)).fadeIn(200);
            setTimeout(function(){$('.alert-info').fadeOut(); },3000);
        }

    });

    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });




}


    var GetCustomerUserID=$('#CustomerID').val();
    /****************************************Customer Profile************************/
//basic info updating
$('body').on('click','#BasicCustomerButton',function(){
    var GetCustomerName=$('#CustomerName').val();
    var GetCustomerFirstName=$('#CustomerFirstName').val();
    var GetCustomerLastName=$('#CustomerLastName').val();
    var GetCustomerPhone=$('#CustomerPhone').val();
    var GetCustomerMail=$('#CustomerMail').val();
    var GetCustomerAddress=$('#CustomerAddress').val();
    var TempArray={};
    TempArray['GetCustomerUserID']=GetCustomerUserID;
    TempArray['GetCustomerName']=GetCustomerName;
    TempArray['GetCustomerFirstName']=GetCustomerFirstName;
    TempArray['GetCustomerLastName']=GetCustomerLastName;
    TempArray['GetCustomerPhone']=GetCustomerPhone;
    TempArray['GetCustomerMail']=GetCustomerMail;
    TempArray['GetCustomerAddress']=GetCustomerAddress;
    TempArray['Mode']='1';

    CommonAJAX(TempArray,'#BasicCustomerButton');


});
//Register User's password

$('body').on('click','#ChangePasswordButton',function(){

    var GetOldPassword=$('#Old_Password').val();
    var GetNewPassword=$('#New_password').val();
    var TempArray={};
    TempArray['GetCustomerUserID']=GetCustomerUserID;
    TempArray['GetOldPassword']=GetOldPassword;
    TempArray['GetNewPassword']=GetNewPassword;
    TempArray['Mode']='2';
    CommonAJAX(TempArray,'#ChangePasswordButton');
});

//avatar upload

$('body').on('click','#avatarButton',function(){




});





});