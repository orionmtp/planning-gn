<?php
session_start();
if(!isset($_SESSION['id'])){
      header("location:presentation.php");
   }
else {
    include 'config.php';
    $id=$_SESSION['id'];
    if (isset($_POST['login'])){
        $temp=mysqli_real_escape_string ($db,$_POST['login']);
        $sql="update login_jeu set login='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['pseudo'])){
        $temp=mysqli_real_escape_string ($db,$_POST['pseudo']);
        $sql="update login_jeu set pseudo='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['nom'])){
        $temp=mysqli_real_escape_string ($db,$_POST['nom']);
        $sql="update login_jeu set nom='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['prenom'])){
        $temp=mysqli_real_escape_string ($db,$_POST['prenom']);
        $sql="update login_jeu set prenom='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['tel'])){
        $temp=mysqli_real_escape_string ($db,$_POST['tel']);
        $sql="update login_jeu set tel='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['adr'])){
        $temp=mysqli_real_escape_string ($db,$_POST['adr']);
        $sql="update login_jeu set adresse='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['alim'])){
        $temp=mysqli_real_escape_string ($db,$_POST['alim']);
        $sql="update login_jeu set alim='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['sante'])){
        $temp=mysqli_real_escape_string ($db,$_POST['sante']);
        $sql="update login_jeu set sante='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['cont1_nom'])){
        $temp=mysqli_real_escape_string ($db,$_POST['cont1_nom']);
        $sql="update login_jeu set contact1_nom='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['cont1_tel'])){
        $temp=mysqli_real_escape_string ($db,$_POST['cont1_tel']);
        $sql="update login_jeu set contact1_tel='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['cont2_nom'])){
        $temp=mysqli_real_escape_string ($db,$_POST['cont2_nom']);
        $sql="update login_jeu set contact2_nom='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['cont2_tel'])){
        $temp=mysqli_real_escape_string ($db,$_POST['cont2_tel']);
        $sql="update login_jeu set contact2_tel='$temp' where id='$id'";
        mysqli_query($db,$sql);
    }
    if (isset($_POST['password'])){
        $temp=$_POST['password'];
        if ($temp!=""){
            $temp=md5($temp);
            $sql="update login_jeu set password='$temp' where id='$id'";
            mysqli_query($db,$sql);
        }
    }
	if (isset($_POST['deletestyle'])){
        $style=$_POST['style'];
		$sql="delete from style_joueur where joueur='$id' and style='$style'";
        mysqli_query($db,$sql);
    }
	if (isset($_POST['ajout'])){
        $style=$_POST['style']; 
        $sql="insert into style_joueur values ('','$id','$style')";
		mysqli_query($db,$sql);
    }
	
    $sql="select * from login_jeu where id='$id'";
    $result=mysqli_query($db,$sql);
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
            echo '<td><input type="text" name="pseudo" value="'.$row['pseudo'].'"></td></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>nom</td>'."\n";
            echo '<td><input type="text" name="nom" value="'.$row['nom'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>prenom</td>'."\n";
            echo '<td><input type="text" name="prenom" value="'.$row['prenom'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>adresse</td>'."\n";
            echo '<td><input type="text" name="adr" value="'.$row['adresse'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>telephone</td>'."\n";
            echo '<td><input type="text" name="tel" value="'.$row['tel'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>regime alimentaire</td>'."\n";
            echo '<td><select>'."\n";
            echo '<option value="0"';
            if ($row['alim']==0) echo 'selected';
            echo ">rien a signaler</option>\n";
            echo '<option value="1"';
            if ($row['alim']==1) echo 'selected';
            echo ">allergie</option>\n";
            echo '<option value="2"';
            if ($row['alim']==2) echo 'selected';
            echo ">vegetarien</option>\n";
            echo '</select></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>sante</td>'."\n";
            echo '<td><input type="text" name="sante" value="'.$row['sante'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '</table>'."\n";
            echo "contacts d'urgence\n";
            echo '<table>'."\n";
            echo '<tr>'."\n";
            echo '<td></td>'."\n";
            echo '<td>nom</td>'."\n";
            echo '<td>telephone</td>'."\n";
            echo '</tr>'."\n";
            echo '<td>contact 1</td>'."\n";
            echo '<td><input type="text" name="cont1_nom" value="'.$row['contact1_nom'].'"></td>'."\n";
            echo '<td><input type="text" name="cont1_tel" value="'.$row['contact1_tel'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '<tr>'."\n";
            echo '<td>contact 2</td>'."\n";
            echo '<td><input type="text" name="cont2_nom" value="'.$row['contact2_nom'].'"></td>'."\n";
            echo '<td><input type="text" name="cont2_tel" value="'.$row['contact2_tel'].'"></td>'."\n";
            echo '</tr>'."\n";
            echo '</table>'."\n";
            echo '<input type = "submit" value = "mettre a jour">'."\n";
            echo "</form>\n";
       }
	   	echo '<br><center>style de jeu</center><br>'."\n";
		$sql = "select style.id,style.nom from style inner join style_joueur on style.id=style_joueur.style where style_joueur.joueur='$id'";
		$result=mysqli_query($db,$sql);
		if (mysqli_num_rows($result) > 0) {
			echo '<table><tr><td>style</td><td>operation</td></tr>'."\n";
			while($row = mysqli_fetch_assoc($result)) {
				echo '<tr><td>'.$row["nom"].'</td><td><form method=POST action="compte.php"><input type="hidden" value="'.$row['id'].'" name="style"><input type="submit" value="supprimer" name="deletestyle"></form></td></tr>'."\n";
			}
			echo '</table><br>'."\n";
		}
		echo '<form method="POST" action="compte.php">'."\n";
		echo '<select name="style">';
		$sql="select id,nom from style where id not in (select style from style_joueur where joueur='$id') order by nom";
		$result=mysqli_query($db,$sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				echo '<option value="'. $row["id"].'">'. $row["nom"] .'</option>';
			}
		}
		echo '</select>';
		echo '<input type="submit" value="ajouter un style de jeu" name="ajout"></form>'."\n";
    }
    else echo "erreur<br>\nveuillez contacter un administrateur\n";
    echo '</center></body></html>';
}
?>
