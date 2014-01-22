<?php include 'header.php'?>
<?php if(isset($_SESSION['LoginedUserID'])):$InitialLocationSelectClass->hiddenInitialLocation();?>
    <div class="container-fluid orderMargin">
        <div class="row-fluid bgconnection">
            <div class="span12 orderBG">
                <div class="form-horizontal">
                    <input type="hidden" class="UserID" value="<?php echo $_GET['UID'];?>">
                    <!--field part-->
                    <fieldset>
                        <h3 class="text-center">Your Order</h3>
                        <h4>Delivery to:</h4>
                        <p><i><h5 id="Necessary_address_zone"><?php echo $InitialLocationSelectClass->GetsSubLocalName($_GET['RootID'],$_GET['SubID']).', '.$InitialLocationSelectClass->GetsRootLocalName($_GET['RootID']);?></h5></i></p>
                        <div class="control-group">
                            <label class="control-label " >Room Number (Detail Address):</label>
                            <div class="controls">
                                <input type="text" class="input-xxlarge" id="input_DetailAddress" placeholder="Put your detail address including room number" value="<?php $DeAddress = explode(', ', $_GET['Address']); echo $DeAddress[0];?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label " >Name:</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="input_NameNecessay" placeholder="Please fill the name" value="<?php
                                if($_GET['AddressNickName'] !==''){
                                    echo $_GET['AddressNickName'];
                                }
                                else{
                                    echo $_GET['UserNickName'];
                                }

                                ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label " >Phone Number:</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="input_phoneNumber" placeholder="Please fill the phone number"  value="<?php echo $_GET['AddressPhone']; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="checkbox">
                                <input type="checkbox" id="saveAsDefaultCheckbox"> <b>Save as Default</b>
                            </label>
                        </div>
                    </fieldset>

                    <!--field2-->
                    <fieldset>
                        <h4>Preferred Delivery Time:</h4>
                        <div class="control-group">
                            <label class="radio">
                                <input type="radio" name="perfectDeliveryTime"  class="perfectDeliveryTime" >
                                As Soon As Possible
                            </label>

                            <label class="radio inline">
                                <input type="radio" name="perfectDeliveryTime" class="perfectDeliveryTime">
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
                        <div class="row-fluid" id="OrderItems-zone">
                            <div class="span12 OrderItems"></div>
                        </div>
                    </fieldset>
                    <!--fieldest-->
                    <fieldest>
                        <h4>Payment Method:</h4>
                        <div class="form-inline">
                            <label class="radio">
                                <input type="radio" name="PaymentRadios" class="PaymentRadios" value="cash" >
                                Cash
                            </label>
                            <img style="width:50px;height:32px;" src="/assets/framework/img/cash.png">


                            <label class="radio">
                                <input type="radio" name="PaymentRadios" class="PaymentRadios" value="paypal">
                                PayPal
                            </label>
                            <img style="width:50px;height:32px;" src="/assets/framework/img/paypal.png">
                        </div>
                    </fieldest>
                    <div class="row-fluid"><div class="span12"></div></div>
                    <div class="control-group text-center">
                        <button type="botton" class="mySubmit Finalcheck"><h5>Check</h5></button>
                    </div>
                </div>

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