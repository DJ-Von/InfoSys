<?php
if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
echo '<link href="../css/menu.css" rel="stylesheet">
    <div class="nav-scroller">
  <nav class="nav-scroller__items">
    <a class="nav-scroller__item" href="index.php">Главная</a>
    <a class="nav-scroller__item" href="#">Преподаватели</a>
    <a class="nav-scroller__item" href="#">Предметы</a>
    <a class="nav-scroller__item" href="#">Студенты</a>
    <a class="nav-scroller__item" href="#">Группы</a>
    <a class="nav-scroller__item" href="../logout.php">Выйти</a>
  </nav>
</div>';

}

else{
    echo '<link href="css/menu.css" rel="stylesheet">
            <div class="nav-scroller">
              <nav class="nav-scroller__items">
                <a class="nav-scroller__item" href="index.php">Главная</a>
                <a class="nav-scroller__item" href="#">Преподаватели</a>
                <a class="nav-scroller__item" href="#">Предметы</a>
                <a class="nav-scroller__item" href="#">Студенты</a>
                <a class="nav-scroller__item" href="#">Группы</a>';
                if (isset($_SESSION['teacher_login']))
                    echo '<a class="nav-scroller__item" href="logout.php">Выйти</a>';
                
        echo '</nav>
        </div>';
}
?>