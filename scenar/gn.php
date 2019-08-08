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
// On vérifie si les champs sont vides
    $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
if($gn==0)
    {
    echo '<font color="red"> et si tu choissais un GN au moins ??? !</font><br>';
    }
// Aucun champ n'est vide, on peut enregistrer dans la table
else     
    {
        $page=11;
include 'upper.php';
echo '<center>';

if (isset($_POST['update'])){
	if (isset($_POST['recur'])) $recur=1; else $recur=0;
	$sql2="select debut from gn where id='$gn'";
	$result=mysqli_query($db,$sql2)  or die(mysqli_error($db));
	$row = mysqli_fetch_assoc($result);
	$old=date_create($row["debut"]);
	mysqli_query($db,$sql)  or die(mysqli_error($db));
    $nom=mysqli_real_escape_string ($db,$_POST['nom']);
    $debut=mysqli_real_escape_string ($db,$_POST['debut']);
    $fin=mysqli_real_escape_string ($db,$_POST['fin']);
    $descr=mysqli_real_escape_string ($db,$_POST['desc']);
    $prez=mysqli_real_escape_string ($db,$_POST['presentation']);
    $pj=mysqli_real_escape_string ($db,$_POST['pj']);
    $pnj=mysqli_real_escape_string ($db,$_POST['pnj']);
    $pafpj=mysqli_real_escape_string ($db,$_POST['pafpj']);
    $pafpnj=mysqli_real_escape_string ($db,$_POST['pafpnj']);
    $url=mysqli_real_escape_string ($db,$_POST['url']);
    $sql="update gn set nom='$nom', debut='$debut', fin='$fin',website='$url',presentation='$prez',nb_pj='$pj',nb_pnj='$pnj',paf_pnj='$pafpnj',paf_pj='$pafpj',description='$descr', recur='$recur' where id='$gn'";
    mysqli_query($db,$sql)  or die(mysqli_error($db));
}
    $sql="select delta from login where id='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
	$row = mysqli_fetch_assoc($result);
	$timeline=$row['delta'];

//les infos sur le GN
$sql = "select nom,debut, fin, nb_pnj,nb_pj,paf_pnj,paf_pj,description,presentation,website,recur from gn where id='$gn'";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
echo '<form method="POST" action="gn.php?gn='.$gn.'">';
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
       echo 'GN<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
	   	$starting=$row['debut'];
       echo '<table><tr><td>du</td><td><input type="datetime-local" name="debut" value="'. date("Y-m-d\TH:i", $starting) .'"></td><td> au </td><td><input type="datetime-local" name="fin" value="'. date("Y-m-d\TH:i", strtotime($row["fin"])) .'"></td></tr></table><br>';
		echo 'one shot <input type="checkbox" name="recur"';
		$recur=$row['recur'];
	   if ($recur!=0)
		{
			echo " checked";
		}
	   echo '><br>';
       echo '<table><tr><td>nombre de pnj</td><td>nombre de pj</td></tr>';
       echo '<tr><td><input type=number name=pnj value='.$row['nb_pnj'].' min=0></td><td><input type=number name=pj value='.$row['nb_pj'].' min=0></td></tr>';
       echo '<tr><td><center>PAF<br><input type=number name=pafpnj value='.$row['paf_pnj'].' min=0></center></td><td><center>PAF<br><input type=number name=pafpj value='.$row['paf_pj'].' min=0></center></td></tr>';
       echo '</table><br>';
       echo 'synopsis<br><textarea name="desc" rows=3 cols=60>'.$row['description'].'</textarea><br><br>';
       echo 'description<br><textarea name="presentation" rows=20 cols=60>'.$row['presentation'].'</textarea><br>';
       echo 'site web<br><input type="url" name="url" value='.$row['website'].'><br>';
       echo '<br>';
   }
}
//echo '<input type="hidden" name="gn" value="'. $gn .'">';
echo '<input type="submit" value="mettre a jour" name="update"></form>'."\n";
echo '<br><br><a href=scenario.php?gn='.$gn.'>scenario du GN</a><br>';        
//la liste des scenaristes
echo '<br><br>scenaristes enregistres<br>';
 $sql = "select login.id,pseudo,admin.admin from login inner join admin on admin.login=login.id where admin.gn='$gn' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="scenar.php?scenar='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"];
      if ($row['admin']==1) echo ' (admin)'; 
      echo '</a><br>'."\n";
   }
      echo '<a href="scenar-list.php?gn='.$gn.'">liste complete</a><br>';
}       
        
