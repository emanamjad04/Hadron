<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="allcss.css">

    <?php
    
        require_once "connectivity.php";


        if(isset($_POST['name']))
        {
        $stmpt=$db->prepare("INSERT INTO consultation (fullname,contact,address,email) values (?,?,?,?)");
        $f_name=$_POST['name'];
        $cont=$_POST['contact'];
        $add=$_POST['address'];
        $em=$_POST['email'];
        $stmpt->bindParam(1,$f_name);
        $stmpt->bindParam(2,$cont);
        $stmpt->bindParam(3,$add);
        $stmpt->bindParam(4,$em);
        $stmpt->execute();
        }
        


    ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homeconsultation</title>
</head>
<body>
<div id="homediv1">
    <br>
  <ul id="ul1">
  <a href="home.php" ><li class="li1">HOME</li></a>
    <a href="#confield" ><li class="li1" >CONSULTATION</li></a>
    <a href="#head_div2" ><li class="li1">ABOUT</li></a>
    <a href="#contact_container" ><li class="li1">CONTACT</li></a>
    <a href="login.php" ><li class="li1">LOGIN</li></a>
  </ul>
  </div>

<br><br><br><br><br><br>
<center>
<div id="head_div2" class="heading" style=" background-color: #b2b2b2;"><h1> ABOUT</h1></div></center>

<center>
<div id="about_div">
<div id ="person1" class="about"><h6>Ali Razaq</h6></div>
<div id ="person2" class="about"><h6>Waqas Moosa</h6></div>
<div id ="person3" class="about"><h6>Atif Rahman</h6></div>
</div>
</center>


  <br><br>

<center>
<div id="consultation_div">

<form name="form" action="home.php"  method="post">
    <fieldset id="confield">
        <center>
<div id="head_div4" class="heading" style=" background-color: #b2b2b2; "><h1> CONSULTATION</h1></div></center>
<table>
  <tr>
    <td>Full Name:</td>
    <td><input class="fontform" name="name"type="text" placeholder=" Example Jack"required /></td>
  </tr>
  
  <tr>
    <td>Contact:</td>
    <td><input name="contact" class="fontform" type="text" placeholder="03#####"/></td>
  </tr>
  <tr>
    <td>Address:</td>
    <td><input class="fontform" name="address"type="text" placeholder="Example defence"required /></td>
  </tr>
  
  <tr>
    <td>Email:</td>
    <td><input class="fontform" name="email" text="email" placeholder="email@address.com" required /></td>
  </tr>  
</table>
<input type="submit" class="loginandform" value="Submit" onclick='' /> 

</fieldset>

</form>
</div>
</center>
 
 <!-- //project -->
<br><br>
 <center>
<div id="head_div1" class="heading" style=" background-color: #b2b2b2;"><h1>PROJECTS</h1></div></center>

<center>
<div id="about_div">
<div id="round" class="about"><h3 id="h31">450</h3><h6>Satisfied Customers</h6></div>
<div id="round" class="about"><h3 id="h32">10</h3><h6>MW</h6></div>
<div id="round"  class="about"><h3 id="h33">42</h3><h6>Cities</h6></div>
</div>
</center>
<br>
<br>
<footer>
  <div id="contact_container" class="clearfix">
  <center><div id="head_div1" class="heading"><h1> CONTACT US</h1></div></center>
    <div id="aep">
      <div class="address">
        <i class="fas fa-map-marker-alt"></i>
        <p>326-Johar Avenue, New Campus Road, Lahore</p>
      </div>
      <div class="email">
        <i class="fas fa-envelope"></i>
        <p>info@hadronsolar.com</p>
      </div>
      <div class="phone">
        <i class="fas fa-phone"></i>
        <p>+92 345 444 4260</p><br/>
        <p>+92 423 3524 0526</p>
      </div>
    </div>
    <div id="links">
      <p><a href=""><i class="fab fa-facebook-f"></i>Hadron Solar</a></p>
      <p><a href=""><i class="fab fa-instagram"></i>@hadronsolar</a></p>
      <p><a href=""><i class="fab fa-youtube"></i>@HadronSolar</a></p>
      <!-- <p><a href=""><i class="fab fa-twitter"></i>Hadron Solar (Pvt.) Ltd.</a></p> -->
    </div>
  </div>
</footer>

</body>
</html>