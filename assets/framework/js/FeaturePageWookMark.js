/**
 * Created by zhaoxun321 on 21/11/2013.
 */
$(document).ready(function(){
    /**********************************************Filter Tags setting*******************************************************/
    /**
     * Filter variables
     */
    //gobal variables
    var AvailabilityTagsArray = new Array(),
        CuisineTagsArray = new Array(),
        TypeTagsArray = new Array(),
        PriceTagsArray = new Array(),
    //counts
        AvailabilityTagsIndex = 0,
        CuisineTagsIndex = 0,
        TypeTagsIndex = 0,
        PriceTagsIndex = 0;

    /**
     * Tags button
     */
    /*********************************************Added Tags button***************************************************/
        //Tag li elements click

    $('body').on('click','.TagAvailable li',function() { //TagAvailable---Availability
        $('#CuisineRelateTiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });



    $('body').on('click','.TagCuisine li',function() { //TagCuisine---Cuisine
        $('#CuisineRelateTiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });


    $('body').on('click','.TagType li',function() { //TagType---Type
        $('#CuisineRelateTiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }
    });

    $('body').on('click','.TagPrice li',function() { //TagPrice---Price
        $('#CuisineRelateTiles').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }
    });


    /**
     * Filter tags function groups
     */
    /*****************************************Filter tags******************************************************/
//Availability tags click
    $('body').on('click','.TagAvailable>li',function(){

        if($(this).hasClass('active')){
            AvailabilityTagsArray[AvailabilityTagsIndex]= $(this).find('a').text();
        }
        else{
            AvailabilityTagsArray.splice( $.inArray($(this).find('a').text(),AvailabilityTagsArray) ,1 );
        }
        $('#CuisineRelateTiles').empty();
        AvailabilityTagsIndex++;
        AvailabilityTagsArray.sort();
        startCount=0;
        loadData();

    });

//Cuisine tags click
    $('body').on('click','.TagCuisine>li',function(){
        if($(this).hasClass('active')){
            CuisineTagsArray[CuisineTagsIndex]= $(this).find('a').text();
        }
        else{
            CuisineTagsArray.splice( $.inArray($(this).find('a').text(),CuisineTagsArray) ,1 );
        }
        $('#CuisineRelateTiles').empty();
        CuisineTagsIndex++;
        CuisineTagsArray.sort();
        startCount=0;
        loadData();


    });

//TagType tags click
    $('body').on('click','.TagType>li',function(){
        if($(this).hasClass('active')){
            TypeTagsArray[TypeTagsIndex]= $(this).find('a').text();
        }
        else{
            TypeTagsArray.splice( $.inArray($(this).find('a').text(),TypeTagsArray) ,1 );
        }
        $('#CuisineRelateTiles').empty();
        TypeTagsIndex++;
        TypeTagsArray.sort();
        startCount=0;
        loadData();


    });

//TagPrice tags click
    $('body').on('click','.TagPrice>li',function(){
        if($(this).hasClass('active')){
            PriceTagsArray[PriceTagsIndex]= $(this).find('a').text();
        }
        else{
            PriceTagsArray.splice( $.inArray($(this).find('a').text(),PriceTagsArray) ,1 );
        }
        $('#CuisineRelateTiles').empty();
        PriceTagsIndex++;
        TypeTagsArray.sort();
        startCount=0;
        loadData();


    });



    /**********************************************Feature Page Only*********************************************************/
    /**
     * Feature wookmark variables
     */
    var startCount = 0,
        Returncount = 4, //this will set how many records returned
        isLoading = false,
        handler = null,
        apiURL =  CurrentDomain+'/json/?GetResAndCuByRootL='+$('#RootLocationName').val();//api
    /**
     * scroll, this is for dynamic scroll screen when user wants to fetch more data steam
     */
    $(document).bind('scroll', onScroll);


    /**
     * wookmark options
     */
    options = {//for feature only
        autoResize: true, // This will auto-update the layout when the browser window is resized.
        resizeDelay:50,
        container: $('#CuisineRelateTiles'), // Optional, used for some extra CSS styling
        offset: 2, // Optional, the distance between grid items
        itemWidth: 215 // Optional, the width of a grid item

    };


    // Load first data from the API.
    loadData();
    /**
     * Refreshes the layout.
     */
    function applyLayout() {
        options.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#CuisineRelateTiles li');
            handler.wookmark(options);
        });
    };

    /**
     * Loads data from the API.
     */
    function loadData() {
        isLoading = true;
        $('.Ajax-loading').fadeIn();
        $.ajax({
            type: "GET",
            url: apiURL,
            dataType: 'json',
            data:{startCount:startCount,count:Returncount,AvailabilityTags:AvailabilityTagsArray,CuisineTags:CuisineTagsArray,TypeTags:TypeTagsArray,PriceTags:PriceTagsArray},
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
        $('.Ajax-loading').fadeOut();
        var html = '';
        var i=0, length=data.length, image;
        for(; i<length; i++) {
            image = data[i];
            html += '<li>';
            if(image.PicPath.length){
                if(image.RestID !== undefined){

                    html += '<input type="hidden" class="RestID" value="'+image.RestID+'">';//Restaurants id
                    html += '<input type="hidden" class="ResName" value="'+image.ResName+'">';//Restaurants Name
                    html += '<input type="hidden" class="ResPicPath" value="'+image.PicPath+'">';//Restaurants PicPath
                    html += '<input type="hidden" class="ResAvailabilityTags" value="'+image.AvailabilityTags+'">';//Restaurants AvailabilityTags
                    html += '<input type="hidden" class="ResCuisineTags" value="'+image.CuisineTags+'">';//Restaurants CuisineTags
                    html += '<input type="hidden" class="ResTotalComments" value="'+image.TotalComments+'">';//Restaurants comments
                    html += '<input type="hidden" class="ResOpenTime" value='+JSON.stringify(image.ResOpenTime)+'>';//Restaurants ResOpenTime
                    html += '<input type="hidden" class="ResRating" value="'+image.ResRating+'">';//Restaurants ResRating

                    html += '<img src="'+image.PicPath+'" width="'+image.PicWidth+'" height="'+image.PicHeight+'">';
                    html += '<h6 class="ResName">'+image.ResName+'</h6>';

                }
                if(image.CuisineID !== undefined){
                //if current cuisine is unavailability
                if(image.CuisineAvailability === 'No'){
                    html += '<input type="hidden" class="CuisineID" value="'+image.CuisineID+'">';//Cuisine id
                    html += '<input type="hidden" class="CuisineName" value="'+image.CuisineName+'">';//Cuisine Name
                    html += '<input type="hidden" class="CuisineDesc" value="'+image.CuisineDescription+'">';//Cuisine description
                    html += '<input type="hidden" class="CuisinePrice" value="'+image.CuisinePrice+'">';//Cuisine price
                    html += '<input type="hidden" class="CuisinePicpath" value="'+image.PicPath+'">';//Cuisine price
                    html += '<input type="hidden" class="CuisineAvaliabilityTag" value="'+image.AvailabilityTags+'">';//Cuisine AvaliabilityTag
                    html += '<input type="hidden" class="CuisinePriceTag" value="'+image.PriceTags+'">';//Cuisine price tag
                    html += '<input type="hidden" class="CuisineTypeTag" value="'+image.TypeTags+'">';//Cuisine type tag
                    html += '<input type="hidden" class="CuisineCuisineTag" value="'+image.CuisineTags+'">';//Cuisine tag
                    html += '<input type="hidden" class="CuisineResName" value="'+image.CuisineResName+'">';//Cuisine name and its Rest Name
                    html += '<input type="hidden" class="CuResID" value="'+image.CuisineRestID+'">';//Cuisine and its Res ID
                    html += '<input type="hidden" class="CuisineRating" value="'+image.CuisineRating+'">';//Cuisine and its Res ID
                    html += '<input type="hidden" class="CuisineTotalComments" value="'+image.TotalComments+'">';//Cuisine and its total comments
                    html += '<input type="hidden" class="CuisineWhetherFavorite" value="0">';
                    html += '<input type="hidden" class="CuisineWhetherInCart" value="0">';
                    html += '<input type="hidden" class="CurrentCuisineStatus" value="UnAvailability">';
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
                    html += '<img src="'+image.PicPath+'" width="'+image.PicWidth+'" height="'+image.PicHeight+'">';
                    html += '<h6 class="foodName">'+image.CuisineName+'</h6>';
                    html += '<h6 id="pic1" class="RetaurantName optionsHide">'+image.CuisineResName+'</h6>';
                    html += '<div class="OutofStock"></div>';
                    html += '<div style="position:absolute;top:0;left:0;"><img src="'+CurrentDomain+'/assets/framework/front-images/SoldOut.png"></div>';
                }
                //if current cuisine is availability
                else if(image.CuisineAvailability === 'Yes'){
                    html += '<input type="hidden" class="CuisineID" value="'+image.CuisineID+'">';//Cuisine id
                    html += '<input type="hidden" class="CuisineName" value="'+image.CuisineName+'">';//Cuisine Name
                    html += '<input type="hidden" class="CuisineDesc" value="'+image.CuisineDescription+'">';//Cuisine description
                    html += '<input type="hidden" class="CuisinePrice" value="'+image.CuisinePrice+'">';//Cuisine price
                    html += '<input type="hidden" class="CuisinePicpath" value="'+image.PicPath+'">';//Cuisine price
                    html += '<input type="hidden" class="CuisineAvaliabilityTag" value="'+image.AvailabilityTags+'">';//Cuisine AvaliabilityTag
                    html += '<input type="hidden" class="CuisinePriceTag" value="'+image.PriceTags+'">';//Cuisine price tag
                    html += '<input type="hidden" class="CuisineTypeTag" value="'+image.TypeTags+'">';//Cuisine type tag
                    html += '<input type="hidden" class="CuisineCuisineTag" value="'+image.CuisineTags+'">';//Cuisine tag
                    html += '<input type="hidden" class="CuisineResName" value="'+image.CuisineResName+'">';//Cuisine name and its Rest Name
                    html += '<input type="hidden" class="CuResID" value="'+image.CuisineRestID+'">';//Cuisine and its Res ID
                    html += '<input type="hidden" class="CuisineRating" value="'+image.CuisineRating+'">';//Cuisine and its Res ID
                    html += '<input type="hidden" class="CuisineTotalComments" value="'+image.TotalComments+'">';//Cuisine and its total comments
                    html += '<input type="hidden" class="CuisineWhetherFavorite" value="0">';
                    html += '<input type="hidden" class="CuisineWhetherInCart" value="0">';
                    html += '<input type="hidden" class="CurrentCuisineStatus" value="Availability">';
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
                    html += '<img src="'+image.PicPath+'" width="'+image.PicWidth+'" height="'+image.PicHeight+'">';
                    if(image.CuisineName!==undefined){
                        html += '<h6 class="foodName">'+image.CuisineName+'</h6>';
                        html += '<h6 id="pic1" class="RetaurantName optionsHide">'+image.CuisineResName+'</h6>';
                    }
                    else{
                        html += '<h6 class="ResName">'+image.ResName+'</h6>';
                    }

                }
                }
            }
            html +='</li>';

        }
        // Add image HTML to the page.
        $(html).hide().fadeIn(1000).appendTo($('#CuisineRelateTiles'));
        // Apply layout.
        if(length!==0){
            applyLayout();
        }
        hoverfunction();
        if(startCount===0){
            startCount=Returncount;//after first time stratCount was used, then added returnCount that added to startCount,i.e first time startCount=0, then next time startCount=4
        }
        else{
            startCount+=Returncount;//if current startCount is not first time load, then added startCount its self. startCount=4, then startCount+=Returncount ====8
        }
    };



    /**
     * parse_date
     */
    function parse_date(string) {
        var date = new Date();
        var parts = String(string).split(/[- :]/);

        date.setFullYear(parts[0]);
        date.setMonth(parts[1] - 1);
        date.setDate(parts[2]);
        date.setHours(parts[3]);
        date.setMinutes(parts[4]);
        date.setSeconds(parts[5]);
        date.setMilliseconds(0);

        return date;
    }

    /**
     * This is only for feature's element
      */
    /**********************************************Detail cuisine************************************************/
        //only for Feature part
    $('body').on('click','#CuisineRelateTiles li',function(){
        var  AjaxContainter = {};
        if($(this).find('.CuisineID').length>0){ //if current is a li and that clicked finding that is Cuisine

            AjaxContainter['RootID'] = $('#RootID').val();
            AjaxContainter['SubID'] = $('#SubID').val();
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
            AjaxContainter['CuisineTotalComments'] = $(this).find('.CuisineTotalComments').val();
            AjaxContainter['CuisineWhetherInCart'] = $(this).find('.CuisineWhetherInCart').val();
            AjaxContainter['CuisineWhetherFavorite'] = $(this).find('.CuisineWhetherFavorite').val();
            AjaxContainter['CurrentCuisineStatus'] = $(this).find('.CurrentCuisineStatus').val();
            AjaxContainter['TabChoose'] = 'FeathuredPages';
            var result = decodeURIComponent($.param(AjaxContainter));
            $('body').modalmanager('loading');
            window.location = 'Cuisine-detail?'+result;

        }
        else if($(this).find('.RestID').length>0){

            AjaxContainter['RootID'] = $('#RootID').val();
            AjaxContainter['SubID'] = $('#SubID').val();
            AjaxContainter['RestID'] = $(this).find('.RestID').val();
            AjaxContainter['ResName'] = $(this).find('.ResName').val();
            AjaxContainter['ResPicPath'] = $(this).find('.ResPicPath').val();
            AjaxContainter['ResAvailabilityTags'] = $(this).find('.ResAvailabilityTags').val();
            AjaxContainter['ResCuisineTags'] = $(this).find('.ResCuisineTags').val();
            AjaxContainter['ResOpenTime'] = $(this).find('.ResOpenTime').val();
            AjaxContainter['ResRating'] = $(this).find('.ResRating').val();
            AjaxContainter['ResTotalComments'] = $(this).find('.ResTotalComments').val();
            AjaxContainter['TabChoose'] = 'RestaurantsPage';
            var result = decodeURIComponent($.param(AjaxContainter));
            $('body').modalmanager('loading');
            window.location = 'Restaurants-detail?'+result;






        }
    });





});