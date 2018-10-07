<?php
   include 'config.php';
   $sql = "select id,debut from event";
   $result=mysqli_query($db,$sql)  or die(mysqli_error($db));
   if (mysqli_num_rows($result) > 0) {
   	while($row = mysqli_fetch_assoc($result)) {
		$date2=date_format(date_create($row["debut"]),"H:i").":00";
		$id=$row['id'];
		$sql2="update event set debut='$date2' where id='$id'";
		mysqli_query($db,$sql2);
        }
   }
?>
