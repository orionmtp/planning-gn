<?php
session_start();
if(!isset($_SESSION['id'])){
      header("location:presentation.php");
   }
else {
include 'config.php';
$id=$_SESSION['id'];
 echo '<html><head></head><body><center>';

// On commence par récupérer les champs

if (isset($_GET['gn'])) $gn=$_GET['gn'];
else $gn=0;
// On vérifie si les champs sont vides
if($gn==0)
    {
    echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
    }

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {

//les infos sur le GN
$sql = "select nom,debut,fin,description from gn where id='$gn'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) == 1) {
   while($row = mysqli_fetch_assoc($result)) {
       echo 'GN<br>'. $row["nom"] .'<br><table><tr><td>du</td><td>'. $row["debut"] .'</td><td> au </td><td>'. $row["fin"] .'</td></tr></table><br>'. $row["description"] . '<br>';
   }
}

$sql = "select pnj,paiement from inscription where gn='$gn' and login='$id'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) == 1) {
   while($row = mysqli_fetch_assoc($result)) {
       if ($row['pnj']==0) echo 'vous etes inscrit en tant que PJ.<br>';
       else echo 'vous etes inscrit en tant que PNJ<br>';
       if ($row['paiement']==0) echo '<font color=red>votre paiement n\'a pas ete recu</font><br>';
       else echo '<font color=green>votre paiement a ete recu.</font><br>';
   }
}

//la liste des scenaristes
echo '<br><br>scenaristes<br>';
 $sql = "select login.id,pseudo,admin.admin,admin.role from login inner join admin on admin.login=login.id where admin.gn='$gn' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="scenar.php?id='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"].' : '.$row['role'].'</a><br>'."\n";
   }
      echo '<a href="scenar-list.php?gn='.$gn.'">liste complete</a><br>';
}       
echo '<br>'."\n";
//les PNJ inscrits
echo 'joueurs inscrits<br>'."\n";
$sql = " select login_jeu.id,pseudo from login_jeu inner join inscription on login_jeu.id=inscription.login where inscription.gn='$gn' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="joueur.php?id='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"] .'</a><br>'."\n";
   }
   echo '<a href="joueur-list.php?gn='.$gn.'">liste complete</a><br>'."\n";
}
  mysqli_close($db);  // on ferme la connexion
} 
 echo '</center></body></html>';
}
?> 
