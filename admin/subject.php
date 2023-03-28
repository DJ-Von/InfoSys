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
    $sql = mysqli_query($db->con, 'SELECT subject_name, subject_teacher_id, teacher_id, teacher_full_name as name FROM subject INNER JOIN teacher ON `subject_teacher_id` = `teacher_id`');
      while ($result = mysqli_fetch_array($sql)) {
?>
<tr><td><?php echo $result['subject_name'] ?></td>
			<td><?php echo $result['name'] ?></td>
			</tr>
<?php
      }
?>
</table>
<?php
}

?>