<?php
include_once (realpath('../DB.php'));
include_once (realpath('../Inter.php'));

if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
    Inter::head();
    Inter::echoTable('SELECT * FROM `teacher`', array('№', 'ФИО', 'Логин'), array('teacher_id', 'teacher_full_name', 'teacher_login'));
    Inter::footer();
}
?>