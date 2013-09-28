<?php

$path =$_SERVER['DOCUMENT_ROOT'];
$paths=$path.'/B2C/assets/assets-imgs/UserPic/'; // this part should be changed while new server using
$returPath='/assets/assets-imgs/UserPic/';//this needed to be change on gobal-define page
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    $fileElementName = $_POST['Input_AdministratorPhoto'];

    $name = $_FILES[$fileElementName]['name'];
    $size = $_FILES[$fileElementName]['size'];


    if(strlen($name))
    {
        list($txt, $ext) = explode(".", $name);
        if(in_array($ext,$valid_formats))
        {
            if($size<(1024*1024)) // Image size max 1 MB
            {
                $actual_image_name = base64_encode(time().".".$ext);
                $tmp = $_FILES[$fileElementName]['tmp_name'];
                if(move_uploaded_file($tmp, $paths.$actual_image_name))
                {
                    echo $returPath.$actual_image_name;
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
?>




