<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
    include 'config.php';
    $id=$_SESSION['id'];
    if (isset($_POST['update'])){
		$login=mysqli_real_escape_string ($db,$_POST['login']);
        $pseudo=mysqli_real_escape_string ($db,$_POST['pseudo']);
		if(isset($_POST['delta'])) $delta=1; else $delta=0;
        $password=$_POST['password'];
        if ($password!=""){
            $password=md5($password);
            $sql="update login set password='$password', pseudo='$pseudo', email='$login', delta='$delta' where id='$id'";
        }
        else {
            $sql="update login set pseudo='$pseudo', login='$login' where id='$id'";
        }
        mysqli_query($db,$sql)  or die(mysqli_error($db));     
    }
    $page=3;
include 'upper.php';
    $sql="select email, pseudo, delta from login where id='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    echo "<html>\n<head>\n</head>\n<body>\n<center>\ninformations sur le compte\n<br>\n<br>\n";
    if (mysqli_num_rows($result) == 1) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<form action="" method="post">'."\n";
            echo '<table border="0">'."\n";
            echo '<tr>'."\n";
            echo '<td>email</td>'."\n";
            echo '<td><input type="email" placeholder="Email" required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" name="login" value="'.$row['email'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>nouveau password</td>'."\n";
            echo '<td><input type = "password" name = "password" value=""></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>pseudo</td>'."\n";
            echo '<td><input type="text" name="pseudo" value="'.$row['pseudo'].'"></td>'."\n";
            echo '</tr>'."\n";
			echo '<tr>'."\n";
			echo '<td>timeline</td>'."\n";
			echo '<td><input type="checkbox" name="delta" ';
			if ($row['delta']) echo 'checked';
			echo '></td>'."\n";
			echo '</tr>'."\n";
            echo '</table>'."\n";
            echo '<input type = "submit" value = "mettre a jour" name="update">'."\n";
            echo "</form>\n";
       }
       echo '<br><br>';
       echo 'liste des GN en cours de redaction<br>';
       $sql="select gn.* from gn inner join admin on admin.gn=gn.id where  admin.login='$id'";
$result=mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
       echo '<a href="gn.php?gn=' . $row["id"] .'">' . $row["nom"] .'</a> du '. $row["debut"] .' au '.$row['fin'].'<br>';
   }
}
       
    }
    else echo "erreur<br>\nveuillez contacter un administrateur\n";
    echo '</center></body></html>';
}
?>