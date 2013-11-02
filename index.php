<?php include 'header.php'?>
<div class="container-fluid"><!--bodywrap begin-->
	<div class="row-fluid waterfall">
		<div class="span12"> <!--waterfall begin-->
            <div id="main" role="main">
                <ul id="tiles">
                    <!-- These is where we place content loaded from the Wookmark API -->
                </ul>
            </div>
               </div>
		</div><!--waterfall end-->
</div><!--bodywrap end-->

<!--index js files begin -->

    <script src="<?php echo GlobalPath;?>/assets/framework/js/jquery.marquee.js"></script>
    <!-- Include the imagesLoaded plug-in -->
    <script src="<?php echo GlobalPath;?>/assets/framework/js/jquery.imagesloaded.js"></script>
    <!-- Include the plug-in -->
    <script src="<?php echo GlobalPath;?>/assets/framework/js/jquery.wookmark.min.js"></script>
    <script src="<?php echo GlobalPath;?>/assets/framework/js/customer-waterfall.js"></script>

<!--index js files end-->



<?php include 'footer.php'?>