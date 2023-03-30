<?php
include_once (realpath('DB.php'));
include_once (realpath('Inter.php'));


    Inter::head();
    Inter::echoTable('SELECT `exam_id`, `subject_name`, DATE_FORMAT(`exam_date`, "%d-%m-%Y") encoded_date, `teacher_full_name`, `student_full_name`, `team_name`, `exam_mark` FROM `exam` INNER JOIN subject ON subject_id=exam_subject_id INNER JOIN student ON student_id=exam_student_id INNER JOIN team ON student_team_id=team_id INNER JOIN teacher ON subject_teacher_id=teacher_id',
                      array('№', 'Предмет', 'Дата', 'Преподаватель', 'Студент', 'Группа', 'Оценка'), 
                      array('exam_id', 'subject_name', 'encoded_date', 'teacher_full_name', 'student_full_name', 'team_name', 'exam_mark'));
    Inter::footer();

?>