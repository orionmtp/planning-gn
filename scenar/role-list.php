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
   else $gn=0;
      if (isset($_GET['pnj'])) 
       $pnj=$_GET['pnj'];
   else $pnj=-1;
      $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
// On vérifie si les champs sont vides
   if($gn==0 || $pnj==-1)
   {
      echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
   }
// Aucun champ n'est vide, on peut enregistrer dans la table
   else     
   {
          if (isset($_POST['delete']))
                {
                $event=$_POST['besoin'];
                $sql="delete from role where id='$event'";
                mysqli_query($db,$sql);
                }


    if ($pnj==0) $page=16;
    else $page=18;
include 'upper.php';
echo '<center>';
echo 'roles joueur<br>'."\n";
$sql = " select id,nom from role where gn='$gn' and pnj='$pnj' order by nom";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
	echo "<table><tr><td>nom</td><td>operation</td></tr>";
   while($row = mysqli_fetch_assoc($result)) {
echo '<tr><td><a href="role.php?role='. $row["id"]. '&gn='.$gn.'">'. $row["nom"] .'</a></td><td><form method=POST action="role-list.php?gn='.$gn.'&pnj='.$pnj.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td></tr>'."\n";
   }
	echo "</table>";
}
echo '<form method="POST" action="add-role.php?gn='.$gn.'&pnj='.$pnj.'">'."\n";
echo '<input type="text" name="nom" value="nom">'."\n";
echo '<input type="submit" value="ajouter un role" name="pnj"></form>'."\n";
}
    echo '</center></body></html>';
}
}
?>
