<?php
include "dbconnect.php";
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $col = isset($_POST['col']) ? $_POST['col'] : '';
    $dep = isset($_POST['dep']) ? $_POST['dep'] : '';
    $path = 'cictlogo.jpg';

    $sql = "SELECT Vis_id FROM VisitorProfile ORDER BY Vis_id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastid = $row['Vis_id'];

        $numpart = (int) substr($lastid, 3);
        $numpart = $numpart + 1;

        $newId = "vis" . str_pad($numpart, 3, "0", STR_PAD_LEFT);
    } else {
        $newId = "vis201";
    }

    $checkUserQuery = "SELECT * FROM VisitorProfile WHERE Vis_id = '$newId'";
    $result = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Error: Invalid Profile.'); window.location.href='profile_account.php';</script>";
        exit();
    } else {
        $sql = "INSERT INTO VisitorProfile (Vis_id, Name, College, Department, Picture) VALUES ('$newId', '$name', '$col', '$dep', '$path')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Profile created successfully!'); window.location.href='profile_account.php';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>
<html>
<head>
    <title>Create Visitor Profile</title>
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
            margin-top: 100px;
            border-radius: 8px;
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
            background-color: antiquewhite;
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
    <a href="homepage.html"><img src="logoicon.png" class="logo"></a>
    <a href="index.php" style="position:fixed; bottom: 0; left: 0; z-index: 2;"><img src="logouticon.png" style="height: 50px; width: 50px; margin-top: 30px; margin-left: 1px;"></a>
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
        <label style="font-size: 100px">Create Visitor Profile</label>
        <br>
        <form action="add_visitor.php" method="post" enctype="multipart/form-data">
            <table>
                <th colspan="2"><label>Profile Creation Form</label></th>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <td><label for="col">College:</label></td>
                    <td><input type="text" id="col" name="col" required></td>
                </tr>
                <tr>
                    <td><label for="dep">Department:</label></td>
                    <td><input type="text" id="dep" name="dep" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Create Profile"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>