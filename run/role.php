<?php
    include '../scenar/config.php';
    echo '<html><head></head><body><center>';
// On commence par récupérer les champs
    if (isset($_GET['besoin'])) $besoin=$_GET['besoin'];
    else $besoin=0;


    // On vérifie si les champs sont vides
    if($besoin==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
        //les infos sur le role a modifier
        $sql = "select role.pnj, role.pnj_recurent,role.nom,role.description as descr, besoin.description as background from role inner join besoin on besoin.role=role.id where besoin.id='$besoin'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
        $joueur=0;
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo 'role<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo 'description : <input type="text" name="descr" value="'. $row["descr"] .'"><br>'; 
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
                echo '<br>action attendue<br><textarea rows=20 cols=60 name=background>'.$row['background'].'</textarea><br>';
            }
        }
		echo "<br>";
		$message="http://run.planning-gn.fr/besoin.php?besoin=".$besoin;
		echo '<img src="create_png.php?text='.$message.'"/><br>';

    }
    echo '</center></body></html>';

?>
