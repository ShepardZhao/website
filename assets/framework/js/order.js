/**
 * Created by zhaoxun321 on 3/11/2013.
 */
$(document).ready(function(){
    /**
     * return current userID and cuisineID are having the postive status of Favorite
     */
    window.isJson = function(obj){
        var isjson = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
        return isjson;
    }

    window.ReturnFavoriteStauts = function (userID,cuisineID){
        var tmpstring = userID + '_' + cuisineID;
        return comparedfavorite(tmpstring);
    }

    window.jumpAnimate = function (ClassOID){
        //added cuisine count for current user
        var CountOfCuisine = parseInt($('.OrderNumberDisplay').text(), 10);
        $('.OrderNumberDisplay').text(CountOfCuisine+1);
        $(ClassOID).animate({top: "-20px"}, 500,function(){
            $(this).animate({top:"20px"},500,function(){
                $(this).animate({top:"0"},500);
            });

        });
    }


    window.pushItemIntoBottomSlide = function (ParentNode){
        var showpic = ParentNode.find('.CuisinePicpath').val();
        var showname = ParentNode.find('.CuisineName').val();
        var showRestaruantName = ParentNode.find('.CuisineResName').val();
        var showprice = ParentNode.find('.CuisinePrice').val();
        $('.AddedNewItem').empty();
        $('<div class="row-fluid text-center"><div class="span2 addeditemCSS"><img src="'+showpic+'" class="img-polaroid"></div><div class="span4 addeditemCSS">'+showname+'</div><div class="span4 addeditemCSS">Made by '+showRestaruantName+'</div><div class="span2 addeditemCSS">$'+showprice+'</div></div>').appendTo($('.AddedNewItem'));

        InformationDisplay('you have added a new cuisine into your shopping cart!','alert-success');

    }

    /**
     * function that passes the paramters to database
     */
    window.passTemper = function(p){
        var status = false;
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:p,
            success:function(data) {
               if (data.sucess === 1){
                   status = true;
               }
               if(data.update ===1){
                   status = true;
               }
            }
        });

        return status;

    }



    /**
     * WithoutSeoncdLevel
     * @param GetThis
     * @param GetTmp
     * @param ParentNode
     * @constructor
     */

     window.WithoutSeoncdLevel = function(GetThis,GetTmp,ParentNode){
        if (passTemper(GetTmp)){
            jumpAnimate('.OrderNumberDisplay');
            DeliverFeeCaul();
            TotalFeeCalculate();
            if($('.AddedNewItem').css('display') === 'block'){
                $('.AddedNewItem').slideUp("slow",function(){
                    $(this).empty();
                    pushItemIntoBottomSlide(ParentNode);
                    $(this).slideDown("slow").fadeIn();

                });
            }
            else{
                pushItemIntoBottomSlide(ParentNode);
                $('.AddedNewItem').slideDown("slow").fadeIn();

            }
            GetThis.empty().addClass('fa-plus');

            setTimeout(function(){$('.AddedNewItem').slideUp('slow').fadeOut();},5000);
        }
        else{
            InformationDisplay('Sorry!, Purchase process has been halted','alert-error');

        }
    }





    /**
     * pass the parmaters to the below function that can be processed by the modal
     * @param tmp
     * @constructor
     */
    window.SecondLevelPassFunction = function(tmp,ParentNode){
        var result = decodeURIComponent($.param(tmp));

        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/CuisineSecondLevelModal.php?'+result, '', function(){
                $modal.modal();
            });
        }, 1000);


        $modal.on('click', '.SecondLevelRadioChoice', function(){
            var getParentNode = $(this).parent();
            var GetName = getParentNode.find('.ChoosenName').text();
            var GetPrice = getParentNode.find('.ChoosenPrice').text();
        });

        $modal.on('click', '.SecondLevelCheckbox', function(){
            var getParentNode = $(this).parent();
            var GetName = getParentNode.find('.ChoosenName').text();
            var GetPrice = getParentNode.find('.ChoosenPrice').text();
        });



        $modal.on('click','.PreAddedToChart',function(){
            var getParentNode = $(this).parent().parent();
            var tmp = {};
            tmp['TempOrder'] = 'TempOrder';
            tmp['CurrentCuisineID'] = getParentNode.find('.CurrentCuisineID').val();
            tmp['CurrentUserID'] = CurrentLoginUser;
            tmp['CurrentResID'] = getParentNode.find('.CurrentResID').val();
            tmp['CurrentCuisinePicPath'] = getParentNode.find('.CurrentCuisinePicPath').val();
            tmp['CurrentCuisineName'] = getParentNode.find('.CurrentCuisineName').val();
            tmp['CurrentCuisinePrice'] = parseFloat(getParentNode.find('.CurrentCuisinePrice').val()) + parseFloat(calculatePriceIncludingSecondLevel());
            tmp['CurrentCuisineSecondLevel'] = returnSecondLevel();

            executeAddFunctionWithSecondLevel(tmp,ParentNode);
        });


        function executeAddFunctionWithSecondLevel(tmp,ParentNode){
            if (passTemper(tmp)){
                jumpAnimate('.OrderNumberDisplay');
                DeliverFeeCaul();
                TotalFeeCalculate();
                if($('.AddedNewItem').css('display') === 'block'){

                    $('.AddedNewItem').slideUp("slow",function(){
                        $(this).empty();
                        pushItemIntoBottomSlide(ParentNode);
                        $(this).slideDown("slow").fadeIn();

                    });
                }
                else{
                    pushItemIntoBottomSlide(ParentNode);
                    $('.AddedNewItem').slideDown("slow").fadeIn();

                }
                $('#ajax-modal').modal('hide');
                setTimeout(function(){
                    $( '.modal' ).remove();
                    $( '.modal-backdrop' ).remove();
                    $( '.modal-scrollable').remove();
                    $( 'body' ).removeClass( "modal-open" );
                },2000);

                setTimeout(function(){
                    $('.AddedNewItem').slideUp('slow').fadeOut();
                },3000);


            }
        }




        function calculatePriceIncludingSecondLevel(){
            var price = null;
            $('.SecondLevelRadioChoice:checked').each(function(){
                price +=parseFloat($(this).parent().find('.ChoosenPrice').text());
            });

            $('.SecondLevelCheckbox:checked').each(function(){
                price +=parseFloat($(this).parent().find('.ChoosenPrice').text());
            });

            return price;
        }




        function returnSecondLevel(){
            var secondlevel = {};

            $('.SecondLevelRadioChoice:checked').each(function(){
                secondlevel[$(this).parent().find('.ChoosenName').text()] = $(this).parent().find('.ChoosenPrice').text();
            });

            $('.SecondLevelCheckbox:checked').each(function(){
                secondlevel[$(this).parent().find('.ChoosenName').text()] = $(this).parent().find('.ChoosenPrice').text();
            });

            return secondlevel;
        }


    }

    /**
     *  Javascript time function
     */
    window.returnDateFunction = function () {
        var getDate = new Date();
        var TheDayOfweek=getDate.getDay()
        if ( TheDayOfweek === 0){
            return 'Sunday';
        }
        else if ( TheDayOfweek === 1){
            return 'Monday';
        }
        else if ( TheDayOfweek === 2){
            return 'Tuesday';
        }
        else if ( TheDayOfweek === 3){
            return 'Wednesday';
        }
        else if ( TheDayOfweek === 4){
            return 'Thursday';
        }
        else if ( TheDayOfweek === 5){
            return 'Friday';
        }
        else if ( TheDayOfweek === 6){
            return 'Saturday';
        }
    }


    /*CurrentUserID*/
    window.CurrentLoginUser=$('#CurrentLoginedUserID').val();

  /*************************************Intialization**************************************************/

    var array = new Array();
    favoriteArray();
    function favoriteArray (){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:{FavoriteStatus:'FavoriteStatus'},
            success:function(data) {
                array = data;
            }
        });
    }


    function comparedfavorite(tmpstring){

        for (var x=0;x<array.length;x++ ){
            if(tmpstring === array[x].UserID_CuID){
                return 'true';
            }


        }
    }
    /**
     * tab switch from Feathured to Dishes
     */
    $('body').on('click','.tabMain>li',function(){
        if($(this).length>0){
            $('body').modalmanager('loading');
        }
    });

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


 /*******************************************check list initialization************************************/
 DeliverFeeCaul();
 TotalFeeCalculate();



