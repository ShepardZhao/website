<?php include 'header.php'?>
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
                         <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                         As Soon As Possible
                     </label>

                     <label class="radio inline">
                         <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                         date1 date2
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
                    <div class="control-group">
                        <label class="radio">
                            <input type="radio" name="PaymentRadios" id="PaymentRadios" value="option1" checked>
                            Cash
                        </label>

                        <label class="radio inline">
                            <input type="radio" name="PaymentRadios" id="optionsRadios1" value="option1" checked>
                            PayPal
                        </label>
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
<?php include 'footer.php'?>