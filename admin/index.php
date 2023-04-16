<?php
include_once (realpath('../classes/DB.php'));
include_once (realpath('../classes/Inter.php'));

if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
Inter::head();
?>
<p>Привет, <?php echo $_SESSION['logged_teacher'];?>. Скоро главная страница будет готова.</p>
<p>Пока что она в разработке.</p>
<?php
Inter::footer();
}
else{
?>
<p>Вам сюда нельзя</p>
<a href="../index.php">На главную</a>
<?php
}

?>