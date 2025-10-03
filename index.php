<?php
session_start();
include 'dbconnect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];

    $sql_user = "SELECT * FROM `Users` WHERE Email = '$user'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $_SESSION['email'] = $user;
        header("Location: password.php");
        exit();
    } else {
        $sql_profile = "SELECT * FROM `FacultyProfile` WHERE Emp_id = '$user'";
        $result_profile = $conn->query($sql_profile);

        if ($result_profile->num_rows > 0) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = 'Faculty';
            echo "<script>alert('Login successful!'); window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Invalid username (email or emp_id).');</script>";
        }
    }
}

if ($conn) {
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
    <style>
        body {
            background-image: url(keyborrowbg.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center; 
        }

        .login {
            background: rgba(255, 255, 255, 0.85);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            color: #333;
            width: 400px;
            text-align: center;
        }

        td {
            text-align: center;
        }

    </style>
    <body>
        <br><br><br>
        
        <form action="index.php" method="post">
            <table class="login">
                <th colspan="2" style="background-color: rgb(210, 4, 45)"><label style="font-size: 50px; color: black;">CICT ROOM <br>KEY BORROWER</label></th>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="2" style="text-align: center; font-size: 50px;">LOGIN HERE<br><br></td>
                </tr>
                <tr>
                    <td><label style="font-size: 35px;">Username: </label></td>
                    <td><input type="text" id="username" name="username" required style="width: 300px; height: 40px; font-size: 30px; border-radius: 8px; border: 1px solid #ddd;"></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="2"><button type="submit" style="color: black; height: 40px; width: 130px; background-color: orange; font-size: 30px;">LOGIN</button></td>
                </tr>
            </table>
        </form>
    </body>
</html>
