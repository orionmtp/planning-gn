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
if (isset($_POST['nom'])) $nom=mysqli_real_escape_string ($db,$_POST['nom']);
else $nom=$_POST['nom'];

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
            $sql = "insert into role values ('','','$gn','nom a modifier','description a modifier','1','0')";
            mysqli_query($db,$sql);
            $role=mysqli_insert_id($db);
        $head="location:role-pnj.php?gn=$gn&role=$role";
        header($head);
    }
}
?>