<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else 
{
    include 'config.php';

    // On commence par récupérer les champs
    if (isset($_GET['gn'])) $gn=$_GET['gn'];
    else $gn=0;
       $id=$_SESSION['id'];
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
        $page=28;
        include 'upper.php';
        echo '<center>';
        if (isset($_POST['update'])){
            $nom=mysqli_real_escape_string ($db,$_POST['nom']);
            $avant=mysqli_real_escape_string ($db,$_POST['desc']);
            $scenario=mysqli_real_escape_string ($db,$_POST['presentation']);
            $sql="update gn set avant='$avant', scenario='$scenario' where id='$gn'";
            mysqli_query($db,$sql);
        }
        $sql = "select nom,avant,scenario from gn where id='$gn'";
        $result=mysqli_query($db,$sql);
        if (mysqli_num_rows($result) ==1) {
            echo '<form method="POST" action="scenario.php?gn='.$gn."\">\n";
            $row = mysqli_fetch_assoc($result);
            echo "GN<br><input type=\"text\" name=\"nom\" value=\"". $row["nom"] ."\"><br>\n";
            echo "situation avant le GN<br>\n<textarea name=\"desc\" rows=40 cols=80>".$row['avant']."</textarea><br>\n<br>\n";
            echo "scenario<br>\n<textarea name=\"presentation\" rows=60 cols=80>".$row['scenario']."</textarea><br>\n";
            echo "<br>\n";
            echo "<input type=submit value=\"updater\" name=\"update\"></form>";
        }
        echo "</center>\n";
    }
}
}
?>