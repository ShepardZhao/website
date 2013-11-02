$(window).load(function() {
    $('#main').kxbdMarquee({direction:"up",isEqual:true});
     enableMask();
    setInterval(enableMask,5000);

    // executes when complete page is fully loaded, including all frames, objects and images
    function enableMask(){
    $("#tiles").children("li").each(function() {
        $(this).mouseenter(function() {
            $(this).find('.mask').fadeIn('fast');
            $(this).find('.text').fadeIn('fast');
        })
            .mouseleave(function() {
                $(this).find('.mask').fadeOut('fast');
                $(this).find('.text').fadeOut('fast');
            });
    });
    }


    //index
    if ($('#tiles').length>0){
        $('body').css('overflow','hidden');//overflow hidden
        var mainHeight= $(window).height();
        $('#main').css('height',mainHeight+'px');

    }



});

$(document).ready(function(){
    $(function(){
        var handler = null,
            isLoading = false,
            apiURL = CurrentDomain+'/json/?GetAllCuis=yes';

        // Prepare layout options.
        var options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $('#tiles'), // Optional, used for some extra CSS styling
            offset: 2, // Optional, the distance between grid items
        };

        /**
         * When scrolled all the way to the bottom, add more tiles.
         */
        function onScroll(event) {
            // Only check when we're not still waiting for data.
            if(!isLoading) {
                 var closeToBottom = ($('#main').scrollTop()  > $('#main').height()-100 );
                console.log(closeToBottom);
                if(closeToBottom) {
                    loadData();
                }
            }
        };

        /**
         * Refreshes the layout.
         */
        function applyLayout() {
            options.container.imagesLoaded(function() {
                // Create a new layout handler when images have loaded.
                handler = $('#tiles li');
                handler.wookmark(options);
            });
        };

        /**
         * Loads data from the API.
         */
        function loadData() {
            isLoading = true;

            $.ajax({
                url: apiURL,
                dataType: 'json',
                success: onLoadData
            });
        };

        /**
         * Receives data from the API, creates HTML for images and updates the layout
         */
        function onLoadData(data) {
            isLoading = false;
            // Create HTML for the images.
            var html = '';
            var i=0, length=data.length, image;
            for(; i<length; i++) {
                image = data[i];
                if(image.CuisinePicPath!==null){
                    html += '<li>';

                    // Image tag (preview in Wookmark are 200px wide, so we calculate the height based on that).
                    html += '<img src="'+image.CuisinePicPath+'">';

                    html += '<div class="mask">';

                    html += '<label class="text">';

                    html += '<blockquote>';

                    html += '<p>'+image.CuisineName+'</p>';

                    html += '<small><i>by'+image.CuisineResName+'</i></small>'

                    html += '</blockquote>';

                    html += '</label>';

                    html += '</div>';

                    html += '</li>';
                }
            }


            // Add image HTML to the page.
            $('#tiles').fadeIn().append(html);

            // Apply layout.
            applyLayout();
        };

        setInterval(onScroll,5000);
        //$(window).bind('change', onScroll);

        // Load first data from the API.
        loadData();
    });





//Order-Feathured
  $(function(){
    $('.Imagetiles li').mouseenter(function(){
        $(this).find('.foodName').removeClass('optionsHide').stop().fadeOut(200);
        $(this).find('.RetaurantName').addClass('optionsHide').stop().fadeIn(200);
        $(this).find('.TopOptions').stop().slideDown();
    }).mouseleave(function(){

            $(this).find('.foodName').addClass('optionsHide').stop().fadeIn(200);
            $(this).find('.RetaurantName').removeClass('optionsHide').stop().fadeOut(200);
            $(this).find('.TopOptions').stop().slideUp();

        });


    if ($('.FeaturedImage').length>0){
        var containter=".Imagemain";
        var subcontainter=".Imagetiles";
        var licontainter=".Imagetiles li";
    }

  });



});