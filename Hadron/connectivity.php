<?php
 try{
    $db= new PDO('mysql:host=localhost;dbname=hadron','root','', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    // var_dump($db);
    }
    catch(Exception $e){
     echo  $e->getMessage();
    }
?>