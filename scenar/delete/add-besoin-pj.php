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
if (isset($_POST['role'])) $role=$_POST['role'];
else $role=-1; 

// On vérifie si les champs sont vides
if($gn==0 || $event==0 || $role==-1)
    {
        echo '<html><head></head><body><center>';
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
        echo '</center></body></html>';
    }

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {
        if($role==0) {
            $sql = "insert into role (login,gn,nom,description,pnj,pnj_recurent,background) values ('0','$gn','nom a modifier','description a modifier','0','0')";
            mysqli_query($db,$sql) or die(mysqli_error($db));
            $role=mysqli_insert_id($db);
        }
        $sql = "insert into besoin (gn,event,role,description,nom,number) values ('$gn','$event','$role','participation a definir','nom a modifier','0')";
        mysqli_query($db,$sql) or die(mysqli_error($db));
        $besoin=mysqli_insert_id($db);
        $head="location:besoin.php?gn=$gn&event=$event&besoin=$besoin";
        header($head);
    }
}
?>