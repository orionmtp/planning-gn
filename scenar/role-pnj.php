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
    if (isset($_GET['role'])) $role=$_GET['role'];
    else $role=0;
    $page=21;
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
            $type_=$_POST['type'];
            $sql="update role_pnj set nom='$nom',description='$descr',type='$type_' where id='$role'";
            mysqli_query($db,$sql);
        }
        //les infos sur le role a modifier
        $sql = "select id,nom,description,type from role_pnj  where id='$role'";
        $result=mysqli_query($db,$sql);
        echo '<form method="POST" action="role-pnj.php?gn='.$gn.'&role='.$role.'">';
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo 'role<br><input type="text" name="nom" value="'. $row["nom"] .'"><br>';
                echo 'description : <input type="text" name="descr" value="'. $row["description"] .'"><br>';  
                echo 'type de role : <select name="type">';
                if ($row['type']==1) {
                    echo '<option value=0>generique</option>';
                    echo '<option value=1 selected>recurent</option>';   
                }
                else {
                    echo '<option value=0 selected>generique</option>';
                    echo '<option value=1>recurent</option>'; 
                }
                echo '</select><br><br>';
            }
        }
        echo '<input type="submit" value="mettre a jour" name="update"></form><br>'."\n";
    }
    echo '</center></body></html>';
}
?>
