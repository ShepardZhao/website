<div id="ConfigureDeliververAndManager">
    <div class="row-fluid">
        <div class="span12">

            <div class="divhead"><h4><i class="fa fa-list-alt">  Binding a delivever with the Manager</i><h4></div>
            <div class="basicInfo-box">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="input-append">
                            <!------------------------------Manager selection ----------------------------------->
                            <select class="span6 _SelectionManagerID">
                                <?php
                                foreach ($ManagerDelivererClass -> SelectManagerOrDeliverer('Manager') as $rootkey => $subvalue){
                                    echo "<option  value='$subvalue[UserID]'>$subvalue[UserMail]($subvalue[UserID])</option>";
                                }
                                ?>
                            </select>

                            <!--------------------------------Deliverver Selection ----------------------------------------->
                            <select class="span6 _SelectionDelivererID">
                                <?php
                                foreach ($ManagerDelivererClass -> SelectManagerOrDeliverer('Deliverer') as $rootkey => $subvalue){
                                    echo "<option  value='$subvalue[UserID]'>$subvalue[UserMail]($subvalue[UserID])</option>";
                                }
                                ?>
                            </select>
                            <div class="btn-group">
                                <button class="btn submitDeliverver">
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
                <div class="divhead"><h4><i class="fa fa-list-alt">  Query or Edit or Delete Deliverer Status</i><h4></div>
                <div class="basicInfo-box">
                    <div class="row-fluid">
                        <div class="span12" id="refreshDeliververTable">
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
