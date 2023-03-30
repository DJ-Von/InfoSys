<?php
include_once (realpath('DB.php'));
include_once (realpath('Inter.php'));

    Inter::head();
    Inter::echoTable('SELECT subject_id, subject_name, teacher_full_name as name FROM subject INNER JOIN teacher ON `subject_teacher_id` = `teacher_id`', 
                      array('№', 'Предмет', 'Преподаватель'), array('subject_id', 'subject_name', 'name'));
    Inter::footer();

?>

