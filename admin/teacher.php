<?php
include_once (realpath('../DB.php'));
include_once (realpath('../Inter.php'));
include_once (realpath('../Teacher.php'));

?>

<table border=1>
<?php
Inter::menu();
if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
    $db = new DB;
    $sql = mysqli_query($db->con, 'SELECT * FROM `teacher`');
      while ($result = mysqli_fetch_array($sql)) {
?>
<tr><td><?php echo $result['teacher_full_name'] ?></td>
			<td><?php echo $result['teacher_login'] ?></td>
			</tr>
<?php
      }
?>
</table>
<?php
}

?>