<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
}
else {
    include 'config.php';
// On commence par récupérer les champs
    if (isset($_GET['gn'])) $gn=$_GET['gn'];
    else $gn=0;
    if (isset($_GET['event'])) $event=$_GET['event'];
    else $event=0;
    if (isset($_GET['pnj'])) $pnj=$_GET['pnj'];
    else $pnj=0;
        $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
    // On vérifie si les champs sont vides
    if($gn==0 || $event==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
              $page=22;
include 'upper.php';
 echo '<center>';
        echo '<center>roles joueurs</center><br>'."\n";
$sql = " select besoin.id,role.nom from besoin inner join role on besoin.role=role.id where besoin.event='$event' and role.pnj='$pnj'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>role</td><td>joueur</td><td>operation</td></tr>'."\n";
   while($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td><a href="besoin.php?besoin='. $row["id"]. '&gn='.$gn.'&event='.$event.'">'. $row["nom"] .'</a></td><td></td><td><form method=POST action="event.php?gn='.$gn.'&event='.$event.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete2"></form></td></tr>'."\n";
   }
      echo '</table><br><center><a href="besoin-list.php?gn='.$gn.'&event='.$event.'">liste complete</a></center><br>';

}
echo '<form method="POST" action="add-besoin.php?gn='.$gn.'&event='.$event.'&pnj='.$pnj.'">'."\n";
echo '<select name="role">';
echo '<option value="0" selected>nouveau role</option>';
$sql="select id,nom from role where role.gn='$gn' and id not in (select role from besoin where event='$event') order by role.nom";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<option value="'. $row["id"].'">'. $row["nom"] .'</option>';
   }
}
echo '</select>';
echo '<input type="submit" value="ajouter un role PJ" name="pj"></form>'."\n";

    }
    echo '</center></body></html>';
}
}
?>