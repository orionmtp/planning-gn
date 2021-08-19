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
                      $page=18;
include 'upper.php';
echo '<center>';
echo '<center>roles non joueur<br>'."\n";
$sql = " select id,nom from role_pnj where gn='$gn'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
echo '<a href="role-pnj.php?role='. $row["id"]. '&gn='.$gn.'">'. $row["nom"] .'</a><br>'."\n";
   }
}
echo '<form method="POST" action="role.php">'."\n";
echo '<input type="text" name="nom" value="nom">'."\n";
echo '<input type="hidden" name="gn" value="'. $gn .'">'."\n";
echo '<input type="submit" value="ajouter un role" name="pnj"></form>'."\n";
}
    echo '</center></body></html>';
}
?>