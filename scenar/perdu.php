<?php
include 'config.php';
        $page=4;
include 'upper2.php';
echo "<html>\n<head>\n";
if(isset($_POST['forgotten']))
{
    $login=mysqli_real_escape_string ($db,$_POST['login']);
    $rand = substr(md5(microtime()),rand(0,26),8);
    $password=md5($rand);
    $sql="update login set password='$password' where login='$login')";
    mysqli_query($db,$sql)  or die(mysqli_error($db));
    $message="vous avez demandé un nouveau mot de passe pour planningGN\r\nle mot de passe suivant a été généré pour vous : ". $rand ."\r\nVous pouvez vous connecter avec immediatement\r\nL'équipe planningGN";
    $headers = 'From: planning@creadvance.org' . "\r\n" . 'Reply-To: planning@creadvance.org' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    mail($login,"mot de passe planningGN perdu",$message,$headers);
    echo '<meta http-equiv="refresh" content="3;url=index.php" />';
    echo "</head>\n<body>\n<center>\n";
    echo 'email envoye avec un nouveau password<br>'."\n";
    echo 'vous pouvez vous connecter'."\n";
}
else {
    echo "</head>\n<body>\n<center>\n";
    echo '<form action = "" method = "post">'."\n";
    echo 'mot de passe oublie<br>'."\n";
    echo 'Email  :<input type="email" placeholder="Email" required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" name="login"><br><br>'."\n";
    echo '<input type="hidden" name="forgotten" value="1">'."\n";
    echo '<input type = "submit" value = "envoyer"/><br><br>'."\n";
}
echo "</center>\n</body>\n</html>"; 
