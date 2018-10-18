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
			echo '<font color="red">t\'as merde... alors recommence</font><br>';
		}
// Aucun champ n'est vide, on peut enregistrer dans la table
		else     
		{
			echo "c'est en cours<br>";
			$sql1="select count(besoin.id) from besoin where gn='$gn' and id not in (select besoin from planning where gn='$gn')";
			$result1=mysqli_query($db,$sql1)  or die(mysqli_error($db));
			$sql2="select listPNJ.id as besoin, listPNJ.role as role, listPNJ.login as joueur, (select count(style_pnj.role) from style_pnj inner join style_joueur on style_pnj.style=style_joueur.style where joueur=listPNJ.login and role=listPNJ.role)as stylecommun, (select count(style) from style_pnj where role=listPNJ.role) as stylerole, (select count(style) from style_joueur where joueur=listPNJ.login) as stylejoueur, listPNJ.recur as recur from (select listbesoin.id as id,listbesoin.role as role,inscription.login, listbesoin.recur from inscription, (select besoin.id,besoin.role, debut-prepa as deb, debut+duree as fin, priorite as prio, role.pnj_recurent as recur from event inner join besoin on besoin.event=event.id inner join role on besoin.role=role.id where besoin.id not in (select besoin from planning where gn='$gn') and event.gn='$gn' and role.pnj='1' order by debut-prepa, priorite) as listbesoin where pnj='1' and gn='$gn' and login not in (select planning.joueur from planning inner join inscription as truc on truc.login=planning.joueur where planning.gn='$gn' and ((debut>listbesoin.deb and debut<listbesoin.fin) or (fin>listbesoin.deb and fin<listbesoin.fin) or (debut<listbesoin.deb and fin>listbesoin.fin)))) as listPNJ order by  stylecommun desc,stylerole desc,stylejoueur asc limit 1";
			$result2=mysqli_query($db,$sql2)  or die(mysqli_error($db));

			while ((mysqli_num_rows($result1) > 0)&&(mysqli_num_rows($result2) > 0)) {
				$row = mysqli_fetch_assoc($result2);
				$besoin=$row['besoin'];
				$perso=$row['joueur'];
				$recur=$row['recur'];
				$role=$row['role'];
// a travailler pour le coté recurrent, parce qu'on peut mettre les informations dans la table "role.login". ne pas oublier de mettre à 0 lors du reset
				if ($recur==0) {
					$sql="select besoin.id,debut-prepa as deb,debut+duree as fin from event inner join besoin on event.id=besoin.event  where besoin.id='$besoin' and besoin.gn='$gn' limit 1";
					$result3=mysqli_query($db,$sql)  or die(mysqli_error($db));
					$row = mysqli_fetch_assoc($result3);
					$deb=$row['deb'];
					$fin=$row['fin'];
					$sql="insert into planning (besoin, joueur, debut, fin, gn) values ('$besoin','$perso','$deb','$fin','$gn')";
					mysqli_query($db,$sql)  or die(mysqli_error($db));
				}
				else {
					$sql="select id from besoin where role='$role'";
					$result4=mysqli_query($db,$sql)  or die(mysqli_error($db));
					if ((mysqli_num_rows($result4) > 0)) {
						while ($row = mysqli_fetch_assoc($result4)) {
							$besoin2=$row['id'];
							$sql="select besoin.id,debut-prepa as deb,debut+duree as fin from event inner join besoin on event.id=besoin.event where besoin.id='$besoin2' and besoin.gn='$gn' limit 1";
							$result3=mysqli_query($db,$sql)  or die(mysqli_error($db));
							$row = mysqli_fetch_assoc($result3);
							$deb=$row['deb'];
							$fin=$row['fin'];
							$sql="insert into planning (besoin, joueur, debut, fin, gn) values ('$besoin2','$perso','$deb','$fin','$gn')";
							mysqli_query($db,$sql)  or die(mysqli_error($db));
							$sql="update role set login='$perso' where id='$role'";
							mysqli_query($db,$sql)  or die(mysqli_error($db));

						}
					}
				}
				$result1=mysqli_query($db,$sql1)  or die(mysqli_error($db));
				$result2=mysqli_query($db,$sql2)  or die(mysqli_error($db));
			}

		}
	}
	$head="location:gn.php?gn=$gn";
    header($head);
}

?>