/********************************************other operation**********************************************/
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



//added to favorite with cuisine main area
    $('body').on('click','.AddedToFavoriteOfDetail',function(){
        if(CurrentLoginUser){
            var tmThis=$(this);
            var tmp={};
            var ThisCuisineID=$('#GetCurrentCuID').val();


            //if have this cuisine has been added as favorite
            if($(this).hasClass('fa-heart')){
                $(this).removeClass('fa-heart').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
                tmp['AddedFavorite']=0;
                tmp['CuisineID']= ThisCuisineID;
                tmp['LoginUserID']= CurrentLoginUser;
                favoriteAJax(tmThis,tmp,'ToCancel');

            }


            //if empty star (prepare to add this cuisine as a favorite)
            else if($(this).hasClass('fa-heart-o')){
                $(this).removeClass('fa-heart-o').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
                tmp['AddedFavorite']=1;
                tmp['CuisineID']= ThisCuisineID;
                tmp['LoginUserID']= CurrentLoginUser;
                favoriteAJax(tmThis,tmp,'ToAdd');

            }
        }
        else{
            InformationDisplay('Sorry!, You have to login first','alert-error');
        }




    });



//added to favorite with wafterfall area
    $('body').on('click','.AddedToFavoriteInWaterfall',function(){
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
           favoriteAJax(tmThis,tmp,'ToCancel');

           }


          //if empty star (prepare to add this cuisine as a favorite)
           else if($(this).hasClass('fa-heart-o')){
           $(this).removeClass('fa-heart-o').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
           tmp['AddedFavorite']=1;
           tmp['CuisineID']= ThisCuisineID;
           tmp['LoginUserID']= CurrentLoginUser;
           favoriteAJax(tmThis,tmp,'ToAdd');

           }
        }
        else{
            InformationDisplay('Sorry!, You have to login first','alert-error');
        }
    });

    function favoriteAJax(tmThis,tmp,condition){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data: tmp,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='true' && condition==='ToAdd'){
                tmThis.empty().addClass('fa-heart');
                InformationDisplay('you have added a new cuisine into your favorite cart','alert-success');

            }
            else if(msg==='true' && condition==='ToCancel'){
                tmThis.empty().addClass('fa-heart-o');
                InformationDisplay('you have removed this cuisine from your favorite cart','alert-warning');



            }
            else if(msg==='false'){
                InformationDisplay('Sorry!, Something is error to add this cuisine to your favorite','alert-error');

            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }



