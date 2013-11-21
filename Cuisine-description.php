<!--Display current cuisine Description-->
<?php if(isset($_GET['MoreDescription']) && isset($_GET['CuisineName'])){?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="text-center"><?php echo $_GET['CuisineName']?></h4>
    </div>
    <div class="modal-body">
        <?php echo $_GET['MoreDescription']?>

    </div>
<?php }?>