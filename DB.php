<?php  
session_start();
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 class DB{  
      public $con;  
      public $error;  
      public function __construct()  
      {  
           $this->con = mysqli_connect("localhost", "s981757s_14", "Nokia3500!", "s981757s_14");  
           if(!$this->con)  
           {  
                echo 'Database Connection Error ' . mysqli_connect_error($this->con);
           }  
      }  
      
      public function getTable($name){
          $query = "SELECT * FROM `".$name."`";
          $result = mysqli_query($this->con, $query);
          return $result;
      }
 }  
 ?>  