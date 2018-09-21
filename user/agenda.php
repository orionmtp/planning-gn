<?php
include 'config.php';

 echo '<html><head></head><body><center>';

// On commence par récupérer les champs

if (isset($_GET['gn'])) $gn=$_GET['gn'];
else $gn=0;
// On vérifie si les champs sont vides
if($gn==0) {
    $today=date("Y-m-d H:i:s");
    $sql = "select id,nom,debut,fin from gn where debut>'$today' order by debut";
$result=mysqli_query($db,$sql);
echo '<html><header></header><body><center>';
if (mysqli_num_rows($result) > 0) {
   echo '<table><tr><td>nom</td><td>debut</td><td>fin</td></tr>';
   while($row = mysqli_fetch_assoc($result)) {
       echo '<tr><td><a href=gns.php?gn='.$row['id'] .'> '. $row["nom"] .'</a></td><td>'. $row["debut"] .'</td><td>'. $row["fin"] .'</td></tr>';
   }
   echo '</table>';
}
}

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {
//les infos sur le GN
$sql = "select nom,debut,fin,description from gn where id='$gn'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
       echo 'GN<br>'. $row["nom"] .'<br><table><tr><td>du</td><td>'. $row["debut"] .'</td><td> au </td><td>'. $row["fin"] .'</td></tr></table><br>'. $row["description"] . '<br>';
   }
}
      echo '</center></body></html>';
}
?>