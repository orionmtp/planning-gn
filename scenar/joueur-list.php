<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
    header("location:index.php");
}
else {
    include 'config.php';

    // On commence par récupérer les champs
    if (isset($_GET['gn'])) 
        $gn=$_GET['gn'];
    else {
        if (isset($_POST['gn']))
            $gn=$_POST['gn']; 
        else 
            $gn=0;
        }
            $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
    $page=26;
    include 'upper.php';
    echo "<center>";
    // On vérifie si les champs sont vides
    if($gn==0)
    {
        echo '<font color="red"> et si tu choissais un GN  et un joueur, au moins ??? !</font><br>';
    }
    // Aucun champ n'est vide, on peut enregistrer dans la table
    else {
		if (isset($_POST['supri'])){
			$id=$_POST['id'];
			$sql="delete from inscription where gn='$gn' and login='$id'";
			mysqli_query($db,$sql)  or die(mysqli_error($db));
		}
        echo "informations joueur<br>";
        $sql = "select login_jeu.id,pseudo,login_jeu.nom,prenom,inscription.pnj,inscription.paiement from login_jeu inner join inscription on login_jeu.id=inscription.login where inscription.gn='$gn'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
        echo "<table><tr><td>pseudo</td><td>nom</td><td>prenom</td><td>PJ</td><td>paiement</td><td>operation</td></tr>";
        if (mysqli_num_rows($result)>0) {
            while ($row=mysqli_fetch_assoc($result)) {
				$id=$row['id'];
                echo "<tr><td><a href=\"joueur.php?gn=".$gn."&id=".$id."\">".$row['pseudo']."</a></td>";
                echo "<td>".$row['nom']."</td>";
                echo "<td>".$row['prenom']."</td>";
                echo "<td><input type=checkbox";
                if ($row['pnj']==0) echo " checked";
                echo "></td>";
                echo "<td><input type=checkbox";
                if ($row['paiement']==1) echo " checked";
                echo '></td><td><form action="joueur-list.php?gn='.$gn.'" method="post"><input type="hidden" name=id value="'.$id.'"><input type = "submit" name="supri" value = "supprimer"></form></td></tr>';
            }
            echo "</table>";
        }
	echo '<form action="add-joueur.php?gn='.$gn.'" method="post">';
    echo '<input type="text" name=nom value="nom a modifier">';
   echo '<input type = "submit" name="envoi" value = "ajouter"><br>';
    }
    echo '</center></body></html>';
}   
} 
?>