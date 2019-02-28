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
	$sql = " select admin.medical,admin.admin from admin where admin.gn='$gn' and admin.login='$orga' ";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
	if (mysqli_num_rows($result) == 1) {
   $row=mysqli_fetch_assoc($result);
   $doc=$row['medical'];
   $admin=$row['admin'];
}
    if (isset($_POST['envoi'])) {
		$pnj=$_POST['pnj'];
        if (isset($_POST['paiement'])) {
            $sql="update inscription set paiement='1',pnj='$pnj' where login='$id' and gn='$gn'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        else {
            $sql="update inscription set paiement='0',pnj='$pnj' where login='$id' and gn='$gn'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
		if ($admin==1) {
		$nom=$_POST['nom'];
		$pseudo=$_POST['pseudo'];
		$prenom=$_POST['prenom'];
		$adr=$_POST['adr'];
		$tel=$_POST['tel'];
		$cont1=$_POST['cont1'];
		$cont1t=$_POST['cont1t'];
		$cont2=$_POST['cont2'];
		$cont2t=$_POST['cont2t'];
		$alim=$_POST['alim'];
		$sante=$_POST['sante'];
		$email=$_POST['email'];
		$sql="update login_jeu set email='$email',sante='$sante', nom='$nom', prenom='$prenom', pseudo='$pseudo', adresse='$adr', tel='$tel', contact1_nom='$cont1', contact2_nom='$cont2', contact1_tel='$cont1t', contact2_tel='$cont2t', alim='$alim' where id='$id'";
		mysqli_query($db,$sql)  or die(mysqli_error($db));
		}
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
   echo '<input type="text" name=pseudo value="'.$row['pseudo'].'"><br>';
   echo "inscrit en tant que ";
   echo '<select name=pnj><option value=0';
	$pnj=$row['pnj'];
    if ($pnj==0) echo ' selected';
                echo '>PJ</option><option value=1';
                if ($pnj==1) echo ' selected';
                echo '>PNJ</option></select><br>';

   echo '<br>';
   echo '<table>';
   echo "<tr><td>nom</td><td><input type=text name=nom value=".$row['nom']."></td></tr>";
   echo "<tr><td>prenom</td><td><input type=text name=prenom value=".$row['prenom']."></td></tr>";
   echo "<tr><td>email</td><td><input type=text name=email value=".$row['email']."></td></tr>";
   echo "<tr><td>adresse</td><td><input type=text name=adr value=".$row['adresse']."></td></tr>";
   echo "<tr><td>telephone</td><td><input type=text name=tel value=".$row['tel']."></td></tr>";
   echo "<tr><td>regime alimentaire</td><td>";
   echo '<select name=alim><option value=0 ';
   if ($row['alim']==0) echo "selected";
   echo ">aucun</option>";
   echo '<option value=1 ';
	if ($row['alim']==1) echo "selected";
		 echo ">allergie/intolerange</option>";
	     echo '<option value=2 ';
		    if ($row['alim']==2) echo "selected";
			echo ">vegetarien</option>";
			echo "</select>";
   echo '</td></tr></table><br>';
   echo 'contacts d urgence<br>';
   echo "<table><tr><td><input type=text name=cont1 value=".$row['contact1_nom']."></td><td><input type=text name=cont1t value=".$row['contact1_tel']."></td></tr>";
   echo "<tr><td><input type=text name=cont2 value=".$row['contact2_nom']."></td><td><input type=text name=cont2t value=".$row['contact2_tel']."></td></tr></table><br>";
   if ($doc==1 OR $admin==1) {
       echo 'informations medicales<br>';
	   echo "<input type=text name=sante value=".$row['sante']."><br>";
   }
   echo '<br>';
   echo 'paiement recu <input type="checkbox" name=paiement';
      if ($row['paiement']==1)
       echo ' checked';
   echo '><br>';
    if ($admin==1) echo '<input type = "submit" name="envoi" value = "updater"><br>';
      }

}
    echo '</center></body></html>';
}
}