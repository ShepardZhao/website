$(window).load(function(){
    $('#main').kxbdMarquee({direction:"up",isEqual:true});
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
            var closeToBottom;
            // Only check when we're not still waiting for data.
            if(!isLoading) {

                 closeToBottom =true;
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
                type:'GET',
                url: apiURL,
                dataType: 'json',
                cache : false,
                success: onLoadData,
                error:function(xhr, status, errorThrown) {
                    alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
                }
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
                if(image.PicPath.length){
                    html += '<li>';

                    // Image tag (preview in Wookmark are 200px wide, so we calculate the height based on that).
                    html += '<img src="'+image.PicPath+'" width="'+image.PicWidth+'" height="'+image.PicHeight+'" >';

                    html += '<div class="mask">';

                    html += '<label class="text">';

                    html += '<blockquote>';
                    if(image.CuisineName===undefined){
                        html += '<p style="width:180px">'+image.ResName+'</p>';
                    }
                    else{
                        html += '<p style="width:180px">'+image.CuisineName+'</p>';
                        html += '<small style="width:180px"><i>by '+image.CuisineResName+'</i></small>'
                    }
                    html += '</blockquote>';

                    html += '</label>';

                    html += '</div>';

                    html += '</li>';
                }
            }


            // Add image HTML to the page.
            $(html).hide().appendTo($('#tiles'));

            // Apply layout.

            applyLayout();

            //index
            if ($('#tiles').length>0){
                $('body').css('overflow','hidden');//overflow hidden
                var mainHeight= $(document).height();
                $('#main').css('height',mainHeight+'px');
            }

        };

        setInterval(onScroll,20000);

        // Load first data from the API.
        loadData();
    });





});