<div id="ConfigureManagerAndBinded">
    <div class="row-fluid">
        <div class="span12">

            <div class="divhead"><h4><i class="fa fa-list-alt">  Added a manager and binded with Root ID</i><h4></div>
            <div class="basicInfo-box">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="input-append">
                            <select class="span8">
                            <?php
                                foreach($LocationClass -> GetRootLocationWithIDAskey() as $rootkey => $subvalue){
                                    foreach ($subvalue as $key => $value){
                                        echo "<option class='SelectedLocationID' id='$key' value='$value'>$value</option>";
                                    }
                                }

                            ?>
                            </select>


                            <input class="input-xlarge" id="managerInputFiled" type="text">
                            <div class="btn-group">
                                <button class="btn submitManager">
                                    Add
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
