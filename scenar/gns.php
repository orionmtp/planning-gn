<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
$id=$_SESSION['id'];
include 'config.php';
if (isset($_POST['gn'])) {
    $gn=$_POST['gn'];
    $sql="insert into admin (login,gn,admin,medical,role,confirmed) values('$id','$gn','0','0','nouvel inscrit','0')"; 
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}
$page=2;
include 'upper.php';
include 'config.php';
echo '<center>';
echo 'liste des GN en cours<br>';
$date=date("Y-m-d H:i").":00";
$sql="select id,nom from gn where id not in (select gn from admin where admin.login='$id') and debut>'$date' order by debut";
$result=mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>nom</td><td>debut</td><td>fin</td><td></td></tr>';
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
       echo '<tr><td><a href="gn.php?gn=' . $row["id"] .'">' . $row["nom"] .'</a></td><td>'. $row["debut"] .'</td><td>'.$row['fin'].'</td><td><form method="POST" action=""><input type=hidden name=gn value='.$row['id'].'><input type="submit" value="participer" name="scenar"></form></td></tr>';
   }
}
echo '</center></body></html>';
}
?>
