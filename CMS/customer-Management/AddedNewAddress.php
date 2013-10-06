<?php session_start();?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="text-center">Added New Address Into your Address Book</h3>
</div>
<div class="modal-body">
    <form id="addNewAddressForm">

    <div class="control-group ">
    <input class="input-block-level RegSize" id="AddedNickName" type="text" placeholder="i.e:John smith">
    </div>

    <div class="control-group">
    <input class="input-block-level RegSize" id="AddedPhone" type="text" placeholder="i.e:032456455">
    </div>

    <div class="control-group">
    <input class="input-block-level RegSize" id="AddedExactlyAddress" type="text" placeholder="i.e:Unit 4">
    </div>

    <div class="control-group">
    <input class="input-block-level RegSize" id="AddedSubAddress" type="text" value="<?php echo $_SESSION['SubLocation'];?>" disabled>
    </div>

    <div class="control-group">
    <input class="input-block-level RegSize" id="AddedRootAddress" type="text" value="<?php echo $_SESSION['RootLocation'];?>" disabled>
    </div>

    <input  id="GetUserID" type="hidden" value="<?php echo $_SESSION['LoginedUserID'];?>" >

    <div class="control-group">
    <i>Notes: The address you added that will be automatically as default address.</i>
    </div>
    <div class="control-group text-center">
    <button type="submit" class="mySubmit" id="AddedNewAddressButton">Next</button>
    </div>

   </form>

</div>

