<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="text-center"><?php echo $_GET['CurrentCuisineName'];?><h6 style="color:rgb(244,112,99); text-align:center;">( Please choose material for current cuisine )</h6></h3>
</div>
<div class="modal-body">
    <input type="hidden" class="TempOrder" value="TempOrder">
    <input type="hidden" class="CurrentCuisineID" value="<?php echo $_GET['CurrentCuisineID'];?>">
    <input type="hidden" class="CurrentUserID" value="<?php echo $_GET['CurrentUserID']?>">
    <input type="hidden" class="CurrentResID" value="<?php echo $_GET['CurrentResID']?>">
    <input type="hidden" class="CurrentCuisineName" value="<?php echo $_GET['CurrentCuisineName']?>">
    <input type="hidden" class="CurrentCuisinePicPath" value="<?php echo $_GET['CurrentCuisinePicPath']?>">
    <input type="hidden" class="CurrentCuisinePrice" value="<?php echo $_GET['CurrentCuisinePrice']?>">

    <div id="SecondLevel">
        <div class="row-fluid">
            <div class="span12">
    <?php
        $GetSecondlevel = json_decode($_GET['CurrentCuisineSecondLevel'],true);
    foreach ($GetSecondlevel as  $rootKey => $subArray){
        foreach ($subArray as $subKey => $deepSubArray){
            if($subKey === 'SecondlevelTitle'){
                echo '<h5>'.$deepSubArray.'</h5>';
            }
            if($subKey === "SecondLevelContent"){
               foreach ($deepSubArray as $doubleDeepKey => $doubleDeepValue){
                   $count++;
                   if($doubleDeepKey === 'Radio'){
                     foreach ($doubleDeepValue as $tripleDeepKey => $tripleDeepValue){
                         echo '<label class="radio inline">';
                         echo '<input type="radio" name="'.$count.'" class="SecondLevelRadioChoice">';
                         foreach($tripleDeepValue as $finalKey => $finalValue){

                             if($finalKey === 'name'){
                                 echo '<i class="ChoosenName">'.$finalValue.'</i>';
                             }
                             else if($finalKey === 'price'){
                                 echo ' ( $<i class="ChoosenPrice">'.$finalValue.'</i> )';

                             }

                         }
                         echo '</label>';
                     }
                   }
                   else if($doubleDeepKey === 'MultiChoice'){
                       foreach ($doubleDeepValue as $tripleDeepKey => $tripleDeepValue){
                           echo '<label class="checkbox inline">';
                           echo '<input type="checkbox" name="'.$count.'" class="SecondLevelCheckbox">';
                           foreach($tripleDeepValue as $finalKey => $finalValue){

                               if($finalKey === 'name'){
                                   echo '<i class="ChoosenName">'.$finalValue.'</i>';
                               }
                               else if($finalKey === 'price'){
                                   echo ' ( $<i class="ChoosenPrice">'.$finalValue.'</i> )';

                               }


                           }
                           echo '</label>';
                       }
                   }

               }
            }
        }
    }



    ?>
            </div>
        </div>

    </div>
    <div class="row-fluid"><div class="span12"></div></div>
    <div class="control-group text-center">
        <button type="botton" class="mySubmit PreAddedToChart">Add</button>
    </div>
</div>