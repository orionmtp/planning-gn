<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
}
else {
    include 'config.php';
    $id=$_SESSION['id'];
    if (isset($_GET['gn'])) $gn=$_GET['gn'];
    else $gn=0;
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
// On vérifie si les champs sont vides
        if($gn==0)
        {
            echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
        }        
// Aucun champ n'est vide, on peut enregistrer dans la table
        else     
        {
            if (isset($_POST['nom'])) {
                $nom=mysqli_real_escape_string ($db,$_POST['nom']);
                $date=date("H:i").":00";
                $sql="insert into event values ('','$nom','$date','01:00','01:00','10','description','$gn')";
                mysqli_query($db,$sql);
                $res=mysqli_insert_id($db);
                $header="location:event.php?gn=".$gn."&event=".$res;
                header($header);
            }
            else {
                header("location:gn.php?gn=$gn"); 
            }
        }   
    }
}
?>
