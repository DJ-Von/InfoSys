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
}
?>