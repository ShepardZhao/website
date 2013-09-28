<?php include '../../header.php'?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/CMS/style.css" />
<div class="container-fluid business-margin">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header active"><a href="#MyOrder " data-toggle="tab">My Order</a></li>
                    <li class="nav-header"><a href="#MyFaveourites" data-toggle="tab">My Faveourites</a></li>
                    <li class="nav-header"><a href="#MyAddressBook" data-toggle="tab">My Address Book</a></li>
                    <li class="nav-header"><a href="#MyRewardPoints" data-toggle="tab"> My Reward Points</a></li>
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span9 rightContent">
            <div class="tab-content">
                <div class="tab-pane active" id="MyOrder">
                    <p>This area displays My profile</p>
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


            </div>
            <div class="bottonPng"></div>

        </div>

    </div><!--/row-->


</div><!--/.fluid-container-->

<?php include '../../footer.php'?>
  
