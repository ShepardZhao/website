/**
 * Created by zhaoxun321 on 3/11/2013.
 */
$(document).ready(function(){
    /**
     * Selection address
     */
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

  /********************************************Gobal Hover function *******************************************************/
  window.hoverfunction = function (){
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
  /*******************************************Gobal Detail cuisine function**********************************************/
   window.AjaxofCuisinePage = function (AjaxContainter){//pass cuisine only
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
                $('#Featured').empty();
                $(msg).fadeIn().appendTo('#Featured');
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
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
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





/****************************************Other operation***********************************************************/
//prevent parent opertation
    $('body').on('click','.TopOptions',function(e){return false;});


});


