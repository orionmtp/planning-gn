<?php
    include '../scenar/config.php';

// On commence par récupérer les champs
if (isset($_GET['event'])) $event=$_GET['event'];
else $event=0;
 echo '<html><header></header><body><center>';
// On vérifie si les champs sont vides
if($event==0)
    {
    echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {

//les infos sur l'event
$sql = "select * from event where id='$event'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result)==1) {
   while($row = mysqli_fetch_assoc($result)) {
       echo 'event<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
       echo '<table><tr><td>debute le </td><td><input type=time name="debut" step="60" value="'. date("H:i:s", strtotime($row["debut"])) .'"></td>';
       echo '<td> pour une duree de </td><td><input type=time name="duree" step="60" value="'. date("H:i:s", strtotime($row["duree"])) .'"></td>';
       echo '<td> et un temps de preparation de </td><td><input type="time" step="60" name="prepa" value="'. date("H:i:s", strtotime($row["prepa"])) .'"></td></tr></table><br>';
       echo 'priorite : <select name="prio">';
       for ($i=1;$i<=10;$i++){
           echo '<option value='.$i;
           if ($i==$row['priorite']) echo ' selected';
           echo '>'.$i.'</option>'."\n";
       }
       echo '</select>';
       echo '<br>description<br><textarea rows=20 cols=60 name="descr" >'.$row["description"].'</textarea><br>';
   }
}

 
 
 
 //les roles PNJ participant à l'event
echo "<center>\n";
$message="http://run.planning-gn.fr/event.php?event=".$event;
echo '<img src="create_png.php?text='.$message.'"/><br>';
echo '<br><br>personnages lies</center><br>';
$sql = " select role.id,role.nom from besoin inner join role on role.id=besoin.role where besoin.event='$event'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="role.php?role='. $row["id"].'">'. $row["nom"] .'</a><br>';
   }
}

echo '<br><br>pre requis<br>';
$sql="select objectif.id, objectif.nom,objectif.role,pre_requis.cond,objectif.succes from objectif inner join pre_requis on objectif.id=pre_requis.objectif where event='$event'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr><td>nom</td><td>role</td><td>condition</td><td>etat actuel</td></tr>'."\n";
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td><a href="objectif.php?objectif='. $row["id"].'">'. $row["nom"] .'</a></td>';
            $cible=$row['role'];
            $sql="select nom from role where id='$cible'";
            $result2=mysqli_query($db,$sql);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<td><a href="role.php?role='.$cible.'">'.$row2['nom'].'</a></td>';
            if ($row['cond']==0) echo '<td>echec</td>';
            else echo '<td>reussite</td>';
            if ($row['succes']==0) echo '<td>echec</td>';
    else echo '<td>reussite</td>';
    echo '</tr>'."\n";
   }
   echo '</table><br>';
}
}
 echo '</center></body></html>';
?> 
