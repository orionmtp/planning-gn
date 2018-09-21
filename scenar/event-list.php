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
    $result=mysqli_query($db,$sql);
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
	  if (isset($_POST['delete']))
		{
		$event=$_POST['besoin'];
		$sql="delete from event where id='$event'";
		mysqli_query($db,$sql);
		}




       //la liste des events
            $sql = "select id,nom,debut,duree,priorite from event where gn='$gn' order by debut asc, priorite desc";
            $result=mysqli_query($db,$sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<table><tr><td>nom</td><td>priorite</td><td>debut</td><td>duree</td><td>operation</td></tr>';
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr><td><a href="event.php?event='. $row["id"]  .'&gn='.$gn.'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td><td>'. $row["debut"] .'</td><td>'. $row["duree"] .'</td><td><form method=POST action="event-list.php?gn='.$gn.'"><input type="hidden" value="'.$row['id'].'" name="besoin"><input type="submit" value="supprimer" name="delete"></form></td></tr>';
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
