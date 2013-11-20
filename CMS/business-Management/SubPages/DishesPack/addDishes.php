<?php
require_once '../../../GobalConnection.php';
session_start();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="text-center">Add A New Dish</h3>
</div>
<div class="modal-body">
    <form id="AddNewDishForm">
        <!--Current Restarant ID-->
        <div class="control-group ">
            <h5>Your Restaurant ID:</h5>
            <input class="span2" type="text" id="CurrentResID" value="<?php echo $_SESSION['RestaruantID'];?>" disabled>
        </div>

        <!--Cuisine Name-->
        <div class="control-group ">
            <h5>Cuisine Name:</h5>
            <input class="input-block-level" id="CuName" type="text" placeholder="Cuisine Name">
        </div>
        <!--Cuisine Description-->
        <div class="control-group">
            <h5>Cuisine Description</h5>
            <textarea class="input-block-level" id="CuDescr" placeholder="Cuisine Description"></textarea>
        </div>
        <!--Cuisine Price-->
        <div class="control-group">
            <h5>Price</h5>
            <input class="input-block-level" id="CuPrice" type="number" pattern="[0-9]+([\,|\.][0-9]+)?" step="0.01" placeholder="Cuisine Price">
        </div>
        <!--Cuisine Avaliability-->
        <div class="control-group">
           <h5>Avaliability</h5>
            <select id="CuAvaliability">
                <option>Yes</option>
                <option>No</option>
            </select>
        </div>
        <!--Cuisine Tags-->
        <div class="control-group">
            <h5>Tags</h5>
            <label>Avaliability Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Availability","CuisineTags");?>
            <label>Cuisine Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Cuisine","CuisineTags");?>
            <label>Cuisine Type Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Type","CuisineTags");?>
            <label>Cuisine Price Tag</label>
            <?php echo $TagsClass->OupPutTagBySelecOption("Price","CuisineTags");?>
        </div>


        <!--Cuisine Order-->
        <div class="control-group">
            <h5>Order</h5>
            <div class="form-horizontal">
                <div class="control-group ">
                    <button type="botton" class="btn minbutton"> - </button>
                    <input class="span1 text-center NumberOfOrder" type="number" value="1">
                    <button type="botton" class="btn plusbutton"> + </button>
                </div>
            </div>
            <label class="alert alert-info">Note: This function is helping you to set up different order of Cuisine</label>
        </div>
        <div class="control-group text-center">
            <button type="submit" class="mySubmit" id="SumitAnewDish">Next</button>
        </div>
    </form>
</div>
