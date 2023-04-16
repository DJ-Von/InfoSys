<?php
require_once ('DB.php');

class Exam {
    public $exam_teacher_id;
    public $exam_date;
    public $exam_student_id;
    public $exam_mark;
    public function __construct($exam_teacher_id, $exam_date, $exam_student_id, $exam_mark){
        $this->exam_teacher_id = $exam_teacher_id;
        $this->exam_date = $exam_date;
        $this->exam_student_id = $exam_student_id;
        $this->exam_mark = $exam_mark;
    }
    
    public function add(){
        $db = new DB;
        $result = $db->getQueryResult("SELECT COUNT(*) FROM exam WHERE exam_teacher_id={$this->exam_teacher_id} AND exam_date='{$this->exam_date}' AND exam_student_id={$this->exam_student_id} AND exam_mark={$this->exam_mark}");
        $teacherCount = mysqli_fetch_array($result)[0];
        if($teacherCount > 0)
            echo '<script language="javascript">alert("Такая запись об экзамене уже есть!")</script>';
        else
            $db->makeQuery("INSERT INTO `exam` (`exam_teacher_id`, `exam_date`, `exam_student_id`, `exam_mark`) VALUES 
                                 ({$this->exam_teacher_id}, '{$this->exam_date}', {$this->exam_student_id }, {$this->exam_mark})");
    }
    
    public static function delete($id){
        $db = new DB;
        $db->makeQuery("DELETE FROM `exam` WHERE `exam_id`={$id};");
    }
    
    public static function change($id, $exam_teacher_id, $exam_date, $exam_student_id, $exam_mark){
        $db = new DB;
        $result = $db->getQueryResult("SELECT * FROM exam WHERE exam_id={$id}");
        $exam = mysqli_fetch_array($result);
        if($exam['exam_teacher_id'] == $exam_teacher_id && $exam['exam_date'] == $exam_date && $exam_mark['exam_mark'] == $exam_mark)
            $db->makeQuery("UPDATE `subject` SET `subject_name`='{$subject_name}' WHERE subject_id={$id}");
        else{
            $result = $db->getQueryResult("SELECT COUNT(*) FROM exam WHERE exam_teacher_id={$exam_teacher_id} AND exam_date='{$exam_date}' AND exam_student_id={$exam_student_id} AND exam_mark={$exam_mark}");
            $teacherCount = mysqli_fetch_array($result)[0];
            if($teacherCount > 0)
                echo '<script language="javascript">alert("Такая запись об экзамене уже есть!")</script>';
            else
                $db->makeQuery("UPDATE `exam` SET `exam_teacher_id`={$exam_teacher_id}, `exam_date`='{$exam_date}', `exam_student_id`={$exam_student_id}, `exam_mark`={$exam_mark} WHERE exam_id={$id};");
        }
    }
    
    public static function displayTable(){
        $sort_list = array(
    	    'exam_id_asc'   => '`exam_id`',
        	'exam_id_desc'  => '`exam_id` DESC',
        	'teacher_full_name_asc'   => '`teacher_full_name`',
        	'teacher_full_name_desc'  => '`teacher_full_name` DESC',
        	'subject_name_asc'  => '`subject_name`',
        	'subject_name_desc' => '`subject_name` DESC',
        	'exam_date_asc'  => '`exam_date`',
        	'exam_date_desc' => '`exam_date` DESC',
        	'student_full_name_asc'  => '`student_full_name`',
        	'student_full_name_desc' => '`student_full_name` DESC',
        	'exam_mark_asc'  => '`exam_mark`',
        	'exam_mark_desc' => '`exam_mark` DESC',
        	'team_name_asc'  => '`exam_mark`',
        	'team_name_desc' => '`exam_mark` DESC'
        );
        $sort = @$_GET['sort'];
        if (array_key_exists($sort, $sort_list)) {
        	$sort_sql = $sort_list[$sort];
        } else {
        	$sort_sql = reset($sort_list);
        }
        
        $db = new DB;
        $sql = "";
        if(isset($_POST['search'])){
            $sql = Exam::searchQuery()." ORDER BY $sort_sql";
        }
        else
            $sql = "SELECT exam_id, teacher_full_name, teacher_login, DATE_FORMAT(`exam_date`, '%d-%m-%Y') exam_date, student_full_name, exam_mark, subject_name, team_name FROM exam INNER JOIN teacher ON `exam_teacher_id` = `teacher_id` INNER JOIN student ON `exam_student_id` = `student_id` LEFT JOIN subject ON `teacher_subject_id`=`subject_id` LEFT JOIN team ON `student_team_id`=`team_id` ORDER BY $sort_sql";
        $res_data = $db->getQueryResult($sql);
        
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/table.css" rel="stylesheet">';
        else
            echo '<link href="css/table.css" rel="stylesheet">';
        echo '<table border=1 class="db_table">
            <thead>
                <tr>
                    <th>';
                    echo Inter::sort_link_th('№', 'exam_id_asc', 'exam_id_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Преподаватель', 'teacher_full_name_asc', 'teacher_full_name_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Предмет', 'subject_name_asc', 'subject_name_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Дата', 'exam_date_asc', 'exam_date_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Студент', 'student_full_name_asc', 'student_full_name_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Группа', 'team_name_asc', 'team_name_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Оценка', 'exam_mark_asc', 'exam_mark_desc');
                    echo'</th>';
                    if(isset($_SESSION['logged_teacher'])){
                        echo '<th></th>
                        <th></th>';
                    }
                echo '</tr>
            </thead>';
        
        if ($res_data->num_rows > 0) {
            while ($row = $res_data->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["exam_id"]."</td>
                    <td>".$row["teacher_full_name"]."</td>
                    <td>".$row["subject_name"]."</td>
                    <td>".$row["exam_date"]."</td>
                    <td>".$row["student_full_name"]."</td>
                    <td>".$row["team_name"]."</td>
                    <td>".$row["exam_mark"]."</td>";
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == $row["teacher_login"] || isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo "<td><a href='?delete={$row['exam_id']}'>Удалить</a></td>
                        <td><a href='?edit={$row['exam_id']}'>Изменить</a></td>";
                    }
                echo "</tr>";
            }
        }
        echo '</table>';
    }
    
