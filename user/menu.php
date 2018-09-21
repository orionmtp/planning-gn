<?php
session_start();
if(!isset($_SESSION['id'])){
      header("location:index.php");
   }
else {
echo '<html><header></header><body><center>';
echo 'PlanningGN<br><br>';
echo '<a href="liste.php">GNs</a><br><br>';
echo '<a href="inscriptions.php">inscriptions</a><br><br>';
echo '<a href="compte.php">compte</a><br><br>';
echo '<a href="logout.php">se deconnecter</a><br>';
echo '</center></body></html>';
}
?>