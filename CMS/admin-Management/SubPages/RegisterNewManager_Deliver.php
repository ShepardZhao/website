<div id="RegisterNewManager_Deliver">
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt"> Register A Manager or Deliver</i><h4></div>
            <div class="basicInfo-box">
                <form class="DisplayForm" id="Register_Manager_Deliverer_form">
                    <div class="span12 text-center">
                        <div class="form-horizontal">

                            <div class="control-group">
                                <label class="control-label">Manager&Deliver's Email(As LoginedUserName):</label>
                                <div class="controls text-left">
                                    <input type="email" class="span8" id="Manager_DeliverEmail" >
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Manager&Deliver's Password:</label>
                                <div class="controls text-left">
                                    <input type="password" class="span8" id="Manager_DeliverPassword">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Manager&Deliver's Real(Nick) Name:</label>
                                <div class="controls text-left">
                                    <input type="text" class="span8" id="Manager_Deliver_Name">
                                </div>
                            </div>


                            <div class="control-group">
                                <label class="control-label">Manager&Deliver's Phone:</label>
                                <div class="controls text-left">
                                    <input type="text" class="span8" id="Manager_Deliver_Phone">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Select Type:</label>
                                <div class="controls text-left">
                                    <select class="Manager_Deliver_selection">
                                        <option>Manager</option>
                                        <option>Deliverer</option>

                                    </select>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div id="infozone">
                        <button id="Manager_Deliver_submit" class="button" type="submit">Submit</button>
                        <br>
                        <br>

                    </div>
                </form>


            </div>
        </div>
    </div>

    <!----------------------------------------Query manager table--------------------------------------------->
    <div class="row-fluid"><div class="span12"></div></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt"> Query and configure Manger table</i><h4></div>
            <div class="basicInfo-box ManagerTable">
                <?php echo $ManagerDelivererClass -> qViewManagerOrDelivererTable('Manager')?>
            </div>
        </div>
    </div>

    <!----------------------------------------Query Delivery table--------------------------------------------->
    <div class="row-fluid"><div class="span12"></div></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt"> Query and configure Deliverer table</i><h4></div>
            <div class="basicInfo-box DeliververTable">
                <?php echo $ManagerDelivererClass -> qViewManagerOrDelivererTable('Deliverer')?>

            </div>
        </div>
    </div>


</div>