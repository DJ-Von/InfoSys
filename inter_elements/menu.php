<?php


if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
echo '<link href="../css/menu.css" rel="stylesheet">
    <div class="nav-scroller">
  <nav class="nav-scroller__items">
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
                <a class="nav-scroller__item" href="index.php">Главная</a>
                <a class="nav-scroller__item" href="teacher_page.php">Преподаватели</a>
                <a class="nav-scroller__item" href="subject_page.php">Предметы</a>
                <a class="nav-scroller__item" href="student_page.php">Студенты</a>
                <a class="nav-scroller__item" href="team_page.php">Группы</a>
                <a class="nav-scroller__item" href="exam_page.php">Сессия</a>';
                if (isset($_SESSION['teacher_login']))
                    echo '<a class="nav-scroller__item" href="logout.php">Выйти</a>';
                
        echo '</nav>
        </div>';
}
?>