//compare cuisineID of order list with cuisine of waterfall, if same then find restore 'AddedToCart' button
    function cancelCurrent(getCuID){
        $('body').find('.Imagetiles>li').each(function(index){
            if($(this).find('.CuisineID').val()===getCuID){
               $(this).find('.AddedToCart').removeClass('fa-shopping-cart').addClass('fa-plus');
            }
        });
    }




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

    if(parseInt($('.OrderNumberDisplay').text(),10)!==0 && $('input[name=optionsRadios]:checked').val()!==''){

        var passContainter = {};
        //pass the check data
        var parentRaidoSelected=$('input[name=optionsRadios]:checked').parent().parent();
        /*Selected Address*/
        var AddressUserID=CurrentLoginUser;
        var AddressNickName=parentRaidoSelected.find('.AddreNickName').val();
        var AddressPhone= parentRaidoSelected.find('.AddrePhone').val();
        var Address=$('input[name=optionsRadios]:checked').val();
        var RootID = $('#RootID').val();
        var SubID = $('#SubID').val();
        var Token = Math.round((new Date()).getTime() / 1000);
        passContainter['UID'] = AddressUserID;
        passContainter['RootID'] = RootID;
        passContainter['SubID'] = SubID;
        passContainter['AddressNickName'] = AddressNickName;
        passContainter['UserNickName'] = $('.LoginedIn').text();
        passContainter['AddressPhone'] = AddressPhone;
        passContainter['Address'] = Address;
        passContainter['Token'] = Token;
        InformationDisplay('Operation is successful, please waiting for jump!','alert-success');
        $('.checkOut>h5').empty().text('Wait..');
        $('body').modalmanager('loading');
        var result = decodeURIComponent($.param(passContainter));

        setTimeout(function(){

            window.location.href=CurrentDomain+'/order-check?'+result;


        },2000)
    }
    else{
        InformationDisplay('You have to choose at least one of cuisines as well as one of shipping addresses! ','alert-error');
    }

});


