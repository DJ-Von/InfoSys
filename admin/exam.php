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
    $sql = mysqli_query($db->con, 'SELECT `subject_name`, `exam_date`, `student_full_name`, `team_name`, `exam_mark` FROM `exam` INNER JOIN subject ON subject_id=exam_subject_id INNER JOIN student ON student_id=exam_student_id INNER JOIN team ON student_team_id=team_id');
      while ($result = mysqli_fetch_array($sql)) {
?>
<tr><td><?php echo $result['subject_name'] ?></td>
			<td><?php echo $result['exam_date'] ?></td>
			<td><?php echo $result['student_full_name'] ?></td>
			<td><?php echo $result['team_name'] ?></td>
			<td><?php echo $result['exam_mark'] ?></td>
			</tr>
<?php
      }
?>
</table>
<?php
}

?>