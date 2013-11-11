<?php include 'header.php'?>
<?php session_start(); if(isset($_SESSION['LoginedUserID'])):$InitialLocationSelectClass->hiddenInitialLocation();?>
  <div class="container-fluid orderMargin">
   <div class="row-fluid bgconnection">
        <div class="span12 orderBG">
            <form class="form-horizontal">

             <!--field part-->
            <fieldset>
            <h3 class="text-center">Your Order</h3>
                <h4>Delivery to:</h4>
                <p><i>Build 2, Sydney Hospital, 8 Marqire street</i></p>
                <div class="control-group">
                    <label class="control-label " >First Name:</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label " >Room Number:</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label " >Phone Number:</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge">
                    </div>
                </div>
                <div class="control-group">
                    <label class="checkbox">
                        <input type="checkbox" > <b>Save as Default</b>
                    </label>
                </div>
            </fieldset>

             <!--field2-->
             <fieldset>
                 <h4>Preferred Delivery Time:</h4>
                 <div class="control-group">
                     <label class="radio">
                         <input type="radio" name="perfectDeliveryTime"  value="20" checked>
                         As Soon As Possible
                     </label>

                     <label class="radio inline">
                         <input type="radio" name="perfectDeliveryTime" id="perfectDeliveryTime">
                         <div class="datepair" data-language="javascript">
                             <input type="text" class="span6 times-picker ui-timepicker-input" placeholder="Click to choose time" autocomplete="off">
                             <input type="text" class="span6 date-picker" placeholder="and  date">
                         </div>
                     </label>
                 </div>
             </fieldset>
            <!--field3-->
             <fieldset>
                 <h4>Order List:</h4>
                 <div class="span12">
                   <div class="span4">123</div>
                   <div class="span3 offset2">321</div>
                   <div class="span3 pull-right">4124</div>
                 </div>
             </fieldset>
         <!--fieldest-->
                <fieldest>
                    <h4>Payment Method:</h4>
                    <div class="form-inline">
                        <label class="radio">
                            <input type="radio" name="PaymentRadios" id="PaymentRadios" value="cash" checked>
                            Cash
                        </label>
                        <img style="width:50px;height:32px;" src="/assets/framework/img/cash.png">


                            <label class="radio">
                                <input type="radio" name="PaymentRadios" id="optionsRadios1" value="paypal">
                                PayPal
                            </label>
                            <img style="width:50px;height:32px;" src="/assets/framework/img/paypal.png">


                        </div>


                </fieldest>
                <div class="control-group text-center">
                    <button type="botton" class="mySubmit"><h5>Check</h5></button>
                </div>
            </form>

        </div>
       <div class="FrontbottonPng"></div>

   </div>

  </div>
<?php else:?>
<?php endif?>
<script src="<?php echo GlobalPath;?>/CMS/Commons-js/jquery.timepicker.min.js"></script>
<script src="<?php echo GlobalPath;?>/assets/framework/js/bootstrap-datepicker.js"></script>
<script src="<?php echo GlobalPath;?>/assets/framework/js/order-check.js"></script>
<?php include 'footer.php'?>