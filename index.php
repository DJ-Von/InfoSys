<!DOCTYPE html>
<?php
require_once 'DB.php';
require_once 'Inter.php';
require_once 'Teacher.php';
require_once 'Exam.php';

$data = $_POST;
$db = new DB;

if (isset($data['do_login'])) {
	
    $query = "SELECT * FROM teacher WHERE teacher_login='{$data['teacher_login']}'";
    $result = mysqli_query($db->con, $query);
    
    if($result){
        $row = mysqli_fetch_row($result);
        $teacher = new Teacher($row[1], $row[2], $row[3]);
        
        if(password_verify($data['teacher_password'], $teacher->teacher_password))  
        {
            $_SESSION["teacher_login"] = $teacher->teacher_login;  
            if($_SESSION["teacher_login"] == 'admin')
                echo "<script>
                        location.replace('admin/index.php');
                      </script>";
            else
                echo "Добро пожаловать, ".$teacher->teacher_login;
        }  
        else  
        {  
            $message = $db->error;  
            echo $message;
        }
    }
}
Inter::head();
if(!isset($_SESSION['teacher_login'])){
    Inter::loginForm();
}

Inter::footer();
?>