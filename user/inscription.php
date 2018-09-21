<?php
include 'config.php';
echo "<html>\n<head>";
if(isset($_POST['register']))
{
    $login=mysqli_real_escape_string ($db,$_POST['login']);
    $password=md5($_POST['password']);
    $pseudo=mysqli_real_escape_string ($db,$_POST['pseudo']);
    $sql="insert ignore into login_jeu values('','$login','$password','$pseudo','','','','','','','','','','','')";
    mysqli_query($db,$sql);
    echo '<meta http-equiv="refresh" content="3;url=presentation.html" />';
    echo "</head>\n<body>\n<center>\n";
    echo 'compte cree<br>'."\n";
    echo 'vous pouvez vous connecter'."\n";
}
else {
    echo "</head>\n<body>\n<center>\n";
    echo '<form action = "" method = "post">'."\n";
    echo 'Email  :<input type="email" placeholder="Email" required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" name="login"><br><br>'."\n";
    echo 'Password :<input type = "password" name = "password"><br><br>'."\n";
    echo 'Pseudo :<input type = "text" name = "pseudo"><br><br>'."\n";
    echo '<input type="hidden" name="register" value="1">'."\n";
    echo '<input type = "submit" value = "S inscrire"/><br><br>'."\n";
}
echo "</center>\n</body>\n</html>"; 
?>