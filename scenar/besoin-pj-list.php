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
    // On vérifie si les champs sont vides
    if($gn==0 || $event==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
              $page=22;
include 'upper.php';
 echo '<center>';
        echo '<center>roles joueurs</center><br>'."\n";
$sql = " select besoin_pj.id,role_pj.nom from besoin_pj inner join role_pj on besoin_pj.role=role_pj.id where besoin_pj.event='$event'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>role</td><td>PNJ</td><td>operation</td></tr>'."\n";
   while($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td><a href="besoin-pj.php?besoin='. $row["id"]. '&gn='.$gn.'&event='.$event.'">'. $row["nom"] .'</a></td><td></td><td><form method=POST action="event.php?gn='.$gn.'&event='.$event.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete2"></form></td></tr>'."\n";
   }
      echo '</table><br><center><a href="besoin-pj-list.php?gn='.$gn.'&event='.$event.'">liste complete</a></center><br>';

}
echo '<form method="POST" action="add-besoin-pj.php?gn='.$gn.'&event='.$event.'">'."\n";
echo '<select name="role">';
echo '<option value="0" selected>nouveau role</option>';
$sql="select id,nom from role_pj where role_pj.gn='$gn' and id not in (select role from besoin_pj where event='$event') order by role_pj.nom";
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
?>