    public static function displayForm(){
        $db = new DB;
        if(isset($_GET['edit'])){
            $product = mysqli_fetch_array($db->getQueryResult("SELECT * FROM exam WHERE exam_id={$_GET['edit']}"));
        }
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/edit_form.css" rel="stylesheet">';
        else
            echo '<link href="css/edit_form.css" rel="stylesheet">';
        echo '<div class="edit-page">
            <div class="edit-form">
                    <form method="post" class="login-form">';
                        echo '<select name="teacher">';
                        $result = $db->getQueryResult("SELECT * FROM teacher");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if($row['teacher_id'] != 1){
                                    echo "<option";
                                    if($row['teacher_id'] == $product['exam_teacher_id'])
                                        echo " selected='selected' ";
                                    echo " value=".$row["teacher_id"].">".$row["teacher_full_name"]."</option>";
                                }
                            }
                        } 
                        echo '</select>';
                        
                        echo '<input type="date" name="date"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["exam_date"].'"';
                        }
                        echo '>';
                        
                        echo '<select name="student">';
                        $result = $db->getQueryResult("SELECT * FROM student");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option";
                                if($row['student_id'] == $product['exam_student_id'])
                                    echo " selected='selected' ";
                                echo " value=".$row["student_id"].">".$row["student_full_name"]."</option>";
                            }
                        } 
                        echo '</select>';
                        
                        echo '<input type="text" name="mark"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["exam_mark"].'"';
                        }
                        echo '>';
                        
                        if(isset($_SESSION['logged_teacher'])){
                            echo '<button type="submit" name="push">';
                                if(isset($_GET['edit']))
                                    echo "Изменить";
                                else
                                    echo "Добавить";
                            echo '</button>';
                        }
                        echo '<br/><br/>';
                        echo '<button type="submit" name="search">Поиск</button>';
                        if(isset($_GET['edit']) || isset($_POST['search']))
                            echo '<a href="?add=new">Очистить форму</a>';
                    echo'    
                    </form>
                </div>
        </div>
        ';
    }
    
    public static function searchQuery(){
        $querySearchList = "select exam_id, teacher_full_name, teacher_login, subject_name, exam_date, student_full_name, team_name, exam_mark from exam where ";
        $queryAllList = "select exam_id, teacher_full_name, teacher_login, subject_name, exam_date, student_full_name, team_name, exam_mark from exam, subject, team, student, teacher where `exam_teacher_id` = `teacher_id` and `exam_student_id` = `student_id` and `teacher_subject_id`=`subject_id` and `student_team_id`=`team_id`";
        $query = $queryAllList;
        if(trim($_POST['mark'])!=''){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= " exam_mark LIKE N'%{$_POST['mark']}%'";
        }
        
        if(isset($_POST['teacher'])){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= " exam_teacher_id LIKE N'{$_POST['teacher']}'";
        }
        
        if(isset($_POST['student'])){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= " exam_student_id LIKE N'{$_POST['student']}'";
        }
        
        if(isset($_POST['date'])){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= " exam_date LIKE N'%{$_POST['date']}%'";
        }
        
        return $query;
    }
}
?>