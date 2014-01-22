/**
 * Created by zhaoxun321 on 5/12/2013.
 */
$(document).ready(function(){

    /**
     * Gobal variable
     */

    /**
     * Filter variables
     */
    //gobal variables
    var AvailabilityTagsArray = new Array(),
        CuisineTagsArray = new Array(),
        TypeTagsArray = new Array(),
        PriceTagsArray = new Array(),
        AvailabilityTagsIndex = 0,
        CuisineTagsIndex = 0,
        TypeTagsIndex = 0,
        PriceTagsIndex = 0;

    /**
     * Comments variables
     */
    var CurrentLoginedUserID = $('#CurrentLoginedUserID').val();
    var GetCurrentResID = $('#RestID').val();
    var commentStartCount=0;
    var LimitedCommentCount=10;
    var FirstFetchComment = 1; //set up the


    /**
     * Tags button
     */
        //Tag li elements click

    $('body').on('click','.TagAvailable li',function() { //TagAvailable---Availability
        $('#RestaurantCuisine').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });



    $('body').on('click','.TagCuisine li',function() { //TagCuisine---Cuisine
        $('#RestaurantCuisine').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }

    });

    $('body').on('click','.TagType li',function() { //TagType---Type
        $('#RestaurantCuisine').css('height','40px');

        if($(this).hasClass('active'))
        {
            $(this).removeClass("active");
        }
        else{
            $(this).addClass("active");
        }
    });

    $('body').on('click','.TagPrice li',function() { //TagPrice---Price
        $('#RestaurantCuisine').css('height','40px');

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
        $('#RestaurantCuisine').empty();
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
        $('#RestaurantCuisine').empty();
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
        $('#RestaurantCuisine').empty();
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
        $('#RestaurantCuisine').empty();
        PriceTagsIndex++;
        TypeTagsArray.sort();
        startCount=0;
        loadData();


    });


    /**
     * Scroll to right position
     */
    $.scrollTo('#ScrollTopPosition',1000);

    /**
     * Detail cuisine variables
     */
    var startCount = 0,
        Returncount = 4, //this will set how many records returned
        isLoading = false,
        handler = null;
    /**
     * Load first data from the API.
     */
    loadData();

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
        container: $('#RestaurantCuisine'), // Optional, used for some extra CSS styling
        offset: 2, // Optional, the distance between grid items
        itemWidth: 215 // Optional, the width of a grid item
    };

    /**
     * Refreshes the layout.
     */
    function applyLayout() {
        options.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#RestaurantCuisine li');
            handler.wookmark(options);
        });
    };

    /**
     * Loads data from the API, waterfall only.
     */
    function loadData() {
        isLoading = true;
        $('.Ajax-loading').fadeIn();
        $.ajax({
            type: "GET",
            url: CurrentDomain+'/json/?GetAllCuisineAccordingToResID=yes&GetResID='+$('#RestID').val(),
            dataType: 'json',
            data:{startCount:startCount,count:Returncount,AvailabilityTags:AvailabilityTagsArray,CuisineTags:CuisineTagsArray,TypeTags:TypeTagsArray,PriceTags:PriceTagsArray},
            success: onLoadData
        });
    };

    /**
     * When scrolled all the way to the bottom, add more tiles.
     */
    function onScroll(event) {
        if($(document).scrollTop()<242){
            $('#Restaurants-left-position').fadeOut();
        }
        else{
            $('#Restaurants-left-position').fadeIn();
        }

            if(!isLoading) {
                // Check if we're within 100 pixels of the bottom edge of the broser window.
                var closeToBottom = ($(window).scrollTop() + $(window).height() > $(document).height() - 10);
                        if(closeToBottom) {
                                loadData();
                            }
                         }

    };




    /**
     * When Ajax has been sucessfully completed, then do following thing -- waterfall only
     * @param data
     */

    function onLoadData(data){
        isLoading = false;
        $('.Ajax-loading').fadeOut();
        var html = '';
        var i=0, length=data.length, image;
        for(; i<length; i++) {
            image = data[i];
            if(image.PicPath.length){
                html += '<li>';
                if(image.CuisineAvailability === 'No'){
                    if(image.SecondLevel.length>0){
                        html += '<div class="secondLevel">';
                        html += JSON.stringify(image.SecondLevel);
                        html +='</div>';
                    }
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
                    html += '<input type="hidden" class="CurrentCuisineStatus" value="UnAvailability">';
                    html += '<div class="TopOptions">';
                    html += '<div class="span4">';
                    if(ReturnFavoriteStauts($('#CurrentLoginedUserID').val(),image.CuisineID) === 'true'){
                        html += '<h5><i id="'+image.CuisineID+'" class="AddedToFavoriteInWaterfall BackgroundOfStarAndPlus fa fa-heart"></i></h5>';
                    }
                    else{
                        html += '<h5><i id="'+image.CuisineID+'" class="AddedToFavoriteInWaterfall BackgroundOfStarAndPlus fa fa-heart-o"></i></h5>';
                    }
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
                    var total=5;
                    var solidStars=image.CuisineRating;
                    var emptyStars=total-solidStars;
                    for (var x=0;x<solidStars;x++){
                        html += '<i class="fa fa-star"></i>';
                    }
                    for (var j=0;j<emptyStars;j++){
                        html += '<i class="fa fa-star-o"></i>';

                    }
                }
                else if(image.CuisineAvailability === 'Yes'){
                    if(image.SecondLevel.length>0){
                        html += '<div class="secondLevel">';
                        html += JSON.stringify(image.SecondLevel);
                        html +='</div>';
                    }
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
                    html += '<input type="hidden" class="CurrentCuisineStatus" value="Availability">';
                    html += '<div class="TopOptions">';
                    html += '<div class="span4">';
                    if(ReturnFavoriteStauts($('#CurrentLoginedUserID').val(),image.CuisineID) === 'true'){
                        html += '<h5><i id="'+image.CuisineID+'" class="AddedToFavoriteInWaterfall BackgroundOfStarAndPlus fa fa-heart"></i></h5>';
                    }
                    else{
                        html += '<h5><i id="'+image.CuisineID+'" class="AddedToFavoriteInWaterfall BackgroundOfStarAndPlus fa fa-heart-o"></i></h5>';
                    }
                    html += '</div>';
                    html += '<div class="span4 blodOfPrice"><h5>$'+image.CuisinePrice+'</h5>';
                    html += '</div>';
                    html += '<div class="span4">';
                    html += '<h5><i class="AddedToCart BackgroundOfStarAndPlus fa fa-plus"></i></h5>';
                    html += '</div>';
                    html += '</div>';
                    html += '<img src="'+image.PicPath+'" width="'+image.PicWidth+'" height="'+image.PicHeight+'">';
                    html += '<h6>'+image.CuisineName;
                    html += '<h5>';
                    var total=5;
                    var solidStars=image.CuisineRating;
                    var emptyStars=total-solidStars;
                    for (var x=0;x<solidStars;x++){
                        html += '<i class="fa fa-star"></i>';
                    }
                    for (var j=0;j<emptyStars;j++){
                        html += '<i class="fa fa-star-o"></i>';

                    }
                    html += '</h5>';
                    html += '</h6>';
                }


                html += '</li>';




            }

        }
        // Add image HTML to the page.

        $(html).hide().fadeIn(1000).appendTo($('#RestaurantCuisine'));
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

    }

    /**
     * This is only for Restaurant's element
     */
    /**********************************************Detail cuisine************************************************/
        //only for Feature part
    $('body').on('click','#RestaurantCuisine>li',function(){
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
            AjaxContainter['CuisineResName'] = $('#ResName').val();
            AjaxContainter['TabChoose'] = 'FeathuredPages';
            var result = decodeURIComponent($.param(AjaxContainter));
            $('body').modalmanager('loading');
            window.location = 'Cuisine-detail?'+result;

        }
    });



    /**
     *Added active to tab
     */
    if($('#TabChoose').val() === 'RestaurantsPage'){
        $('.tabMain').find('li').eq(1).addClass('active');
    }




    /**
     * Click class .ResCommentStar to go to comment for current cuisine
     */
    $('body').on('click','.ResCommentStar',function(){
        if($('#CurrentLoginedUserID').val() != ''){
            var CurrentUserID=encodeURIComponent($('#CurrentLoginedUserID').val());
            var CurrentResID=encodeURIComponent($('#RestID').val());
            var CurrentResName=encodeURIComponent($('#ResName').val());
            $('body').modalmanager('loading');
            setTimeout(function(){
                $modal.load(CurrentDomain+'/Restaurant-comment?CurrentResName='+CurrentResName+'&CurrentUserID='+CurrentUserID+'&CurrentResID='+CurrentResID, '', function(){
                    $modal.modal();
                });
            }, 1000);
        }
        else{
            InformationDisplay('Sorry!, You have to login first','alert-error');

        }

    });

    /**
     * following function of CuisineCommentStar is for when user clicks stars
     */
    $modal.on('click','.ResCommentStar-given',function(){
        var getThisLength = $('.ResCommentStar-given').length;
        for (var i=0;i<getThisLength;i++){
            if($('.ResCommentStar-given').hasClass('fa-star')){
                $('.ResCommentStar-given').eq(i).removeClass('fa-star').addClass('fa-star-o');
            }

        }

        var CurrentLength = $('.ResCommentStar-given').index($(this));
        for (var i=0;i<CurrentLength+1;i++){
            if($('.ResCommentStar-given').hasClass('fa-star-o')){
                $('.ResCommentStar-given').eq(i).removeClass('fa-star-o').addClass('fa-star');
            }

        }

    });

    /**
     * Prepare submit Cuisine comment
     */
    /***********************************Submit cuisine comment******************************************/
    $modal.on('click','.submitResComment',function(){
        var CurrentResID = $('#CommentCurrentResID').val();
        var CurrentUserID = $('#CommentCurrentUserID').val();
        var Currentstars =  $('.ResCommentStarGroup').find('.fa-star').length;
        var CurrentCommentContent = $('#Res-comment-area').val();
        var tmp={};
        tmp['CurrentResID'] = CurrentResID;
        tmp['CurrentUserID'] = CurrentUserID;
        tmp['Currentstars'] = Currentstars;
        tmp['CurrentCommentContent'] = CurrentCommentContent;
        if(Currentstars===0){
            InformationDisplay('You have to choose at least one star','alert-error');
            return false;
        }
        if(CurrentCommentContent===''){
            InformationDisplay('You have to fill the content of comment','alert-error');
            return false;
        }

        AJAXpassTempResComment(tmp);
    });


    /**
     * Ajax pass the tmp comment data to backend-controller
     */
    function AJAXpassTempResComment(tmp){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });
        request.done(function(msg) {
            if(msg==='true'){
                AjaxMessage('alert-success','Congratulations! you have successfully submited the comment, please waiting for you comment review.');
                setTimeout(function(){$('#ajax-modal').modal('hide');},4000);
                RestStars(tmp['Currentstars']);
            }
            else if(msg==='Over Comment'){
                AjaxMessage('alert-error','Be careful, you cannot submit comment more than once within limited time');
                setTimeout(function(){$('#ajax-modal').modal('hide');},4000);

            }
            else if(msg==='false'){
                AjaxMessage('alert-error','Datebase operation error');
                setTimeout(function(){$('#ajax-modal').modal('hide');},4000);

            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

    /**
     * Reset stars
     */
    function RestStars(SoldStars){
        var getStarsLength = $('.ResCommentStar').length;
        for (var i=0;i<SoldStars;i++){
            $('.ResCommentStar').eq(i).removeClass('fa-star-o').addClass('fa-star');
        }
    }

    /**
     * $modal info
     */
    function AjaxMessage(className,info){
        $modal.modal('loading');
        setTimeout(function(){
            $modal
                .modal('loading')
                .find('.modal-body').empty()
                .prepend("<div class='alert " + className + " fade in'>" + info + "</div>");

        }, 1000);

    }

    /**************************************************Switch comment page and waterfall page -- Restaurant*********************************/
    /**
     * Click #Navcomments to swithch comment or wataerfall
     */

    $('body').on('click','#Navcomments',function(){//arrow click event between comments and waterfall
        if($(this).hasClass('fa-arrow-circle-down')){
            $('#ResWaterfall-zone').fadeOut(500);
            $('#ClickToComment').fadeIn(500);
            $(this).removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            $('.commentMarginBottom').empty();
            GetRestaurantCommentJson();
        }

        else if($(this).hasClass('fa-arrow-circle-up')){
            $('#ClickToComment').fadeOut(500);
            $('#ResWaterfall-zone').fadeIn(500);
            $('#RestaurantCuisine').trigger('refreshWookmark');
            $(this).removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');

        }
    });

    /**
     * Get Cuisine Comment Json
     */
    function GetRestaurantCommentJson(){
        $.ajax({
            type: "GET",
            url: CurrentDomain+'/json/?GetResComment=yes&GetCurrentResID='+GetCurrentResID+'&commentStartCount='+commentStartCount+'&LimitedCommentCount='+LimitedCommentCount,
            dataType: 'json',
            success: onLoadComment
        });
    }

    /**
     * if sucessfully got json, then do followling thing
     */
    function onLoadComment(data){
        var html = '';
        if(data.length>0){
            var i=0, length=data.length, comment;
            for(; i<length; i++) {
                comment = data[i];
                html += '<li>';
                html += '<input type="hidden" class="CommentID" value="'+comment.ResCommentID+'">'
                html += '<div class="media">';
                html += '<a class="pull-left" href="#">';
                html += '<img class="media-object" src="'+comment.UserPhotoPath+'">';
                html += '</a>';
                html += '<div class="media-body">';
                html += '<h5 class="media-heading">'+comment.UserName+'</h5>';
                html += '<h6>'+comment.ResCommentDate+'</h6>';
                html += '<p>'+comment.RestaurantsComments+'</p>';
                html += '<ul class="inline inlineLeftPadding">';
                var total=5;
                var solidStars=comment.ResCommentRating;
                var emptyStars=total-solidStars;
                for (var x=0;x<solidStars;x++){
                    html += '<i class="fa fa-star"></i>';
                }
                for (var j=0;j<emptyStars;j++){
                    html += '<i class="fa fa-star-o"></i>';

                }
                html += '<li style="margin-left:19px;"><i class="fa fa-thumbs-o-up"></i><span style="margin-left:9px;" class="good">'+comment.ResCommentLike+'</span></li>';
                html += '<li style="margin-left:19px;"><i class="fa fa-thumbs-o-down"></i><span style="margin-left:9px;" class="bad">'+comment.ResCommentDislike+'</span></li>';
                html += '</ul>';
                html += '</div>';
                html += '</div>';
                html += '</li>';

            }
            html += '<div class="MoreComments btn text-center">More</div>';


        }
        else if(data.length === 0 && FirstFetchComment === 1){
            html += '<h4 class="text-center">No more comments</h4>';
            FirstFetchComment++;
        }
        // Add image HTML to the page.

        $(html).hide().fadeIn(1000).appendTo($('.commentMarginBottom'));


    }

    /**
     * click comment more button for displaying more comments
     */

    $('body').on('click','.MoreComments',function(){
        $(this).hide();
        if(commentStartCount===0){
            commentStartCount=LimitedCommentCount;//after first time stratCount was used, then added returnCount that added to startCount,i.e first time startCount=0, then next time startCount=4
        }
        else{
            commentStartCount+=LimitedCommentCount;//if current startCount is not first time load, then added startCount its self. startCount=4, then startCount+=startCount ====8
        }
        GetRestaurantCommentJson();
    });


    /**
     * fa-thumbs-o-up
     * given a good comment
     */
    $('body').on('click','.fa-thumbs-o-up',function(){
        if($('#CurrentLoginedUserID').val()===''){
            InformationDisplay('You have to login before you are going to vote','alert-error');
        }
        else{
            var Tmpsave = $(this);
            var JsonPass = {};
            JsonPass['thumbLikeOrDislike'] = 'like';
            JsonPass['CurrentUserID'] = CurrentLoginedUserID;
            JsonPass['CurrentCommmentID'] = $(this).parent().parent().parent().parent().parent().find('.CommentID').val();
            JsonPass['CurrentCommentType'] = 'RestaurantsComments';
            thumbsLikeorDislike(Tmpsave,JsonPass);
        }
    });

    /**
     * fa-thumbs-o-down
     * @param Tmpsave
     * @param temp
     */
    $('body').on('click','.fa-thumbs-o-down',function(){
        if($('#CurrentLoginedUserID').val()===''){
            InformationDisplay('You have to login before you are going to vote','alert-error');
        }
        else{
            var Tmpsave = $(this);
            var JsonPass = {};
            JsonPass['thumbLikeOrDislike'] = 'dislike';
            JsonPass['CurrentUserID'] = CurrentLoginedUserID;
            JsonPass['CurrentCommmentID'] = $(this).parent().parent().parent().parent().parent().find('.CommentID').val();
            JsonPass['CurrentCommentType'] = 'RestaurantsComments';
            thumbsLikeorDislike(Tmpsave,JsonPass);
        }
    });
    /**
     * thumbs for like or dislike
     */

    function thumbsLikeorDislike(Tmpsave,temp){

        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:temp,
            dataType: "json"
        });

        request.done(function( msg ) {
            if(msg.Error===0){
                InformationDisplay(msg.info,"alert-success");
                if(msg.like===1){
                    Tmpsave.parent().find('.good').text(msg.ReturntCount);
                }
                else if(msg.dislike===1){
                    Tmpsave.parent().find('.bad').text(msg.ReturntCount);
                }
            }
            else if (msg.Error===1){
                InformationDisplay(msg.info,"alert-error");
            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

    /**
     * Restaurants-left-position button
     */
    $('body').on('click','#Restaurants-left-position',function(){
        var AjaxContainter = {};
        AjaxContainter['RootID'] = $('#RootID').val();
        AjaxContainter['SubID'] = $('#SubID').val();
        var result = decodeURIComponent($.param(AjaxContainter));
        $('body').modalmanager('loading');
        window.location = 'Restaurants?'+result;

    });



});