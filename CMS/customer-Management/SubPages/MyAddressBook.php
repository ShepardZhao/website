<div class="row-fluid">
    <div class="span12 text-center">
        <h4 class="text-left">Add and Manage Address books</h4>
        <div class="controls controls-row">
            <input class="span2" type="text" id="AddNickName" placeholder="Nick Name">
            <input class="span2" type="text" id="AddPhone" placeholder="Phone">
            <input class="span2" type="text" id="AddAdress" placeholder="Address">
            <input class="span3" type="text" id="AddSubLocation" value="<?php echo $_SESSION['SubLocation'];?>" disabled>
            <input class="span3" type="text" id="AddRootLocation" value="<?php echo $_SESSION['RootLocation'];?>" disabled>


        </div>
        <div class="control-group text-left">
            <div class="controls">
                <button id="AddressBookButton" class="button" type="button">Add</button>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row-fluid">
    <div class="span12 text-center">
        <h4 class="text-left">Select default Address or Remove it</h4>
        <ul class="thumbnails">
            <?php $MyaddressBookClass->loopDisplayAddressCard($_SESSION['LoginedUserID']);?>
        </ul>
        <div class="control-group text-left">
            <div class="controls">
                <button id="AddressBookDefaultButton" class="button" type="button">Confirm</button>
                <button id="AddressBookRemoveButton" class="button" type="button">Remove</button>

            </div>
        </div>

    </div>
</div>