<?php

echo "<script>
onload = function ()
{
for (var lnk = document.links, j = 0; j < lnk.length; j++)
if (lnk [j].href == document.URL) lnk [j].style.cssText = 'color:red; border:1px solid #000';
}
</script>";
if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
echo '<link href="../css/menu.css" rel="stylesheet">
    <div class="nav-scroller">
  <nav class="nav-scroller__items">
    <img src="../inter_elements/logo.jpg">
    <a class="nav-scroller__item" href="index.php">Главная</a>
    <a class="nav-scroller__item" href="teacher.php">Преподаватели</a>
    <a class="nav-scroller__item" href="subject.php">Предметы</a>
    <a class="nav-scroller__item" href="student.php">Студенты</a>
    <a class="nav-scroller__item" href="team.php">Группы</a>
    <a class="nav-scroller__item" href="exam.php">Сессия</a>
    <a class="nav-scroller__item" href="../logout.php">Выйти</a>
  </nav>
</div>';

}

else{
    echo '<link href="css/menu.css" rel="stylesheet">
            <div class="nav-scroller">
              <nav class="nav-scroller__items">
                <img src="inter_elements/logo.jpg">
                <a class="nav-scroller__item" href="index.php">Главная</a>
                <a class="nav-scroller__item" href="teacher_page.php">Преподаватели</a>
                <a class="nav-scroller__item" href="subject_page.php">Предметы</a>
                <a class="nav-scroller__item" href="student_page.php">Студенты</a>
                <a class="nav-scroller__item" href="team_page.php">Группы</a>
                <a class="nav-scroller__item" href="exam_page.php">Сессия</a>';
                if (isset($_SESSION['logged_teacher']))
                    echo '<a class="nav-scroller__item" href="logout.php">Выйти</a>';
                
        echo '</nav>
        </div>';
}
?>