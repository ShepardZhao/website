<?php
    session_start();
    if($_GET['UserTempActiveCode']===$_SESSION['TempActiveCode']){
 ?>

<!--this place is about if Tempcode valided correct>



 <?php
    }
else {
 ?>
        <!--this place is about the if valid is fail>
<?php
}
?>


?>