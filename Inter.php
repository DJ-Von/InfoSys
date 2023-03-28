<?php
class Inter{
    public static function head(){
        include_once 'inter_elements/head.php';
    }
    public static function menu(){
        include_once 'inter_elements/menu.php';
    }
    
    public static function loginForm(){
        include_once 'inter_elements/login_form.php';
    }
    public static function footer(){
        include_once 'inter_elements/footer.php';
    }
}
?>