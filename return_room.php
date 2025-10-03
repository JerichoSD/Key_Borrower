<?php
    session_start();
    include 'dbconnect.php';
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    if (isset($_GET['room'])) {
        $room = $_GET['room'];
        
        $deleteSql = "DELETE FROM Borrowers WHERE Room = '$room'";

        if (mysqli_query($conn, $deleteSql)) {
            $updateSql = "UPDATE Borrowers_Record SET Status = 'Returned' WHERE Room = '$room'";

            if (mysqli_query($conn, $updateSql)) {
                $updateRoomSql = "UPDATE Rooms SET Status = 'Available' WHERE Name = '$room'";

                if (mysqli_query($conn, $updateRoomSql)) {
                    echo "<script>alert('Room status updated to Available, borrower record deleted, and Borrowers_Record updated!'); window.location.href = 'rooms.php';</script>";
                } else {
                    echo "<script>alert('Error updating room status.'); window.location.href = 'rooms.php';</script>";
                }
            } else {
                echo "<script>alert('Error updating Borrowers_Record.'); window.location.href = 'rooms.php';</script>";
            }
        } else {
            echo "<script>alert('Error deleting borrower record.'); window.location.href = 'rooms.php';</script>";
        }
    } else {
        echo "<script>window.location.href = 'rooms.php';</script>";
    }
?>
