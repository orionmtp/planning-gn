<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
   include 'config.php';
   $orga=$_SESSION['id'];
   
// On commence par récupérer les champs
   if (isset($_GET['gn'])) 
       $gn=$_GET['gn'];
   else {
       if (isset($_POST['gn']))
           $gn=$_POST['gn']; 
       else 
           $gn=0;
    }
       $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$orga' and confirmed='1'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
            $page=15;
include 'upper.php';
   if (isset($_GET['scenar'])) 
       $id=$_GET['scenar'];
   else {
       if (isset($_POST['scenar']))
           $id=$_POST['scenar'];
       else 
          $id=0;
    }
    if (isset($_POST['envoi'])) {  
   
        if (isset($_POST['delete'])) {
            if (!isset($_POST['admin'])) {
                $sql="delete from admin where id='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }
        }
        else {
            if (isset($_POST['confirm'])) {
                $sql="update admin set confirmed='1' where id='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }        
            if (isset($_POST['admin'])) {
                $sql="update admin set admin='1' where login='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }
            else {
                $sql="update admin set admin='0' where login='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }
            if (isset($_POST['doc'])) {
                $sql="update admin set medical='1' where login='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }
            else {
                $sql="update admin set medical='0' where login='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }
            if (isset($_POST['role'])) {
                $temp=mysqli_real_escape_string ($db,$_POST['role']);
                $sql="update admin set role='$temp' where login='$id' and gn='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
            }
        }
    }
   
    $sql = " select admin.admin from admin where admin.gn='$gn' and admin.login='$orga' ";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) == 1) {
   $row=mysqli_fetch_assoc($result);
   $admin=$row['admin'];
}
echo '<html><head></head><body><center>';
// On vérifie si les champs sont vides
   if($gn==0 OR $id==0)
   {
      echo '<font color="red"> et si tu choissais un GN  et un scenariste, au moins ??? !</font><br>';
   }
// Aucun champ n'est vide, on peut enregistrer dans la table
   else     
   {
   echo '<center>informations scénariste<br>'."\n";

$sql = " select login.id,pseudo,admin.admin,admin.role,admin.medical,confirmed from login inner join admin on login.id=admin.login where admin.gn='$gn' and admin.login='$id'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) == 1) {
   $row=mysqli_fetch_assoc($result);
   echo $row['pseudo'].'<br>';
   if ($admin==1) 
       echo '<form action="" method="post">';
   echo 'admin <input type="checkbox" name=admin';
   if ($row['admin']==1)
       echo ' checked';
   echo '><br>';
   echo 'personnel medical <input type="checkbox" name=doc';
   if ($row['medical']==1)
       echo ' checked';
   echo '><br>';
   if ($admin==0) echo '<form action="" method="post">';
   echo '<input type="text" name="role" value="'.$row['role'].'"><br>';
   echo '<input type=hidden name="scenar" value='.$id.'>';
   echo '<input type=hidden name="gn" value='.$gn.'>';
   if ($admin==1) 
       if ($row['confirmed']==1)
           echo "supprimer l'acces scenariste <input type=checkbox name=delete><br>";
       else
            echo "confirmer l'acces scenariste <input type=checkbox name=confirm><br>" ;
   echo '<input type = "submit" name="envoi" value = "updater">';
}

}
    echo '</center></body></html>';
}
}
?>