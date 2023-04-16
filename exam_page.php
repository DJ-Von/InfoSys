<?php
include_once (realpath('classes/Exam.php'));
include_once (realpath('classes/Inter.php'));
Inter::head();
$db = new DB;

if(isset($_POST['push']) && isset($_SESSION['logged_teacher'])){
    $errors = [];
    if(trim($_POST['teacher'])=='' && !isset($_GET['edit'])){
        $errors[] = "Введите преподавателя";
    }
    if(trim($_POST['date'])=='' && !isset($_GET['edit'])){
        $errors[] = "Введите дату";
    }
    if(trim($_POST['student'])=='' && !isset($_GET['edit'])){
        $errors[] = "Введите студента";
    }
    if(trim($_POST['mark'])=='' && !isset($_GET['edit'])){
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
        $res = $db->getQueryResult("SELECT * from teacher where teacher_login='".$_SESSION['logged_teacher']."'");
        $teacher = mysqli_fetch_array($res)[0];
        if($_POST['teacher'] != $teacher && $_SESSION['logged_teacher'] != 'admin'){
            $errors[] = "Вы не можете добавлять запись об экзамене по чужому предмету!";
        }
        if(empty($errors))
            $exam->add();
        else
            echo '<script>alert("'.array_shift($errors).'");</script>';
    }
}
    
if(isset($_GET['delete']) && isset($_SESSION['logged_teacher'])){
    Exam::delete($_GET['delete']);
}
Exam::displayForm();
Exam::displayTable();
Inter::footer();
?>