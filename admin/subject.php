<?php
include_once (realpath('../classes/Subject.php'));
include_once (realpath('../classes/Inter.php'));
if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
    Inter::head();
    $db = new DB;
    if(isset($_POST['push'])){
        $errors = [];
        if(trim($_POST['subject_name'])==''){
            $errors[] = "Введите название предмета";
        }
        if(empty($errors)){
            if (isset($_GET['edit'])) {
                Subject::change($_GET['edit'], $_POST['subject_name']);
            }
            else {
                $subject = new Subject($_POST['subject_name']);
                $subject->add();
            }
        }
        else
            echo '<div style = "color: red">'.array_shift($errors).'</div>';
    }
    
    if(isset($_GET['delete'])){
        Subject::delete($_GET['delete']);
    }
    
    Subject::displayForm();
    Subject::displayTable();
    Inter::footer();
}

else{
    echo "<script>location.replace('index.php'); </script>";
}
?>