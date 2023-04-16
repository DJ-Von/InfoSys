<?php
include_once ('DB.php');
include_once ('Inter.php');
class Team{
    public $team_name;
    public function __construct($team_name){
        $db = new DB;
        $this->team_name = $db->con->real_escape_string($team_name);
    }
    
    public function add(){
        $db = new DB;
        $result = $db->getQueryResult("SELECT COUNT(*) FROM team WHERE team_name='{$this->team_name}'");
        $teacherCount = mysqli_fetch_array($result)[0];
        if($teacherCount > 0)
            echo '<script language="javascript">alert("Такая группа уже есть!")</script>';
        else
            $db->makeQuery("INSERT INTO `team`(`team_name`) VALUES ('{$this->team_name}')");
    }
    
    public static function delete($id){
        $db = new DB();
        $db->makeQuery("DELETE FROM `team` WHERE team_id={$id};");
    }
    
    public static function change($id, $team_name){
        $db = new DB;
        $result = $db->getQueryResult("SELECT * FROM team WHERE team_id={$id}");
        $team = mysqli_fetch_array($result);
        if($team['team_name'] == $team_name)
            $db->makeQuery("UPDATE `team` SET `team_name`='{$team_name}' WHERE team_id={$id}");
        else{
            $result = $db->getQueryResult("SELECT COUNT(*) FROM team WHERE team_name='{$team_name}'");
            $teacherCount = mysqli_fetch_array($result)[0];
            if($teacherCount > 0)
                echo '<script language="javascript">alert("Такая группа уже есть!")</script>';
            else
                $db->makeQuery("UPDATE `team` SET `team_name`='{$team_name}' WHERE team_id={$id}");
        }
    }
    
    public static function displayTable(){
        $sort_list = array(
    	    'team_id_asc'   => '`team_id`',
        	'team_id_desc'  => '`team_id` DESC',
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
            $sql = Team::searchQuery()." ORDER BY $sort_sql";
        else
            $sql = "SELECT team_id, team_name FROM team ORDER BY $sort_sql";
        $res_data = $db->getQueryResult($sql);
        
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/table.css" rel="stylesheet">';
        else
            echo '<link href="css/table.css" rel="stylesheet">';
        echo '<table border=1 class="db_table">
            <thead>
                <tr>
                    <th>';
                    echo Inter::sort_link_th('№', 'team_id_asc', 'team_id_desc');
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
                    <td>".$row["team_id"]."</td>
                    <td>".$row["team_name"]."</td>";
                    if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
                        echo "<td><a href='?delete={$row['team_id']}'>Удалить</a></td>
                        <td><a href='?edit={$row['team_id']}'>Изменить</a></td>";
                    }
                echo "</tr>";
            }
        }
        echo '</table>';
    }
    
    public static function displayForm(){
        $db = new DB;
        if(isset($_GET['edit'])){
            $product = mysqli_fetch_array($db->getQueryResult("SELECT * FROM team WHERE team_id={$_GET['edit']}"));
        }
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            echo '<link href="../css/edit_form.css" rel="stylesheet">';
        else
            echo '<link href="css/edit_form.css" rel="stylesheet">';
        echo '<div class="edit-page">
            <div class="edit-form">
                    <form method="post" class="login-form">
                        <input type="text" name="team_name"';
                        if(isset($_GET['edit'])){
                            echo ' value="'.$product["team_name"].'"';
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
        $querySearchList = "select team_id, team_name from team where ";
        $queryAllList = "select team_id, team_name from team";
        $query = $queryAllList;
        if(trim($_POST['team_name'])!=''){
            $query .= " where team_name LIKE N'%{$_POST['team_name']}%'";
        }
        
        return $query;
    }
}
?>