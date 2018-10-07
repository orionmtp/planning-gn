<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
}
else {
    include 'config.php';
    echo '<html><head></head><body><center>';
// On commence par récupérer les champs
    if (isset($_GET['gn'])) $gn=$_GET['gn'];
    else $gn=0;
    if (isset($_GET['role'])) $role=$_GET['role'];
    else $role=0;
       $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
        $page=20;
include 'upper.php';
 echo '<center>';
    // On vérifie si les champs sont vides
    if($gn==0 || $role==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
        if (isset($_POST['update'])){
            $nom=mysqli_real_escape_string ($db,$_POST['nom']); 
            $descr=mysqli_real_escape_string ($db,$_POST['descr']);
            $pnj=$_POST['pnj'];
            if (isset($_POST['recurent'])) $recurent=$_POST['recurent'];
            else $recurent=0;
            $background=mysqli_real_escape_string ($db,$_POST['background']);
            $sql="update role set nom='$nom',description='$descr',pnj='$pnj',pnj_recurent='$recurent',background='$background' where id='$role'";
            mysqli_query($db,$sql);
        }
        if (isset($_POST['update3'])){
            $inscr=$_POST['login'];
            $sql="update role set login='$inscr' where id='$role'";
            mysqli_query($db,$sql);
        }
        if (isset($_POST['update2'])){
            $sql="update role set login='0' where id='$role'";
            mysqli_query($db,$sql);
        }
        if (isset($_POST['delete'])){
            $obj=$_POST['obj'];
            $sql="delete from pre_requis where objectif='$obj'";
            mysqli_query($db,$sql);
            $sql="delete from objectif where id='$obj'";
            mysqli_query($db,$sql);
        }
		if (isset($_POST['deletestyle'])){
            $style=$_POST['style'];
			$sql="delete from style_pnj where role='$role' and style='$style'";
            mysqli_query($db,$sql);
        }
		if (isset($_POST['ajout'])){
            $style=$_POST['style']; 
            $sql="insert into style_pnj values ('','$role','$style')";
			mysqli_query($db,$sql);
        }
        //les infos sur le role a modifier
        $sql = "select nom,description,login,pnj,pnj_recurent,background from role  where id='$role'";
        $result=mysqli_query($db,$sql);
        $joueur=0;
        echo '<form method="POST" action="role.php?gn='.$gn.'&role='.$role.'">';
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo 'role<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo 'description : <input type="text" name="descr" value="'. $row["description"] .'"><br>'; 
                echo 'type : <select name=pnj><option value=0';
                if ($row['pnj']==0) echo ' selected';
                echo '>PJ</option><option value=1';
                if ($row['pnj']==1) echo ' selected';
                echo '>PNJ</option></select><br>';
                if ($row['pnj']==1) {
                    echo 'recurent : <select name=recurent><option value=0';
                    if ($row['pnj_recurent']==0) echo ' selected';
                    echo '>generique</option><option value=1';
                    if ($row['pnj_recurent']==1) echo ' selected';
                    echo '>nomme</option></select><br>';
                }
                
                $joueur=$row['login'];
                echo '<br>background<br><textarea rows=20 cols=60 name=background>'.$row['background'].'</textarea><br>';
            }
        }

        echo '<input type="submit" value="mettre a jour" name="update"></form><br>'."\n";
        echo '<br><br>joueur affecte<br>';
        if ($joueur>0){
            echo '<br>le cesar du meilleur role principal est attribue a :<br>';
            $sql = "select login_jeu.id,login_jeu.pseudo from login_jeu inner join inscription on inscription.login=login_jeu.id where login_jeu.id='$joueur' and inscription.gn='$gn'";
            $result=mysqli_query($db,$sql);
            $row = mysqli_fetch_assoc($result);
            echo '<a href="joueur.php?id='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"] .'</a><form method="POST" action="role.php?gn='.$gn.'&role='.$role.'"></select><input type="submit" value="supprimer" name="update2"></form><br>';
        }
        echo '<form method="POST" action="role.php?gn='.$gn.'&role='.$role.'"><select name="login">';
        $sql = "select login_jeu.id,login_jeu.pseudo from login_jeu inner join inscription on inscription.login=login_jeu.id where inscription.gn='$gn' and login_jeu.id not in (select login from role where gn='$gn') and inscription.pnj=0 order by pseudo";
        $result=mysqli_query($db,$sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<option value='.$row['id'].'>'.$row['pseudo'].'</option>';
            }
        }
        echo '</select><input type="submit" value="mettre a jour" name="update3"></form>'."\n";
        echo 'objectifs<br>';
        $sql="select id,nom,relation from objectif where gn='$gn' and role='$role'";
        $result=mysqli_query($db,$sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<table><tr><td>description</td><td>qui</td><td>operation</td></tr>';
            while($row = mysqli_fetch_assoc($result)) {
                
                echo '<tr><td><a href=objectif.php?gn='.$gn.'&objectif='.$row['id'].'>'.$row['nom'].'</a></td>';
                
                echo '<td>';
                if ($row['relation']>0) {
                    $cible=$row['relation'];
                    $sql="select nom from role where id='$cible' and gn='$gn'";
                    $result2=mysqli_query($db,$sql);
                    if (mysqli_num_rows($result) > 0) {
                        $row2 = mysqli_fetch_assoc($result2);
                        echo '<a href=role.php?gn='.$gn.'&role='.$cible.'>'.$row2['nom'].'</a>';
                    }
                }
                echo '</td><td><form method="POST" action="role.php?role='. $role  .'&gn='.$gn.'"><input type=hidden name=obj value='.$row['id'].'><input type=submit value="supprimer" name="delete"></form>';
                echo '</td></tr>';
            }
            echo "</table>";
        }
        echo '<form method="POST" action="add-objectif.php?gn='.$gn.'&role='.$role.'">';
        echo '<input type="submit" value="ajouter un objectif"></form><br>';
        echo '<br>implications<br>';
        $sql="select id,nom,role,cible_secret from objectif where gn='$gn' and relation='$role'";
        $result=mysqli_query($db,$sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<table><tr><td>qui</td><td>description</td><td>secret</td></tr>';
            while($row = mysqli_fetch_assoc($result)) {
                echo '<tr><td>';
                $cible=$row['role'];
                $sql="select nom from role where id='$cible' and gn='$gn'";
                $result2=mysqli_query($db,$sql);
                if (mysqli_num_rows($result) > 0) {
                    $row2 = mysqli_fetch_assoc($result2);
                    echo '<a href=role.php?gn='.$gn.'&role='.$cible.'>'.$row2['nom'].'</a>';
                }
                echo '</td><td><a href=objectif.php?gn='.$gn.'&objectif='.$row['id'].'>'.$row['nom'].'</a></td>';
                echo '<td>';
                echo '<input type="checkbox"';
                if ($row['cible_secret']==1) echo ' checked';
                echo '>';
                echo '</td></tr>';
            }
            echo "</table>";
        }
				echo '<br><center>style de jeu</center><br>'."\n";
		$sql = " select style.id,style.nom from style inner join style_pnj on style.id=style_pnj.style where role='$role'";
		$result=mysqli_query($db,$sql);
		if (mysqli_num_rows($result) > 0) {
			echo '<table><tr><td>style</td><td>operation</td></tr>'."\n";
			while($row = mysqli_fetch_assoc($result)) {
				echo '<tr><td>'.$row["nom"].'</td><td><form method=POST action="role.php?gn='.$gn.'&role='.$role.'"><input type="hidden" value="'.$row['id'].'" name="style"><input type="submit" value="supprimer" name="deletestyle"></form></td></tr>'."\n";
			}
			echo '</table><br>'."\n";
		}
		echo '<form method="POST" action="role.php?gn='.$gn.'&role='.$role.'">'."\n";
		echo '<select name="style">';
		$sql="select id,nom from style where id not in (select style from style_pnj where role='$role') order by nom";
		$result=mysqli_query($db,$sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo '<option value="'. $row["id"].'">'. $row["nom"] .'</option>';
		}
	}
	echo '</select>';
	echo '<input type="submit" value="ajouter un style de jeu" name="ajout"></form>'."\n";
    }
    echo '</center></body></html>';
}
}
?>
