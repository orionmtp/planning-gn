<?php
session_start();
if(!isset($_SESSION['id'])){
      header("location:presentation.php");
   }
else {
$id=$_SESSION['id'];
if (isset($_POST['gn'])) {
    include 'config.php';
    $gn=$_POST['gn'];
    if (isset($_POST['PJ']))
        $role=0;
    else
        $role=1;
    $sql="insert into inscription (login,gn,pnj,paiement) values('0','$id','$gn','$role','0')"; 
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}
include 'config.php';
echo '<html><head></head><body><center>';
echo 'liste des GN en cours<br>';
$date=date("Y-m-d H:i:s");
$sql="select gn.* from gn  left join inscription on inscription.gn=gn.id where inscription.gn IS NULL and debut>'$date' order by debut";
$result=mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>nom</td><td>debut</td><td>fin</td><td>s\'inscrire</td></tr>';
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
       echo '<tr><td><form method="POST" action=""><a href="gn.php?gn=' . $row["id"] .'">' . $row["nom"] .'</a></td><td>'. $row["debut"] .'</td><td>'.$row['fin'].'</td><td><input type=hidden name=gn value='.$row['id'].'><input type="submit" value="PJ" name="PJ"><input type="submit" value="PNJ" name="PNJ"></form></td></tr>';
   }
}
echo '</center></body></html>';
}
?>