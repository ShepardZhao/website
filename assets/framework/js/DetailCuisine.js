/**
 * Created by zhaoxun321 on 21/11/2013.
 */
$(document).ready(function(){
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
        handler = null,
        apiURL =  CurrentDomain+'/json/?GetResAndItsCuisine=yes&FilterCuisineID='+$('#GetCurrentCuID').val()+'&GetResID='+$('#GetCurrentResID').val();
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
        container: $('#ReleventCuisine'), // Optional, used for some extra CSS styling
        offset: 2, // Optional, the distance between grid items
        itemWidth: 215 // Optional, the width of a grid item
    };

    /**
     * Refreshes the layout.
     */
    function applyLayout() {
        options.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#ReleventCuisine li');
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
            data:{startCount:startCount,count:Returncount},
            success: onLoadData
        });
    };

    /**
     * When scrolled all the way to the bottom, add more tiles.
     */
    function onScroll(event) {
        if($(document).scrollTop()<242){
            $('#Feathred-left-position').fadeOut();
        }
        else{
            $('#Feathred-left-position').fadeIn();
        }
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
     * When Ajax has been sucessfully completed, then do following thing
     * @param data
     */

    function onLoadData(data){
        console.log(data);
        isLoading = false;
        $('.Ajax-loading').fadeOut();
        var html = '';
        var i=0, length=data.length, image;
        for(; i<length; i++) {
            image = data[i];
            if(image.PicPath.length){
                if(image.CuisineID!==$('#GetCurrentCuID').val()){
                    html += '<li>';
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
                    html += '<h6>'+image.CuisineName+'</h6>';
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

        }
        // Add image HTML to the page.

        $(html).hide().fadeIn(1000).appendTo($('#ReleventCuisine'));
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
     * if user click detail page's cuisine then uses below function
     */
        //only for cuisine-detail page
    $('body').on('click','#ReleventCuisine>li',function(){

        if($(this).parent().parent().hasClass('Imagetiles-detail')){
            $(this).parent().parent().parent().parent().parent().parent().remove();

        }
        var AjaxContainter = {};
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
        }
    });

    /**
     * if user click read more link, then execute follow function
     */
    /****************************************Cuisine Detail Description************************************************/
    $('body').on('click','#ClickReadMore',function(){
        var CuisineDescription=encodeURIComponent($('#CuisineDescriptWrap').text());
        var CuisineName=encodeURIComponent($('#CuisineName').text());
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/Cuisine-description?CuisineName='+CuisineName+'&MoreDescription='+CuisineDescription, '', function(){
                $modal.modal();
            });
        }, 1000);
    });



    /**
     * Return to previous page by click below arrow function
     */
    $('body').on('click','#Feathred-left-position',function(){
        window.location = 'order?RootID='+$('#RootID').val()+'&SubID='+$('#SubID').val();

    });

    /**
     * Click #Navcomments to swithch comment or wataerfall
     */

    $('body').on('click','#Navcomments',function(){//arrow click event between comments and waterfall
        if($(this).hasClass('fa-arrow-circle-down')){
            $(this).removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            // set Up the Css name of Featured page
            var name = "CssId";
            var value = "commentSt";
            var dataObj = {};
            dataObj[name]=value;
            AjaxFunction("#ClickToComment",dataObj,"Common-comments.php",1);
            dataObj=null; //destry the container
        }

        else if($(this).hasClass('fa-arrow-circle-up')){
            $(this).removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            var name="mode";
            var value="mode2";
            var dataObj={};
            dataObj[name]=value;
            AjaxFunction("#ClickToComment",dataObj,"Common-waterfall.php",1);
            dataObj=null;
        }
    });

    /**
     * Click class .CuisineCommentStar to go to comment for current cuisine
     */
    $('body').on('click','.CuisineCommentStar',function(){
        var CurrentUserID=encodeURIComponent($('#CurrentLoginedUserID').val());
        var CuisineID=encodeURIComponent($('#GetCurrentCuID').val());
        var CuisineName=encodeURIComponent($('#CuisineName').text());
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/Cuisine-comment?CuisineName='+CuisineName+'&CurrentUserID='+CurrentUserID+'&CuisineID='+CuisineID, '', function(){
                $modal.modal();
            });
        }, 1000);

    });

    /**
     * following function of CuisineCommentStar is for when user clicks stars
     */
    $modal.on('click','.CuisineCommentStar-given',function(){
        var getThisLength = $('.CuisineCommentStar-given').length;
        for (var i=0;i<getThisLength;i++){
            if($('.CuisineCommentStar-given').hasClass('fa-star')){
                $('.CuisineCommentStar-given').eq(i).removeClass('fa-star').addClass('fa-star-o');
            }

        }

        var CurrentLength = $('.CuisineCommentStar-given').index($(this));
        for (var i=0;i<CurrentLength+1;i++){
            if($('.CuisineCommentStar-given').hasClass('fa-star-o')){
                $('.CuisineCommentStar-given').eq(i).removeClass('fa-star-o').addClass('fa-star');
            }

        }

    });

    /**
     * Prepare submit Cuisine comment
     */
    /***********************************Submit cuisine comment******************************************/
    $modal.on('click','.submitCuisineComment',function(){
        var CurrentCuisineID = $('#CommentCuisineID').val();
        var CurrentUserID = $('#CommentCurrentUserID').val();
        var Currentstars =  $('.CuisineCommentStarGroup').find('.fa-star').length;
        var CurrentCommentContent = $('#cuisine-comment-area').val();
        var tmp={};
        tmp['CurrentCuisineID'] = CurrentCuisineID;
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



        AJAXpassTempCuisineComment(tmp);
    });


    /**
     * Ajax pass the tmp comment data to backend-controller
     */
    function AJAXpassTempCuisineComment(tmp){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/FrontEnd-controller/FrontEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });
        request.done(function( msg ) {
           if(msg){
               AjaxMessageSuccess('alert-success','Congratulations! you have successfully submited the comment, please waiting for you comment review.');
               setTimeout(function(){$('#ajax-modal').modal('hide');},4000);
           }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

    /**
     * $modal info
     */
    function AjaxMessageSuccess(className,info){

        $modal.modal('loading');
        setTimeout(function(){
            $modal
                .modal('loading')
                .find('.modal-body').empty()
                .prepend("<div class='alert " + className + " fade in'>" + info + "</div>");

        }, 1000);

    }


});