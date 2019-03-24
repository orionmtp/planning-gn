<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
include 'config.php';
// On commence par récupérer les champs
if (isset($_GET['gn'])) $gn=$_GET['gn'];
else $gn=0;
if (isset($_POST['nom'])) $nom=$_POST['nom'];
else $nom="";
    $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
// On vérifie si les champs sont vides
if($gn==0)
    {
        echo '<html><head></head><body><center>';
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
        echo '</center></body></html>';
    }

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {
		$sql = "select id from login_jeu where pseudo='$nom'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
		if (mysqli_num_rows($result) > 0) {
			$row=mysqli_fetch_assoc($result);
			$role=$row['id'];
			$sql="select id from inscription where gn='$gn' and login='$role'";
			$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
			if (mysqli_num_rows($result) == 0) {
				$sql="insert into inscription (login,gn,pnj,paiement) values ('$role','$gn','0','0')";
				mysqli_query($db,$sql)  or die(mysqli_error($db));
			}
		}
		else {
			$rand = substr(md5(microtime()),rand(0,26),8);
			$sql = "insert into login_jeu (pseudo,email,password) values ('$nom','$rand','$rand')";
			mysqli_query($db,$sql)  or die(mysqli_error($db));
			$role=mysqli_insert_id($db);
			$sql="insert into inscription (login,gn,pnj,paiement) values ('$role','$gn','0','0')";
			 mysqli_query($db,$sql)  or die(mysqli_error($db));
		}
        $head="location:joueur.php?gn=".$gn."&id=".$role;
		header($head);
    }
}
}
?>