<?php
require_once 'classes/DB.php';
require_once 'classes/Inter.php';
require_once 'classes/Teacher.php';

$data = $_POST;
$db = new DB;

if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
    echo "<script>location.replace('admin/index.php');</script>";
}

if (isset($data['do_login'])) {
	
    $query = "SELECT * FROM teacher WHERE teacher_login='{$data['teacher_login']}'";
    $result = mysqli_query($db->con, $query);
    
    if($result){

        $row = mysqli_fetch_row($result);
        $teacher = new Teacher($row[1], $row[2], $row[3], $row[4]);
        
        if(password_verify($data['teacher_password'], $teacher->teacher_password))  
        {
            $_SESSION["logged_teacher"] = $teacher->teacher_login;  
            if($_SESSION["logged_teacher"] == 'admin')
                echo "<script>
                        location.replace('admin/index.php');
                      </script>";
        }  
        else  
        {  
            $message = $db->error;  
            echo $message;
        }
    }
}
Inter::head();
if(!isset($_SESSION['logged_teacher'])){
    Inter::loginForm();
}

else{
    echo "Добро пожаловать, ".$_SESSION["logged_teacher"];
}

Inter::footer();
?>