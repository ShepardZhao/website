
$(document).ready(function(){
  /*************************************** gobal function *****************************************/
    /**
     * isJson function
     * @param obj
     * @returns {boolean}
     */
   var isJson = function(obj){
        var isjson = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
        return isjson;
    }
    var CurrentLoginUser = $('.UserID').val();







 /************************************** Fetch Items ********************************************/


 var tmps = {};
    tmps['FetchTempOrderItems'] = 'FetchTempOrderItems';
    tmps['CurrentUserID'] = CurrentLoginUser
    _LoadingOrderItems(tmps);

    function _LoadingOrderItems(tmps){
        $('.Item-loading').fadeIn();
        $.ajax({
         type: "POST",
         dataType: "json",
         url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
         data:tmps,
         success: _FetchOrderItems
        });
    };


    function _FetchOrderItems(data){
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

        $(html).hide().fadeIn(1000).appendTo($('.OrderItems'));
        $('<hr id="hr-zone" style="width:100%;border-top: 1px solid #ccc;">').hide().fadeIn(1000).appendTo($('.OrderItems'));
        $('<div class="text-right" style="margin-top:9px;"><i>Delivery Fee: $<b><span id="Final-deliverFee"></span></b></i></div>').hide().fadeIn(1000).appendTo($('.OrderItems'));
        DeliverFeeCaul();
        $('<div class="text-right" id="TotalPrice-order"><h4></h4></div>').appendTo($('.OrderItems'));
        TotalFeeCalculate();
    };


    /****************************************delivery fee calculation***************************************************/

    function DeliverFeeCaul(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            data:{DeliverCondition:'yes', CurrentUserID:CurrentLoginUser},
            success:function(data) {
                if(data.ReturnedDeliveryFee === 1){
                    $('#Final-deliverFee').fadeOut(500,function(){
                        $(this).empty();
                        $(this).text(' '+ parseFloat(data.finalDeliverFee).toFixed(2)).fadeIn(500);
                    });
                }
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
                console.log(data);
                if(data.success === 1) {
                    $('#TotalPrice-order>h4').fadeOut(500,function(){
                        $(this).empty();
                        var a = parseFloat(data.result);
                        var b = parseFloat($('#Final-deliverFee').text());
                        var c = a + b;
                        $(this).text('Total Fee: $ '+ parseFloat(c).toFixed(2)).fadeIn(500);
                    });
                }
            },
            error:function(jqXHR, textStatus){
                alert( "Request failed: " + textStatus );

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
        //save the data in temp table that's in databse
        _changeItInDB($(this).parent().parent().find('.tempOrderID').val(),$(this).parent().parent().find('.Temp_OrderCuCount').text(),$(this).parent().parent().find('.ItemPrice').text());
        //caculate the total price
        TotalFeeCalculate();

    });


    //clicked to sub one
    $('body').on('click','.countPosition-down',function(){
        var CurrentTempOrderID_down = $(this).parent().parent().find('.TempOrderID');
        //change the count only with sub one
        _changedCountOfTempOrder_sub($(this));
        //change the price only
        _chagnePriceOnly($(this),'sub');
        //save the data in temp table that's in databse
        _changeItInDB($(this).parent().parent().find('.tempOrderID').val(),$(this).parent().parent().find('.Temp_OrderCuCount').text(),$(this).parent().parent().find('.ItemPrice').text());
        //caculate the total price
        TotalFeeCalculate();

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
                    TotalFeeCalculate();

                }
            }
        });
    }








/*************************************** final check function ***********************************/
    $('body').on('click','.Finalcheck',function(){
        if(NecessaryCheck()){
            console.log('all done');
            //then do the following thing
        }
        else{
            InformationDisplay('Sorry!, you have to fill and select adaptive section ','alert-error');
            //jump error SMS

        }

    });



    //Preferred Delivery Time:

    $('body').on('click','.perfectDeliveryTime',function(){
        if($("input[name='perfectDeliveryTime']").eq(0).is(':checked')){
            $("input[name='perfectDeliveryTime']").eq(1).parent().find('.times-picker').val('');
            $("input[name='perfectDeliveryTime']").eq(1).parent().find('.date-picker').val('');
        }
    });



    $('body').on('click','.times-picker',function(){
        $(this).parent().parent().find('.perfectDeliveryTime').removeAttr('checked').prop('checked',true);
    });

    $('body').on('click','.date-picker',function(){
        $(this).parent().parent().find('.perfectDeliveryTime').prop('checked',true);


    });




/**************************************** necessary payment check *****************************/

    $('body').on('click','#saveAsDefaultCheckbox',function(){
        if($(this).is(':checked') && NecessaryCheck()){
            CheckPaymentAddressSettingUp(ReturnTmpOfDefaultAddress());
        }

    });


    function ReturnTmpOfDefaultAddress(){
        var tmp = {};
        var niceName = $('#input_NameNecessay').val();
        var detalAddress = $('#input_DetailAddress').val();
        var phoneNumber = $('#input_phoneNumber').val();
        var userID = $('.UserID').val();
        var status = 1;
        var completeAddress = detalAddress + ', ' + $('#Necessary_address_zone').text();

        tmp['PaymentAddressSet'] = completeAddress;
        tmp['PaymentNiceName'] = niceName;
        tmp['PaymentNumber'] = phoneNumber;
        tmp['PaymentUserID'] = userID;
        tmp['PaymentSetDefaultStatus'] = status;
        return tmp;

    }



    function CheckPaymentAddressSettingUp(data){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: 'html'
        });

        request.done(function( msg ) {
            if(msg === 'Repeated Addressbook'){
                InformationDisplay('Sorry!, Repeated Addressbook!','alert-error');
                $('#saveAsDefaultCheckbox').prop('checked',false);
            }
            if(msg === 'ok'){
                InformationDisplay('Successed!, Current address has been set up as default address that you may use it after later login','alert-success');
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }

    function NecessaryCheck(){
        if(ReturnNecessary_address_zone($('#Necessary_address_zone>i').text())){
            InformationDisplay('Sorry!, The delivery address is emppty, please making sure that you have correct purchaes porcess. ','alert-error');
        }
        else if(ReturnNecessary_address_zone($('#input_NameNecessay').val())){
            InformationDisplay('Sorry!, you have to fill the contact name ','alert-error');
        }
        else if(ReturnNecessary_address_zone($('#input_DetailAddress').val())){
            InformationDisplay('Sorry!, you have to type the detaill address then we can delivery to ','alert-error');
        }
        else if(ReturnNecessary_address_zone($('#input_phoneNumber').val())){
            InformationDisplay('Sorry!, you have to input phone number that we can contact to ','alert-error');

        }
        else if(ReturnRadioCheck($('.perfectDeliveryTime'))){
            InformationDisplay('Sorry!, you have to choose the delivery time ','alert-error');

        }
        else if(ReturnRadioCheck($('.PaymentRadios'))){
            InformationDisplay('Sorry!, you have to choose payment method ','alert-error');

        }
        else if(!$('.OrderItems').text().length > 0){
            InformationDisplay('Sorry!, you do not have the Items in your cart ','alert-error');

        }
        else{
            return true;
        }
    }


    function ReturnNecessary_address_zone(v){
        if(v === ''){
            return true;
        }
        else{
            return false;
        }
    }



    function ReturnRadioCheck(par){
        if(!par.is(':checked')){
            return true;
        }
        else{
            return false;
        }
    }




/***************************************** Time picker block***********************************/

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var checkin = $('.date-picker').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#dpd2')[0].focus();
        }).data('datepicker');
    var checkout = $('.date-picker').datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

    $('.times-picker').timepicker();
});