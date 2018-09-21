<?php
session_start();
if(!isset($_SESSION['id'])){
      header("location:presentation.php");
   }
else {
    $id=$_SESSION['id'];
    include 'config.php';
    echo '<html><header></header><body><center>';
    echo 'inscriptions en cours<br>';
    $sql="select gn.*,inscription.pnj from gn inner join inscription on inscription.gn=gn.id where inscription.login='$id'";
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
       echo '<a href="gn.php?gn=' . $row["id"] .'">' . $row["nom"] .'</a> du '. $row["debut"] .' au '.$row['fin'].' en tant que ';
       if ($row['pnj']==0)
           echo 'PJ';
       else
           echo 'PNJ';
       echo '<br>';
   }
}
    echo '</center></body></html>';
}
?>