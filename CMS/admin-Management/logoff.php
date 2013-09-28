<?php
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}
    session_destroy();

     echo '<script type="text/javascript">'; 
     echo 'alert("Logoff Successed");window.location ="login.php"';
     echo '</script>';
?>

