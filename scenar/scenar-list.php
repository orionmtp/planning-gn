<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
   include 'config.php';
   echo '<center>';
// On commence par récupérer les champs
   if (isset($_GET['gn'])) 
       $gn=$_GET['gn'];
   else $gn=0;
// On vérifie si les champs sont vides
   $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
   if($gn==0)
   {
      echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
   }
// Aucun champ n'est vide, on peut enregistrer dans la table
   else     
   {
               $page=14;
include 'upper.php';
   echo '<center>scenaristes sur le projet<br>'."\n";

$sql = " select login.id,pseudo,admin.admin,role,medical, confirmed from login inner join admin on admin.login=login.id where admin.gn='$gn' order by confirmed desc, admin.admin desc, pseudo asc ";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
echo '<table><tr><td>pseudo</td><td>responsabilite</td><td>admin</td><td>doc</td><td>confirme</td></tr>';
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
       echo '<tr><td><a href="scenar.php?scenar='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"].'</a></td>';
       echo '<td>'.$row['role'].'</td>';
       echo '<td><input type=checkbox';
       if ($row['admin']==1) echo ' checked'; 
       echo '></td>';
       echo '<td><input type=checkbox';
      if ($row['medical']==1) echo ' checked';
      echo '></td>';
      echo '<td><input type=checkbox';
      if ($row['confirmed']==1) echo ' checked';
      echo '></td>';
      echo '</tr>';
   }
}
echo '</table>';
}
    echo '</center></body></html>';
}
}
?>