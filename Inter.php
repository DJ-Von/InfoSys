<?php
require_once 'DB.php';
class Inter{
    public static function head(){
        include 'inter_elements/head.php';
    }
    public static function menu(){
        include 'inter_elements/menu.php';
    }
    
    public static function loginForm(){
        include 'inter_elements/login_form.php';
    }
    public static function footer(){
        include 'inter_elements/footer.php';
    }
    public static function echoTable($query, $tableHeaders, $queryHeaders){
        $db = new DB;
        if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
            echo '<link href="../css/table.css" rel="stylesheet">';
        }
        else{
            echo '<link href="css/table.css" rel="stylesheet">';
        }
        echo '<table border = 1 class="db_table">
        <thead>
                  <tr>';
        foreach($tableHeaders as $header){
            echo '<th>'.$header.'</th>';
        }
        echo '</tr></thead>';
        
        $sql = mysqli_query($db->con, $query);
        echo '<tbody>';
        while ($result = mysqli_fetch_array($sql)) {
            echo '<tr>';

            foreach($queryHeaders as $key){
                echo '<td>'.$result[$key].'</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        
        echo '</table>';
    }
}
?>