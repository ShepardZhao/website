<div class="fixed_button_top"></div>
<!--footer zone--->
<footer class="row-fluid footer">
    <div class="span12" style="position:relative">
        <div style="position:absolute; right:0; top:9px;color: white;font-size: 8em;margin: 19px;"><i class="fa fa-times-circle footer-close"></i></div>


    </div>
</footer>
<div id="footerButton"><h4>About Us</h4></div>
<?php  echo $InitialLocationSelectClass->GetLocation('LoginedIn');?>
</body>

<!--------------------------------------------------some js function that may used------------------------------->

<!--information display-->
<div class="information-bar"></div>
<!--register--><!--&&--><!--password found-->
<div id="ajax-modal" class="modal hide fade" tabindex="-1"></div>
<div id="ajax-modal-cuisine-photo" class="modal hide fade large" tabindex="-1"></div>
<!--facebook element-->
<div id="fb-root"></div>
<!--added new item into current cart-->
<div class="AddedNewItem"></div>
<!--view purchased items from this div-->
<div class="VPurchaseItems"><div class="TempItemsPrice"><h4 class="text-center"></h4></div><div class="row-fluid" style="position:relative"><div class="span1 closeShoppingCart"><h4 class="text-center"><img src="<?php echo GlobalPath?>/assets/framework/front-images/cancel.png"></h4></div><div class="span11 VPurchaseItemsInner"><div class="Item-loading"><img src="<?php echo GlobalPath?>/assets/framework/img/ajax-loader.gif"></div></div></div></div>
<script src="<?php echo GlobalPath;?>/assets/framework/js/Facebook-Api.js" type="text/javascript"></script>
<!-- modal style sheet for extention-->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/assets/framework/css/bootstrap-modal.css" />
<!-- Include the plug-in -->
<script src="<?php echo GlobalPath;?>/assets/framework/js/bootstrap-modal.js"></script>
<!-- Include the plug-in -->
<script src="<?php echo GlobalPath;?>/assets/framework/js/bootstrap-modalmanager.js"></script>
<!-- typedhead search js-->
<script src="<?php echo GlobalPath;?>/assets/framework/js/typedhead.js"></script>
</html>

