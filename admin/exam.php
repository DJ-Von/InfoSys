<?php
include_once (realpath('../classes/Exam.php'));
include_once (realpath('../classes/Inter.php'));
if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
    Inter::head();
    $db = new DB;
    if(isset($_POST['push'])){
        $errors = [];
        if(trim($_POST['teacher'])==''){
            $errors[] = "Введите преподавателя";
        }
        if(trim($_POST['date'])==''){
            $errors[] = "Введите дату";
        }
        if(trim($_POST['student'])==''){
            $errors[] = "Введите студента";
        }
        if(trim($_POST['mark'])==''){
            $errors[] = "Введите оценку";
        }
        
        if (isset($_GET['edit'])) {
            if(empty($errors))
                Exam::change($_GET['edit'], $_POST['teacher'], $_POST['date'], $_POST['student'], $_POST['mark']);
            else
                echo '<div style = "color: red">'.array_shift($errors).'</div>';
        }
        
        else {
            $exam = new Exam($_POST['teacher'], $_POST['date'], $_POST['student'], $_POST['mark']);
            if(empty($errors))
                $exam->add();
            else
                echo '<div style = "color: red">'.array_shift($errors).'</div>';
        }
    }
    
    if(isset($_GET['delete'])){
        Exam::delete($_GET['delete']);
    }

    Exam::displayForm();
    Exam::displayTable();
    Inter::footer();
}

else{
    echo "<script>location.replace('index.php'); </script>";
}
?>