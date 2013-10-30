$(document).ready(function(){
//initial img on page order.php



//ajax function --WaterFall and Comments

    function AjaxFunction(ContentId,dataInfo,DesPage,mode){
         //mode=0; display all not condition
         //mode=1;display stuff according to picID
        //Ajax Image Loading
        $(ContentId).empty().append('<div class="loadingImage"><img src="assets/framework/img/ajax-loader.gif"></div>').fadeIn();
        var request = $.ajax({
            url: DesPage,
            type: "POST",
            cache: false,
            data: dataInfo,
            dataType: "html"

        });

        request.done(function(msg) {

              $(ContentId).empty().append(msg).fadeIn();

            if(mode===1){//display image according to picID
                active();

            }
            else if(mode===0){//display image for all
                inactive();
            }

        });

        request.fail(function(jqXHR, textStatus) {
            $(ContentId).empty().append( "Request failed: " + textStatus );
        });
    }


    function active(){

        $('.left-position').fadeIn();

    }
    function inactive(){


        $('.left-position').fadeOut();

    }

 //feathured events group

//re-bind the even after AJAX

    $('body').on('click','.Imagetiles li',function(){//image click event
        var getId= $(this).find('.RetaurantName').attr('id');
        AjaxFunction("#FeathuredInterface",dataObj("getMode","mode2"),"Feathured-detail.php",1);

    });


    $('body').on('click','#Navcomments',function(){//arrow click event between comments and waterfall
        if($(this).hasClass('icon-circle-arrow-down')){
            $(this).removeClass('icon-circle-arrow-down').addClass('icon-circle-arrow-up');
            // set Up the Css name of Featured page
            var name = "CssId";
            var value = "commentSt";
            var dataObj = {};
            dataObj[name]=value;
            AjaxFunction("#ClickToComment",dataObj,"Common-comments.php",1);
            dataObj=null; //destry the container
        }

        else if($(this).hasClass('icon-circle-arrow-up')){
            $(this).removeClass('icon-circle-arrow-up').addClass('icon-circle-arrow-down');
            var name="mode";
            var value="mode2";
            var dataObj={};
            dataObj[name]=value;
            AjaxFunction("#ClickToComment",dataObj,"Common-waterfall.php",1);
            dataObj=null;
        }
    });

    //intials image loading event
$(function(){
    if(('#FeathuredInterface').length>0){
        AjaxFunction("#FeathuredInterface",dataObj("getMode","mode1"),"Feathured.php",0);
    }

});
//Click #left-position to return the index page of Feathured
    $('#Feathred-left-position').on('click',function(){
        AjaxFunction("#FeathuredInterface",dataObj("getMode","mode1"),"Feathured.php",0);
    });


//Featured events group

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




    //Tag li elements click

    $('body').on('click','.TagAvailable li',function() { //TagAvailable---Availability
        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });



    $('body').on('click','.TagCuisine li',function() { //TagCuisine---Cuisine
        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });


    $('body').on('click','.TagType li',function() { //TagType---Type
        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }
    });

    $('body').on('click','.TagPrice li',function() { //TagPrice---Price
        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }
    });



//pop alert to select the address
    $('#QuestionMark').popover();
    $('#DeliveryQuestionMark').popover();


    $('#switchArrow').on('click',function(){
        if($('#switchArrow i').hasClass('fa-arrow-circle-o-right'))
        {$('#switchArrow i').removeClass('fa-arrow-circle-o-right').addClass('fa-arrow-circle-o-down');
            $('.hideAddress').fadeIn();

        }

        else if($('#switchArrow i').hasClass('fa-arrow-circle-o-down'))
        {$('#switchArrow i').removeClass('fa-arrow-circle-o-down').addClass('fa-arrow-circle-o-right');
            $('.hideAddress').fadeOut();
        }
    });



});