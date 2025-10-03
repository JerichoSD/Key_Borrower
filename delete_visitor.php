<?php
	include'dbconnect.php';
	
	$sql = "DELETE FROM VisitorProfile WHERE vis_id='" . $_GET["vis_id"] . "'";
	
	if (mysqli_query($conn, $sql)) {
        header("Location: profile_account.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
	mysqli_close($conn);
?>