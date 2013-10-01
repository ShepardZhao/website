<?php include '../../header.php'?>
<script src="<?php echo GlobalPath;?>/cms/customer-Management/Customer.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/CMS/customer-Management/style.css" />
<div class="container-fluid Customer-margin">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header"><a href="#MyOrder" data-toggle="tab">My Order</a></li>
                    <li class="nav-header"><a href="#MyFaveourites" data-toggle="tab">My Faveourites</a></li>
                    <li class="nav-header"><a href="#MyAddressBook" data-toggle="tab">My Address Book</a></li>
                    <li class="nav-header"><a href="#MyRewardPoints" data-toggle="tab"> My Reward Points</a></li>
                    <li class="nav-header"><a href="#MyPrpfile" data-toggle="tab"> My Profile</a></li>        
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span9 rightContent">
            <div class="tab-content">
                <div class="tab-pane active" id="MyOrder">
                    <p>This area displays My order</p>
                </div>

                <div class="tab-pane" id="MyFaveourites">
                    <p>This area displays My MyFaveourites</p>
                </div>
                <div class="tab-pane" id="MyAddressBook">
                    <ul class="nav nav-pills MyAddressBook_li">

                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                               Default Address
                            </label>
                        </li>
                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" >
                                Default Address
                            </label>
                        </li>

                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                                Default Address
                            </label>
                        </li>
                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios4" value="option4" >
                                Default Address
                            </label>
                        </li>


                    </ul>

                </div>
                <div class="tab-pane " id="MyRewardPoints">
                    <p>This area displays My MyRewardPoints</p>
                </div>
                <!--My Profile start-->
                <div class="tab-pane " id="MyPrpfile">
				<div class="row-fluid text-center">
				
				
				<div class="span6">
				<h4 class="text-left">Basic Profile Setting</h4>
				<div class="form-horizontal">
				<!--Customer ID-->
				<div class="control-group">
				    <label class="control-label">Customer ID:</label>
				    <div class="controls">
				      <input type="text" id="CustomerID" disabled>
				    </div>
				  </div>
				<!--Customer Name-->
				<div class="control-group">
				    <label class="control-label">Full Name:</label>
				    <div class="controls">
				      <input type="text" id="CustomerName" placeholder="Please input your Full Name">
				    </div>
				  </div>  
				 <!--Customer First Name-->
				 <div class="control-group">
				     <label class="control-label">First Name:</label>
				     <div class="controls">
				       <input type="text" id="CustomerFirstName" placeholder="Please input your First Name">
				     </div>
				   </div>
				   
				   <!--Customer Last Name-->
				   <div class="control-group">
				       <label class="control-label">Last Name:</label>
				       <div class="controls">
				         <input type="text" id="CustomerLastName" placeholder="Please input your Last Name">
				       </div>
				     </div>
				   
				   <!--Customer Phone-->
				   <div class="control-group info">
				       <label class="control-label">Phone:</label>
				       <div class="controls">
				         <input type="text" id="CustomerPhone" placeholder="Please input your phone here">
				         
				       </div>
				     </div>
				   <!--Customer Photo-->
				   <div class="control-group">
				       <label class="control-label">Customer Photo:</label>
				       <div class="controls">
				         <input type="file" id="CustomerPhoto">
				       </div>
				     </div>
				   
				   </div>  
				   
	  
				</div>
				
				
				<div class="span6">
					<img src="..." id="CustomerPhotoPrev" class="img-circle">
				</div>
				
				</div>

				

                </div>
				   				   <hr>


            </div>
            <div class="bottonPng"></div>

        </div>

    </div><!--/row-->


</div><!--/.fluid-container-->

<?php include '../../footer.php'?>
  
