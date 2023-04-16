<?php
include_once (realpath('../classes/Student.php'));
include_once (realpath('../classes/Inter.php'));
if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
    Inter::head();
    $db = new DB;
    if(isset($_POST['push'])){
        $errors = [];
        if(trim($_POST['full_name'])==''){
            $errors[] = "Введите ФИО";
        }
        
        if(trim($_POST['team'])==''){
            $errors[] = "Выберете группу";
        }
        
        if (isset($_GET['edit'])) {
            if(empty($errors))
                Student::change($_GET['edit'], $_POST['full_name'], $_POST['team']);
            else
                echo '<div style = "color: red">'.array_shift($errors).'</div>';
        }
        else {
            $student = new Student($_POST['full_name'], $_POST['team']);
            if(empty($errors))
                $student->add();
            else
                echo '<div style = "color: red">'.array_shift($errors).'</div>';
        }
    }
    
    if(isset($_GET['delete'])){
        Student::delete($_GET['delete']);
    }
    
    Student::displayForm();
    Student::displayTable();
    Inter::footer();
}

else{
    echo "<script>location.replace('index.php'); </script>";
}
?>