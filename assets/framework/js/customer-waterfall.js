$(document).ready(function(){
    //index
    $(function(){
        //marquee waterfall
        if($('.waterfall').length>0){

            $('body').css('overflow','hidden');
            var containter="#main";
            var subcontainter="#tiles";
            var licontainter="#tiles li";
            Waterfall(containter,subcontainter,licontainter);
            $("#main").kxbdMarquee({direction:"up",isEqual:true});
            //waterfall hover function
            $(function() {
                $("#main ul").children("li").each(function() {
                    $(this).mouseover(function() {
                        $(this).find('.mask').fadeIn('fast');
                        $(this).find('.text').fadeIn('fast');
                    });
                    $(this).mouseout(function () {
                        $(this).find('.mask').hide();
                        $(this).find('.text').hide();

                    });
                });
            });
        }

        if ($('.FeaturedImage').length>0){
            var containter=".Imagemain";
            var subcontainter=".Imagetiles";
            var licontainter=".Imagetiles li";

            Waterfall(containter,subcontainter,licontainter);

        }


    });


    function Waterfall(containter,subcontainter,licontainter){

        //Index waterfall options
        $(subcontainter).imagesLoaded(function() {
            var handler = null;

            // Prepare layout options.
            var options = {
                autoResize: true, // This will auto-update the layout when the browser window is resized.
                container: $(containter), // Optional, used for some extra CSS styling
                offset: 10, // Optional, the distance between grid items
                outerOffset: 0, // Optional, the distance to the containers border
                itemWidth: 210 // Optional, the width of a grid item
            };

            function applyLayout() {
                $(subcontainter).imagesLoaded(function() {
                    // Destroy the old handler
                    if (handler.wookmarkInstance) {
                        handler.wookmarkInstance.clear();
                    }

                    // Create a new layout handler.
                    handler = $(licontainter);
                    handler.wookmark(options);
                });
            }

            // Call the layout function.
            handler = $(licontainter);
            handler.wookmark(options);
        });


    }


//Order-Feathured
    $('.Imagetiles li').mouseenter(function(){
        $(this).find('.foodName').removeClass('optionsHide').stop().fadeOut(200);
        $(this).find('.RetaurantName').addClass('optionsHide').stop().fadeIn(200);
        $(this).find('.TopOptions').stop().slideDown();
    }).mouseleave(function(){

            $(this).find('.foodName').addClass('optionsHide').stop().fadeIn(200);
            $(this).find('.RetaurantName').removeClass('optionsHide').stop().fadeOut(200);
            $(this).find('.TopOptions').stop().slideUp();

        });










});