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
    $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
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
        $sql = "insert into objectif (gn,role,nom,relation,succes,description,obj_secret,cible_secret,defvalue) values ('$gn','0','nom','0','0','description','0','0','0')";
        mysqli_query($db,$sql)  or die(mysqli_error($db));
        $besoin=mysqli_insert_id($db);
        $head="location:objectif.php?gn=$gn&objectif=$besoin";
        header($head);
    }
}
}
?>
