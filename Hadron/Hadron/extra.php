<!DOCTYPE html>
<html lang="en">
<head>
<script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
    <script>
        var choice1="consultation";
        var choice2="complaint";
        const cols = ["fullname","contact","address","email","complaint_no","complaint_description","complaint_status","client_id"];
        $(document).ready(function(){
            $("#consul").click(function(){
                $("#consuldiv").load("comp_consul_table.php",{
                    action:"showconsultation_action",
                    data: choice1,
                    cols:cols.slice(0,4)
                
                });
            })
            $("#comp").click(function(){
                $("#compdiv").load("comp_consul_table.php",{
                    action:"showcomplaint_action",
                    data: choice2,
                    cols:cols.slice(4,8)
                
                });
            })

        })
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" type="text/css" href="design.css"> -->
    <?php
// echo "working";
require_once "connectivity.php";

"/br";
if(isset($_POST['add_c'])){
    if(isset($_POST['addclientid']) && isset($_POST['addclientpass'])){
        // echo "hi";
    $stmt = $db->prepare("INSERT INTO add_client (client_id,client_pass) values (?,?)");
    $clientid = $_POST['addclientid'];
    $clientpass = $_POST['addclientpass'];
        $stmt->bindParam(1,$clientid);
        $stmt->bindParam(2,$clientpass);
        $stmt->execute();
    }
}
else if(isset($_POST['change_status_button'])){
    if(isset($_POST['change_status'])){
        $stmt = $db->prepare("UPDATE complaint SET complaint_status= ? where client_id=?");
        $clientid =$_POST['change_status'];
        $stmt->bindValue(1,true);
        $stmt->bindParam(2,$clientid);
        $stmt->execute();
    }
}

?> 
</head>
<body>
    <h1>Admin</h1>

<fieldset>
    <legend>Add Client</legend>
<div id="homediv">
<form name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
Client ID:<input type="text" name="addclientid"/>
Password:<input type="text" name="addclientpass"/>
<input type="submit" id="add_c" class="loginandform" value="+ add" name="add_c"  />
</form>

 <br><br><br>
</div>
</fieldset>
<br><br><br>

<fieldset>
<legend>Change Status</legend>
    <div>
        <form name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
          
          <input type="text" name="change_status"/>
          <input type="submit" id="#change_status_button" name="change_status_button" value="Acknowleged/completed"/>
</form>
    
</div>


</fieldset>
<input type="submit" id="comp" class="loginandform" value="complaint" />
<input type="submit" id="consul" class="loginandform" value="consultation"  />
<div id="consuldiv"></div>
<div id="compdiv"></div>

</body>
</html>