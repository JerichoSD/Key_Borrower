<?php
include 'dbconnect.php';
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<html>
<head>
    <title>Create Account</title>
    <style>
        body
        {
            background-image: url(pimentel.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        img.logo{
            width: 70px;
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .topbar{
            z-index: 2;
            width: 100%;
            height: 80px;
            background-color: rgb(210, 4, 45);
            position: fixed;
            top: 0;
            left: 0;
        }

        .side-menu{
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

       .menu-item img{
            height: 40px;
            width: 40px;
            margin-right: 10px;
        }

        .contents{
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
        <a href="homepage.php"><img src="cictlogo.png" class="logo"></a>
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

            <label style="font-size: 100px">Create Account</label>
            <br>
            <form action="add_user.php" method="post">
                <table>
                    <th colspan="2"><label>USER CREATION FORM</label></th>
                    <tr>
                        <td><label for="name">Name:</label></td>
                        <td><input type="text" id="name" name="name" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email:</label></td>
                        <td><input type="email" id="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td><label for="username">Password:</label></td>
                        <td><input type="password" id="password" name="password" required></td>
                    </tr>
                    </tr>
                        <td><label for="confirm_password">Confirm Password:</label></td>
                        <td><input type="password" id="confirm_password" name="confirm_password" required></td>
                    </tr>
                    <tr>
                        <td><label for="utype">User Type:</label></td>
                        <td><select id="utype" name="utype" style="width: 100%; padding: 12px; font-size: 18px; border: 2px solid #ccc; border-radius: 8px; box-sizing: border-box; margin-top: 5px;">
                            <option>Admin</option>
                            <option>Staff</option> </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Create Account"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>