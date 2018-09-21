<?php

    include '../scenar/config.php';
// On commence par récupérer les champs
    if (isset($_GET['serial'])) $serial=$_GET['serial'];
    else $serial=0;
//    if (isset($_GET['obj'])) $obj=$_GET['obj'];
//    else $obj=0;
    $sql="select id from gn where serial='$serial'";
    $result=mysqli_query($db,$sql);
	echo "<html><header></header><body><center>";
    if (mysqli_num_rows($result) ==1) {
    // On vérifie si les champs sont vides
	$row=mysqli_fetch_assoc($result);
        $gn=$row['id'];
        if($gn==0) {
            echo '<font color="red">t\'as merde... alors recommence</font><br>';
        }
        else {
	if (isset($_POST['changer'])) {
	 $obj=$_POST['obj'];
	 $sql = " select succes from objectif where id='$obj'";
	$result=mysqli_query($db,$sql);
	$row = mysqli_fetch_assoc($result);
	if ($row['succes']==1) $sql = " update objectif set succes='0' where id='$obj'";
	else  $sql = " update objectif set succes='1' where id='$obj'";
	$result=mysqli_query($db,$sql);


	    }
            $zeroed=date_create("00:00:01");
            $now=date_create(date("H:i:s",strtotime("now"))); 
            $sql = "select delta,avance from gn where id='$gn'";
            $result=mysqli_query($db,$sql);
            $row = mysqli_fetch_assoc($result);
            $delta=date_create($row['delta']);
            $avance=$row['avance'];
//            $page=30;
	    echo "<html><header><title>running</title><meta http-equiv=refresh content=60></header><body>";
            echo '<center>';
            //les infos sur le role a modifier
            $sql = "select running from gn where id='$gn'";
            $result=mysqli_query($db,$sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['running']==0) {
                $sql = "select debut,fin from gn where id='$gn'";
                $result=mysqli_query($db,$sql);
                $row = mysqli_fetch_assoc($result);
                $deb=date_create($row["debut"]);
                $fin=date_create($row["fin"]);
                echo "actuelle ". date_format($now,"H:i:s")."<br>\n";
                echo "debut ". date_format($deb,"H:i:s")."<br>\n";
                echo "fin ".date_format($fin,"H:i:s")."<br>\n";
                echo '<form method="POST" action="runtime.php?gn='.$gn.'">'."\n";
                echo '<input type="submit" value="lancer le GN !" name="update"></form><br>'."\n";
                
            }
            else {
                echo "heure : ".date_format($now,"H:i:s")."<br>\ndelta : ";
		if ($avance==1) echo "-";
		echo date_format($delta,"H:i:s")."<br>\n<br>\n";
                $test=date_format($delta,"H:i:s");
                $differ=date_diff($delta,$zeroed);
		if ($avance==1) $situation=date_format(date_sub($now,$differ),"H:i:s");
		else $situation=date_format(date_add($now,$differ),"H:i:s");
 $sql="select event.id,addtime(event.debut,delta) as debut1,addtime(subtime(event.debut,event.prepa),delta) as prepa1,addtime(addtime(event.debut,event.duree),delta) as fin,event.nom,priorite from event inner join gn on gn.id=event.gn where gn='$gn' and event.debut<='$situation' and '$situation'<=addtime(event.debut,event.duree) order by priorite, prepa1";
                $result=mysqli_query($db,$sql);
                echo "en cours de jeu<br>\n";
                if (mysqli_num_rows($result) > 0) {
                    echo '<table><tr><td>nom</td><td>priorite</td><td>preparation</td><td>debut</td><td>fin</td></tr>';
                    while($row = mysqli_fetch_assoc($result)) {


                        $id_event=$row['id'];
			$sql1="select cond,succes from pre_requis inner join objectif on pre_requis.objectif=objectif.id where pre_requis.event='$id_event'";
			$result4=mysqli_query($db,$sql1);
			$activ=1;
			if (mysqli_num_rows($result4) > 0) {
				while (($activ==1) and ($row4 = mysqli_fetch_assoc($result4))) {
			if ($row4['succes']!=$row4['cond']) $activ=0;
				}
			}
			if ($activ==1) {
                        $deb_event=date_create($row['debut1']);
                        $deb_prepa=date_create($row['prepa1']);
                        $fin_event=date_create($row['fin']);
                        echo '<tr><td><a target="_blank" href="event.php?event='. $id_event.'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td><td>'.date_format($deb_prepa,"H:i:s").'</td><td>'.date_format($deb_event,"H:i:s").'</td><td>'.date_format($fin_event,"H:i:s").'</td></tr>';
                    }
}
                    echo "</table>\n";

                }
                echo "<br>en cours de preparation<br>\n";
                $sql="select event.id,addtime(event.debut,delta) as debut1,addtime(subtime(event.debut,event.prepa),delta) as prepa1, addtime(addtime(event.debut,event.duree),delta) as fin,event.nom,priorite  from event inner join gn on gn.id=event.gn  where gn='$gn' and subtime(event.debut,event.prepa)<='$situation' and '$situation'<=event.debut order by prepa1";
                $result=mysqli_query($db,$sql);
                if (mysqli_num_rows($result) > 0) {
                    echo '<table><tr><td>nom</td><td>priorite</td><td>prepa</td><td>debut</td><td>heure fin</td></tr>';
                    while($row = mysqli_fetch_assoc($result)) {
                        $id_event=$row['id'];
                        $sql1="select cond,succes from pre_requis inner join objectif on pre_requis.objectif=objectif.id where pre_requis.event='$id_event'";
                        $result4=mysqli_query($db,$sql1);
                        
                        $activ=1;
                        if (mysqli_num_rows($result4) > 0) {
                                while (($activ==1) and ($row4 = mysqli_fetch_assoc($result4))) {
                        if ($row4['succes']!=$row4['cond']) $activ=0;
                                }
                        }
                        if ($activ==1) {

                        $deb_event=date_create($row['debut1']);
                        $deb_prepa=date_create($row['prepa1']);
                        $fin_event=date_create($row['fin']);
                        echo '<tr><td><a  target="_blank" href="event.php?event='. $row["id"]  .'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td><td>'.date_format($deb_prepa,"H:i:s").'</td><td>'.date_format($deb_event,"H:i:s").'</td><td>'.date_format($fin_event,"H:i:s").'</td></tr>';
                    }
                }
}
                echo "</table><br>\n";
                echo "a venir<br>\n";
                $sql="select event.id,addtime(event.debut,delta) as debut1,addtime(subtime(event.debut,event.prepa),delta) as prepa1, addtime(addtime(event.debut,event.duree),delta) as fin,event.nom,priorite  from event inner join gn on gn.id=event.gn where  gn='$gn' and '$situation'<subtime(event.debut,event.prepa) order by prepa1";
                $result=mysqli_query($db,$sql);
                if (mysqli_num_rows($result) > 0) {
                    echo '<table><tr><td>nom</td><td>priorite</td><td>preparation</td><td>debut</td><td>heure fin</td></tr>';
                    while($row = mysqli_fetch_assoc($result)) {
                        $id_event=$row['id'];
                        $sql1="select cond,succes from pre_requis inner join objectif on pre_requis.objectif=objectif.id where pre_requis.event='$id_event'";
                        $result4=mysqli_query($db,$sql1);
                        $activ=1;
                        if (mysqli_num_rows($result4) > 0) {
                                while (($activ==1) and ($row4 = mysqli_fetch_assoc($result4))) {
                        if ($row4['succes']!=$row4['cond']) $activ=0;
                                }
                        }

                        if ($activ==1) {
                        $deb_event=date_create($row['debut1']);
                        $deb_prepa=date_create($row['prepa1']);
                        $fin_event=date_create($row['fin']);
                        echo '<tr><td><a  target="_blank" href="event.php?event='. $row["id"]  .'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td><td>'.date_format($deb_prepa,"H:i:s").'</td><td>'.date_format($deb_event,"H:i:s").'</td><td>'.date_format($fin_event,"H:i:s").'</td></tr>';
                    }
                }
}
                echo "</table><br>\n";
                $sql="select event.id,addtime(event.debut,delta) as debut1,addtime(subtime(event.debut,event.prepa),delta) as prepa1, addtime(addtime(event.debut,event.duree),delta) as fin,event.nom,priorite  from event inner join gn on gn.id=event.gn where gn='$gn' and '$situation'>addtime(event.debut,event.duree) order by prepa1";
                $result=mysqli_query($db,$sql);
                echo "termines<br>\n";
                if (mysqli_num_rows($result) > 0) {
                    echo '<table><tr><td>nom</td><td>priorite</td><td>prepa</td><td>debut</td><td>heure fin</td></tr>';
                    while($row = mysqli_fetch_assoc($result)) {
                        $id_event=$row['id'];
                        $sql1="select cond,succes from pre_requis inner join objectif on pre_requis.objectif=objectif.id where pre_requis.event='$id_event'";
                        $result4=mysqli_query($db,$sql1);
                        
                        $activ=1;
                        if (mysqli_num_rows($result4) > 0) {
                                while (($activ==1) and ($row4 = mysqli_fetch_assoc($result4))) {
                        if ($row4['succes']!=$row4['cond']) $activ=0;
                                }
                        }
			if ($activ==1) {

$deb_event=date_create($row['debut1']);
                        $deb_prepa=date_create($row['prepa1']);
                        $fin_event=date_create($row['fin']);
                        echo '<tr><td><a  target="_blank" href="event.php?event='. $row["id"]  .'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td><td>'.date_format($deb_prepa,"H:i:s").'</td><td>'.date_format($deb_event,"H:i:s").'</td><td>'.date_format($fin_event,"H:i:s").'</td></tr>';
                    }
                }
}
                echo "</table><br>\n";
		echo "OBJECTIFS<br>";
$sql = " select id,nom,role,succes from objectif where objectif.gn='$gn'";
$result=mysqli_query($db,$sql);
echo '<table><tr><td>titre</td><td>personnage</td><td>reussite</td><td>operation</td></tr>';
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      if ($row['role']!=0) {
      $role_temp=$row['role'];
      $sql=" select nom from role where id='$role_temp'";
      $result2=mysqli_query($db,$sql);
      $row2 = mysqli_fetch_assoc($result2);
      $nom1=$row2['nom'];
      }
      else
      {
	$role_temp=0;
	$nom1="Personne";
      }
      echo '<tr><td><a  target="_blank" href="objectif.php?objectif='. $row["id"]. '">'. $row["nom"] .'</a></td>';
if ($role_temp!=0) echo '<td><a  target="_blank" href="role.php?role='. $row["role"]. '">'. $nom1 .'</a></td>';
else echo '<td>'.$nom1.'</td>';
      echo '<td><input type="checkbox"';
      if ($row['succes']==1) echo ' checked';
          echo '></td>';
      echo '<td><form method="POST" action="running.php?serial='.$serial.'"><input type="hidden" name="obj" value="'.$row["id"].'"><input type="submit" value="changer" name="changer"></form></td>';
      echo '</tr>';
   }
}
echo "</table>";
           echo "<br>evenements suspendus<br>";
                $sql="select distinct event.id,event.nom from event inner join pre_requis on event.id=pre_requis.event inner join objectif on pre_requis.objectif=objectif.id where event.gn='$gn' and pre_requis.cond!=objectif.succes order by event.nom";
                $result=mysqli_query($db,$sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<tr><td><a  target="_blank" href="event.php?event='. $row["id"]  .'">'. $row["nom"] .'</a><br>';
                    }
                }
}
            echo '</center></body></html>';
        }
    }

?>
