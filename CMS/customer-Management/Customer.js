$(document).ready(function(){
    CurrentLoginUser=$('#CustomerID').val();
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



    /**************************************list Favourite******************************************/
    var handler = null,
        emptyTry=0;
    index=0;
    startCount = 0,
        Filter =new Array(),
        Returncount = 4, //this will set how many records returned
        isLoading = false,
        apiURL =  CurrentDomain+'/json/?ListMyFavourite=yes&FavouriteStatus=1&UserID='+$('#CustomerID').val();
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
            success: onLoadData
        });
    };

    /**
     * Receives data from the API, creates HTML for images and updates the layout
     */
    function onLoadData(data) {
        console.log(data);

        $('#Ajax-loading').fadeOut();
        // Create HTML for the images.
        console.log(data);
        var html = '';
        var i=0, length=data.length, image;
        for(; i<length; i++) {
            image = data[i];
            if(image.PicPath.length){
                    html += '<li>';
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
                    html += '<div class="common">';
                    html += '<a class="button is-inverse has-fixed-icon">';
                    html += '<h5><i class="AddedToFavorite BackgroundOfStarAndPlus fa fa-heart"></i></h5>';
                    html += '</a>';
                    html += '</div>';
                    html += '<div class="common blodOfPrice"><h5>$'+image.CuisinePrice+'</h5>';
                    html += '</div>';
                    html += '<div class="common">';
                    html += '<h5><i class="AddedToCart BackgroundOfStarAndPlus fa fa-plus"></i></h5>';
                    html += '</div>';
                    html += '<img src="'+image.PicPath+'">';
                    html += '<h6 class="foodName">'+image.CuisineName+'</h6>';
                    var total=5;
                    var solidStars=image.CuisineRating;
                    var emptyStars=total-solidStars;
                     for (var x=0;x<solidStars;x++){
                        html += '<i class="fa fa-star"></i>';
                     }
                    for (var j=0;j<emptyStars;j++){
                        html += '<i class="fa fa-star-o"></i>';

                    }
                    html += '</li>';
                  }
            }



        // Add image HTML to the page.
        $(html).hide().fadeIn(1000).appendTo($('#Imagetiles'));

        applyLayout();
        //hoverfunction();



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
    }

    // Load first data from the API.
    loadData();

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
    $('body').on('click','.AddedToCart',function(){
        if(CurrentLoginUser){// see whether have login or not
            var CuisineID = $(this).parent().parent().parent().parent().find('.CuisineID').val();
            var CurrentRestID= $(this).parent().parent().parent().parent().find('.CuResID').val();
            var CuisineName = $(this).parent().parent().parent().parent().find('.CuisineName').val();//get current CuisineName
            var CuisinePrice = parseFloat($(this).parent().parent().parent().parent().find('.CuisinePrice').val()).toFixed(2);
            var DefaultNumber=1;
                InformationDisplay('Great!, you have successfully added a new Cuisine.','alert-success');
                if($(this).hasClass('fa-plus')){
                    $(this).removeClass('fa-plus').addClass('fa-shopping-cart');
                    $(this).parent().parent().parent().parent().find('.CuisineWhetherInCart').val("1");
                    var TemCargo="<tr><td><div class='well well-small sendCuisineName'>"+CuisineName+"</div></td><td><h5><span class='numberPosition'><i class='plus fa fa-plus-circle'></i><i class='sendCuisineNumber'>"+DefaultNumber+"</i><i class='sub fa fa-minus-circle'></i></span></h5></td><td><span class='price'><i>$<i class='sendCuisinePrice'>"+CuisinePrice+"</i></i></span></td><td><i class='fa fa-times'></i></td><input type='hidden' class='sendCuisineID' value="+CuisineID+"><input type='hidden' class='hiddenTotalCuisinepirce' value="+CuisinePrice+"><input type='hidden' class='hiddenCuisinepirce' value="+CuisinePrice+"><input type='hidden' class='sendCuisineResID' value="+CurrentRestID+"></tr>";
                    //try to save the
            }
        }
        else{
            InformationDisplay('Sorry!, You have to login first','alert-error');

        }
        return false;
    });


    /**************************************remove mybook address Ajax******************************/
    function RemoveAddressAddBookAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='Error'){
                InformationDisplay("Data Base Error","alert-error");
            }
            else{
                $('.thumbnails').empty().append(msg);
                InformationDisplay("Removed Successfully","alert-info");
            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }

    /**************************************Set Default mybook address Ajax******************************/
    function SetDeafultAddressAddBookAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='Error'){
                InformationDisplay(">Data Base Error","alert-error");
            }
            else{
                $('.thumbnails').empty().append(msg);
                InformationDisplay("Successfully sets my default address book","alert-info");
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }

    /****************************************Added mybook address Ajax*****************************/
    function AddressAddBookAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='Repeated Addressbook'){
                InformationDisplay("You already added these info to your address book","alert-error");
            }

            else if(msg==='Error'){
                InformationDisplay("Sorry, DataBase Error","alert-error");
            }
            else{
                $('.thumbnails').empty().append(msg);
                InformationDisplay("Added new info to My addressbook","alert-info");

            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }


    /****************************************proflie Ajax*****************************/
    function ProfileAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {

            if(msg==='Updated successfully'){
                InformationDisplay("Updated successfully","alert-info");
            }
            else if (msg==='Successfully added myaddressbook'){
                InformationDisplay("Added new record to your address book","alert-success");
            }
            else if(msg==='Changed password successfully'){
                InformationDisplay("Changed Password successfully","alert-success");
            }
            else if(msg==='Updated error'){
                InformationDisplay("Sorry,Updated Error","alert-error");
            }
            else if(msg==='Repeated Addressbook'){
                InformationDisplay("Sorry,You already added these info to your address book","alert-error");
            }
            else if(msg==='fail'){
                InformationDisplay("Sorry,The old password is not match to your input","alert-error");
            }
            else if(msg==='Error'){
                InformationDisplay("Sorry,The Data Base Error","alert-error");
            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }





    var GetCustomerUserID=$('#CustomerID').val();


    /***************************************Add My address book************************************/
    $('body').on('click','#AddressBookButton',function(){
        var AddNickName=$('#AddNickName').val();
        var AddPhone=$('#AddPhone').val();
        var AddAdress=$('#AddAdress').val();
        var AddSubLocation=$('#AddSubLocation').val();
        var AddRootLocation=$('#AddRootLocation').val();
        if(AddNickName===''||AddPhone==='' || AddAdress===''){
            InformationDisplay("Sorry, You have to fill all fields","alert-error");
        }
        else{
            var tmp={};
            tmp['AddNickName']=AddNickName;
            tmp['AddPhone']=AddPhone;
            tmp['AddAdress']=AddAdress+', '+AddSubLocation+', '+AddRootLocation;
            tmp['GetCustomerUserID']=GetCustomerUserID;
            AddressAddBookAJAX(tmp,'#AddressBookButton');
        }
    });



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

        ProfileAJAX(TempArray,'#BasicCustomerButton');


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
        ProfileAJAX(TempArray,'#ChangePasswordButton');
    });


    /*******************************************avatar upload**************************************/
        //cp pic into special folder and get return path

    function imageUpload(Input_Photo,dataset)
    {
        $('#submitPic').html('Submitting.....');

        $.ajaxFileUpload
        (
            {
                url:CurrentDomain+'/cms/BackEnd-controller/AjaxImage-controller.php',
                secureuri:false,
                fileElementId:Input_Photo,
                dataType: 'html',
                data:dataset,
                success: function (data, status)
                {
                    $('#submitPic').html('done');
                    var tmpPath= $('#gobalPath').val();

                    var savedPath=tmpPath+data;
                    $('#CustomerImagePath').removeClass('placeholder');
                    $('#CustomerImagePath').val(savedPath);
                    $('<img class="img-circle" src='+tmpPath+data +'>').insertAfter($('#Input_Customeravatar')).fadeIn(200);

                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )

        return false;

    }




    $('body').on('click','#submitPic',function() {
        if($("#Input_Customeravatar")[0].files[0]!==undefined){
            var file = $("#Input_Customeravatar")[0].files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileType = file.type;
            $('<label class="fileinfo">'+fileName+', '+ fileSize+' bytes FileType: ' +fileType+' </label>').insertAfter($('#submitPic')).fadeIn(200);

            var tmp={};
            tmp['Input_Photo']='Input_Customeravatar';
            tmp['Mode_UserPic']='CustomerPhoto';
            imageUpload('Input_Customeravatar',tmp);



        }
        else if($(this).html()==='done'){
            InformationDisplay("Sorry, You already submited the head photo","alert-error");
            return false;
        }
        else
        {
            InformationDisplay("Sorry, Please select file first","alert-error");
        }



    });



    //update the Photo path
    $('body').on('click','#avatarButton',function(){
        if($('#CustomerImagePath').length>0){
            var CustomerPhotoPath=$('#CustomerImagePath').val();
            var tmp={};
            tmp['GetCustomerUserID']=GetCustomerUserID;
            tmp['CustomerPhotoPath']=CustomerPhotoPath;
            tmp['Mode']='3';
            PhotoPathUpdatingAjax(tmp,'#avatarButton');

        }

        function PhotoPathUpdatingAjax(data,infoid){
            var request = $.ajax({
                url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
                type: "POST",
                data:data,
                dataType: "html"
            });

            request.done(function( msg ) {
                if(msg==='Error'){
                    InformationDisplay("Sorry, Data Base Error","alert-error");
                }
                else{
                    InformationDisplay("Sorry, Your avatar has been updated","alert-success");
                }


            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });



        }




    });


//get gobal radio id
    $('body').on('click','.radioStatus',function(){
        window.Getid=$(this).attr('id');

    });
//remove the addressbook card

    $('body').on('click','#AddressBookRemoveButton',function(){
        var TempArray={};
        TempArray['GetCustomerUserID']=GetCustomerUserID;
        TempArray['RemoveID']=Getid;
        RemoveAddressAddBookAJAX(TempArray,'.thumbnails');

    });

//Set selected addressbook as default
    $('body').on('click','#AddressBookDefaultButton',function(){

        var TempArray={};
        TempArray['GetCustomerUserID']=GetCustomerUserID;
        TempArray['SetDefault']=Getid;
        SetDeafultAddressAddBookAJAX(TempArray,'.thumbnails');


    });

});