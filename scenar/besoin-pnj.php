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
    if (isset($_GET['event'])) $event=$_GET['event'];
    else $event=0;
    if (isset($_GET['besoin'])) $besoin=$_GET['besoin'];
    else $besoin=0;
    // On vérifie si les champs sont vides
    if($gn==0 || $event==0 || $besoin==0) {
        echo '<font color="red">t\'as merde... alors recommence</font><br>';
    }
    else {
                      $page=25;
include 'upper.php';
 echo '<center>';
        if (isset($_POST['update1'])){
            $role=mysqli_real_escape_string ($db,$_POST['role']);
            $nom=mysqli_real_escape_string ($db,$_POST['nom']); 
            $descr=mysqli_real_escape_string ($db,$_POST['descr']);
            $type=$_POST['type'];
            $sql="update role_pnj set nom='$nom',description='$descr',type='$type' where id='$role'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        if (isset($_POST['update2'])){
            $nom=mysqli_real_escape_string ($db,$_POST['nom']);
            $descr=mysqli_real_escape_string ($db,$_POST['descr']);
            $sql="update besoin set nom='$nom', description='$descr' where id='$besoin'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        if (isset($_POST['update3'])){
            $inscr=$_POST['inscription'];
            $sql="update besoin set login='$inscr' where id='$besoin'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        if (isset($_POST['update4'])){
            $inscr=$_POST['inscription'];
            $sql="update besoin set login='0' where id='$besoin'";
            mysqli_query($db,$sql)  or die(mysqli_error($db));
        }
        //les infos sur le role a modifier
        $sql = "select role_pnj.id,role_pnj.nom,role_pnj.description,role_pnj.type from role_pnj inner join besoin on besoin.role=role_pnj.id where besoin.id='$besoin'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
        echo '<form method="POST" action="besoin-pnj.php?gn='.$gn.'&event='.$event.'&besoin='.$besoin.'">';
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo 'role<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo '<input type="text" name="descr" value="'. $row["description"] .'"><br>';  
                echo '<input type="hidden" name="role" value="'. $row["id"] .'"><br>';
                echo 'type de role : <select name="type">';
                if ($row['type']==1) {
                    echo '<option value="0">generique</option>';
                    echo '<option value="1" selected>recurent</option>';   
                }
                else {
                    echo '<option value="0" selected>generique</option>';
                    echo '<option value="1">recurent</option>'; 
                }
                echo '</select><br><br>';
            }
        }
        echo '<input type="submit" value="mettre a jour" name="update1"></form><br>'."\n";
        
        //les infos sur le besoin
        $sql = "select nom,description,login from besoin where id='$besoin'";
        $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
        echo '<form method="POST" action="besoin-pnj.php?gn='.$gn.'&event='.$event.'&besoin='.$besoin.'">';
        $joueur=0;
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo 'intervention <br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo '<br>description de l\'intervention du personnage dans l\'event<br><input type="text" name="descr" value="'. $row["description"] . '"><br>';
                $joueur=$row['login'];
            }
            echo '<input type="submit" value="mettre a jour" name="update2"></form>'."\n";
            echo '<br><br>joueur affecte<br>';
            if ($joueur>0){
                echo '<br>le cesar du meilleur second role est attribue a :<br>';
                $sql = "select login_jeu.id,login_jeu.pseudo from login_jeu inner join inscription on inscription.login=login_jeu.id where login_jeu.id='$joueur' and inscription.gn='$gn' and inscription.gn='$gn'";
                $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
                $row = mysqli_fetch_assoc($result);
                echo '<a href="joueur.php?id='. $row["id"]. '&gn='.$gn.'">'. $row["pseudo"] .'</a> ';
                echo '<form method="POST" action="besoin-pnj.php?gn='.$gn.'&event='.$event.'&besoin='.$besoin.'"><input type="submit" value="supprimer" name="update4"></form>';
                echo '<br>';
            }
            echo '<form method="POST" action="besoin-pnj.php?gn='.$gn.'&event='.$event.'&besoin='.$besoin.'"><select name="inscription">';
            $sql = "select login_jeu.id,login_jeu.pseudo from login_jeu inner join inscription on inscription.login=login_jeu.id  where login_jeu.id!='$joueur' and login_jeu.id not in (select login from besoin where event='$event') and inscription.pnj=1 and inscription.gn='$gn' order by pseudo";
            $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value='.$row['id'].'>'.$row['pseudo'].'</option>';
                }
            }
            echo '</select><input type="submit" value="mettre a jour" name="update3"></form>'."\n";

        }
    }
    echo '</center></body></html>';
}
?>