<?php

echo "<!DOCTYPE html><html>
        <head><title>Экзамен - информационная система</title></head>
        <body>";
        if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher']=='admin')
            echo "<link href='../css/head.css' rel='stylesheet'>";
        else
            echo "<link href='css/head.css' rel='stylesheet'>";
        echo "<div class='wrapper'>";
        include 'menu.php';
        echo '<div class="content">';
        
?>