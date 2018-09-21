<?php
session_set_cookie_params(1800);
session_start();
if(!isset($_SESSION['id'])){
    header("location:index.php");
}
else {
    include 'config.php';

    // On commence par récupérer les champs
    if (isset($_GET['gn'])) 
        $gn=$_GET['gn'];
    else {
        if (isset($_POST['gn']))
            $gn=$_POST['gn']; 
        else 
            $gn=0;
        }
            $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql);
    if (mysqli_num_rows($result) > 0) {
    $page=26;
    include 'upper.php';
    echo "<center>\n";
    // On vérifie si les champs sont vides
    if($gn==0)
    {
        echo '<font color="red"> et si tu choissais un GN  et un joueur, au moins ??? !</font><br>';
    }
    // Aucun champ n'est vide, on peut enregistrer dans la table
    else {
        echo "informations joueur<br>\n";
        $sql = "select login_jeu.id,pseudo,nom,prenom,inscription.pnj,inscription.paiement from login_jeu inner join inscription on login_jeu.id=inscription.login where inscription.gn='$gn'";
        $result=mysqli_query($db,$sql);
        echo "<table>\n<tr>\n<td>pseudo</td>\n<td>nom</td>\n<td>prenom</td>\n<td>PJ</td>\n<td>paiement</td>\n</tr>\n";
        if (mysqli_num_rows($result)>0) {
            while ($row=mysqli_fetch_assoc($result)) {
                echo "<tr>\n<td><a href=\"joueur.php?gn=$gn&id=".$row['id']."\">".$row['pseudo']."</a></td>\n";
                echo "<td>".$row['nom']."</td>\n";
                echo "<td>".$row['prenom']."</td>\n";
                echo "<td><input type=checkbox";
                if ($row['pnj']==0) echo " checked";
                echo "></td>\n";
                echo "<td><input type=checkbox";
                if ($row['paiement']==1) echo " checked";
                echo "></td>\n</tr>\n";
            }
            echo "</table>\n";
        }
    }
    echo '</center></body></html>';
}   
} 
?>