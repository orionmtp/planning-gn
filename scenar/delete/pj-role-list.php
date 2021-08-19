<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
   include 'config.php';
   echo '<html><head></head><body><center>';
// On commence par récupérer les champs
   if (isset($_GET['gn'])) 
       $gn=$_GET['gn'];
   else $gn=0;
// On vérifie si les champs sont vides
   if($gn==0)
   {
      echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
   }
// Aucun champ n'est vide, on peut enregistrer dans la table
   else     
   {
                      $page=16;
include 'upper.php';
echo '<center>';
   echo '<center>roles joueurs<br>'."\n";
$sql = " select role_pj.id,role_pj.nom from role_pj where gn='$gn'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo '<a href="role.php?role='. $row["id"]. '&gn='.$gn.'">'. $row["nom"] .'</a>';
        $id=$row['id'];
        $sql = " select login_jeu.id,login_jeu.pseudo from login_jeu inner join role_pj on login_jeu.id=role_pj.login where role_pj.id='$id'";
        $result2=mysqli_query($db,$sql)  or die(mysqli_error($db));
        if (mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);
        echo ' joue par <a href="joueur.php?id='. $row2['id'].'&gn='.$gn.'">'. $row2["pseudo"] .'</a>';
        }
        echo '<br>';
   }
}
echo '<form method="POST" action="role-pj.php">'."\n";
echo '<input type="text" name="nom" value="nom">'."\n";
echo '<input type="hidden" name="gn" value="'. $gn .'">'."\n";
echo '<input type="submit" value="ajouter un role PJ" name="pj"></form>'."\n";
}
    echo '</center></body></html>';
}
?>