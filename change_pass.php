<?php
    include "dbconnect.php";

    if(isset($_POST['submit']))
    {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        } else {
            echo "<script>alert('User ID is missing.'); window.location.href='users.php';</script>";
            exit();
        }

        $checkUserQuery = "SELECT * FROM Users WHERE User_id = '$user_id'";
        $result = mysqli_query($conn, $checkUserQuery);

        if (mysqli_num_rows($result) == 0) {
            echo "<script>alert('User not found.'); window.location.href='users.php';</script>";
            exit();
        } else {
            $userData = mysqli_fetch_assoc($result);
            $storedPassword = $userData['Password'];

            if ($currentPassword !== $storedPassword) {
                echo "<script>alert('Current password is incorrect.'); window.location.href='update_user.php?user_id=$user_id';</script>";
                exit();
            } 
            else {
                if ($newPassword !== $confirmPassword) {
                    echo "<script>alert('New passwords do not match!'); window.location.href='update_user.php?user_id=$user_id';</script>";
                    exit();
                } else {
                    $updatePasswordQuery = "UPDATE Users SET Password = '$newPassword' WHERE user_id = '$user_id'";

                    if (mysqli_query($conn, $updatePasswordQuery)) {
                        echo "<script>alert('Password changed successfully!'); window.location.href='user.php';</script>";
                        exit();
                    } else {
                        echo "Error: " . $updatePasswordQuery . "<br>" . mysqli_error($conn);
                    }
                }
            }
        }

        mysqli_close($conn);
    }
?>
