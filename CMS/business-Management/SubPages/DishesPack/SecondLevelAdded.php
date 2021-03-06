<?php if(isset($_GET['CuID']) && isset($_GET['CuName'])):?>
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <input type="hidden" id="GetCuid" value="<?php echo $_GET['CuID']?>">
        <h3 id="TitleOfSecondLevel"><?php echo $_GET['CuName']?></h3>
    </div>
    <form id="SecondLevelForm">
        <div class="modal-body" id="SecondLevelWrap">
            <div class="row-fluid">
                <div class="span12">
                    <div class="form-horizontal">
                        <div class="control-group SecondTitleWrap">
                            <label class="control-label SecondLevelModalLabel">Title:</label>
                            <div class="controls text-left SecondLevelModalControl">
                                <input type="text" class="span9 SecondTitle" name="SecondLevelTitle[]" placeholder="Second level dish's type. i.e: pizza base">
                                <button class="button text-right button-delete SecondLevelButton-delete" type="button">Delete</button>

                            </div>
                            <!--SecondLevelCheckbox-->
                            <br>
                            <label class="checkbox SecondLevelCheckbox">
                                <input type="checkbox" id="SecondLevelCheckbox">
                                Multiple choice
                            </label>

                            <div class="form-inline SubSecondstyle">
                                <label>Name:
                                    <input type="text" class="SubSecondInput span8" name="SubLevelOfName[]" placeholder="i.e: extra cheese">
                                </label>
                                <label>Price:
                                    <input class="SubSecondInputPrice" type="number" pattern="[0-9]+([\,|\.][0-9]+)?" name="SubLevelOfPrice[]" step="0.01" placeholder="i.e: $2.00">
                                </label>
                                <button class="button text-right button-delete SubSecondButton-delete" type="button">Delete</button>
                            </div>

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
        </div>

        <div class="modal-footer">
            <button type="button" class="button floatstyle addedNewTitle">Add New Title</button>
            <button type="submit"  id="AddSecondLevelForm" class="button">Saving</button>
            <button type="button" data-dismiss="modal" class="button SubCancel">Cancel</button>
        </div>
    </form>

<?php else: ?>
<?php endif?>