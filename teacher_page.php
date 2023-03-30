<?php
include_once (realpath('DB.php'));
include_once (realpath('Inter.php'));


    Inter::head();
    Inter::echoTable('SELECT * FROM `teacher`', array('№', 'ФИО', 'Логин'), array('teacher_id', 'teacher_full_name', 'teacher_login'));
    Inter::footer();

?>