<?php
    session_start();
    
    include 'dbconnect.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_SESSION['email'];
        $pass = $_POST['password'];

        $sql = "SELECT * FROM `Users` WHERE Email = '$user' AND password = '$pass'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION['user'] = $user;
            $row = $result->fetch_assoc();
            $_SESSION['role'] = $row['User_type'];
            echo "<script>alert('Login successful!'); window.location.href='homepage.php';</script>";
        } 
        else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    }
    $conn->close();
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
        <form action="password.php" method="post">
            <table class="login">
                <th colspan="2" style="background-color: rgb(210, 4, 45)"><label style="font-size: 50px; color: white;">CICT ROOM <br>KEY BORROWER</label></th>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="2" style="text-align: center; font-size: 50px;">ENTER PASSWORD<br><br></td>
                </tr>
                <tr>
                    <td><label style="font-size: 35px;">Password: </label></td>
                    <td><input type="password" id="password" name="password" required style="width: 300px; height: 40px; font-size: 30px; border-radius: 8px; border: 1px solid #ddd;"></td>
                </tr>
                <tr><td><br><br></td></tr>
                <tr>
                    <td colspan="2"><button type="submit" style="color: white; height: 40px; width: 130px; background-color: rgb(210, 4, 45); font-size: 30px;">LOGIN</button></td>
                </tr>
            </table>
        </form>
    </body>
</html>
