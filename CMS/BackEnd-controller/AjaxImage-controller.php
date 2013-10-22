<?php
include '../GobalConnection.php';

$path =$_SERVER['DOCUMENT_ROOT'];
if(isset($_POST['Mode_UserPic'])){

//this is return the usrPic
$returPath='/assets/assets-imgs/UserPic/';//this needed to be change on gobal-define page
$paths=$path.$returPath; // this part should be changed while new server using
}
//this is return the Other Pic
elseif(isset($_POST['Mode_Location'])){
$returPath='/assets/assets-imgs/LocationPic/';//this needed to be change on gobal-define page
$paths=$path.$returPath; // this part should be changed while new server using

}
//this is return the CuisinePic
elseif(isset($_POST['Mode_CuisinePic'])){

$returPath='/assets/assets-imgs/CuisinePic/';//this needed to be change on gobal-define page
$paths=$path.$returPath; // this part should be changed while new server using
}
//this is return the RestaurantsPic
elseif(isset($_POST['Mode_RestaurantPic'])){
$returPath='/assets/assets-imgs/RestaurantPic/';//this needed to be change on gobal-define page
$paths=$path.$returPath; // this part should be changed while new server using
}



$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    $fileElementName = $_POST['Input_Photo'];

    $name = $_FILES[$fileElementName]['name'];
    $size = $_FILES[$fileElementName]['size'];
    //only for croped file
    if(isset($_POST['CropedCuisine']) && isset($_POST['Mode_CuisinePic'])){
        retrunImage($_POST['GetCurrentCuid'],$_POST['resizeOldWidth'],$_POST['resizeOldHeight'],$_POST['CuisineW'],$_POST['CuisineH'],$_POST['CuisineOldImagePath'],$_POST['CuisineX'],$_POST['CuisineY'],$paths,$_POST['EncryptedName'],$returPath,$_POST['WaterMarkerStatus'],$_POST['WaterMarkerPositon']);
    }

    else
    {
    if(!is_dir($paths)){
        mkdir($paths, 0777);
        chmod($paths, 0777);
    }

    if(strlen($name))
    {
        list($txt, $ext) = explode(".", $name);
        if(in_array($ext,$valid_formats))
        {
            if($size<(1024*1024)) // Image size max 1 MB
            {
                $actual_real_image_name = time().".".$ext;


                $tmp = $_FILES[$fileElementName]['tmp_name'];

                if(move_uploaded_file($tmp, $paths.$actual_real_image_name))
                {
                   if(isset($_POST['Mode_CuisinePic'])){
                     echo $paths.$actual_real_image_name.','.$returPath.$actual_real_image_name.','.$actual_real_image_name; //absolute path only for cuisine photo
                    }
                    else{
                     echo  $returPath.$actual_real_image_name; // relative path for location, resturant's photo and user avatar
                    }
                }
                else{
                    echo "Error:failed";
                 }
            }
            else
                echo "Error:Image file size max 1 MB";
        }
        else
            echo "Error:Invalid file format..";
    }
    else
        echo "Error:Please select image..!";
    exit;
    }
}


function retrunImage($GetCurrentID,$OldWidth,$OldHeight,$CuisineW,$CuisineH,$CuisineOldImagePath,$CuisineX,$CuisineY,$savePath,$EncryptedName,$returPath,$WaterMarkerStatus,$WaterMarkerPositon){
try{
    $targ_w = $CuisineW;
    $targ_h = $CuisineH;
    $jpeg_quality = 2000;
    $savePath=$savePath.$EncryptedName;
    //using class to crop image first
    $resizeObj = new resize($CuisineOldImagePath);
    $resizeObj -> resizeImage($OldWidth, $OldHeight, 'crop');
    $resizeObj -> saveImage($savePath, $jpeg_quality);
    //on slection and uploading
    echo $resizeObj -> OnselectSave($CuisineOldImagePath,$targ_w,$targ_h,$CuisineX,$CuisineY,$CuisineW,$CuisineH,$CuisineOldImagePath,$savePath,$jpeg_quality,$returPath,$WaterMarkerStatus,$WaterMarkerPositon);


}
catch(Exception $e){
    echo $e->getMessage();

}

}


?>




