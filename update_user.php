<?php
    include 'dbconnect.php';
    session_start();
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        $sql = "SELECT * FROM Users WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $userdata = mysqli_fetch_assoc($result);
        } else {
            echo "<script>alert('User not found.'); window.location.href='user.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No user selected.'); window.location.href='user.php';</script>";
        exit();
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Management</title>
    <style>
        body {
            background-image: url(pimentel.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        img.logo {
            width: 70px;
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .topbar {
            z-index: 2;
            width: 100%;
            height: 80px;
            background-color: rgb(210, 4, 45);
            position: fixed;
            top: 0;
            left: 0;
        }

        .side-menu {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 55px;
            background-color: rgb(210, 4, 45);
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            font-size: 38px;
            z-index: 1;
        }

        .menu-item img {
            height: 40px;
            width: 40px;
            margin-right: 10px;
        }

        .contents {
            margin-top: 5%;
            margin-left: 120px;
        }

        table {
            margin: 0 auto;
            width: 60%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: antiquewhite;
        }

        th {
            font-size: 40px;
            text-align: center;
            padding: 15px;
            background-color: rgb(210, 4, 45);
            color: white;
            font-weight: bold;
            border-radius: 8px;
        }

        td {
            font-size: 35px;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            
        }

        tr {
            margin-radius: 10px;

        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: rgb(210, 4, 45);
            color: white;
            border: none;
            padding: 10px;
            font-size: 35px;
            cursor: pointer;
            border-radius: 8px;
            width: 50%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #006666;
        }

    </style>
</head>
<body>
    <div class="topbar">
        <h2 style="text-align: left; margin-left: 8%; margin-top: 10px; color: white;">Jericho S. Dineros<br>3B-G2</h2>
    </div>

    <a href="homepage.php"><img src="cictlogo.png" class="logo"></a>

    <a href="index.php" style="position:fixed; bottom: 0; left: 0; z-index: 2;">
        <img src="logouticon.png" style="height: 50px; width: 50px; margin-top: 30px; margin-left: 1px;">
    </a>

    <div class="side-menu">
            <br>
            <?php if (isset($role) && $role === 'Admin') { ?>
                <a href="user.php" class="menu-item">
                    <img src="useracc.png" style="height: 50px; width: 50px; margin-top: 30px; margin-left: 1px;">
                </a><br>
            <?php } ?>
            <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                <a href="profile_account.php" class="menu-item">
                    <img src="profileicon.png" style="height: 50px; width: 50px; margin-top: 5px; margin-left: 2px;">
                </a><br>
            <?php } ?>
            <a href="rooms.php" class="menu-item">
                <img src="roomlogo.png" style="height: 50px; width: 50px; margin-top: 5px; margin-left: 2px;">
            </a><br>
            <a href="schedules.php" class="menu-item">
                <img src="scheduleicon.png" style="height: 50px; width: 50px; margin-top: 5px; margin-left: 2px;">
            </a><br>
            <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
            <a href="borrower.php" class="menu-item">
                <img src="borrowicon.png" style="height: 50px; width: 50px; margin-top: 5px; margin-left: 2px;">
            </a><br>
            <a href="record.php" class="menu-item"><img src="recordicon.png" style="height: 50px; width: 50px; margin-top: 5px; margin-left: 2px;"></a><br>
            <?php } ?>
        </div>

    <div class="contents">
        <label style="font-size: 60px;">Change Password</label>
        <form action="change_pass.php?user_id=<?php echo $user_id; ?>" method="post">
            <table>
                <th colspan = "2">Change Password for User: <?php echo $userdata['Username']; ?>
                <tr>
                    <td><label for="current_password">Current Password:</label></td>
                    <td><input type="password" id="current_password" name="current_password" required></td>
                </tr>
                <tr>
                    <td><label for="new_password">New Password:</label></td>
                    <td><input type="password" id="new_password" name="new_password" required></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">Confirm New Password:</label></td>
                    <td><input type="password" id="confirm_password" name="confirm_password" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" name="submit" value="Change Password">
                    </td>
                </tr>
            </table>
        </form>
        <br><br>
    </div>
</body>
</html>
