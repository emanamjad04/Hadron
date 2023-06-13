<?php
$choice =$_POST['data'];
$whereclause=$_POST['where'];
// $choice = isset($_POST['data']) ? $_POST['data'] : '';
// var_dump($choice); 

try{
    $db= new PDO('mysql:host=localhost;dbname=hadron','root','', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    // var_dump($db);
    }
    catch(Exception $e){
     echo  $e->getMessage();
    }
    $stmpt2=$db->prepare("SELECT * FROM  $choice $whereclause");
    $stmpt2->execute();
    $rows=$stmpt2->fetchall(PDO::FETCH_ASSOC);
    echo '<table border=1>';
    foreach($rows as $row){
        echo '<tr>';
        foreach($_POST['cols'] as $col){
            // var_dump($col); 
        echo '<td>' . $row[$col] . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';

?>