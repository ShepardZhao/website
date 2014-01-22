/**
 * This js file is the funictional of dynamic search
 */
$(document).ready(function(){
    /**
     * initial variable
     */
    var CurrentUserID = $('#CurrentLoginedUserID').val();

    var startCount = 0,
        isLoading = false,
        FirstFetch = 1,
        limitedCount = 5;

    /**
     * Select the serach type by clicking searchDropdown
     */
    $('body').on('click','.searchDropdown>li',function(){
            $('.searchChoice>h7').text($(this).text());
    });


    /**
     * checks the key up when user relases the input key
     */
    $(document).keypress(function(e) {
        if(e.which == 13) {
                $('.searchItem').select();
                checkFilledSearchBlock();
           }
    });
    /**
     * checks the key up when user relases the input key
     */
    $('body').on('click','#searchImg',function(){
        $('.searchItem').select();
        checkFilledSearchBlock();
    });

    /**
     * checks empty of field of serach
     */
    $('body').on('keyup','.searchItem',function(){
        checkEmptySearchBlock();
    });


    /**
     * if current input function is filled then fadeIn .SearchResult
     */

    function checkFilledSearchBlock(){
        startCount = 0;
        if($('.searchItem').val() !== ''){
        $('.SearchResult').empty();
        var getWidth = $('#search').width();
        $('.SearchResult').css('width',getWidth+'px');
        sendData($('#RootID').val(),$('.searchItem').val(),$('.searchChoice>h7').text());
        $('.SearchResult').fadeIn();
        $('#close').fadeIn();
        }
    }


    /**
     * click close then closes the serach window
     */

    $('body').on('click','#close',function(){
        $('.SearchResult').fadeOut();
        $('#close').fadeOut();
    });
    /**
     * if current input function is empty then hide .SearchResult
     */
    function checkEmptySearchBlock(){
    if($('.searchItem').val() === ''){
        $('.SearchResult').fadeOut();
        $('#close').fadeOut();
    }
    }

    /**
     * Send Ajax data to query
     */
    function sendData(localtion,value,type){
    $('<div class="AjaxLoading text-center"><img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif></div>').appendTo($('.SearchResult'));
        $.ajax({
            type: "GET",
            url: CurrentDomain+'/json/?Search=yes&GetSearchLoaction='+localtion+'&GetSearchValue='+value+'&GetType='+type,//api,
            dataType: 'json',
            data:{startCount:startCount,count:limitedCount},
            success: onLoadData
        });
    }

    /**
     * Fecthing the result
     */
    function onLoadData(data){
        $('.AjaxLoading').fadeOut();
        isLoading = false;
        var html = '';
        if(data.length>0){
            isLoading = false;
            var i=0, length=data.length, type;
            for(; i<length; i++) {
                type = data[i];
                    if(type.RestID !== undefined){
                          html += '<div class="container-fluid searchResearchAaea">';

                          html += '<input type="hidden" class="RestID" value="'+type.RestID+'">';//Restaurants id
                          html += '<input type="hidden" class="ResName" value="'+type.ResName+'">';//Restaurants Name
                          html += '<input type="hidden" class="ResPicPath" value="'+type.PicPath+'">';//Restaurants PicPath
                          html += '<input type="hidden" class="ResAvailabilityTags" value="'+type.AvailabilityTags+'">';//Restaurants AvailabilityTags
                          html += '<input type="hidden" class="ResCuisineTags" value="'+type.CuisineTags+'">';//Restaurants CuisineTags
                          html += '<input type="hidden" class="ResTotalComments" value="'+type.TotalComments+'">';//Restaurants comments
                          html += '<input type="hidden" class="ResOpenTime" value='+JSON.stringify(type.ResOpenTime)+'>';//Restaurants ResOpenTime
                          html += '<input type="hidden" class="ResRating" value="'+type.ResRating+'">';//Restaurants ResRating
                          html += '<div class="row-fluid" style="max-height:60px; padding-top:9px;padding-bottom:9px">';
                          html += '<div class="clickwrap">';
                          html += '<div class="span1">';
                          html += '<img src="'+type.PicPath+'" class="img-polaroid">';
                          html += '</div>';
                          html += '<div class="span2">';
                          html +=  type.ResName;
                          html += '</div>';
                          html += '<div class="span4">';
                          html += '<ul class="nav">';
                          for (var x=0;x<type.AvailabilityTags.length;x++){
                              html += '<li class="btn btn-mini pull-left">'+type.AvailabilityTags[x]+'</li>';
                          }
                         for (var y=0;y<type.CuisineTags.length;y++){
                            html += '<li class="btn btn-mini pull-left">'+type.CuisineTags[y]+'</li>';
                        }

                          html += '</ul>';
                          html += '</div>';
                          html += '<div class="span2">';
                          html += '<ul class="inline inlineLeftPadding" style="height:60px; line-height:60px;">';
                          var total=5;
                          var solidStars=type.ResRating;
                          var emptyStars=total-solidStars;
                          for (var x=0;x<solidStars;x++){
                            html += '<i class="fa fa-star"></i>';
                           }
                          for (var j=0;j<emptyStars;j++){
                            html += '<i class="fa fa-star-o"></i>';
                           }
                          html += '</ul>';
                          html += '</div>';
                          html += '<div class="span1">';
                          html += '</div>';
                          html += '<div class="span1">';
                          html += '</div>';
                          html += '<div class="span1">';
                          html += '</div>';
                          html += '</div>';
                          html += '</div>';
                          html += '</div>';
                    }


                //Cuisine Part
                    else if(type.CuisineID !== undefined){
                        html += '<div class="container-fluid searchResearchAaea">';
                        if(type.SecondLevel.length>0){
                            html += '<div class="secondLevel">';
                            html += JSON.stringify(type.SecondLevel);
                            html +='</div>';
                        }
                        html += '<input type="hidden" class="CuisineID" value="'+type.CuisineID+'">';//Cuisine id
                        html += '<input type="hidden" class="CuisineAvailability" value="'+type.CuisineAvailability+'">'; //Cuisine CuisineAvailability
                        html += '<input type="hidden" class="CuisineName" value="'+type.CuisineName+'">';//Cuisine Name
                        html += '<input type="hidden" class="CuisineDesc" value="'+type.CuisineDescription+'">';//Cuisine description
                        html += '<input type="hidden" class="CuisinePrice" value="'+type.CuisinePrice+'">';//Cuisine price
                        html += '<input type="hidden" class="CuisinePicpath" value="'+type.PicPath+'">';//Cuisine pic path

                        html += '<input type="hidden" class="CuisineAvaliabilityTag" value="'+type.AvailabilityTags+'">';//Cuisine AvaliabilityTag
                        html += '<input type="hidden" class="CuisinePriceTag" value="'+type.PriceTags+'">';//Cuisine price tag
                        html += '<input type="hidden" class="CuisineTypeTag" value="'+type.TypeTags+'">';//Cuisine type tag
                        html += '<input type="hidden" class="CuisineCuisineTag" value="'+type.CuisineTags+'">';//Cuisine tag
                        html += '<input type="hidden" class="CuisineResName" value="'+type.CuisineResName+'">';//Cuisine name and its Rest Name
                        html += '<input type="hidden" class="CuResID" value="'+type.CuisineRestID+'">';//Cuisine and its Res ID
                        html += '<input type="hidden" class="CuisineRating" value="'+type.CuisineRating+'">';//Cuisine and its Res ID
                        html += '<input type="hidden" class="CuisineTotalComments" value="'+type.TotalComments+'">';//Cuisine and its total comments
                        html += '<input type="hidden" class="CuisineWhetherFavorite" value="0">';
                        html += '<input type="hidden" class="CuisineWhetherInCart" value="0">';
                        html += '<input type="hidden" class="CurrentCuisineStatus" value="Availability">';
                        html += '<div class="row-fluid" style="max-height:55px; padding-top:9px;padding-bottom:9px">';
                        html += '<div class="clickwrap">';
                        html += '<div class="span1">';
                        html += '<img src="'+type.PicPath+'" class="img-polaroid">';
                        html += '</div>';
                        html += '<div class="span2">';
                        html += '<small>'+type.CuisineName+'</small>';
                        html += '<i style="font-size:10px;font-weight:blod;"> by '+type.CuisineResName+'</i>';
                        html += '</div>';
                        html += '<div class="span4">';
                        html += '<ul class="nav">';
                        for (var a=0;a<type.AvailabilityTags.length;a++){
                            html += '<li class="btn btn-mini pull-left">'+type.AvailabilityTags[a]+'</li>';
                        }
                        for (var b=0;b<type.CuisineTags.length;b++){
                            html += '<li class="btn btn-mini pull-left">'+type.CuisineTags[b]+'</li>';
                        }
                        for (var c=0;c<type.TypeTags.length;c++){
                            html += '<li class="btn btn-mini pull-left">'+type.TypeTags[c]+'</li>';
                        }
                        for (var d=0;d<type.PriceTags.length;d++){
                            html += '<li class="btn btn-mini pull-left">'+type.PriceTags[d]+'</li>';
                        }

                        html += '</ul>';
                        html += '</div>';
                        html += '<div class="span2">';
                        html += '<ul class="inline inlineLeftPadding" style="height:60px; line-height:60px;">';
                        var total=5;
                        var solidStars=type.CuisineRating;
                        var emptyStars=total-solidStars;
                        for (var x=0;x<solidStars;x++){
                            html += '<i class="fa fa-star"></i>';
                        }
                        for (var j=0;j<emptyStars;j++){
                            html += '<i class="fa fa-star-o"></i>';
                        }
                        html += '</ul>';
                        html += '</div>';
                        html += '<div class="span1" style="height:55px; line-height:55px;">';
                        html += '$'+type.CuisinePrice;
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="span1" style="height:55px; line-height:55px;">';
                        if(ReturnFavoriteStauts($('#CurrentLoginedUserID').val(),type.CuisineID) === 'true'){
                        html += '<i id="'+type.CuisineID+'" class="AddedToFavoriteOfSearch BackgroundOfStarAndPlus fa fa-heart"></i>';
                        }
                        else{
                        html += '<i id="'+type.CuisineID+'" class="AddedToFavoriteOfSearch BackgroundOfStarAndPlus fa fa-heart-o"></i>';
                        }
                        html += '</div>';
                        html += '<div class="span1" style="height:55px; line-height:55px;">';
                        html += '<i id="'+type.CuisineID+'" class="AddedToCartOfSearch BackgroundOfStarAndPlus fa fa-plus"></i>';
                        html += '</div>';
                        html += '</div>';
                        if(type.CuisineAvailability === 'No'){
                            html += '<div style="position:absolute;top:0;left:10px;width:70px;"><img src="'+CurrentDomain+'/assets/framework/front-images/SoldOut.png"></div>';
                        }
                        html += '</div>';
                    }

            }
            $('.AjaxLoading').hide();
            html += '<div class="MoreSearch btn text-center">More</div>';

        }
        else if(data.length === 0 && FirstFetch === 1){
            $("<div class='text-center'><h4>Sorry, there is no result that matches to your query</h4><h4><i class='fa fa-frown-o'></i><h4></div>").hide().fadeIn(1000).appendTo($('.SearchResult'));
            FirstFetch++;
        }
        else {
            $("<div class='text-center'><h4>Sorry, there is no result that matches to your query</h4><h4><i class='fa fa-frown-o'></i><h4></div>").hide().fadeIn(1000).appendTo($('.SearchResult'));

        }

        $(html).hide().fadeIn(1000).appendTo($('.SearchResult'));
       }


    /**
     * Clike result of search and redirect to relative page
     */
    $('body').on('click','.clickwrap',function(){
       if($(this).parent().parent().find('.RestID').length>0){
            passParamterToResOnly($(this).parent().parent());
        }
       else if($(this).parent().parent().find('.CuisineID').length>0){
            passParamterToCuisineOnly($(this).parent().parent());
       }
    });


    /**
     *
     * @param Parent
     */
    function passParamterToCuisineOnly(parent){
        var AjaxContainter = {};
        AjaxContainter['RootID'] = $('#RootID').val();
        AjaxContainter['SubID'] = $('#SubID').val();
        AjaxContainter['CuisineID'] = parent.find('.CuisineID').val();
        AjaxContainter['CuisineName'] = parent.find('.CuisineName').val();
        AjaxContainter['CuisineDesc'] = parent.find('.CuisineDesc').val();
        AjaxContainter['CuisinePrice'] = parent.find('.CuisinePrice').val();
        AjaxContainter['CuisinePicpath'] = parent.find('.CuisinePicpath').val();
        AjaxContainter['CuisineAvaliabilityTag'] = parent.find('.CuisineAvaliabilityTag').val();
        AjaxContainter['CuisineTypeTag'] = parent.find('.CuisineTypeTag').val();
        AjaxContainter['CuisinePriceTag'] = parent.find('.CuisinePriceTag').val();
        AjaxContainter['CuisineCuisineTag'] = parent.find('.CuisineCuisineTag').val();
        AjaxContainter['CuisineResName'] = parent.find('.CuisineResName').val();
        AjaxContainter['CuResID'] = parent.find('.CuResID').val();
        AjaxContainter['CuisineRating'] = parent.find('.CuisineRating').val();
        AjaxContainter['CuisineTotalComments'] = parent.find('.CuisineTotalComments').val();
        AjaxContainter['CuisineWhetherInCart'] = parent.find('.CuisineWhetherInCart').val();
        AjaxContainter['CuisineWhetherFavorite'] = parent.find('.CuisineWhetherFavorite').val();
        AjaxContainter['CurrentCuisineStatus'] = parent.find('.CurrentCuisineStatus').val();
        AjaxContainter['TabChoose'] = 'DishesPages';
        var result = decodeURIComponent($.param(AjaxContainter));
        $('body').modalmanager('loading');
        window.location = 'Cuisine-detail?'+result;
    }


    /**
     *
     * @param Parent
     */
    function passParamterToResOnly(Parent){
        var AjaxContainter = {};
        AjaxContainter['RootID'] = $('#RootID').val();
        AjaxContainter['SubID'] = $('#SubID').val();
        AjaxContainter['RestID'] = Parent.find('.RestID').val();
        AjaxContainter['ResName'] = Parent.find('.ResName').val();
        AjaxContainter['ResPicPath'] = Parent.find('.ResPicPath').val();
        AjaxContainter['ResAvailabilityTags'] = Parent.find('.ResAvailabilityTags').val();
        AjaxContainter['ResCuisineTags'] = Parent.find('.ResCuisineTags').val();
        AjaxContainter['ResOpenTime'] = Parent.find('.ResOpenTime').val();
        AjaxContainter['ResRating'] = Parent.find('.ResRating').val();
        AjaxContainter['ResTotalComments'] = Parent.find('.ResTotalComments').val();
        AjaxContainter['TabChoose'] = 'RestaurantsPage';
        var result = decodeURIComponent($.param(AjaxContainter));
        $('body').modalmanager('loading');
        window.location = 'Restaurants-detail?'+result;
    }

    /**
     * loading more results if clicked .MoreSearch
     */

    $('body').on('click','.MoreSearch',function(){
        $(this).hide();
        if(startCount===0){
            startCount=limitedCount;
        }
        else{
            startCount+=limitedCount;
        }
        sendData($('#RootID').val(),$('.searchItem').val(),$('.searchChoice>h7').text());

    });


    /**
     * added current cuisine into user faviours
     */
    $('body').on('click','.AddedToFavoriteOfSearch',function(){
        var CurrentCuisineID = $(this).attr('id');
        var passThis = $(this);
        var tmp = {};
        //if have this cuisine has been added as favorite
       if(CurrentUserID !== ''){
        if($(this).hasClass('fa-heart')){
            $(this).removeClass('fa-heart').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
            tmp['AddedFavorite']=0;
            tmp['CuisineID']= CurrentCuisineID;
            tmp['LoginUserID']= CurrentUserID;
            favoriteAJax(passThis,tmp,'ToCancel');

        }


        //if empty star (prepare to add this cuisine as a favorite)
        else if($(this).hasClass('fa-heart-o')){
            $(this).removeClass('fa-heart-o').empty().append('<img class="ajax-loading-favorite" width="15" hegiht="15" src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
            tmp['AddedFavorite']=1;
            tmp['CuisineID']= CurrentCuisineID;
            tmp['LoginUserID']= CurrentUserID;
            favoriteAJax(passThis,tmp,'ToAdd');

        }
    }
    else{
        InformationDisplay('Sorry!, You have to login first','alert-error');
    }

    function favoriteAJax(passThis,tmp,condition){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data: tmp,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='true' && condition==='ToAdd'){
                passThis.empty().addClass('fa-heart');
                InformationDisplay('you have added a new cuisine into your favorite cart','alert-success');

            }
            else if(msg==='true' && condition==='ToCancel'){
                passThis.empty().addClass('fa-heart-o');
                InformationDisplay('you have removed current cuisine from your favorite list','alert-warning');



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


    /**
     *Added current item into the temp shopping cart
     */

    $('body').on('click','.AddedToCartOfSearch',function(){
        if(CurrentLoginUser!==''){
        var ParentNode = $(this).parent().parent().parent();
        var tmp = {};
        if(ParentNode.find('.CurrentCuisineStatus').val() === 'UnAvailability'){
            InformationDisplay('Sorry!, Currently, The status of this cuisine is UnAvailabile, plese visit this page later','alert-error');

        }
        else{
        tmp ['TempOrder'] = 'TempOrder';
        tmp ['CurrentCuisineID'] = ParentNode.find('.CuisineID').val();
        tmp ['CurrentUserID'] = CurrentUserID;
        tmp ['CurrentResID'] = ParentNode.find('.CuResID').val();
        tmp ['CurrentCuisineName'] = ParentNode.find('.CuisineName').val();
        tmp ['CurrentCuisinePicPath'] = ParentNode.find('.CuisinePicpath').val();
        tmp ['CurrentCuisinePrice'] = ParentNode.find('.CuisinePrice').val();
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








});