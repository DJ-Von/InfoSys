<?php
include_once ('DB.php');
include_once ('Inter.php');
class Subject{
    public $subject_name;
    public function __construct($subject_name){
        $db = new DB;
        $this->subject_name = $db->con->real_escape_string($subject_name);
    }
    
    public function add(){
        $db = new DB;
        $result = $db->getQueryResult("SELECT COUNT(*) FROM subject WHERE subject_name='{$this->subject_name}'");
        $teacherCount = mysqli_fetch_array($result)[0];
        if($teacherCount > 0)
            echo '<script language="javascript">alert("Такой предмет уже есть!")</script>';
        else
            $db->makeQuery("INSERT INTO `subject`(`subject_name`) VALUES ('{$this->subject_name}')");
    }
    
    public static function delete($id){
        $db = new DB();
        $db->makeQuery("DELETE FROM `subject` WHERE subject_id={$id};");
    }
    
    public static function change($id, $subject_name){
        $db = new DB;
        $result = $db->getQueryResult("SELECT * FROM subject WHERE subject_id={$id}");
        $subject = mysqli_fetch_array($result);
        if($subject['subject_name'] == $subject_name)
            $db->makeQuery("UPDATE `subject` SET `subject_name`='{$subject_name}' WHERE subject_id={$id}");
        else{
            $result = $db->getQueryResult("SELECT COUNT(*) FROM subject WHERE subject_name='{$subject_name}'");
            $teacherCount = mysqli_fetch_array($result)[0];
            if($teacherCount > 0)
                echo '<script language="javascript">alert("Такой предмет уже есть!")</script>';
            else
                $db->makeQuery("UPDATE `subject` SET `subject_name`='{$subject_name}' WHERE subject_id={$id}");
        }
    }
    
    public static function displayTable(){
        $sort_list = array(
    	    'subject_id_asc'   => '`subject_id`',
        	'subject_id_desc'  => '`subject_id` DESC',
        	'subject_name_asc'  => '`subject_name`',
        	'subject_name_desc' => '`subject_name` DESC'
        );
        $sort = @$_GET['sort'];
        if (array_key_exists($sort, $sort_list)) {
        	$sort_sql = $sort_list[$sort];
        } else {
        	$sort_sql = reset($sort_list);
        }
        
        $db = new DB;
        if(isset($_POST['search']))
            $sql = Subject::searchQuery()." ORDER BY $sort_sql";
        else
            $sql = "SELECT subject_id, subject_name FROM subject ORDER BY $sort_sql";
        $res_data = $db->getQueryResult($sql);
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/table.css" rel="stylesheet">';
        else
            echo '<link href="css/table.css" rel="stylesheet">';
        echo '<table border=1 class="db_table">
            <thead>
                <tr>
                    <th>';
                    echo Inter::sort_link_th('№', 'subject_id_asc', 'subject_id_desc');
                    echo'</th>
                    <th>';
                    echo Inter::sort_link_th('Предмет', 'subject_name_asc', 'subject_name_desc');
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
                    <td>".$row["subject_id"]."</td>
                    <td>".$row["subject_name"]."</td>";
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo "<td><a href='?delete={$row['subject_id']}'>Удалить</a></td>
                        <td><a href='?edit={$row['subject_id']}'>Изменить</a></td>";
                    }
                echo "</tr>";
            }
        }
        echo '</table>';
    }
    
    public static function displayForm(){
        $db = new DB;
        if(isset($_GET['edit'])){
            $product = mysqli_fetch_array($db->getQueryResult("SELECT * FROM subject WHERE subject_id={$_GET['edit']}"));
        }
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/edit_form.css" rel="stylesheet">';
        else
            echo '<link href="css/edit_form.css" rel="stylesheet">';
        echo '<div class="edit-page">
            <div class="edit-form">
                    <form method="post" class="login-form">
                        <input type="text" name="subject_name"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["subject_name"].'"';
                        }
                        echo '>';
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
        $querySearchList = "select subject_id, subject_name from subject where ";
        $queryAllList = "select subject_id, subject_name from subject";
        $query = $queryAllList;
        if(trim($_POST['subject_name'])!=''){
            $query .= " where subject_name LIKE N'%{$_POST['subject_name']}%'";
        }
        
        return $query;
    }
}
?>