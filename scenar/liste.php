<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
$id=$_SESSION['id'];
include 'config.php';
$page=1;
include 'upper.php';
if (isset($_POST['delete'])) {
    $gn=$_POST['gn'];
    $sql="delete from gn where id='$gn';";
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}
echo '<center>';
$sql = "select gn.id, gn.nom,admin.admin,debut from gn inner join admin on admin.gn=gn.id where admin.login='$id' order by debut";
$result=mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
echo 'choisir le GN a mouliner :<br><table><tr>';
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
       if ($row['admin']==1) echo '<form method="POST" action="">';
       echo '<td><a href="gn.php?gn=' . $row["id"] .'">' . $row["nom"] .'</a></td><td> le '. date("Y-m-d", strtotime($row["debut"])) .' a '.date("H:i", strtotime($row["debut"])).'</td><td><input type="hidden" name="gn" value="'.$row['id'].'">';
       if ($row['admin']==1) echo '<input type="submit" value="supprimer" name="delete"></form></td></tr>';
   }
}
echo '</tr></table><br><form method="POST" action="add-gn.php">';
echo '<input type="text" name="nom"> ';
echo '<input type="submit" value="Creer un nouveau GN" name="envoyer"></form><br>';
echo '</center></body></html>';
}
?>
