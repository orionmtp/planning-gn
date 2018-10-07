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
    $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
              $page=13;
include 'upper.php';
 echo '<center>';
// On vérifie si les champs sont vides
if($gn==0 || $event==0)
    {
    echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }

// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {
	echo "c'est en cours";
	}


?>