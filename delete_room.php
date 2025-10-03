<?php
	include'dbconnect.php';
	
	$sql = "DELETE FROM Rooms WHERE Room_id='" . $_GET["room_id"] . "'";
	
	if (mysqli_query($conn, $sql)) {
        header("Location: rooms.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
	mysqli_close($conn);
?>