/****************************************visit my shopping cart****************************************************/
    var switchOfChart = false;
    $('body').on('click','.vshopingcart',function(){

        if(switchOfChart === false){
            switchOfChart = true;
        var tmps = {};
        var element_width = $('.VPurchaseItems').width();
        var element_left =  $('.VPurchaseItems').position().left;
        $('.closeShoppingCart').fadeIn();
        $(".VPurchaseItems").css({left:element_left })  // Set the left to its calculated position
            .animate({"left": (element_left - element_width + 20) + "px"}, 1000);
        tmps['FetchTempOrderItems'] = 'FetchTempOrderItems';
        tmps['CurrentUserID'] = CurrentLoginUser;
        LoadingTempItems(tmps);
        }

    });

    $('body').on('click','.closeShoppingCart',function(){
        switchOfChart = false;
        var element_width = $('.VPurchaseItems').width();
        var element_left =  $('.VPurchaseItems').position().left;
        $(".VPurchaseItems").css({left:element_left})  // Set the left to its calculated position
            .animate({"left":(element_left + element_width - 20) + 'px'}, 1000,function() {
                $('.VPurchaseItemsInner').empty();
                $('.closeShoppingCart').fadeOut();
                restCountNumber();
                DeliverFeeCaul();
                TotalFeeCalculate();
            });



    });




    function LoadingTempItems(tmps){
        $('.Item-loading').fadeIn();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:tmps,
            success: FetchItems
        });
    };


    function FetchItems(data){
        $('.Item-loading').fadeOut();
        var html = '';
        var i=0, length=data.length, items;
        for(; i<length; i++) {
            items = data[i];
        html +='<table class="table table-hover">';
        html +='<tr>';
        html +='<td style="width:150px"><img src="'+items.Temp_OrderCuPicPath+'" class="img-polaroid"></td>';
        html +='<td style="width:200px">'+items.Temp_OrderCuName+'</td>';
        html +='<td style="width:150px">';
        html +='<b>Configuration: </b>';
        if(isJson(items.Temp_OrderCuSecondLevel)){

            $.each(items.Temp_OrderCuSecondLevel, function(k, v) {
                html +='<br><small>'+k+'('+v+')</small>';

            });
        }
        else{
            html +='<samll>'+items.Temp_OrderCuSecondLevel+'</small>';
        }

        html +='</td>';
        html +='<td style="width:150px;text-align:center"><i>$<b class="ItemPrice">'+parseFloat(items.Temp_OrderCuPrice).toFixed(2)+'</b></i></td>';
        html +='<td style="width:90px" class="countPosition"><i class="fa fa-caret-up countPosition-top"></i><i class="fa fa-caret-down countPosition-down"></i><span class="Temp_OrderCuCount">'+items.Temp_OrderCuCount+'</span></td>';
        html +='<td><input type="hidden" class="tempOrderID" value="'+items.Temp_OrderID+'"><input type="hidden" class="singlePrice" value="'+parseFloat(items.Temp_OrderCuPrice).toFixed(2)/items.Temp_OrderCuCount+'"><input type="hidden" class="TempOrderID" value="'+items.Temp_OrderID+'"><i class="fa fa-times TempOrderItemCancel"></i></td>';
        html +='</tr>';
        html +='</table>';

        }

        $(html).hide().fadeIn(1000).appendTo($('.VPurchaseItemsInner'));
        caculateTotalPrice();

    };


    function caculateTotalPrice(){
        if($('.ItemPrice').length >0){
        var Totalprice = null;
        $('.ItemPrice').each(function(){
            Totalprice += parseFloat($(this).text());
        });
        $('.TempItemsPrice>h4').empty().append('Total:<i>$'+parseFloat(Totalprice).toFixed(2)+'</i>').hide().fadeIn(1000);
        }
        else{
            $('.TempItemsPrice>h4').empty().append('Total:<i>$'+parseFloat(0).toFixed(2)+'</i>').hide().fadeIn(1000);

        }
    }

    function restCountNumber(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:{resetCountNumber:'resetCountNumber',CurrentUserID:CurrentLoginUser},
            success: finishedFunction

        });
    }

    function finishedFunction(data){
        if (data !== null){
            jumpAnimate('.OrderNumberDisplay');
            $('.OrderNumberDisplay').empty().text(parseInt(data,10));
        }
        else{
            jumpAnimate('.OrderNumberDisplay');
            $('.OrderNumberDisplay').empty().text(0);
        }

    };



    /***************************************added new temp item*********************************************************/
    var SecondContainter = {};

    /**
     *Added current item into the temp shopping cart
     */

    $('body').on('click','.AddedToCart',function(){
        if(CurrentLoginUser!==''){
            // get current parent node
            var tmp = {};
            var ParentNode = $(this).parent().parent().parent().parent();
            if(ParentNode.find('.CurrentCuisineStatus').val() === 'UnAvailability'){
                InformationDisplay('Sorry!, Currently, The status of this cuisine is UnAvailabile, plese visit this page later','alert-error');
            }
            else{
                tmp['TempOrder'] = 'TempOrder';
                tmp['CurrentCuisineID'] = ParentNode.find('.CuisineID').val();
                tmp['CurrentUserID'] = CurrentLoginUser;
                tmp['CurrentResID'] = ParentNode.find('.CuResID').val();
                tmp['CurrentCuisineName'] = ParentNode.find('.CuisineName').val();
                tmp['CurrentCuisinePicPath'] = ParentNode.find('.CuisinePicpath').val();
                tmp['CurrentCuisinePrice'] = ParentNode.find('.CuisinePrice').val();

                if(ParentNode.find('.secondLevel').text().length>0){
                    tmp['CurrentCuisineSecondLevel'] = ParentNode.find('.secondLevel').text();
                    SecondLevelPassFunction(tmp,ParentNode);
                }
                else{
                    tmp['CurrentCuisineSecondLevel'] = 'Empty';
                    WithoutSeoncdLevel($(this),tmp,ParentNode);
                }
            }

        }
        else{
          InformationDisplay('Sorry!, You have to login first','alert-error');
            }



    });









