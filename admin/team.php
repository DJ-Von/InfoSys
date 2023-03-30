<?php
include_once (realpath('../DB.php'));
include_once (realpath('../Inter.php'));

if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
    Inter::head();
    Inter::echoTable('SELECT team_id, team_name, teacher_full_name FROM `team` INNER JOIN teacher ON team_teacher_id = teacher_id', 
                      array('№', 'Группа', 'Куратор'), 
                      array('team_id', 'team_name', 'teacher_full_name'));
    Inter::footer();
}
?>