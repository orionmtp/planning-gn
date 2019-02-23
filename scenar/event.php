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
    $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
              $page=13;
include 'upper.php';
 echo '<center>';
// On vérifie si les champs sont vides
if($gn==0 || $event==0)
    {
    echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {
if (isset($_POST['update'])){
    $nom=mysqli_real_escape_string ($db,$_POST['nom']);
    $debut=mysqli_real_escape_string ($db,$_POST['debut']);
    $prepa=mysqli_real_escape_string ($db,$_POST['prepa']);
    $duree=mysqli_real_escape_string ($db,$_POST['duree']);
    $prio=$_POST['prio'];
    $descr=mysqli_real_escape_string ($db,$_POST['descr']);
    $sql="update event set nom='$nom', debut='$debut', duree='$duree', prepa='$prepa',priorite='$prio',description='$descr' where id='$event'";
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}
if (isset($_POST['delete'])){
    $besoin=$_POST['besoin'];
    $sql="delete from besoin where id='$besoin'";
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}
if (isset($_POST['delete2'])){
    $objectif=$_POST['objectif'];
    $sql="delete from pre_requis where objectif='$objectif' and event='$event'";
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}

//les infos sur l'event
$sql = "select * from event where id='$event'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
echo '<form method="POST" action="event.php?gn='.$gn.'&event='.$event.'">';
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
       echo 'event<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
       echo '<table><tr><td>debute le </td><td><input type=datetime name="debut" step="60" value="'. date("H:i", strtotime($row["debut"])) .'"></td>';
       echo '<td> pour une duree de </td><td><input type=datetime name="duree" step="60" value="'. date("H:i", strtotime($row["duree"])) .'"></td>';
       echo '<td> et un temps de preparation de </td><td><input type="datetime" step="60" name="prepa" value="'. date("H:i", strtotime($row["prepa"])) .'"></td></tr></table><br>';
       echo 'priorite : <select name="prio">';
       for ($i=1;$i<=10;$i++){
           echo '<option value='.$i;
           if ($i==$row['priorite']) echo ' selected';
           echo '>'.$i.'</option>'."\n";
       }
       echo '</select>';
       echo '<br>description<br><textarea rows=20 cols=60 name="descr" >'.$row["description"].'</textarea><br>';
       echo '<input type="submit" value="mettre a jour" name="update"></form>'."\n";
   }
}

 
 
 
 //les roles PNJ participant à l'event
echo '<center>roles non joueur</center><br>'."\n";
$sql = " select besoin.id,role.nom from besoin inner join role on role.id=besoin.role where besoin.event='$event' and role.pnj='1' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>role</td><td>PNJ</td><td>operation</td></tr>'."\n";
   while($row = mysqli_fetch_assoc($result)) {
      echo '<tr><td><a href="besoin.php?besoin='. $row["id"]. '&gn='.$gn.'&event='.$event.'">'. $row["nom"] .'</a></td><td></td><td><form method=POST action="event.php?gn='.$gn.'&event='.$event.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td></tr>'."\n";
   }
      echo '</table><br><center><a href="besoin-list.php?gn='.$gn.'&event='.$event.'&pnj=1">liste complete</a></center><br>'."\n";
}
echo '<form method="POST" action="add-besoin.php?gn='.$gn.'&event='.$event.'">'."\n";
echo '<select name="role">';
echo '<option value="0" selected>nouveau role</option>';
$sql="select id,nom from role where role.gn='$gn' and role.pnj='1' and (role.pnj_recurent='0' or (role.pnj_recurent='1' and id not in (select role from besoin where event='$event') )) order by role.nom";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<option value="'. $row["id"].'">'. $row["nom"] .'</option>';
   }
}
echo '</select>';
echo '<input type="submit" value="ajouter un role PNJ" name="pj"></form>'."\n";


//les roles joueur participants a l'event
echo '<center>roles joueurs</center><br>'."\n";
$sql = " select besoin.id,role.nom from besoin inner join role on besoin.role=role.id where besoin.event='$event' and pnj='0' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>role</td><td>PJ</td><td>operation</td></tr>'."\n";
   while($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td><a href="besoin.php?besoin='. $row["id"]. '&gn='.$gn.'&event='.$event.'">'. $row["nom"] .'</a></td><td></td><td><form method=POST action="event.php?gn='.$gn.'&event='.$event.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td></tr>'."\n";
   }
      echo '</table><br><center><a href="besoin-list.php?gn='.$gn.'&event='.$event.'&pnj=0">liste complete</a></center><br>';

}
echo '<form method="POST" action="add-besoin.php?gn='.$gn.'&event='.$event.'">'."\n";
echo '<select name="role">';
echo '<option value="0" selected>nouveau role</option>';
$sql="select id,nom from role where role.gn='$gn' and pnj='0' and id not in (select role from besoin where event='$event') order by role.nom";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<option value="'. $row["id"].'">'. $row["nom"] .'</option>';
   }
}
echo '</select>';
echo '<input type="submit" value="ajouter un role PJ" name="pj"></form>'."\n";
echo '<br><br>pre requis<br>';
$sql="select objectif.id, objectif.nom,objectif.role,pre_requis.cond,objectif.succes from objectif inner join pre_requis on objectif.id=pre_requis.objectif where event='$event'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>nom</td><td>role</td><td>condition</td><td>etat actuel</td><td>operation</td></tr>'."\n";
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td><a href="prereq.php?objectif='. $row["id"]. '&gn='.$gn.'&event='.$event.'">'. $row["nom"] .'</a></td>';
            $cible=$row['role'];
            $sql="select nom from role where id='$cible'";
            $result2=mysqli_query($db,$sql)  or die(mysqli_error($db));
            $row2 = mysqli_fetch_assoc($result2);
            echo '<td><a href="role.php?gn='.$gn.'&role='.$cible.'">'.$row2['nom'].'</a></td>';
            if ($row['cond']==0) echo '<td>echec</td>';
            else echo '<td>reussite</td>';
            if ($row['succes']==0) echo '<td>echec</td>';
    else echo '<td>reussite</td>';
    echo '<td><form method="POST" action="event.php?event='. $event  .'&gn='.$gn.'"><input type=hidden name=objectif value='.$row['id'].'><input type=submit value="supprimer" name="delete2"></form></td>';
    echo '</tr>'."\n";
   }
   echo '</table><br>';
}
    $sql="select id,nom from objectif where gn='$gn'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    echo '<form method="POST" action="add-prereq.php?gn='.$gn.'&event='.$event.'">';
    echo '<select name=objectif>';
    echo '<option value=0 selectect>nouvel objectif</option>';
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<option value='.$row['id'].'>'.$row['nom'].'</option>';
        }
    }
    echo '<input type="submit" value="ajouter un pre-requis"></form><br>';
 echo '</center></body></html>';
}
}
}
?> 
