<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
   include 'config.php';
   $orga=$_SESSION['id'];
  if (isset($_GET['gn'])) 
       $gn=$_GET['gn'];
   else {
       if (isset($_POST['gn']))
           $gn=$_POST['gn']; 
       else 
           $gn=0;
    } 
 $sql="select id from admin where gn='$gn' and login='$orga' and confirmed='1'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
// On commence par récupérer les champs
 
   if (isset($_GET['id'])) 
       $id=$_GET['id'];
   else {
       if (isset($_POST['id']))
           $id=$_POST['id'];
       else 
          $id=0;
    }
    if (isset($_POST['envoi'])) {
        if (isset($_POST['paiement'])) {
            $sql="update inscription set paiement='1' where login='$id' and gn='$gn'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        else {
            $sql="update inscription set paiement='0' where login='$id' and gn='$gn'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }

    }
    $sql = " select admin.medical,admin.admin from admin where admin.gn='$gn' and admin.login='$orga' ";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) == 1) {
   $row=mysqli_fetch_assoc($result);
   $doc=$row['medical'];
   $admin=$row['admin'];
}
       $page=27;
include 'upper.php';
echo '<center>';
// On vérifie si les champs sont vides
   if($gn==0 OR $id==0)
   {
      echo '<font color="red"> et si tu choissais un GN  et un joueur, au moins ??? !</font><br>';
   }
// Aucun champ n'est vide, on peut enregistrer dans la table
   else     
   {
   echo '<center>informations joueur<br>'."\n";
	$sql = " select login_jeu.*,inscription.login,inscription.pnj,inscription.paiement from login_jeu inner join inscription on login_jeu.id=inscription.login where inscription.gn='$gn' and inscription.login='$id'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) == 1) {
   $row=mysqli_fetch_assoc($result);
   echo '<form action="" method="post">';
   echo '<input type="text" name=nom value="'.$row['pseudo'].'"><br>';
   echo "inscrit en tant que ";
   echo '<select name=pnj><option value=0';
	$pnj=$row['pnj'];
    if ($pnj==0) echo ' selected';
                echo '>PJ</option><option value=1';
                if ($pnj==1) echo ' selected';
                echo '>PNJ</option></select><br>';

   echo '<br>';
   echo '<table>';
   echo "<tr><td>nom</td><td>".$row['nom']."</td></tr>";
   echo "<tr><td>prenom</td><td>".$row['prenom']."</td></tr>";
   echo "<tr><td>adresse</td><td>".$row['adresse']."</td></tr>";
   echo "<tr><td>telephone</td><td>".$row['tel']."</td></tr>";
   echo "<tr><td>regime alimentaire</td><td>";
   switch ($row['alim']) {
       case 0 : echo 'aucun'; break;
       case 1 : echo 'allergie'; break;
       case 2 : echo 'vegetarien'; break;
   }
   echo '</td></tr></table><br>';
   echo 'contacts d urgence<br>';
   echo "<table><tr><td>".$row['contact1_nom']."</td><td>".$row['contact1_tel']."</td></tr>";
   echo "<tr><td>".$row['contact2_nom']."</td><td>".$row['contact2_tel']."</td></tr></table><br>";
   if ($doc==1 OR $admin==1) {
       echo 'informations medicales<br>';
       echo $row['sante']."<br>";
   }
   echo '<br>';
   echo 'paiement recu <input type="checkbox" name=paiement';
      if ($row['paiement']==1)
       echo ' checked';
   echo '><input type = "submit" name="envoi" value = "updater"><br>';
      }

}
    echo '</center></body></html>';
}
}