$(document).ready(function(){

/*
    $('body').on('click','.Imagetiles li',function(){//image click event
        var getId= $(this).find('.RetaurantName').attr('id');
        AjaxFunction("#FeathuredInterface",dataObj("getMode","mode2"),"Feathured-detail.php",1);

    });

*/



//Featured events group
/*
$('body').on('click','#Featured-tab',function(){//to prevent water conflict, each tab will clear other two tabs while its clicked

    //step:1. wipe out other two contents of tabs.
        inactive();
      //  $('#Restaurants').empty();
        //$('#Dishes').empty();
        AjaxFunction("#Featured",dataObj("getMode","mode1"),"Feathured.php",0);


});



//Restaurants events group
$('body').on('click','#Restaurants-tab',function(){//to prevent water conflict, each tab will clear other two tabs while its clicked
    inactive();
    $('#Featured').empty();
    $('#Dishes').empty();
    AjaxFunction("#Restaurants",dataObj("getMode","mode1"),"Restaurants.php",0);



});



//Dishes events group
$('body').on('click','#Dishes-tab',function(){//to prevent water conflict, each tab will clear other two tabs while its clicked
    inactive();
    $('#Featured').empty();
    $('#Restaurants').empty();

});




$('body').on('click','.RestaurantsName',function(){

    AjaxFunction("#RestaurantsIndex",dataObj("RestuarntID","123"),"Restaurants-detail.php",1);


});

$('body').on('click','.foodName-Restaurants',function(){
    AjaxFunction("#RestaurantsIndex",dataObj("getMode","mode2"),"Feathured-detail.php",1);


});


function dataObj(pushName,PushValue){
    var name = pushName;
    var value = PushValue;
    var dataObj = {};
    dataObj[name]=value;
    return dataObj;

}






*/

});