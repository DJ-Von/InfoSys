<?php
include_once (realpath('classes/Teacher.php'));
include_once (realpath('classes/Inter.php'));
Inter::head();
Teacher::displayForm();
Teacher::displayTable();
Inter::footer();
?>