<?php
class Inter{
    public static function head(){
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            include (realpath('../inter_elements/head.php'));
        else
            include (realpath('./inter_elements/head.php'));
    }
    public static function menu(){
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            include (realpath('../inter_elements/menu.php'));
        else
            include (realpath('./inter_elements/head.php'));
    }
    
    public static function loginForm(){
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            include (realpath('../inter_elements/login_form.php'));
        else
            include (realpath('./inter_elements/login_form.php'));
    }
    public static function footer(){
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin')
            include (realpath('../inter_elements/footer.php'));
        else
            include (realpath('./inter_elements/footer.php'));
    }
    
    public static function sort_link_th($title, $a, $b) {
	    $sort = @$_GET['sort'];
    	if ($sort == $a) {
    		return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
    	} elseif ($sort == $b) {
    		return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';  
    	} else {
    		return '<a href="?sort=' . $a . '">' . $title . '</a>';  
    	}
    }
}
?>