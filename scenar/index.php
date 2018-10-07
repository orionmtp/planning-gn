<?php
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();
if(isset($_SESSION['id'])){
    header("location: liste.php");
}
else {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form 
        include("config.php");
        $myusername = mysqli_real_escape_string($db,$_POST['login']);
        $mypassword = md5(mysqli_real_escape_string($db,$_POST['password']));   
        $sql = "SELECT id FROM login WHERE email = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($db,$sql)  or die(mysqli_error($db));
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
        $page=1;
        include 'upper2.php';
        echo "<center>\n";
        include 'presentation.php';
        echo "</center>\n";
        //include 'lower.php';        
	}
    }
    else
    {       
        $page=1;
        include 'upper2.php';
        echo "<center>\n";
        include 'presentation.php';
        echo "</center>\n";
        //include 'lower.php';
    }
}
?>
