<?php
include_once ('DB.php');
include_once ('Inter.php');

class Teacher{
    public $teacher_full_name;
    public $teacher_login;
    public $teacher_password;
    public $teacher_subject_id;
    public function __construct($teacher_full_name, $teacher_login, $teacher_password, $teacher_subject_id){
        $db = new DB;
        $this->teacher_full_name = $db->con->real_escape_string($teacher_full_name);
        $this->teacher_login = $db->con->real_escape_string($teacher_login);
        $this->teacher_password = $db->con->real_escape_string($teacher_password);
        $this->teacher_subject_id = $db->con->real_escape_string($teacher_subject_id);
    }
    
    public function add(){
        $db = new DB;
        $result = $db->getQueryResult("SELECT COUNT(*) FROM teacher WHERE teacher_login='{$this->teacher_login}'");
        $teacherCount = mysqli_fetch_array($result)[0];
        if($teacherCount > 0)
            echo '<script language="javascript">alert("Учитель с таким логином уже есть!")</script>';
        else
            $db->makeQuery("INSERT INTO `teacher`(`teacher_full_name`, `teacher_login`, `teacher_password`, `teacher_subject_id`) VALUES ('{$this->teacher_full_name}','{$this->teacher_login}', '".password_hash($this->teacher_password, PASSWORD_DEFAULT)."', {$this->teacher_subject_id})");
    }
    
    public static function delete($id){
        $db = new DB();
        $db->makeQuery("DELETE FROM `teacher` WHERE teacher_id={$id}");
    }
    
    public static function change($id, $teacher_full_name, $teacher_login, $teacher_password, $teacher_subject_id){
        $db = new DB;
        $result = $db->getQueryResult("SELECT * FROM teacher WHERE teacher_id={$id}");
        $teacher = mysqli_fetch_array($result);
        
        if($teacher['teacher_login'] == $teacher_login){
            $dop = '';
            if (trim($teacher_password) != ''){
                $pass = $db->con->real_escape_string($teacher_password);
                $dop = ', teacher_password="'.password_hash($pass, PASSWORD_DEFAULT).'"';
            }
            $db->makeQuery("UPDATE teacher SET teacher_full_name='{$db->con->real_escape_string($teacher_full_name)}', teacher_login='{$db->con->real_escape_string($teacher_login)}', teacher_subject_id={$db->con->real_escape_string($teacher_subject_id)}".$dop." WHERE teacher_id={$db->con->real_escape_string($id)}");
        }
        
        else{
            $result = $db->getQueryResult("SELECT COUNT(*) FROM teacher WHERE teacher_login='{$teacher_login}'");
            $teacherCount = mysqli_fetch_array($result)[0];
            if($teacherCount > 0)
                echo '<script language="javascript">alert("Учитель с таким логином уже есть!")</script>';
            else{
                $dop = '';
            if (isset($teacher_password)){
                $pass = $db->con->real_escape_string($teacher_password);
                $dop = ', teacher_password="'.password_hash($pass, PASSWORD_DEFAULT).'"';
            }
            $db->makeQuery("UPDATE teacher SET teacher_full_name='{$db->con->real_escape_string($teacher_full_name)}', teacher_login='{$db->con->real_escape_string($teacher_login)}', teacher_subject_id={$db->con->real_escape_string($teacher_subject_id)}".$dop." WHERE teacher_id={$db->con->real_escape_string($id)}");
            }
        }
    }
    
