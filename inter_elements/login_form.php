<?php 

$data = $_POST;

echo '<link href="css/login_form.css" rel="stylesheet">
<div class="login-page">
  <div class="form">
    <form class="login-form" action="index.php"  method="POST">
      <input type="text" placeholder="Логин" name="teacher_login" value="'.@$data['teacher_login'].'"/>
      <input type="password" placeholder="Пароль" name="teacher_password" value="'.@$data['teacher_password'].'"/>
      <button type="submit" name="do_login">Войти</button>
    </form>
  </div>
</div>';
?>