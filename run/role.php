<?php
    include '../scenar/config.php';
	include('../phpqrcode/qrlib.php'); 
    echo '<html><head></head><body><center>';
// On commence par récupérer les champs
    if (isset($_GET['role'])) $role=$_GET['role'];
    else $role=0;


    // On vérifie si les champs sont vides
    if($role==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
        //les infos sur le role a modifier
        $sql = "select nom,description,login,pnj,pnj_recurent,background from role  where id='$role'";
        $result=mysqli_query($db,$sql);
        $joueur=0;
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
		echo "<br>";
		$message="http://run.planning-gn.fr/role.php?role=".$role;
		echo "<img src=\"data:image/png;base64,".QRcode::png('$message')."></img>;
        echo '<br>objectifs<br>';
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
                        echo '<a href=role.php?role='.$cible.'>'.$row2['nom'].'</a>';
                    }
                }
                echo '</td></tr>';
            }
            echo "</table>";
        }
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
    }
    echo '</center></body></html>';

?>
