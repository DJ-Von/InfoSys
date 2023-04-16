<?php
include_once (realpath('classes/Team.php'));
include_once (realpath('classes/Inter.php'));
Inter::head();
Team::displayForm();
Team::displayTable();
Inter::footer();
?>