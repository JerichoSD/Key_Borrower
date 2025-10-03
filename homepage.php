<?php
    session_start();
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
    <title>HOMEPAGE</title>
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
            color: rgb(210, 4, 45);
            text-shadow: 2px 2px 2px white;
        }
       
    </style>
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
            <br><br><br>
            <table>
                <tr>
                    <td colspan="2" style="font-size: 75px; width: 550px;"><b>CICT KEY Borrower:</b></td>
                <tr><td><br><br></td></tr>
                <tr>
                    <td rowspan="8"><img src="cictlogo.png" style="width: 450px; heigh: 600px;"></td>
                    <td style="font-size: 30px;"><pre> <b>   This system aims to develop a smart system <br>tool for the rooms of the College of Information <br>Technology of Bulacan State University Main <br>Campus. It will be a system where one can see <br> the different rooms and their availability as <br>well as lets others borrow the key for opening it. </b></pre></td>
            </table>
        </div>
    </body>
</html>