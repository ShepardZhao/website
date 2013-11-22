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
        console.log(AvailabilityTagsArray);
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
            if(image.PicPath.length){
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
                    html += '<input type="hidden" class="CuisineAvaliabilityTag" value="'+image.AvailabilityTags+'">';//Cuisine AvaliabilityTag
                    html += '<input type="hidden" class="CuisinePriceTag" value="'+image.PriceTags+'">';//Cuisine price tag
                    html += '<input type="hidden" class="CuisineTypeTag" value="'+image.TypeTags+'">';//Cuisine type tag
                    html += '<input type="hidden" class="CuisineCuisineTag" value="'+image.CuisineTags+'">';//Cuisine tag
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
            startCount+=Returncount;//if current startCount is not first time load, then added startCount its self. startCount=4, then startCount+=startCount ====8
        }
    };

    /**
     * This is only for feature's element
      */
    /**********************************************Detail cuisine************************************************/
        //only for Feature part
    $('body').on('click','#CuisineRelateTiles>li',function(){

        var  AjaxContainter = {};
        if($(this).find('.CuisineID')){ //if current is a li and that clicked finding that is Cuisine
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
            AjaxContainter['CuisineWhetherInCart'] = $(this).find('.CuisineWhetherInCart').val();
            AjaxContainter['CuisineWhetherFavorite'] = $(this).find('.CuisineWhetherFavorite').val();
            var result = decodeURIComponent($.param(AjaxContainter));
            window.location = 'Cuisine-detail?'+result;

            //AjaxofCuisinePage(AjaxContainter);
        }
        if($(this).find('.RestID')){
            //  console.log($(this).find('.RestID').val());
        }
    });





});