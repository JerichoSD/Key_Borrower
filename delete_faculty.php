<?php
	include'dbconnect.php';
	
	$sql = "DELETE FROM FacultyProfile WHERE emp_id='" . $_GET["emp_id"] . "'";
	
	if (mysqli_query($conn, $sql)) {
        header("Location: profile_account.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
	mysqli_close($conn);
?>