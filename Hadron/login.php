<html>
<head>
<link rel="stylesheet" type="text/css" href="design.css">
 <?php
 session_start();
 $_SESSION=array();
 session_destroy();
 $match=false;

 require_once "connectivity.php";

 if(isset($_POST['client_id']) && isset($_POST['client_pass']))
 {
	// print_r($_POST);
	if($_POST['client_id']==="Admin" && $_POST['client_pass']==="password")
	{
		header("Location:Admin.php");
	}
 }


 if(isset($_POST['client_id']) && isset($_POST['client_pass'])){
    $stmt = $db->prepare("SELECT * FROM add_client WHERE client_id = :client_id");
    $stmt->bindParam(':client_id', $_POST['client_id']);
    $stmt->execute();
	   while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
	      if($row['client_pass']==$_POST['client_pass']){
			session_start();//session created for user
			$_SESSION['s_client_id']=$_POST['client_id']; 
			$match=true;
			break;
		  };
   }

   if($match==true){
	header("Location:clientside.php");
	exit;
   }
}
// $stmt = $db->prepare("SELECT * FROM add_client WHERE client_id =?");
// $client = 'HD2114';
// 	$stmt->bindParam(1,$client);
// 	$stmt->execute();
	
//    while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
// 	echo htmlentities($row['client_id'])."   ".htmlentities ($row['client_pass']);
//    }






?> 
<meta name="viewport" content="width=device-width, initial scale=1.0">
<title>skillset</title>
<script type="text/javascript">
    
function check()
{

var match = "<?php echo $match; ?>";

if (match == "1") {
	var h3 = document.querySelector('h3');
	h3.innerHTML = "correct!";
// var no=document.getElementById("c_id").value;
// var pass=document.getElementById("password").value;
// var reg= /^HD\d{4}/;
// if(!reg.test(no))
// {
// alert("invalid input");
// window.location.href=("mainpage.html") ;
// }
// else
// {
// window.location.replace=("page2.html") ;
// }
// if(pass.length<2)
// {
// alert("Password Should be 6 Characters long");
// window.location.href=("mainpage.html") ;
// }
// else{
    
// }
// }

}}
</script>

</head>
<body>
<section class="head">

<nav >
<a href="home.php"><img id="logo" src="images/finallogo.png"></a>
<h4>by E.M</h4>
</nav>
<center>
<img id="imposter" src="images/imposter.png">
<h1>Welcome to Hadron</h1>
<br>
<fieldset>
<div id="homediv">
<form name="form" action="login.php"  method="post" autocomplete="off">
<h2 class="info">CLIENT ID:</h2>
<br>
<input type="text"  id="c_id" name="client_id" placeholder="example:HCxxxxxx" autocomplete="off"/>
<h2 class="info">PASSWORD:</h2>
<br>
<input id="password" type="password" name="client_pass" placeholder="  must be atleast 6 characters" autocomplete="off"/>
<br>
<br>
<input type="submit" class="loginandform" value="Login" onclick='check()' /> <br><br><br>
<h3></h3>
</form>
</div>
</fieldset>
</center>
</section>
</body>
</html>
