<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
    include 'config.php';
    $id=$_SESSION['id'];

    if (isset($_POST['nom'])) {
       $nom=mysqli_real_escape_string ($db,$_POST['nom']);
        $date=date("Y-m-d H:i").":00";
        $sql="insert into gn values ('','$nom','$date','$date','resume','presentation','0','0','0','0','adresse','ville','france','0000','','website','evenements precedents','scenario','0','0','0',NULL)";
        mysqli_query($db,$sql);
        $res=mysqli_insert_id($db);
        $sql="insert into admin values ('','$res','$id','1','0','admin','1')";
        mysqli_query($db,$sql);
        $header="location:gn.php?gn=".$res;
        header($header);
    }
    else {
        header("location:liste.php"); 
    }
}
?>