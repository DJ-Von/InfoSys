<?php
include_once ('DB.php');
include_once ('Inter.php');
class Student {
    public $student_full_name;
    public $student_team_id;
    public function __construct($student_full_name, $student_team_id){
        $db = new DB;
        $this->student_full_name = $db->con->real_escape_string($student_full_name);
        $this->student_team_id = $db->con->real_escape_string($student_team_id);
    }
    
    public function add(){
        $db = new DB;
        $result = $db->getQueryResult("SELECT COUNT(*) FROM student WHERE student_full_name='{$this->student_full_name}' AND student_group_id={$student_team_id}");
        $teacherCount = mysqli_fetch_array($result)[0];
        if($teacherCount > 0)
            echo '<script language="javascript">alert("Такой студент уже есть!")</script>';
        else
            $db->makeQuery("INSERT INTO `student` (`student_full_name`, `student_team_id`) VALUES ('{$this->student_full_name}', {$this->student_team_id})");
    }
    
    public static function delete($id){
        $db = new DB;
        $db->makeQuery("DELETE FROM `student` WHERE `student_id`={$id};");
    }
    
    public static function change($id, $student_full_name, $student_team_id){
        $db = new DB;
        $result = $db->getQueryResult("SELECT * FROM student WHERE student_id={$id}");
        $student = mysqli_fetch_array($result);
        if($student['student_full_name'] == $student_full_name)
            $db->makeQuery("UPDATE `student` SET `student_full_name`='{$student_full_name}', `student_team_id`={$student_team_id} WHERE student_id={$id}");
        else{
            $result = $db->getQueryResult("SELECT COUNT(*) FROM student WHERE student_full_name='{$student_full_name}'");
            $teacherCount = mysqli_fetch_array($result)[0];
            if($teacherCount > 0)
                echo '<script language="javascript">alert("Такой Студент уже есть!")</script>';
            else
                $db->makeQuery("UPDATE `student` SET `student_full_name`='{$student_full_name}', `student_team_id`={$student_team_id} WHERE student_id={$id}");
        }
    }
    
    public static function displayTable(){
        $sort_list = array(
    	    'student_id_asc'   => '`student_id`',
        	'student_id_desc'  => '`student_id` DESC',
        	'student_full_name_asc'   => '`student_full_name`',
        	'student_full_name_desc'  => '`student_full_name` DESC',
        	'team_name_asc'  => '`team_name`',
        	'team_name_desc' => '`team_name` DESC'
        );
        $sort = @$_GET['sort'];
        if (array_key_exists($sort, $sort_list)) {
        	$sort_sql = $sort_list[$sort];
        } else {
        	$sort_sql = reset($sort_list);
        }
        
        $db = new DB;
        if(isset($_POST['search']))
            $sql = Student::searchQuery()." ORDER BY $sort_sql";
        else
            $sql = "SELECT student_id, student_full_name, team_name FROM student LEFT JOIN team ON `student_team_id` = `team_id` ORDER BY $sort_sql";
        $res_data = $db->getQueryResult($sql);
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/table.css" rel="stylesheet">';
        else
            echo '<link href="css/table.css" rel="stylesheet">';
        echo '<table border=1 class="db_table">
            <thead>
                <tr>
                    <th>';
                    echo Inter::sort_link_th('№', 'student_id_asc', 'student_id_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('ФИО', 'student_full_name_asc', 'student_full_name_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Группа', 'team_name_asc', 'team_name_desc');
                    echo'</th>';
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo '<th></th>
                        <th></th>';
                    }
                echo '</tr>
            </thead>';
        
        if ($res_data->num_rows > 0) {
            while ($row = $res_data->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["student_id"]."</td>
                    <td>".$row["student_full_name"]."</td>
                    <td>".$row["team_name"]."</td>";
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo "<td><a href='?delete={$row['student_id']}'>Удалить</a></td>
                        <td><a href='?edit={$row['student_id']}'>Изменить</a></td>";
                    }
                echo "</tr>";
            }
        }
        echo '</table>';
    }
    
    public static function displayForm(){
        $db = new DB;
        if(isset($_GET['edit'])){
            $product = mysqli_fetch_array($db->getQueryResult("SELECT * FROM student WHERE student_id={$_GET['edit']}"));
        }
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/edit_form.css" rel="stylesheet">';
        else
            echo '<link href="css/edit_form.css" rel="stylesheet">';
        echo '<div class="edit-page">
            <div class="edit-form">
                    <form method="post" class="login-form">
                        <input type="text" name="full_name"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["student_full_name"].'"';
                        }
                        echo '>';
                        
                        echo '<select name="team">';
                        $result = $db->getQueryResult("SELECT * FROM team");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option";
                                if($row['team_id'] == $product['student_team_id'])
                                    echo " selected='selected' ";
                                echo " value=".$row["team_id"].">".$row["team_name"]."</option>";
                            }
                        } 
                        echo '</select>';
                        
                        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
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
        $querySearchList = "select student_id, student_full_name, team_name from student, team where ";
        $queryAllList = "select student_id, student_full_name, team_name from student, team where student_team_id=team_id";
        $query = $queryAllList;
        if(trim($_POST['full_name'])!=''){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= "student_full_name LIKE N'%{$_POST['full_name']}%'";
        }
        
        if(isset($_POST['team'])){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= "student_team_id LIKE N'{$_POST['team']}'";
        }
        
        return $query;
    }
}

?>