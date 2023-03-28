<?php
require_once 'DB.php';

if($_SESSION['teacher_login'] == 'admin'){
    //unset($_SESSION['teacher_login']);
    echo "<script>
        location.replace('./index.php');
        </script>";
}

else{
    //unset($_SESSION['teacher_login']);
    echo "<script>
        location.replace('index.php');
        </script>";
}
?>