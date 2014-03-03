<div id="ConfigureManagerAndBinded">
    <div class="row-fluid">
        <div class="span12">

            <div class="divhead"><h4><i class="fa fa-list-alt">  Binding a manager with the Root ID</i><h4></div>
            <div class="basicInfo-box">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="input-append">
                            <!------------------------------Location selection ----------------------------------->
                            <select class="span8 SelectLocationID">
                            <?php
                                foreach($LocationClass -> GetRootLocationWithIDAskey() as $rootkey => $subvalue){
                                    foreach ($subvalue as $key => $value){
                                        echo "<option value='$key'>$value($key)</option>";
                                    }
                                }

                            ?>
                            </select>

                            <!--------------------------------Selection ----------------------------------------->
                            <select class="span8 SelectionManagerID">
                                <?php
                                foreach ($ManagerDelivererClass -> SelectManagerOrDeliverer('Manager') as $rootkey => $subvalue){
                                        echo "<option  value='$subvalue[UserID]'>$subvalue[UserMail]($subvalue[UserID])</option>";


                                }
                                ?>
                            </select>
                            <div class="btn-group">
                                <button class="btn submitManager">
                                    Binding
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!----------only display the query view table ------->
        <div class="row-fluid"> <div class="span12"></div></div>

            <div class="row-fluid">
            <div class="span12">
                <div class="divhead"><h4><i class="fa fa-list-alt">  Query or Edit or Delete Manager Status</i><h4></div>
                <div class="basicInfo-box">
                    <div class="row-fluid">
                        <div class="span12" id="refreshManagerTable">
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
