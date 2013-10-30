<?php require_once '../../../GobalConnection.php';?>
<?php if(isset($_GET['CuID']) && isset($_GET['CuName'])):?>
    <?php $getArray=json_decode($CuisineClass->GetSecondLevelofCuisine($_GET['CuID']));
    $count=0;
    session_start();
    $tmpID=array();
    $tmpTitle=array();
    $tmpContent=array();
    $SecondLevelCompeteArray=array(); //this array struct will be used below
    //Create temp array to save the value according to current CuID
    foreach ($getArray as $TopKey=>$SubArray){
        foreach ($SubArray as $key=>$content){
            if($key==='SecLevelCuID'){
                array_push($tmpID,$content);
            }
            if($key==='SeLevelTitle'){
                array_push($tmpTitle,$content);
            }
            if($key==='SeLevelMultiple'){
                array_push($tmpContent,$content);
            }
        }
    }

    //Put content into the new array
    for($i=0;$i<count($tmpTitle);$i++){
        $SecondLevelCompeteArray[$tmpTitle[$i]]=$tmpContent[$i];
    }

    $_SESSION['UpdateID']=$tmpID;
    ?>
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <input type="hidden" id="GetCuid" value="<?php echo $_GET['CuID']?>">
        <h3 id="TitleOfSecondLevel"><?php echo $_GET['CuName']?></h3>
    </div>
    <form id="SecondLevelForm">
        <div class="modal-body" id="SecondLevelWrap">
            <?php foreach ($SecondLevelCompeteArray as $index=>$Value){?>
                <div class="row-fluid">
                        <div class="span12">
                            <input type="hidden" name="UpdateKey[]" class="UpdateKey" value="<?php echo $_SESSION['UpdateID'][$count++];?>">
                            <div class="form-horizontal">
                            <div class="control-group SecondTitleWrap">
                                <label class="control-label SecondLevelModalLabel ">Title:</label>
                                <div class="controls text-left SecondLevelModalControl">
                                    <input type="text" class="span9 SecondTitle" name="SecondLevelTitle[]" value="<?php echo $index?>" placeholder="Second level dish's type. i.e: pizza base">
                                    <button class="button text-right button-delete SecondLevelButton-delete" type="button">Delete</button>

                                </div>

                                <!--SecondLevelCheckbox-->
                                <br>
                                <label class="checkbox SecondLevelCheckbox">
                                    <input type="checkbox" id="SecondLevelCheckbox">
                                    Multiple choice
                                </label>
                                <?php foreach (unserialize($Value) as $contentIndex=>$contentIndexValue){?>
                                    <div class="form-inline SubSecondstyle">

                                        <?php foreach ($contentIndexValue as $contentNameAndPrice=>$NameAndPrice){?>
                                            <?php if ($contentNameAndPrice==='name'):?>
                                                <label>Name:
                                                    <input type="text" class="SubSecondInput span8" name="SubLevelOfName[]" value="<?php echo $NameAndPrice;?>" placeholder="i.e: extra cheese">
                                                </label>
                                            <?php elseif ($contentNameAndPrice==='price'):?>
                                                <label>Price:
                                                    <input class="SubSecondInputPrice" type="number" pattern="[0-9]+([\,|\.][0-9]+)?" value="<?php echo $NameAndPrice;?>" name="SubLevelOfPrice[]" step="0.01" placeholder="i.e: $2.00">
                                                </label>
                                            <?php endif?>

                                        <?php }?>
                                        <button class="button text-right button-delete SubSecondButton-delete" type="button">Delete</button>

                                    </div>
                                <?php }?>



                                <div class="row-fluid AddNewButtonZone">
                                    <div class="span12 text-center">
                                        <button class="button subbutton subAddNewBotton"  type="button">Add New</button>
                                    </div>
                                </div>
                            </div>
                            <label class="alert alert-info">Note: If you want to add new name and pric for current title, please click 'Add New' with bule button </label>
                        </div>
                    </div>
                </div>

            <?php }?>

        </div>

        <div class="modal-footer">
            <button type="button" class="button floatstyle addedNewTitle">Add New Title</button>
            <button type="submit"  id="UpdateSecondLevelForm" class="button">Saving</button>
            <button type="button" data-dismiss="modal" class="button SubCancel">Cancel</button>
        </div>
    </form>



<?php else: ?>

<?php endif?>