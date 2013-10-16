<?php
require_once '../../../GobalConnection.php';
session_start();
?>
<?php if(isset($_GET['CUID'])):$GetCuisineData=json_decode($CuisineClass->ReturnDataOfNormalCuisineByID($_GET['CUID']));?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="text-center">Eedit Current Cuisine</h3>
</div>
<div class="modal-body">
    <form id="SumitModifyDishForm">

        <!--Current Cuisine's ID-->
        <div class="control-group ">
            <h5>Your Cuisine ID:</h5>
            <input class="span2" type="text" id="UpCurrentCuisineID" value="<?php echo $_GET['CUID'];?>" disabled>
        </div>

        <!--Cuisine Name-->
        <div class="control-group ">
            <h5>Cuisine Name:</h5>
            <input class="input-block-level" id="UpCuName" type="text" value="<?php echo $GetCuisineData[0]->CuName;?>" placeholder="Cuisine Name">
        </div>
        <!--Cuisine Description-->
        <div class="control-group">
            <h5>Cuisine Description</h5>
            <textarea class="input-block-level" id="UpCuDescr" placeholder="Cuisine Description"><?php echo $GetCuisineData[0]->CuDescr;?></textarea>
        </div>
        <!--Cuisine Price-->
        <div class="control-group">
            <h5>Price</h5>
            <input class="input-block-level" id="UpCuPrice"  type="text" value="<?php echo $GetCuisineData[0]->Price;?>" placeholder="Cuisine Price">
        </div>
        <!--Cuisine Avaliability-->
        <div class="control-group">
            <h5>Avaliability</h5>
            <select id="UpCuAvaliability">
                <?php if($GetCuisineData[0]->Avaliability==='Yes'):?>
                <option selected>Yes</option>
                <option>No</option>
                <?php else:?>
                <option>Yes</option>
                <option selected>No</option>
                <?php endif?>
            </select>
        </div>
        <!--Cuisine Tags-->
        <div class="control-group ReChooseTagsBackgroundWarning">
            <h5>Tags<small class='ReChooseTags'>--Please choose new tags below</small></h5>
            <label>Avaliability Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Availability","B2C.CuisineTags");?>
            <label>Cuisine Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Cuisine","B2C.CuisineTags");?>
            <label>Cuisine Type Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Type","B2C.CuisineTags");?>
            <label>Cuisine Price Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Price","B2C.CuisineTags");?>
        </div>


        <!--Cuisine Order-->
        <div class="control-group">
            <h5>Order</h5>
            <div class="form-horizontal">
                <div class="control-group">
                    <button type="botton" class="btn minbutton"> - </button>
                    <input class="span1 text-center NumberOfOrder" type="number" value="<?php echo $GetCuisineData[0]->CuOrder;?>">
                    <button type="botton" class="btn plusbutton"> + </button>

                </div>
            </div>
            <label class="alert alert-info">Note: This function is helping you to set up different order of Cuisine</label>
        </div>
        <div class="control-group text-center">
            <button type="submit" class="mySubmit" id="SumitModifyDish">Next</button>
        </div>
    </form>
</div>
<?php else:?>
    <?php require_once '../../../../Login-Logout/login-Error.php';?>
<?php endif ?>
