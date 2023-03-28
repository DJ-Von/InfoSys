<?php
//require 'DB.php';
class Teacher{
    public $teacher_full_name;
    public $teacher_login;
    public $teacher_password;
    public function __construct($teacher_full_name, $teacher_login, $teacher_password){
        $this->teacher_full_name = $teacher_full_name;
        $this->teacher_login = $teacher_login;
        $this->teacher_password = $teacher_password;
    }
    
    public function add(){
        $db = new DB;
        $db->con = mysqli_query("INSERT INTO `teacher`(`teacher_full_name`, `teacher_login`, `teacher_password`) VALUES ({$this->teacher_full_name},{$this->teacher_login},{$this->teacher_password})");
    }
    
    public static function delete($id){
        $db = new DB();
        $db->con = mysqli_query("DELETE FROM `teacher` WHERE teacher_id={$id}");
    }
    
    public static function change($id, $teacher_full_name, $teacher_login, $teacher_password){
        $db = new DB;
        $db->con = mysqli_query("UPDATE `teacher` SET `teacher_full_name`={$teacher_full_name},`teacher_login`={$teacher_login},`teacher_password`= {password_hash($teacher_password, PASSWORD_DEFAULT)} WHERE teacher_id={$id}");
    }
    
    public function echoTestTeacher(){
        echo "Teacher ".$this->teacher_full_name;
    }
}
?>