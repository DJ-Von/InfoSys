<?php
include_once (realpath('../classes/Team.php'));
include_once (realpath('../classes/Inter.php'));
if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
    Inter::head();
    $db = new DB;
    if(isset($_POST['push'])){
        $errors = [];
        if(trim($_POST['team_name'])==''){
            $errors[] = "Введите группу";
        }
        if(empty($errors)){
            if (isset($_GET['edit'])) {
                Team::change($_GET['edit'], $_POST['team_name']);
            }
            else {
                $team = new Team($_POST['team_name']);
                $team->add();
            }
        }
        else
            echo '<div style = "color: red">'.array_shift($errors).'</div>';
    }
    
    if(isset($_GET['delete'])){
        Team::delete($_GET['delete']);
    }
    
    Team::displayForm();
    Team::displayTable();
    Inter::footer();
}

else{
    echo "<script>location.replace('index.php'); </script>";
}
?>