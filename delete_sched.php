<?php
	include'dbconnect.php';
	
	$sql = "DELETE FROM Schedule WHERE Sched_id='" . $_GET["sched_id"] . "'";
	
	if (mysqli_query($conn, $sql)) {
        header("Location: schedules.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
	mysqli_close($conn);
?>