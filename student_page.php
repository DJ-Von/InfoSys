<?php
include_once (realpath('classes/Student.php'));
include_once (realpath('classes/Inter.php'));
Inter::head();
    
Student::displayForm();
Student::displayTable();
Inter::footer();
?>