<?php
require_once 'classes/DB.php';

if($_SESSION['logged_teacher'] == 'admin'){
    unset($_SESSION['logged_teacher']);
    echo "<script>
        location.replace('./index.php');
        </script>";
}

else{
    unset($_SESSION['logged_teacher']);
    echo "<script>
        location.replace('index.php');
        </script>";
}
?>