    public static function displayTable(){
        $sort_list = array(
    	    'teacher_id_asc'   => '`teacher_id`',
        	'teacher_id_desc'  => '`teacher_id` DESC',
        	'teacher_full_name_asc'  => '`teacher_full_name`',
        	'teacher_full_name_desc' => '`teacher_full_name` DESC',
        	'teacher_login_asc'   => '`teacher_login`',
        	'teacher_login_desc'  => '`teacher_login` DESC',
        	'subject_name_asc'   => '`subject_name`',
        	'subject_name_desc'  => '`subject_name` DESC'
        );
        $sort = @$_GET['sort'];
        if (array_key_exists($sort, $sort_list)) {
        	$sort_sql = $sort_list[$sort];
        } else {
        	$sort_sql = reset($sort_list);
        }
        
        $db = new DB;
        $sql = "";
        if(isset($_POST['search']))
            $sql = Teacher::searchQuery()." ORDER BY $sort_sql";
        else
            $sql = "SELECT teacher_id, teacher_full_name, teacher_login, subject_name FROM teacher LEFT JOIN subject ON (teacher_subject_id=subject_id) ORDER BY $sort_sql";
        $res_data = $db->getQueryResult($sql);
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/table.css" rel="stylesheet">';
        else
            echo '<link href="css/table.css" rel="stylesheet">';
        echo '<table border=1 class="db_table">
            <thead>
                <tr>
                    <th>';
                    echo Inter::sort_link_th('№', 'teacher_id_asc', 'teacher_id_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('ФИО', 'teacher_full_name_asc', 'teacher_full_name_desc');
                    echo'</th>';
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo '<th>';
                        echo Inter::sort_link_th('Логин', 'teacher_login_asc', 'teacher_login_desc');
                        echo'</th>';
                    }
                    echo '<th>';
                    echo Inter::sort_link_th('Предмет', 'subject_name_asc', 'subject_name_desc');
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo'<th></th>
                        <th></th>';
                    }
                echo '</tr>
            </thead>';
        
        if ($res_data->num_rows > 0) {
            while ($row = $res_data->fetch_assoc()) {
                if($row["teacher_login"] != 'admin'){
                    echo "<tr>
                        <td>".$row["teacher_id"]."</td>
                        <td>".$row["teacher_full_name"]."</td>";
                        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
                            echo "<td>".$row["teacher_login"]."</td>";
                        echo "<td>".$row["subject_name"]."</td>";
                        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
                            echo "<td><a href='?delete={$row['teacher_id']}'>Удалить</a></td>
                                  <td><a href='?edit={$row['teacher_id']}'>Изменить</a></td>";
                    echo "</tr>";
                }
            }
        }
        echo '</table>';

    }
    
    public static function displayForm(){
        $db = new DB;
        if(isset($_GET['edit'])){
            $product = mysqli_fetch_array($db->getQueryResult("SELECT * FROM teacher WHERE teacher_id={$_GET['edit']}"));
        }
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/edit_form.css" rel="stylesheet">';
        else
            echo '<link href="css/edit_form.css" rel="stylesheet">';
        echo '<div class="edit-page">
            <div class="edit-form">
                    <form method="post" class="login-form">
                        <input type="text" placeholder="ФИО" name="full_name"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["teacher_full_name"].'"';
                        }
                        echo '>';
                        
                        echo '<input type="text" placeholder="Логин" name="login"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["teacher_login"].'"';
                        }
                        echo'>';
                        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
                            echo '<input type="password" placeholder="Пароль" name="password">';
                        echo '<select name="subject">';
                        $result = $db->getQueryResult("SELECT * FROM subject");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option";
                                if($row['subject_id'] == $product['teacher_subject_id'])
                                    echo " selected='selected' ";
                                echo " value=".$row["subject_id"].">".$row["subject_name"]."</option>";
                            }
                        } 
                        echo '</select>';
                        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                            echo '<button type="submit" name="push">';
                            
                            if(isset($_GET['edit']))
                                echo "Изменить";
                            else
                                echo "Добавить";
                        }
                            
                        echo '</button>';
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
        $querySearchList = "select teacher_id, teacher_full_name, teacher_login, subject_name from teacher, subject where ";
        $queryAllList = "select teacher_id, teacher_full_name, teacher_login, subject_name from teacher, subject where teacher_subject_id=subject_id";
        $query = $queryAllList;
        if(trim($_POST['full_name'])!=''){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= "teacher_full_name LIKE N'%{$_POST['full_name']}%'";
        }
        
        if(trim($_POST['login'])!=''){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= " teacher_login LIKE N'%{$_POST['login']}%'";
        }
        
        if(isset($_POST['subject'])){
            if ($query != $querySearchList)
                $query .= " AND ";
            $query .= " teacher_subject_id LIKE N'{$_POST['subject']}'";
        }
        
        return $query;
    }
}
?>