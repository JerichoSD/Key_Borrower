<?php
	include "dbconnect.php";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    if (isset($_POST['submit'])) {	 
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $cpass = $_POST['confirm_password'];
        $role = $_POST['utype'];

        $checkUserQuery = "SELECT * FROM Users WHERE Email = '$email'";
        $result = mysqli_query($conn, $checkUserQuery);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email already used. Please use another email address.'); window.location.href='add_account.php';</script>";
            exit();
        } else {
            if ($pass !== $cpass) {
                echo "<script>alert('Passwords do not match!'); window.location.href='add_account.php';</script>";
                exit(); 
            } else {
                $sql = "INSERT INTO Users (Name, Email, Password, User_type) VALUES ('$name', '$email', '$pass', '$role')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Account created successfully!'); window.location.href='user.php';</script>";
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }

    mysqli_close($conn);
?>
