<?php
include_once (realpath('../classes/Teacher.php'));
include_once (realpath('../classes/Inter.php'));
if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
    Inter::head();
    $db = new DB;
    if(isset($_POST['push'])){
        $errors = [];
        if(trim($_POST['full_name'])==''){
            $errors[] = "Введите ФИО";
        }
        if(trim($_POST['login'])==''){
            $errors[] = "Введите логин";
        }
        
        if(trim($_POST['subject'])==''){
            $errors[] = "Выберете предмет";
        }
        if (isset($_GET['edit'])) {
            if(empty($errors))
                Teacher::change($_GET['edit'], $_POST['full_name'], $_POST['login'], $_POST['password'], $_POST['subject']);
            else
                echo '<script>alert("'.array_shift($errors).'");</script>';
        }
        else {
            $teacher = new Teacher($_POST['full_name'], $_POST['login'], $_POST['password'], $_POST['subject']);
            if(trim($_POST['password'])==''){
                $errors[] = "Введите пароль";
            }
            if(empty($errors))
                $teacher->add();
            else
                echo '<script>alert("'.array_shift($errors).'");</script>';
        }
    }
    
    if(isset($_GET['delete'])){
        Teacher::delete($_GET['delete']);
    }

    Teacher::displayForm();
    Teacher::displayTable();
    Inter::footer();
}

else{
    echo "<script>location.replace('index.php'); </script>";
}
?>