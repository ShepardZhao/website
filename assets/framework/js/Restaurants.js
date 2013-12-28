/**
 * Created by zhaoxun321 on 8/12/2013.
 */
$(document).ready(function(){



    /**
     * Restaurants' list variables
     */
    var startCount = 0,
        limitedCount = 4, //this will set how many records returned
        isLoading = false;
    var AvailabilityTagsArray = new Array(),
        CuisineTagsArray = new Array(),
        AvailabilityTagsIndex = 0,
        CuisineTagsIndex = 0;
    /**
     * Restaurants's Comments variables
     *
     */

    var commentStartCount = 0,
        LimitedCommentCount = 5,
        FirstFetchComment = 1,
        collapseOne = 0,
        currentCommentStatus = false,
        isCommentLoading = false;



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
        $('.Restaurant_zone').empty();
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
        $('.Restaurant_zone').empty();

        loadData();


    });

    /*****************************Restaurant list**********************************/

    /**
     * loading first data from API
     */
    loadData();

    /**
     * scroll, this is for dynamic scroll screen when user wants to fetch more data steam
     */
    $(document).bind('scroll', onScroll);

    /**
     * Loads data from the API.
     */
    function loadData() {
        isLoading = true;
        $('.Ajax-loading').fadeIn();
        $.ajax({
            type: "GET",
            url: CurrentDomain+'/json/?GetRestaurantOnlyByLocation='+$('#RootLocationName').val(),//api,
            dataType: 'json',
            data:{startCount:startCount,count:limitedCount,AvailabilityTags:AvailabilityTagsArray,CuisineTags:CuisineTagsArray},
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
        html += '<div class="accordion">';
        html += '<input type="hidden" class="RestID" value="'+image.RestID+'">';//Restaurants id
        html += '<input type="hidden" class="ResName" value="'+image.ResName+'">';//Restaurants Name
        html += '<input type="hidden" class="ResPicPath" value="'+image.PicPath+'">';//Restaurants PicPath
        html += '<input type="hidden" class="ResAvailabilityTags" value="'+image.AvailabilityTags+'">';//Restaurants AvailabilityTags
        html += '<input type="hidden" class="ResCuisineTags" value="'+image.CuisineTags+'">';//Restaurants CuisineTags
        html += '<input type="hidden" class="ResTotalComments" value="'+image.TotalComments+'">';//Restaurants comments
        html += '<input type="hidden" class="ResOpenTime" value='+JSON.stringify(image.ResOpenTime)+'>';//Restaurants ResOpenTime
        html += '<input type="hidden" class="ResRating" value="'+image.ResRating+'">';//Restaurants ResRating
        html += '<div class="accordion-group ListReGroup">';
        html += '<div class="accordion-heading ListHeading">';
        html += '<div class="row-fluid innerHeading">';
        html += '<div class="span3 text-right">';
        html += '<img class="ResImage img-rounded" sytle="width:205px;height:205px" src="'+image.PicPath+'">';
        html += '</div>';
        html += '<div class="span6  text-left">';
        html += '<h4 class="RestaurantsName">'+image.ResName+'</h4>';
        html += '<ul class="inline  TagWidthOverflow inlineLeftPadding">';
        for (var x = 0; x < image.AvailabilityTags.length; x++ ){
        html += '<li><button class="btn btn-mini" type="button">'+image.AvailabilityTags[x]+'</button></li>';
        }
        for (var j = 0; j < image.CuisineTags.length; j++ ){
        html += '<li><button class="btn btn-mini" type="button">'+image.CuisineTags[j]+'</button></li>';
        }
        html += '</ul>';
        html += '<div class="RestaurantDatePosition">';
        html += '<h6 class="resetColor">Open Time (Today): ';
        if (returnDateFunction() === 'Sunday'){
        html += image.ResOpenTime.Sunday;
        }
        else if (returnDateFunction() === 'Monday'){
            html += image.ResOpenTime.Monday;
        }
        else if (returnDateFunction() === 'Tuesday'){
            html += image.ResOpenTime.Tuesday;

        }
        else if (returnDateFunction() === 'Wednesday'){
            html += image.ResOpenTime.Wednesday;
        }
        else if (returnDateFunction() === 'Thursday'){
            html += image.ResOpenTime.Thursday;
        }
        else if (returnDateFunction() === 'Friday'){
            html += image.ResOpenTime.Friday;
        }
        else if (returnDateFunction() === 'Saturday'){
            html += image.ResOpenTime.Saturday;
        }
        html += '  <i class="showHiddenDate fa fa-chevron-down"></i>';
        html += '</h6>';
        html += '<div class="HidenResturantDate">';
        html += '<p>Monday: '+image.ResOpenTime.Monday+'</p>';
        html += '<p>Tuesday: '+image.ResOpenTime.Tuesday+'</p>';
        html += '<p>Wednesday: '+image.ResOpenTime.Wednesday+'</p>';
        html += '<p>Thursday: '+image.ResOpenTime.Thursday+'</p>';
        html += '<p>Friday: '+image.ResOpenTime.Friday+'</p>';
        html += '<p>Saturday: '+image.ResOpenTime.Saturday+'</p>';
        html += '<p>Sunday: '+image.ResOpenTime.Sunday+'</p>';
        html += '</div>';
        html += '</div>';
        html += '<div class="row-fluid">';
        html += '<h5>Your Rating:</h5>';
        html += '<h4>';
        html += '<ul class="inline inlineLeftPadding" id="'+image.RestID+'">';
        html += '<li><i class="fa ResCommentStar fa-star-o"></i></li>';
        html += '<li><i class="fa ResCommentStar fa-star-o"></i></li>';
        html += '<li><i class="fa ResCommentStar fa-star-o"></i></li>';
        html += '<li><i class="fa ResCommentStar fa-star-o"></i></li>';
        html += '<li><i class="fa ResCommentStar fa-star-o"></i></li>';
        html += '</ul>';
        html += '</h4>';
        html += '</div>';
        html += '</div>';
        html += '<div class="span3 text-center resetColor" id="toppadding">';
        html += '<h4>';
        html += '<ul class="inline" id="rightRestaurantsStars">';
        html += '<li>';
        var total=5;
        var solidStars=image.ResRating;
        var emptyStars=total-solidStars;
        for (var x=0;x<solidStars;x++){
            html += '<i class="fa fa-star"></i>';
        }
        for (var j=0;j<emptyStars;j++){
            html += '<i class="fa fa-star-o"></i>';

        }
        html += '</li>';
        html += '</ul>';
        html += '</h4>';
        html += '<p class="resetColor">'+image.TotalComments+' Comments </p>';
        html += '<a class="accordion-toggle" data-toggle="collapse"  href="#'+collapseOne+'" >';
        html += '<h3><i class="Navcomments resetColor fa fa-arrow-circle-down"></i></h3>';
        html += '</a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div id="'+collapseOne+'" class="accordion-body collapse">';
        html += '<div class="accordion-inner">';
        html += '<ul class="nav nav-pills nav-stacked ResCommentSlip">';
        html += '</ul>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        collapseOne++;

    }
    // Add image HTML to the page.
    $(html).hide().fadeIn(1000).appendTo($('.Restaurant_zone'));
    if(startCount===0){
        startCount=limitedCount;//after first time stratCount was used, then added limitedCount that added to startCount,i.e first time startCount=0, then next time startCount=4
    }
    else{
        startCount+=limitedCount;//if current startCount is not first time load, then added startCount its self. startCount=4, then startCount+=limitedCount ====8
    }
};



    /**
     * Click class .ResCommentStar to go to comment for current cuisine
     */
    $('body').on('click','.ResCommentStar',function(){
        if($('#CurrentLoginedUserID').val() != ''){
            var CurrentUserID=encodeURIComponent($('#CurrentLoginedUserID').val());
            var CurrentResID=encodeURIComponent($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('.RestID').val());
            var CurrentResName=encodeURIComponent($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('.ResName').val());
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
                RestStars(tmp['CurrentResID'],tmp['Currentstars']);
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
    function RestStars(ResID,SoldStars){
        for (var i=0;i<SoldStars;i++){
            $('#'+ResID).find('.ResCommentStar').eq(i).removeClass('fa-star-o').addClass('fa-star');
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

    /***************************************Following function is clicking function that passes the paramters to Restayrants-detail.php******/

    $('body').on('click','.ResImage',function(){
        var parent = $(this).parent().parent().parent().parent().parent();
        passParamterToRestaurantDetail(parent);
    });


    $('body').on('click','.RestaurantsName',function(){
        var parent = $(this).parent().parent().parent().parent().parent();
        passParamterToRestaurantDetail(parent);

    });


    function passParamterToRestaurantDetail(Parent){
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
     * hover to display all hiden open date of Restaurants
     */
    $('body').on('mouseenter','.showHiddenDate',function(){
        $(this).parent().parent().find('.HidenResturantDate').fadeIn(1000);
    });
    $('body').on('mouseleave','.showHiddenDate',function(){
        $(this).parent().parent().find('.HidenResturantDate').fadeOut(1000);
    });


    /**
     * Click Navcomments to expand comments
     */

    $('body').on('click','.Navcomments',function(){
        var CurrentCommenParent = $(this).parent().parent().parent().parent().parent().parent().parent().index();
        var CommentResID = $(this).parent().parent().parent().parent().parent().parent().parent().find('.RestID').val();

        if($(this).hasClass('fa-arrow-circle-up')){
            $(this).removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');

        }
        else if($(this).hasClass('fa-arrow-circle-down')){
            $(this).removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
                Commentloading(CommentResID,CurrentCommenParent);
                $('.ResCommentSlip').empty();
        }
    });



    /**
     * Loading Comment from the json
     */
    function Commentloading(CommentResID,CurrentCommenParent){
    $.ajax({
        type: "GET",
        url: CurrentDomain+'/json/?GetResComment=yes&GetCurrentResID='+CommentResID+'&commentStartCount='+commentStartCount+'&LimitedCommentCount='+LimitedCommentCount,
        dataType: 'json',
        success: function(data){CommentList(CurrentCommenParent,data)}
    });
    }

    /**
     * add comments into the current restaurant list
     */
    function CommentList(CurrentCommenParent,data){
        var html = '';
        if(data.length>0){
            isLoading = false;
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

        $(html).hide().fadeIn(1000).appendTo($('.accordion').eq(CurrentCommenParent).find('.ResCommentSlip'));

    }

    /**
     * click more button to display more comment of cuisine
     */

    $('body').on('click','.MoreComments',function(){
        $(this).hide();
        if(commentStartCount===0){
            commentStartCount=LimitedCommentCount;//after first time stratCount was used, then added returnCount that added to startCount,i.e first time startCount=0, then next time startCount=4
        }
        else{
            commentStartCount+=LimitedCommentCount;//if current startCount is not first time load, then added startCount its self. startCount=4, then startCount+=startCount ====8
        }
        var parentIndex = $(this).parent().parent().parent().parent().parent().index();
        var CommentResID = $(this).parent().parent().parent().parent().parent().find('.RestID').val();
        Commentloading(CommentResID, parentIndex);
    });

});