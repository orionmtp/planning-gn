<?php
    include '../scenar/config.php';
// On commence par récupérer les champs
    if (isset($_GET['objectif'])) $obj=$_GET['objectif'];
    else $obj=0;
    echo '<html><hrader></header><body>';
    // On vérifie si les champs sont vides
    if($obj==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
        echo '<center>';
        //les infos sur le role a modifier
        $sql = "select * from objectif where id='$obj'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
        $row = mysqli_fetch_assoc($result);
            $qui=$row["role"];
                $sql="select id,nom from role where id='$qui'";
                $result2=mysqli_query($db,$sql)  or die(mysqli_error($db));
                echo 'nom<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo 'role concerné : ';
                if (mysqli_num_rows($result2)== 0) echo  "Personne<br>";
		else { 
			$row4 = mysqli_fetch_assoc($result2);
			echo '<a href=role.php?role='.$row4["id"].'>'.$row4["nom"].'</a><br>';
		}
			 
                echo 'que doit je faire ?<br><textarea name="descr" rows=20 cols=60>'.$row['description'].'</textarea><br>';
                echo 'qui est la cible ? ';
                $qui=$row["relation"];
                $sql="select id,nom from role where id='$qui'";
                $result2=mysqli_query($db,$sql)  or die(mysqli_error($db));
                if (mysqli_num_rows($result2)== 0) echo  "Personne<br>";
                else {
                        $row4 = mysqli_fetch_assoc($result2);
                        echo '<a href=role.php?role='.$row4["id"].'>'.$row4["nom"].'</a><br>';
                }

		echo 'le joueur doit il connaitre sa cible ? <input type="checkbox" name="objectif"';
                if ($row['obj_secret']==1) echo " checked";
                echo '><br>';
                echo 'la cible est elle dans l\'ignorance de cet objectif ? <input type="checkbox" name="cible"';
                if ($row['cible_secret']==1) echo " checked";
                echo '><br>';
                echo 'succes <input type="checkbox" name="cestbon"';
                if ($row['succes']==1) echo " checked";
                echo '><br>';
            
        

    }
    echo '</center></body></html>';


?>