/****************************************cancel current Temp item**************************************************/
    $('body').on('click','.TempOrderItemCancel',function(){
       var tmp = {};
       var thisparent = $(this);
       var getTempOrderID = $(this).parent().find('.TempOrderID').val();
       tmp['CancelCurrentOrderItem'] = getTempOrderID;
       cancelTempItemByAJAX(thisparent,tmp);
    });


    function cancelTempItemByAJAX(thisparent,tmp){
        $(thisparent).parent().parent().parent().parent().fadeOut(1000,function(){$(this).empty().append('<div class="row-fluid"><div class="span12 text-center"><img src="'+CurrentDomain+'/assets/framework/img/ajax-loader.gif"></div></div>');});
        $.ajax({
            type: "POST",
            dataType: "json",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:tmp,
            success:function(data) {
                if(data.Deleted === 1){
                    InformationDisplay('You have successful remove the item from your shopping chart','alert-success');
                    $(thisparent).parent().parent().fadeOut(1000,function(){$(this).remove(); caculateTotalPrice();});
                    //recaculate the price
                }
            }
        });
    }



/****************************************Change the count***********************************************************/
    //clicked to plus one
    $('body').on('click','.countPosition-top',function(){
       var CurrentTempOrderID_plus = $(this).parent().parent().find('.TempOrderID');
       //change the count only with plus one
        _changedCountOfTempOrder_plus($(this));
       //Change the price only
        _chagnePriceOnly($(this),'plus');
       //caculate the total price
        caculateTotalPrice();
       //save the data in temp table that's in databse
        _changeItInDB($(this).parent().parent().find('.tempOrderID').val(),$(this).parent().parent().find('.Temp_OrderCuCount').text(),$(this).parent().parent().find('.ItemPrice').text());

    });


    //clicked to sub one
    $('body').on('click','.countPosition-down',function(){
     var CurrentTempOrderID_down = $(this).parent().parent().find('.TempOrderID');
       //change the count only with sub one
        _changedCountOfTempOrder_sub($(this));
       //change the price only
        _chagnePriceOnly($(this),'sub');
        //caculate the total price
        caculateTotalPrice();
        //save the data in temp table that's in databse
        _changeItInDB($(this).parent().parent().find('.tempOrderID').val(),$(this).parent().parent().find('.Temp_OrderCuCount').text(),$(this).parent().parent().find('.ItemPrice').text());

    });


    function _changedCountOfTempOrder_plus(Getthis){
        //get target count
        var _useGetThisCount =  Getthis.parent().parent().find('.Temp_OrderCuCount').text();
        //new target count
        var _setUpNewCountForTarget = parseInt(_useGetThisCount,10) + 1;
        //reset target count
        Getthis.parent().parent().find('.Temp_OrderCuCount').text(_setUpNewCountForTarget);

    }


    function _changedCountOfTempOrder_sub(Getthis){
        //get target count
        var _GetTargetCount = Getthis.parent().parent().find('.Temp_OrderCuCount').text();
        if((parseInt(_GetTargetCount,10) -1 )<0 || (parseInt(_GetTargetCount,10) -1 ) === 0){

            }
        else{
            var _SetUPnewTargetCount = parseInt(_GetTargetCount,10) - 1;
            Getthis.parent().parent().find('.Temp_OrderCuCount').text(_SetUPnewTargetCount);
        }

    }


    function _chagnePriceOnly(GetThis,condition){
        var _GetTargetPrice = GetThis.parent().parent().find('.ItemPrice').text();
        var _GetTargetCount = GetThis.parent().parent().find('.Temp_OrderCuCount').text();
        var _GetTargeSignPrice = GetThis.parent().parent().find('.singlePrice').val();
        //new price for current cuisine
        if(condition === 'plus'){
            var value_plus = parseFloat(_GetTargeSignPrice * _GetTargetCount).toFixed(2);
            GetThis.parent().parent().find('.ItemPrice').empty().text(value_plus);
        }
        else if(condition === 'sub'){
            var value_sub = parseFloat(_GetTargeSignPrice * _GetTargetCount).toFixed(2);
            GetThis.parent().parent().find('.ItemPrice').empty().text(value_sub);
        }


    }


    function _changeItInDB(tempOrderID,NewCount,NewPrice){
        $.ajax({
            type: "POST",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:{updateCurrentOrder:'yes',tempOrderID:tempOrderID,NewCount:NewCount,NewPrice:NewPrice},
            error:function(jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );

            }
        });
    }


