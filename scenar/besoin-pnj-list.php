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

              $page=24;
include 'upper.php';
 echo '<center>';
        
$sql = " select besoin.id,role_pnj.nom from besoin inner join role_pnj on role_pnj.id=besoin.role where besoin.event='$event'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>role</td><td>PNJ</td><td>operation</td></tr>'."\n";
   while($row = mysqli_fetch_assoc($result)) {
      echo '<tr><td><a href="besoin-pnj.php?besoin='. $row["id"]. '&gn='.$gn.'&event='.$event.'">'. $row["nom"] .'</a></td><td></td><td><form method=POST action="event.php?gn='.$gn.'&event='.$event.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td></tr>'."\n";
   }
      echo '</table><br><br>'."\n";
}
echo '<form method="POST" action="add-besoin-pnj.php?gn='.$gn.'&event='.$event.'">'."\n";
echo '<select name="role">';
echo '<option value="0" selected>nouveau role</option>';
$sql="select id,nom from role_pnj where role_pnj.gn='$gn' and (role_pnj.type='0' or (role_pnj.type='1' and id not in (select role from besoin where event='$event') )) order by role_pnj.nom";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<option value="'. $row["id"].'">'. $row["nom"] .'</option>';
   }
}
echo '</select>';
echo '<input type="submit" value="ajouter un role PNJ" name="pj"></form>'."\n";
    
    }
    echo '</center></body></html>';
}
?>