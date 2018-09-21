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
    if (isset($_POST['objectif'])) $objectif=$_POST['objectif'];
    else $objectif=-1; 
        $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
    // On vérifie si les champs sont vides
    if($gn==0 || $event==0 || $objectif==-1)
    {
        echo '<html><head></head><body><center>';
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
        echo '</center></body></html>';
    }
    // Aucun champ n'est vide, on peut enregistrer dans la table
    else     
    {
        if ($objectif==0) {
            $sql = "insert into objectif values ('','$gn','0','nom','0','0','description','0','0')";
            mysqli_query($db,$sql);
            $objectif=mysqli_insert_id($db);
        } 
        $sql = "insert into pre_requis values ('','$event','$objectif','0')";
        mysqli_query($db,$sql);
        $besoin=mysqli_insert_id($db);
        $head="location:prereq.php?gn=$gn&objectif=$objectif&event=$event";
        header($head);
    }
}
}
?>