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
    if (isset($_GET['event'])) $event=$_GET['event'];
    else $event=0;
       $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
    // On vérifie si les champs sont vides
    if($gn==0 || $obj==0 || $event==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
        $page=23;
        include 'upper.php';
        echo '<center>';
        if (isset($_POST['update'])){
            
            $role=$_POST['role'];
            $nom=mysqli_real_escape_string ($db,$_POST['nom']);
            if (isset($_POST['cestbon'])) $succes=1;
            else $succes=0;
            if (isset($_POST['secret'])) $secret=1;
            else $secret=0;
            if (isset($_POST['cible'])) $cible=1;
            else $cible=0;
            $relation=$_POST['relation'];
            $cond=$_POST['cond'];
            $descr=mysqli_real_escape_string ($db,$_POST['descr']);
            $sql="update objectif set role='$role',nom='$nom',succes='$succes',obj_secret='$secret',cible_secret='$cible',relation='$relation',description='$descr' where id='$obj'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
            $sql=" update pre_requis set cond='$cond' where event='$event' and objectif='$obj'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        //les infos sur le role a modifier
        $sql = "select * from objectif inner join pre_requis on pre_requis.objectif=objectif.id where objectif.id='$obj' and pre_requis.event='$event'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));

        echo '<form method="POST" action="prereq.php?gn='.$gn.'&objectif='.$obj.'&event='.$event.'">';
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $qui=$row['role'];
                $sql="select id,nom from role where gn='$gn' order by nom";
                $result2=mysqli_query($db,$sql)  or die(mysqli_error($db));
                $sql="select id,nom from role where gn='$gn' and id!='$qui' order by nom";
                $result3=mysqli_query($db,$sql)  or die(mysqli_error($db));
                echo 'nom<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo 'role concerné : <select name=role>';
		echo '<option value=0';
		if ($row['role']==0) echo ' selected';
		echo '>personne</option>';
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
                echo 'le joueur doit il connaitre sa cible ? <input type="checkbox" name="secret"';
                if ($row['obj_secret']==1) echo " checked";
                echo '><br>';
                echo 'la cible est elle dans l\'ignorance de cet objectif ? <input type="checkbox" name="cible"';
                if ($row['cible_secret']==1) echo " checked";
                echo '><br>';
                echo 'succes <input type="checkbox" name="cestbon"';
                if ($row['succes']==1) echo " checked";
                echo '><br>';
                echo 'condition pour l\'activation de l\'evenement : <select name=cond>';
                echo '<option value=0'; 
                if ($row['cond']==0) echo " selected";        
                echo '>echec</option>';
                echo '<option value=1'; 
                if ($row['cond']==1) echo " selected";
                echo '>reussite</option>';
                echo '</select><br>';
            }
        }
 
        echo '<input type="submit" value="mettre a jour" name="update"></form><br>'."\n";

    }
    echo '</center></body></html>';
}
}
?>
