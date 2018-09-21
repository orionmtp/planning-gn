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
    if (isset($_GET['objectif'])) $obj=$_GET['objectif'];
    else $obj=0;
       $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
    // On vérifie si les champs sont vides
    if($gn==0 || $obj==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
        $page=23;
        include 'upper.php';
        echo '<center>';
        if (isset($_POST['update1'])){
            
            $role=$_POST['role'];
            $nom=mysqli_real_escape_string ($db,$_POST['nom']);
            if (isset($_POST['cestbon'])) $succes=1;
            else $succes=0;
            if (isset($_POST['objectif'])) $objectif=1;
            else $objectif=0;
            if (isset($_POST['cible'])) $cible=1;
            else $cible=0;
            $relation=$_POST['relation'];
            $descr=mysqli_real_escape_string ($db,$_POST['descr']);
            $sql="update objectif set role='$role',nom='$nom',succes='$succes',obj_secret='$objectif',cible_secret='$cible',relation='$relation',description='$descr' where id='$obj'";
            mysqli_query($db,$sql);
        }
        //les infos sur le role a modifier
        $sql = "select * from objectif where objectif.id='$obj'";
        $result=mysqli_query($db,$sql);

        echo '<form method="POST" action="objectif.php?gn='.$gn.'&objectif='.$obj.'">';
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $qui=$row['role'];
                $sql="select id,nom from role where gn='$gn' order by nom";
                $result2=mysqli_query($db,$sql);
                $sql="select id,nom from role where gn='$gn' and id!='$qui' order by nom";
                $result3=mysqli_query($db,$sql);
                echo 'nom<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo 'role concerné : <select name=role>';
                echo "<option value=0";
                if (0==$row['role']) echo " selected";
                   echo  ">Personne</option>";
                if (mysqli_num_rows($result2) > 0) {
                    while($row2 = mysqli_fetch_assoc($result2)) {
                        echo "<option value=".$row2['id'];
                        if ($row2['id']==$row['role']) echo " selected";
                        echo  ">".$row2['nom']."</option>";
                    }
                }
                echo '</select><br>';
                echo 'que doit je faire ?<br><textarea name="descr" rows=20 cols=60>'.$row['description'].'</textarea><br>';
                echo 'qui est la cible ? <select name="relation"><br>';
                echo "<option value=0";
                if (0==$row['relation']) echo " selected";
                echo  ">personne</option>";
                if (mysqli_num_rows($result3) > 0) {
                    while($row2 = mysqli_fetch_assoc($result3)) {
                        echo "<option value=".$row2['id'];
                        if ($row2['id']==$row['relation']) echo " selected";
                        echo  ">".$row2['nom']."</option>";
                    }
                }
                echo '</select><br>';
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
        }
        echo '<input type="submit" value="mettre a jour" name="update1"></form><br>'."\n";

    }
    echo '</center></body></html>';
}
}
?>