echo '<br><br>evenements prevus<br>';

//la liste des events
if ($timeline) $sql = "select event.id,event.nom,addtime(gn.debut,event.debut) as debut,event.duree,event.description,priorite from event iner join gn on gn.id=event.gn where gn='$gn' order by debut asc, priorite asc limit 10";
else $sql = "select id,nom,debut,duree,description,priorite from event where gn='$gn' order by debut asc, priorite asc limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   echo '<table><tr><td>nom</td><td>priorite</td><td>debut</td><td>duree</td><td>description</td></tr>';
   while($row = mysqli_fetch_assoc($result)) {
echo '<tr><td><a href="event.php?event='. $row["id"]  .'&gn='.$gn.'">'. $row["nom"] .'</a></td><td>'. $row["priorite"] .'</td>';
if ($timeline) echo '<td>'. $row["debut"] .'</td>';
else echo '<td>H+'. $row["debut"] .'</td>';
echo '<td>'. $row["duree"] .'</td><td>'. $row["description"] . '</td></tr>';
   }
   echo '</table>';
   echo '<a href="event-list.php?gn='.$gn.'">liste complete</a><br>';
}
echo '<form method="POST" action="add-event.php?gn='.$gn.'">';
echo '<input type="text" name="nom" value="nom">';
echo '<input type="submit" value="Creer un event" name="event"></form>'."\n";

echo '<table><tr><td>'."\n";
//les PNJ inscrits
echo '<center>PNJ presents</center><br>'."\n";
$sql = " select login_jeu.id,pseudo from login_jeu inner join inscription on login_jeu.id=inscription.login where inscription.gn='$gn' and inscription.pnj='1' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="joueur.php?id='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"] .'</a><br>'."\n";
   }
   echo '<center><a href="joueur-list.php?gn='.$gn.'">liste complete</a></center><br>'."\n";
}
echo '</td><td>'."\n";
//les joueurs inscrits
echo '<center>joueurs inscrits</center><br>'."\n";
$sql = " select login_jeu.id,pseudo from login_jeu inner join inscription on login_jeu.id=inscription.login where inscription.gn='$gn' and inscription.pnj='0' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="joueur.php?id='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"] .'</a><br>';
   }
   echo '<center><a href="joueur-list.php?gn='.$gn.'">liste complete</a></center><br>';
}
echo '</td></tr></table>'."\n";
echo '<table><tr><td>'."\n";
//les roles PNJ définis
echo '<center>roles non joueur</center></td><td><center>roles joueurs</center></td></tr>'."\n";
$sql = " select id,nom from role where gn='$gn' and pnj='1' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
echo "<tr><td>";
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo '<a href="role.php?role='. $row["id"]. '&gn='.$gn.'">'. $row["nom"] .'</a><br>'."\n";
   }
}

echo '</td><td>'."\n";
//les roles joueur definis
$sql = " select id,nom from role where gn='$gn' and pnj='0' limit 10";
$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
echo '<a href="role.php?role='. $row["id"]. '&gn='.$gn.'">'. $row["nom"] .'</a><br>';
   }
}
mysqli_close($db);  // on ferme la connexion
echo '</td></tr>'."\n";
echo '<tr><td><center><a href="role-list.php?gn='.$gn.'&pnj=1">liste complete</a></center></td>';
echo '<td><center><a href="role-list.php?gn='.$gn.'&pnj=0">liste complete</a></center></td></tr>'."\n";
echo "<tr><td>";
echo '<form method="POST" action="add-role.php?gn='.$gn.'&pnj=1">'."\n";
echo '<input type="text" name="nom" value="nom">'."\n";
echo '<input type="submit" value="ajouter un PNJ" name="pnj"></form>'."\n";
echo "</td><td>";
echo '<form method="POST" action="add-role.php?gn='.$gn.'&pnj=0">'."\n";
echo '<input type="text" name="nom" value="nom">'."\n";
echo '<input type="submit" value="ajouter un PJ" name="pj"></form>'."\n";
echo '</td></tr></table>'."\n";

} 
 echo '<color=red>en cours de dev > <a href="moulinette.php?gn='.$gn.'">ici</a> < ved ed sruoc ne</color><br><br>';
 echo '<a href=menu.php>revenir au menu admin</a>';
 echo '</center></body></html>';
}
}
?> 
