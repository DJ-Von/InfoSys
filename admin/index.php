<?php
include_once (realpath('../DB.php'));
include_once (realpath('../Inter.php'));
include_once (realpath('../Teacher.php'));

if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
Inter::head();
?>
<p>Привет, <?php echo $_SESSION['teacher_login'];?>. Скоро главная страница будет готова.</p>
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