<?php
include_once (realpath('../DB.php'));
include_once (realpath('../Inter.php'));

if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
    Inter::head();
    Inter::echoTable('SELECT student_id, student_full_name, team_name FROM `student` INNER JOIN team ON student_team_id = team_id', 
                      array('№', 'ФИО', 'Группа'), 
                      array('student_id', 'student_full_name', 'team_name'));
    Inter::footer();
}
?>