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
    $id=$_SESSION['id'];
    $sql="select id from admin where gn='$gn' and login='$id'";
    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
    if (mysqli_num_rows($result) > 0) {
    // On vérifie si les champs sont vides
        if($gn==0) {
            echo '<font color="red">t\'as merde... alors recommence</font><br>';
        }
        else {
            $zeroed=date_create("00:00:01");
            $now=date_create(date("H:i",strtotime("now")).":00");
            if (isset($_POST['update2'])) {
                $sql="update gn set running='0',serial=NULL where id='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
				$sql="select  recur from gn where id='$gn'";
                mysqli_query($db,$sql)  or die(mysqli_error($db));
				$result=mysqli_query($db,$sql)  or die(mysqli_error($db));
                $row = mysqli_fetch_assoc($result);
				if ($row['recur'])
				{
					$sql="update objectif set succes=defvalue where gn='$gn';update role set login='0' where gn='$gn'; delete from planning where gn='$gn'";
					mysqli_query($db,$sql)  or die(mysqli_error($db));
				}
				else {
					$sql="update objectif set succes=defvalue where gn='$gn'";
					mysqli_query($db,$sql)  or die(mysqli_error($db));
					$sql="update role set login='0' where gn='$gn' and pnj='1'";
					mysqli_query($db,$sql)  or die(mysqli_error($db));
					$sql="delete from planning where gn='$gn'";
					mysqli_query($db,$sql)  or die(mysqli_error($db));
				}
                $delta=0;
            }
            else {
                if (isset($_POST['update'])) {
                    $sql = "select debut from gn where id='$gn'";
                    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
                    $row = mysqli_fetch_assoc($result);
                    $deb=date_create($row["debut"]);
					$truc=date_format($deb,"H:i:s");
					$chouette=date_format($now,"H:i:s");
                    if ($truc>$chouette) {$delta=date_diff($now,$deb); $avance=1;}
                    else {$delta=date_diff($deb,$now); $avance=0;}
                    $differ=date_format(date_add($zeroed,$delta),"H:i").":00";
					$serial = substr(md5(microtime()),rand(0,26),16);
                    $sql="update gn set running='1',delta='$differ',avance='$avance', serial='$serial' where id='$gn'";
                    mysqli_query($db,$sql)  or die(mysqli_error($db));
                    $delta=date_create($differ);
                    $nom="qrcode/". $serial . ".png";
					$message="http://run.planning-gn.fr/running.php?serial=".$serial;
                }
                else {
                    $sql = "select delta,avance,serial from gn where id='$gn'";
                    $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
                    $row = mysqli_fetch_assoc($result);
                    $delta=date_create($row['delta']);
                    $avance=$row['avance'];
					$serial=$row['serial'];
					$message="http://run.planning-gn.fr/running.php?serial=".$serial;
                }
            }    
            
            $page=29;
            include 'upper.php';
            echo '<center>';
            //les infos sur le role a modifier
            $sql = "select running from gn where id='$gn'";
            $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
            $row = mysqli_fetch_assoc($result);
            if ($row['running']==0) {
                $sql = "select debut,fin from gn where id='$gn'";
                $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
                $row = mysqli_fetch_assoc($result);
                $deb=date_create($row["debut"]);
                $fin=date_create($row["fin"]);
                echo "actuelle ". date_format($now,"H:i")."<br>\n";
                echo "debut ". date_format($deb,"H:i")."<br>\n";
                echo "fin ".date_format($fin,"H:i")."<br>\n";
                echo '<form method="POST" action="runtime.php?gn='.$gn.'">'."\n";
                echo '<input type="submit" value="lancer le GN !" name="update"></form><br>'."\n";
                
            }
            else {
                echo "heure : ".date("H:i",strtotime("now")/*date_format(strtotime("now"),"T H:i")*/."<br>\ndelta : ".date_format($delta,"H:i")."<br>\n<br>\n";
		echo "<a href=\"http://run.planning-gn.fr/running.php?serial=".$serial."\" target=\"new\"><img src=\"create_png.php?text=".$message."\"/></a><br>\n<br>\n";
                echo '<form method="POST" action="runtime.php?gn='.$gn.'">'."\n";
                echo '<input type="submit" value="arreter" name="update2"></form>'."\n";
            }
            echo '</center></body></html>';
        }
    }
}
?>
