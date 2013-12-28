/**
 * This js file is the funictional of dynamic search
 */
$(document).ready(function(){
    /**
     * initial variable
     */
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
        sendData($('.searchItem').val(),$('.searchChoice>h7').text());
        $('.SearchResult').fadeIn();
        }
    }

    /**
     * if current input function is empty then hide .SearchResult
     */
    function checkEmptySearchBlock(){
    if($('.searchItem').val() === ''){
        $('.SearchResult').fadeOut();
    }
    }

    /**
     * Send Ajax data to query
     */
    function sendData(value,type){
    $('<div class="AjaxLoading text-center"><img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif></div>').appendTo($('.SearchResult'));
        $.ajax({
            type: "GET",
            url: CurrentDomain+'/json/?Search=yes&GetSearchValue='+value+'&GetType='+type,//api,
            dataType: 'json',
            data:{startCount:startCount,count:limitedCount},
            success: onLoadData
        });
    }

    /**
     * Fecthing the result
     */
    function onLoadData(data){
        console.log(data);
        $('.AjaxLoading').fadeOut();
        isLoading = false;
        var html = '';
        if(data.length>0){
            isLoading = false;
            var i=0, length=data.length, type;
            for(; i<length; i++) {
                type = data[i];
                    if(type.RestID !== undefined){
                          html += '<div class="container-fluid">';
                          html += '<input type="hidden" class="RestID" value="'+type.RestID+'">';//Restaurants id
                          html += '<input type="hidden" class="ResName" value="'+type.ResName+'">';//Restaurants Name
                          html += '<input type="hidden" class="ResPicPath" value="'+type.PicPath+'">';//Restaurants PicPath
                          html += '<input type="hidden" class="ResAvailabilityTags" value="'+type.AvailabilityTags+'">';//Restaurants AvailabilityTags
                          html += '<input type="hidden" class="ResCuisineTags" value="'+type.CuisineTags+'">';//Restaurants CuisineTags
                          html += '<input type="hidden" class="ResTotalComments" value="'+type.TotalComments+'">';//Restaurants comments
                          html += '<input type="hidden" class="ResOpenTime" value='+JSON.stringify(type.ResOpenTime)+'>';//Restaurants ResOpenTime
                          html += '<input type="hidden" class="ResRating" value="'+type.ResRating+'">';//Restaurants ResRating
                          html += '<div class="row-fluid searchResearchAaea" style="max-height:60px; padding-top:9px;padding-bottom:9px">';
                          html += '<div class="span1">';
                          html += '<img src="'+type.PicPath+'" class="img-polaroid">';
                          html += '</div>';
                          html += '<div class="span2">';
                          html +=  type.ResName;
                          html += '</div>';
                          html += '<div class="span4">';
                          html += '<ul class="nav">';
                          for (var x=0;x<type.ResAvailability.length;x++){
                              html += '<li class="btn btn-mini pull-left">'+type.ResAvailability[x]+'</li>';
                          }
                         for (var y=0;y<type.ResCuisine.length;y++){
                            html += '<li class="btn btn-mini pull-left">'+type.ResCuisine[y]+'</li>';
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
                          html += '</div>';
                          html += '<div class="span1">';
                          html += '</div>';
                          html += '<div class="span1">';
                          html += '</div>';
                          html += '<div class="span1">';
                          html += '</div>';

                          html += '</div>';
                          html += '</div>';
                    }


                //Cuisine Part
                    if(type.CuisineID !== undefined){
                        html += '<div class="container-fluid">';
                        html += '<div class="row-fluid searchResearchAaea" style="max-height:55px; padding-top:9px;padding-bottom:9px">';
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
                        html += '</div>';
                        html += '<div class="span1" style="height:55px; line-height:55px;">';
                        html += '$'+type.CuisinePrice;
                        html += '</div>';
                        html += '<div class="span1" style="height:55px; line-height:55px;">';
                        html += '<i class="AddedToFavorite BackgroundOfStarAndPlus fa fa-heart-o"></i>';
                        html += '</div>';
                        html += '<div class="span1" style="height:55px; line-height:55px;">';
                        html += '<i class="AddedToFavorite BackgroundOfStarAndPlus fa fa-plus"></i>';
                        html += '</div>';
                        html += '</div>';
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
            console.log(1);
            $("<div class='text-center'><h4>Sorry, there is no result that matches to your query</h4><h4><i class='fa fa-frown-o'></i><h4></div>").hide().fadeIn(1000).appendTo($('.SearchResult'));

        }

        $(html).hide().fadeIn(1000).appendTo($('.SearchResult'));
       }


    /**
     * Clike result of search and redirect to relative page
     */
    $('body').on('click','.SearchResult>.container-fluid',function(){
       if($(this).find('.RestID').val()!==''){
            //passParamterToResOnly($(this));
        }
    });






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
        sendData($('.searchItem').val(),$('.searchChoice>h7').text());

    });



});