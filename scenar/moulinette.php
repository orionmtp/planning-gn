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
		$page=13;
		include 'upper.php';
		echo '<center>';
// On vérifie si les champs sont vides
		if($gn==0)
		{
			echo '<font color="red">t\'as merde... alors recommence</font><br>';
		}
// Aucun champ n'est vide, on peut enregistrer dans la table
		else     
		{
			echo "c'est en cours<br>";
// on fait la liste des besoins et des heures de debut et fin correspondantes, classé par preparation et priorité
			$sql="select listPNJ.id as besoin, listPNJ.role as role, listPNJ.login as joueur, (select count(style_pnj.role) from style_pnj inner join style_joueur on style_pnj.style=style_joueur.style where joueur=listPNJ.login and role=listPNJ.role)as stylecommun, (select count(style) from style_pnj where role=listPNJ.role) as stylerole, (select count(style) from style_joueur where joueur=listPNJ.login) as stylejoueur from (select listbesoin.id as id,listbesoin.role as role,inscription.login from inscription, (select besoin.id,besoin.role, debut-prepa as deb, debut+duree as fin, priorite as prio from event inner join besoin on besoin.event=event.id inner join role on besoin.role=role.id where event.gn='$gn' and role.pnj='1' order by debut-prepa, priorite) as listbesoin where pnj='1' and gn='$gn' and login not in (select planning.joueur from planning inner join inscription as truc on truc.login=planning.joueur where planning.gn='$gn' and ((debut>listbesoin.deb and debut<listbesoin.fin) or (fin>listbesoin.deb and fin<listbesoin.fin) or (debut<listbesoin.deb and fin>listbesoin.fin)))) as listPNJ order by stylerole desc, stylecommun desc,stylejoueur asc ";
			$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {	
					echo "besoin : ".$row['besoin']." role : ".$row['role']." joueur : ".$row['joueur']." role : ".$row['stylerole']." commun : ".$row['stylecommun']." PNJ : ".$row['stylejoueur']."<br>";
				}
			}
		}
	}
}

?>