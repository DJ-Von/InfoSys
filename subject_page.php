<?php
include_once (realpath('classes/Subject.php'));
include_once (realpath('classes/Inter.php'));

Inter::head();
Subject::displayForm();
Subject::displayTable();
Inter::footer();

?>