/**
 * Created by zhaoxun321 on 3/11/2013.
 */
$(document).ready(function(){

        var handler = null,
            index=0;
            startCount = 0,
            Filter =new Array(),
            Returncount = 8,
            isLoading = false,

            apiURL =  CurrentDomain+'/json/?GetResAndCuByRootL='+$('#RootLocationName').val();
        // Prepare layout options.
        var options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
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
                data:{startCount:startCount,count:Returncount,filter:Filter},
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
            $('#Ajax-loading').fadeOut();
            // Create HTML for the images.
            var html = '';
            var i=0, length=data.length, image;
        console.log(data);
            for(; i<length; i++) {
                image = data[i];
                if(image.PicPath!==null){
                    html += '<li>';
                    if(image.CuisinePrice!==undefined){
                    html += '<div class="TopOptions">';
                    html += '<div class="span4">';
                    html += '<h5><i class="BackgroundOfStarAndPlus fa fa-heart-o"></i></h5>';
                    html += '</div>';
                    html += '<div class="span4 blodOfPrice"><h5>$'+image.CuisinePrice+'</h5>';
                    html += '</div>';
                    html += '<div class="span4">';
                    html += '<h5><i class="BackgroundOfStarAndPlus fa fa-plus"></i></h5>';
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
            $('#Imagetiles').append(html);

            // Apply layout.
        if(length!==0){
            applyLayout();
        }
            hoverfunction();
            if(startCount===0){
            startCount=Returncount;
            }
            else{
                startCount+=startCount;
            }

    };

        // Capture scroll event.
        $(document).bind('scroll', onScroll);

        // Load first data from the API.
    loadData();

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



/*****************************************Filter tags******************************************************/
$('body').on('click','.TagWidthOverflow>li',function(){//filter tages
    if($(this).hasClass('active')){
        Filter[index]= $(this).find('a').text();
    }
    else{
        Filter.splice( $.inArray($(this).find('a').text(),Filter) ,1 );
    }
    index++;
    Filter.sort();
    $('#Imagetiles').empty();
    startCount=0;
    loadData();

});
















});


