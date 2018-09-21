<?php
include 'config.php';
$page=3;
include 'upper2.php'; 

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form 
        include("config.php");
        $myusername = mysqli_real_escape_string($db,$_POST['login']);
        $mypassword = md5(mysqli_real_escape_string($db,$_POST['password']));     
        $sql = "SELECT id FROM login WHERE email = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);
        // If result matched $myusername and $mypassword, table row must be 1 row
        if($count == 1) {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            //session_register("planning");
            session_start();
            $_SESSION['id'] = $row['id'];
            header("location: liste.php");
        }
        else {
            $error = "Your Login Name or Password is invalid";
        }
    }
    else
    {       
echo '<center>';

// On commence par récupérer les champs

if (isset($_GET['gn'])) $gn=$_GET['gn'];
else $gn=0;
// On vérifie si les champs sont vides
if($gn==0) {
    $today=date("Y-m-d H:i").":00";
    $sql = "select id,nom,debut,fin from gn where debut>'$today' order by debut";
$result=mysqli_query($db,$sql);
echo "<center>\n";
if (mysqli_num_rows($result) > 0) {
   echo "<table>\n<tr><td>nom</td><td>debut</td><td>fin</td></tr>\n";
   while($row = mysqli_fetch_assoc($result)) {
       echo '<tr>'."\n".'<td><a href=agenda.php?gn='.$row['id'] .'> '. $row["nom"] .'</a></td>'."\n".'<td>'. $row["debut"] .'</td>'."\n".'<td>'. $row["fin"] .'</td>'."\n".'</tr>'."\n";
   }
   echo '</table>'."\n";
}
}

else     
    {
//les infos sur le GN
$sql = "select nom,debut,fin,description from gn where id='$gn'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
       echo 'GN<br>'."\n".$row["nom"] .'<br>'."\n".'<table>'."\n".'<tr>'."\n".'<td>du</td><td>'. $row["debut"] .'</td>'."\n".'<td> au </td>'."\n".'<td>'. $row["fin"] .'</td>'."\n".'</tr>'."\n".'</table><br>'."\n".''. $row["description"] . '<br>'."\n";
   }
}
    }
      echo '</center></body></html>';
}
?>