/****************************************Total fee calculation******************************************************/
function TotalFeeCalculate(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
        data:{GetSumPrice:'yes',CurrentUserID:CurrentLoginUser},
        success:function(data) {
            if(data.success === 1) {
                $('.price>h2').fadeOut(1000,function(){
                    $(this).empty();
                    var a = parseFloat(data.result);
                    var b = parseFloat($('.Delivery_Margin').text());
                    if(parseInt($('.OrderNumberDisplay').text(),10) === 0){
                    var c = 0;
                    }
                    else {
                    var c = a + b;
                    }
                    $(this).text('$'+ parseFloat(c).toFixed(2) ).fadeIn(1000);
                });
            }
        },
        error:function(jqXHR, textStatus){
            alert( "Request failed: " + textStatus );

        }
    });

}

/****************************************delivery fee calculation***************************************************/

function DeliverFeeCaul(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
        data:{DeliverCondition:'yes', CurrentUserID:CurrentLoginUser},
        success:function(data) {
            if(data.ReturnedDeliveryFee === 1){
                $('.Delivery_Margin').fadeOut(1000,function(){
                    $(this).empty();
                    $(this).text(' '+ parseFloat(data.finalDeliverFee).toFixed(2)).fadeIn(1000);
                });
            }
        }
    });
}

/****************************************Other operation***********************************************************/
//prevent parent opertation
    $('body').on('click','.TopOptions',function(e){return false;});
//display the serach control
    $('#searchParent').fadeIn();


});


