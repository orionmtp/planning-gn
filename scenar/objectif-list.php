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
// On vérifie si les champs sont vides
   if($gn==0)
   {
      echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
   }
// Aucun champ n'est vide, on peut enregistrer dans la table
   else     
   {
          if (isset($_POST['delete']))
                {
                $event=$_POST['besoin'];
                $sql="delete from objectif where id='$event'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
                }

              $page=31;
include 'upper.php';
   echo '<center>liste des objectifs definis<br>'."\n";
$sql = " select id,role,nom,relation from objectif where gn='$gn'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
echo '<table><tr><td>titre</td><td>personnage</td><td>cible</td></tr>';
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
$id=$row["role"];
$sql = " select nom from role where id='$id'";
$result1=mysqli_query($db,$sql)  or die(mysqli_error($db));
$row1 = mysqli_fetch_assoc($result1);
$id=$row["relation"];
$sql = " select nom from role where id='$id'";
$result2=mysqli_query($db,$sql)  or die(mysqli_error($db));
$row2 = mysqli_fetch_assoc($result2);

      echo '<tr><td><a href="objectif.php?gn='.$gn.'&objectif='. $row["id"]. '">'. $row["nom"] .'</a></td>';
      echo '<td><a href="role.php?gn='.$gn.'&role='. $row["role"]. '">'. $row1["nom"] .'</a></td>';
      echo '<td><a href="role.php?gn='.$gn.'&role='. $row["relation"]. '">'. $row2["nom"] .'</a></td>';
      echo '<td><form method=POST action="objectif-list.php?gn='.$gn.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td>';
      echo '</tr>';
   }
}
echo '</table>';
        echo '<form method="POST" action="add-objectif.php?gn='.$gn.'&role=0">';
        echo '<input type="submit" value="ajouter un objectif"></form><br>';
}
    echo '</center></body></html>';
}
?>
