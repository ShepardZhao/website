/**
 * Created by zhaoxun321 on 3/11/2013.
 */
$(document).ready(function(){
    /**********************************************Order jquery*******************************************/
        //Tag li elements click

    $('body').on('click','.TagAvailable li',function() { //TagAvailable---Availability
        $('#Imagetiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });



    $('body').on('click','.TagCuisine li',function() { //TagCuisine---Cuisine
        $('#Imagetiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });


    $('body').on('click','.TagType li',function() { //TagType---Type
        $('#Imagetiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }
    });

    $('body').on('click','.TagPrice li',function() { //TagPrice---Price
        $('#Imagetiles').css('height','40px');

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


        var handler = null,
            emptyTry=0;
            index=0;
            startCount = 0,
            Filter =new Array(),
            Returncount = 4, //this will set how many records returned
            isLoading = false,
            apiURL =  CurrentDomain+'/json/?GetResAndCuByRootL='+$('#RootLocationName').val();
        // Prepare layout options.
        var options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            resizeDelay:50,
            container: $('#Imagetiles'), // Optional, used for some extra CSS styling
            offset: 2, // Optional, the distance between grid items
            itemWidth: 215 // Optional, the width of a grid item
        };

        /**
         * Refreshes the layout.
         */
        function applyLayout() {
            options.container.imagesLoaded(function() {
                // Create a new layout handler when images have loaded.
                handler = $('#Imagetiles li');
                handler.wookmark(options);
            });
        };

        /**
         * Loads data from the API.
         */
        function loadData() {
            isLoading = true;
            $('#Ajax-loading').fadeIn();

            $.ajax({
                type: "GET",
                url: apiURL,
                dataType: 'json',
                data:{startCount:startCount,count:Returncount,filter:Filter},
                success: onLoadData
            });
        };



    /**
     * When scrolled all the way to the bottom, add more tiles.
     */
    function onScroll(event) {
        // Only check when we're not still waiting for data.
        if(!isLoading) {
            // Check if we're within 100 pixels of the bottom edge of the broser window.
            var closeToBottom = ($(window).scrollTop() + $(window).height() > $(document).height() - 10);
            if(closeToBottom) {
                loadData();
            }
        }
    };





    /**
         * Receives data from the API, creates HTML for images and updates the layout
         */
        function onLoadData(data) {

            isLoading = false;
            $('#Ajax-loading').fadeOut();
            // Create HTML for the images.
            var html = '';
            var i=0, length=data.length, image;
            if(length===0){//if this time the data that are fetched empty, then re-quest agian, total 10 counts
            }

            for(; i<length; i++) {
                image = data[i];
                if(image.PicPath!==null){
                    html += '<li>';
                    if(image.RestID!==undefined){
                        html += '<input type="hidden" class="RestID" value="'+image.RestID+'">';
                    }
                    else if(image.CuisineID!==undefined){
                        html += '<input type="hidden" class="CuisineID" value="'+image.CuisineID+'">';//Cuisine id
                        html += '<input type="hidden" class="CuisineName" value="'+image.CuisineName+'">';//Cuisine Name
                        html += '<input type="hidden" class="CuisineDesc" value="'+image.CuisineDescription+'">';//Cuisine description
                        html += '<input type="hidden" class="CuisinePrice" value="'+image.CuisinePrice+'">';//Cuisine price
                        html += '<input type="hidden" class="CuisinePicpath" value="'+image.PicPath+'">';//Cuisine price
                        html += '<input type="hidden" class="CuisineAvaliabilityTag" value="'+image.CuisineAvaliabilityTag+'">';//Cuisine AvaliabilityTag
                        html += '<input type="hidden" class="CuisinePriceTag" value="'+image.CuisinePriceTag+'">';//Cuisine price tag
                        html += '<input type="hidden" class="CuisineTypeTag" value="'+image.CuisineTypeTag+'">';//Cuisine type tag
                        html += '<input type="hidden" class="CuisineCuisineTag" value="'+image.CuisineCuisineTag+'">';//Cuisine tag
                        html += '<input type="hidden" class="CuisineResName" value="'+image.CuisineResName+'">';//Cuisine name and its Rest Name
                        html += '<input type="hidden" class="CuResID" value="'+image.CuisineRestID+'">';//Cuisine and its Res ID
                        html += '<input type="hidden" class="CuisineRating" value="'+image.CuisineRating+'">';//Cuisine and its Res ID
                        html += '<input type="hidden" class="CuisineWhetherFavorite" value="0">';
                        html += '<input type="hidden" class="CuisineWhetherInCart" value="0">';

                    }
                    if(image.CuisinePrice!==undefined){
                    html += '<div class="TopOptions">';
                    html += '<div class="span4">';
                    html += '<h5><i class="AddedToFavorite BackgroundOfStarAndPlus fa fa-heart-o"></i></h5>';
                    html += '</div>';
                    html += '<div class="span4 blodOfPrice"><h5>$'+image.CuisinePrice+'</h5>';
                    html += '</div>';
                    html += '<div class="span4">';
                    html += '<h5><i class="AddedToCart BackgroundOfStarAndPlus fa fa-plus"></i></h5>';
                    html += '</div>';
                    html += '</div>';
                    }
                    html += '<img src="'+image.PicPath+'">';
                    if(image.CuisineName!==undefined){
                    html += '<h6 class="foodName">'+image.CuisineName+'</h6>';
                    html += '<h6 id="pic1" class="RetaurantName optionsHide">'+image.CuisineResName+'</h6>';
                    }
                    else{
                        html += '<h6 class="ResName">'+image.ResName+'</h6>';
                    }
                    html += '</li>';
                }

            }

            // Add image HTML to the page.
            $('#Imagetiles').append(html).fadeIn();

            // Apply layout.
        if(length!==0){
            applyLayout();
        }
            hoverfunction();
            if(startCount===0){
            startCount=Returncount;//after first time stratCount was used, then added returnCount that added to startCount,i.e first time startCount=0, then next time startCount=4
            }
            else{
                startCount+=startCount;//if current startCount is not first time load, then added startCount its self. startCount=4, then startCount+=startCount ====8
            }

    };

        // Capture scroll event.
        $(document).bind('scroll', onScroll);

        // Load first data from the API.
    loadData();

    function hoverfunction(){
            $('.Imagetiles li').mouseenter(function(){
                $(this).find('.foodName').removeClass('optionsHide').fadeOut(200);
                $(this).find('.RetaurantName').addClass('optionsHide').fadeIn(200);
                $(this).find('.TopOptions').slideDown();
            }).mouseleave(function(){

                    $(this).find('.foodName').addClass('optionsHide').fadeIn(200);
                    $(this).find('.RetaurantName').removeClass('optionsHide').fadeOut(200);
                    $(this).find('.TopOptions').slideUp();

                });
    }



/*****************************************Filter tags******************************************************/
$('body').on('click','.TagWidthOverflow>li',function(){//filter tages
    if($(this).hasClass('active')){
        Filter[index]= $(this).find('a').text();
    }
    else{
        Filter.splice( $.inArray($(this).find('a').text(),Filter) ,1 );
    }
    index++;
    Filter.sort();
    $('#Imagetiles').empty();
    startCount=0;
    loadData();

});


/*****************************************Operation of Cuisine********************************************/
   $('body').on('click','.Imagetiles>li',function(){//only for Feature part
       var  AjaxContainter = {};
       if($(this).find('.CuisineID')){ //if current is a li and that clicked finding that is Cuisine
           AjaxContainter['CuisineID'] = $(this).find('.CuisineID').val();
           AjaxContainter['CuisineName'] = $(this).find('.CuisineName').val();
           AjaxContainter['CuisineDesc'] = $(this).find('.CuisineDesc').val();
           AjaxContainter['CuisinePrice'] = $(this).find('.CuisinePrice').val();
           AjaxContainter['CuisinePicpath'] = $(this).find('.CuisinePicpath').val();
           AjaxContainter['CuisineAvaliabilityTag'] = $(this).find('.CuisineAvaliabilityTag').val();
           AjaxContainter['CuisineTypeTag'] = $(this).find('.CuisineTypeTag').val();
           AjaxContainter['CuisinePriceTag'] = $(this).find('.CuisinePriceTag').val();
           AjaxContainter['CuisineCuisineTag'] = $(this).find('.CuisineCuisineTag').val();
           AjaxContainter['CuisineResName'] = $(this).find('.CuisineResName').val();
           AjaxContainter['CuResID'] = $(this).find('.CuResID').val();
           AjaxContainter['CuisineRating'] = $(this).find('.CuisineRating').val();
           AjaxContainter['CuisineWhetherInCart'] = $(this).find('.CuisineWhetherInCart').val();
           AjaxContainter['CuisineWhetherFavorite'] = $(this).find('.CuisineWhetherFavorite').val();
           AjaxofCuisinePage(AjaxContainter);
       }
       if($(this).find('.RestID')){
         //  console.log($(this).find('.RestID').val());
       }





   });




function AjaxofCuisinePage(AjaxContainter){//pass cuisine only
    $('#FeathuredInterface').fadeOut();
    $('#Featured').fadeIn().append('<div class="ajax-order-loading" style="padding-top:50px;padding-bottom:50px;text-align:center"><img src="'+CurrentDomain+'/assets/framework/img/ajax-loader.gif">');
    var request = $.ajax({
        url: CurrentDomain+"/Cuisine-detail.php",
        type: "POST",
        data:AjaxContainter,
        dataType: "html"
    });
    request.done(function( msg ) {

        if(msg){
            $('.ajax-order-loading').remove();
            $(msg).fadeIn().appendTo('#Featured');
            $.scrollTo('#ScrollTopPosition',1000);
            $('.left-position').fadeIn();

        }

    });

    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });



}





/********************************************other operation**********************************************/
var isPurchaes=false;
var CurrentLoginUser= $('#CurrentLoginedUserID').val();
//initial total price
$('.price>h2').text('$'+parseFloat($('.Delivery_Margin').text()).toFixed(2));


    $('body').on('click','.left-position',function(){
    if($(this).css('display')==='block'){
        $(this).hide();
        $('#Cuisine-Detail-page').remove();
        $('#FeathuredInterface').fadeIn();
        $('#Imagetiles').trigger('refreshWookmark');

    }

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

//check the cart
    function checkCart(RequesedCuisineID){
        //check cart first, if arelad have this cuisine, then return true;

        var tmpArray=new Array();
        $('.sendCuisineID').each(function(index){ tmpArray.push($(this).val()); });
        tmpArray.sort();
        for(var i=0; i<tmpArray.length;i++){
            if(tmpArray[i]===RequesedCuisineID){
                return true;
            }
        }




    }
    function calculateTotalPrice(){
        var total=null;
        $('body').find('.hiddenTotalCuisinepirce').each(function(index){
            total+=parseFloat($(this).val());
        });
        total+=parseFloat($('.Delivery_Margin').text());
        $('.price>h2').empty().text('$'+total.toFixed(2));

    }

//added to favorite
    $('body').on('click','.AddedToFavorite',function(){
        if(CurrentLoginUser){
            var tmThis=$(this);
            var tmp={};
            var ThisCuisineID=$(this).parent().parent().parent().parent().find('.CuisineID').val();


            //if have this cuisine has been added as favorite
           if($(this).hasClass('fa-heart')){
           $(this).removeClass('fa-heart').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
           tmp['AddedFavorite']=0;
           tmp['CuisineID']= ThisCuisineID;
           tmp['LoginUserID']= CurrentLoginUser;
           favoriteAJax(tmp,'ToCancel');
           $(this).parent().parent().parent().parent().find('.CuisineWhetherFavorite').val("0");
           InformationDisplay('you have removed this cuisine from your favorite cart','alert-warning');

           }


          //if empty star (prepare to add this cuisine as a favorite)
           else if($(this).hasClass('fa-heart-o')){
           $(this).removeClass('fa-heart-o').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
           tmp['AddedFavorite']=1;
           tmp['CuisineID']= ThisCuisineID;
           tmp['LoginUserID']= CurrentLoginUser;
           favoriteAJax(tmp,'ToAdd');
           $(this).parent().parent().parent().parent().find('.CuisineWhetherFavorite').val("1");
           InformationDisplay('you have added a new cuisine into your favorite cart','alert-success');

           }
        }
        else{
            InformationDisplay('Sorry!, You have to login first','alert-error');
        }

    function favoriteAJax(tmp,condition){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/FrontEnd-controller/FrontEnd-controller.php",
            type: "POST",
            data: tmp,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='true' && condition==='ToAdd'){
                tmThis.empty().addClass('fa-heart');
            }
            else if(msg==='true' && condition==='ToCancel'){
                tmThis.empty().addClass('fa-heart-o');


            }
            else if(msg==='false'){
                InformationDisplay('Sorry!, Something is error to add this cuisine to your favorite','alert-error');

            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
    });
//added to cart
    $('body').on('click','.AddedToCart',function(e){
    if(CurrentLoginUser){// see whether have login or not
        var CuisineID = $(this).parent().parent().parent().parent().find('.CuisineID').val();
        var CurrentRestID= $(this).parent().parent().parent().parent().find('.CuResID').val();
        var CuisineName = $(this).parent().parent().parent().parent().find('.CuisineName').val();//get current CuisineName
        var CuisinePrice = parseFloat($(this).parent().parent().parent().parent().find('.CuisinePrice').val()).toFixed(2);
        var DefaultNumber=1;
        if(checkCart(CuisineID)){
            InformationDisplay('Sorry!, You already added this Cuisine into your Order list','alert-error');
        }
        else{
            //check initial message on order list, if exeist then wipe it out
            if($('#orderTable>tbody').find('#initialOrderListSMS').length>0){
                $('#orderTable>tbody').empty();
            }

            InformationDisplay('Great!, you have successfully added a new Cuisine.','alert-success');
            if($(this).hasClass('fa-plus')){
                $(this).removeClass('fa-plus').addClass('fa-shopping-cart');
                $(this).parent().parent().parent().parent().find('.CuisineWhetherInCart').val("1");
                var TemCargo="<tr><td><div class='well well-small sendCuisineName'>"+CuisineName+"</div></td><td><h5><span class='numberPosition'><i class='plus fa fa-plus-circle'></i><i class='sendCuisineNumber'>"+DefaultNumber+"</i><i class='sub fa fa-minus-circle'></i></span></h5></td><td><span class='price'><i>$<i class='sendCuisinePrice'>"+CuisinePrice+"</i></i></span></td><td><i class='fa fa-times'></i></td><input type='hidden' class='sendCuisineID' value="+CuisineID+"><input type='hidden' class='hiddenTotalCuisinepirce' value="+CuisinePrice+"><input type='hidden' class='hiddenCuisinepirce' value="+CuisinePrice+"><input type='hidden' class='sendCuisineResID' value="+CurrentRestID+"></tr>";
                $(TemCargo).fadeIn().appendTo('#orderTable');
                calculateTotalPrice();
                //setup isPurchaes to true
                isPurchaes=true;
            }
        }

    }
        else{
        InformationDisplay('Sorry!, You have to login first','alert-error');

    }
        return false;
    });

//compare cuisineID of order list with cuisine of waterfall, if same then find restore 'AddedToCart' button
    function cancelCurrent(getCuID){
        $('body').find('.Imagetiles>li').each(function(index){
            if($(this).find('.CuisineID').val()===getCuID){
               $(this).find('.AddedToCart').removeClass('fa-shopping-cart').addClass('fa-plus');
            }
        });
    }


//remove current cuisine
    $('body').on('click','.fa-times',function(){
        $(this).parent().parent().fadeOut(300, function() {
            $(this).remove();
            calculateTotalPrice();
            if($('#orderTable>tbody>tr').length===0){
                $('#orderTable>tbody').append('<tr id="initialOrderListSMS"><td style="color:#c09853">There is nothing yet~~</td></tr>');

                isPurchaes=false;

            }


        });//remove current cuisine from order list
        var getCuID=$(this).parent().parent().find('.sendCuisineID').val();
        cancelCurrent(getCuID);

    });


//plus fucntion
    $('body').on('click','.plus',function(){
       var GetSinglePrice=parseFloat($(this).parent().parent().parent().parent().find('.hiddenCuisinepirce').val());//get hidden price first
       var CalPrice=parseFloat($(this).parent().parent().parent().parent().find('.sendCuisinePrice').text());//get displayed price

        var defaultCount=parseInt($(this).parent().find('.sendCuisineNumber').text());//get count
       $(this).parent().find('.sendCuisineNumber').text(defaultCount+1);//set up count
       $(this).parent().parent().parent().parent().find('.sendCuisinePrice').text(parseFloat((defaultCount+1)*GetSinglePrice).toFixed(2));//computing total price
       $(this).parent().parent().parent().parent().find('.hiddenTotalCuisinepirce').val(parseFloat((defaultCount+1)*GetSinglePrice).toFixed(2));
        calculateTotalPrice();
    });

//sub function
    $('body').on('click','.sub',function(){
        var defaultCount=parseInt($(this).parent().find('.sendCuisineNumber').text());//get count
        if(Math.abs(defaultCount)>1){
            $(this).parent().find('.sendCuisineNumber').text(defaultCount-1);
            var GetSinglePrice=parseFloat($(this).parent().parent().parent().parent().find('.hiddenCuisinepirce').val());//get hidden price first
            var CalPrice=parseFloat($(this).parent().parent().parent().parent().find('.sendCuisinePrice').text());//get displayed price
            $(this).parent().parent().parent().parent().find('.sendCuisinePrice').text(parseFloat((defaultCount-1)*GetSinglePrice).toFixed(2));//computing total price
            $(this).parent().parent().parent().parent().find('.hiddenTotalCuisinepirce').val(parseFloat((defaultCount-1)*GetSinglePrice).toFixed(2));
            calculateTotalPrice();
        }
    });

/**************************************************Check out**************************************************/
$('body').on('click','.checkOut',function(){

    if($('#orderTable>tbody').find('#initialOrderListSMS').length===0 && isPurchaes===true && $('input[name=optionsRadios]:checked').val()!==''){
        //pass the check data
        var parentRaidoSelected=$('input[name=optionsRadios]:checked').parent().parent();
        /*CurrentUserID*/
        var CurrentUserID=$('#CurrentLoginedUserID').val();
        /*Selected Address*/
        var AddressUserID=parentRaidoSelected.find('AddreUserID').val();
        var AddressNickName=parentRaidoSelected.find('AddreNickName').val();
        var AddressPhone= parentRaidoSelected.find('AddrePhone').val();
        var Address=$('input[name=optionsRadios]:checked').val();


        InformationDisplay('Operation is successful, please waiting for jump!','alert-success');
        $('.checkOut>h5').text('Wait..');
        setTimeout(function(){window.location.href=CurrentDomain+'/order-check.php'},2000)
    }
    else{
        InformationDisplay('You have to choose at least one of cuisines as well as one of shipping addresses! ','alert-error');
    }




});



//prevent parent opertation
    $('body').on('click','.TopOptions',function(e){return false;});


});


