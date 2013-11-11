<div class="span3 siderbar"><!--right calculate zone-->
    <div class="row-fluid">
    <div class="span12 topTitle">
        <h4 class="text-center orderlist">Order List</h4>
    </div>
     </div>
    <div class="row-fluid">
        <div class="span12 relvateBottom">
            <section class="clearfix"><!--addresss section begins-->
                <div class="span12">
                    <ul class="inline text-center">
                        <li><a id="QuestionMark" data-toggle="popover" data-placement="left" data-content="Click below arrow to collapse all address"><i class="fa fa-question-circle"></i></a></li>
                        <li><h5 class=" orderListColor">DELIVERY TO:</h5></li>
                    </ul>

                    <ul class="inline clearfix">
                        <li class="pull-left orderListColor orderListBloder">My Address book:</li>
                        <li class="pull-right orderListColor"><a id="switchArrow"><i class="fa fa-arrow-circle-o-right"></i></a></li>
                    </ul>
                </div>

                <div class="span12 address">
                        <!--display user's addressbook that is according to UID-->
                <?php echo $InitialUserMyaddressBookClass->DisplayAddressBookByUID($_SESSION['LoginedUserID']);?>
                </div>
            </section><!--address section ends-->

            <hr class="hrline"> </hr>

            <section class="clearfix"><!--order section begins-->
                <div class="row-fluid">
                <div class="span12">
                    <table class="table" id="orderTable">
                        <tbody>
                        <tr id="initialOrderListSMS"><td style="color:#c09853">There is nothing yet~~</td></tr>
                        </tbody>
                    </table>

                </div>
               </div>

            </section><!--order section ends-->


            <hr class="hrline"></hr>


            <section class="clearfix"><!--develivery section begins-->
                 <div class="row-fluid">
                     <div class="span12">

                         <table class="table">
                             <tr>
                                 <td> <h5>Delivery Fee:</h5></td>
                                 <td></td>
                                 <td><h5 class="text-right"><span class="price" id="DeliveryFee"><i>$</i><i class="Delivery_Margin"></i><a id="DeliveryQuestionMark" data-toggle="popover" data-placement="left" data-content="The delivery fee depends on region"><i class="cancel fa fa-question-circle"></i></a></span></h5></td>

                             </tr>

                         </table>
                     </div>
                 </div>
             </section><!--develivery section ends-->


            <hr class="hrline"> </hr>

            <section><!--total price begins-->
                <div class="row-fluid">
                    <div class="span12 text-center price">
                        <h2></h2>

                    </div>
                </div>
            </section><!--total price ends-->

            <hr class="hrline"> </hr>

            <section class="clearfix"><!--check section begins-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="control-group text-center">
                            <button type="botton" class="mySubmit checkOut"><h5>Check</h5></button>
                        </div>
                    </div>
                </div>
            </section><!--check section ends-->


            <div class="FrontbottonPng"></div><!--bottom png-->

        </div>
    </div>

</div>