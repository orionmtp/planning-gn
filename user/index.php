<?php
   include("config.php");
   session_start();
    //mysqli_select_db($database,$db)  or die('Erreur de selection '.mysql_error());
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['login']);
      $mypassword = md5(mysqli_real_escape_string($db,$_POST['password'])); 
    
      $sql = "SELECT id FROM login_jeu WHERE email = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql)  or die(mysqli_error($db));
      $count = mysqli_num_rows($result);
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
         //session_register("planning");
		 session_start();
         $_SESSION['id'] = $row['id'];
         header("location: menu.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
<head>
<title>Login Page</title>      
</head>
<body>
<center>
PlanningGN<br><br>
<form action = "" method = "post">
Login  :<input type = "text" name = "login" class = "box"/><br><br>
Password :<input type = "password" name = "password" class = "box" /><br><br>
<input type = "submit" value = "Se Connecter"/><br><br>
<a href=perdu.php>mot de passe perdu</a><br>
<a href=inscription.php>s'inscrire</a><br>
<a href="http://scenar.planning-gn.fr/index.php">menu scenariste</a><br>
<br>
<?php /*include ("generique.php")*/;?>
</center>
</form>
</body>
</html>
