<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
   include 'config.php';
// On commence par récupérer les champs
   if (isset($_GET['gn'])) 
       $gn=$_GET['gn'];
   else $gn=0;
       $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
        $page=12;
        include 'upper.php';
        echo "<center>";
// On vérifie si les champs sont vides
        if($gn==0)
        {
            echo '<html><head></head><body><center>';
            echo '<font color="red">t\'as merde... alors recommence</font><br>';
            echo '</center></body></html>';
        }
// Aucun champ n'est vide, on peut enregistrer dans la table
        else     
        {    
	$sql="select delta from login where id='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
	$row = mysqli_fetch_assoc($result);
	$timeline=$row['delta'];
	if ($timeline) {
		$sql="select debut from gn where id='$gn'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
	$row = mysqli_fetch_assoc($result);
	$starting=$row['debut'];
	}
			
	  if (isset($_POST['delete']))
		{
		$event=$_POST['besoin'];
		$sql="delete from event where id='$event'";
		mysqli_query($db,$sql)  or die(mysqli_error($db));
		}




       //la liste des events
	   
	   if ($timeline) $sql = "select event.id,event.nom,addtime(gn.debut,event.debut) as debut1,duree,priorite, lieu from event inner join gn on gn.id=event.gn where event.gn='$gn' order by debut1 asc, priorite asc";
	   else  $sql = "select id,event.nom,debut as debut1,duree,priorite from event where gn='$gn' order by debut asc, priorite asc";
            $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
            if (mysqli_num_rows($result) > 0) {
                echo '<table><tr><td>nom</td><td>priorite</td><td>debut</td><td>duree</td><td>operation</td></tr>';
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr><td><a href="event.php?event='. $row["id"]  .'&gn='.$gn.'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td><td>';
					if ($timeline) echo $row["debut1"];
						else echo 'H+'. $row["debut1"];
					
					echo '</td><td>'. $row["duree"] .'</td><td><form method=POST action="event-list.php?gn='.$gn.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td></tr>';
                }
            }
            echo '</table>';
            echo '<form method="POST" action="add-event.php?gn='.$gn.'">';
            echo '<input type="text" name="nom" value="nom">';
            echo '<input type="submit" value="Creer un event" name="event"></form>'."\n";
        }
        echo '</center></body></html>';
    }
}
?>
