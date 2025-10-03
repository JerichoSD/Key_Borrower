<?php
include 'dbconnect.php';
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room = isset($_POST['room']) ? $_POST['room'] : '';
    $instructor = isset($_POST['instructor']) ? $_POST['instructor'] : '';
    $role_instructor = isset($_POST['role_instructor']) ? $_POST['role_instructor'] : '';
    $day = isset($_POST['day']) ? $_POST['day'] : '';
    $timestart = isset($_POST['time_start']) ? $_POST['time_start'] : '';
    $timeend = isset($_POST['time_end']) ? $_POST['time_end'] : '';

    $roomcheckquery = "SELECT * FROM Rooms WHERE Name = '$room'";
    $roomcheckresult = mysqli_query($conn, $roomcheckquery);
    

    if (mysqli_num_rows($roomcheckresult) == 0) {
        echo "<script>alert('The room does not exist!');</script>";
        exit();
    }

    if ($role_instructor == 'Faculty') {
        $instructorcheck = "SELECT * FROM FacultyProfile WHERE Name = '$instructor'";
    } else if ($role_instructor == 'Visitor') {
        $instructorcheck = "SELECT * FROM VisitorProfile WHERE Name = '$instructor'";
    } else {
        echo "<script>alert('Invalid role!');</script>";
        exit();
    }

    $instructorcheckres = mysqli_query($conn, $instructorcheck);
    if (mysqli_num_rows($instructorcheckres) == 0) {
        echo "<script>alert('The instructor does not exist in the selected profile!');</script>";
        exit();
    }

    $overlapcheck = "SELECT * FROM Schedule WHERE Room = '$room' AND DayOfTheWeek = '$day' 
                           AND (('$timestart' BETWEEN TimeStart AND TimeEnd) OR ('$timeend' BETWEEN TimeStart AND TimeEnd))";
    $overlapcheckres = mysqli_query($conn, $overlapcheck);

    if (mysqli_num_rows($overlapcheckres) > 0) {
        echo "<script>alert('The room is already booked for the selected time!');</script>";
        exit();
    }

    $sql = "SELECT Sched_id FROM Schedule ORDER BY Sched_id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastid = $row['Sched_id'];

        $numpart = (int)substr($lastid, 5);
        $numpart += 1;

        $newid = "sched" . str_pad($numpart, 1, "0", STR_PAD_LEFT);
    } else {
        $newid = "sched1";
    }

    $insertScheduleQuery = "INSERT INTO Schedule (Sched_id, Room, Instructor, Role, DayOfTheWeek, TimeStart, TimeEnd)
                            VALUES ('$newid', '$room', '$instructor', '$role_instructor', '$day', '$timestart', '$timeend')";

    if (mysqli_query($conn, $insertScheduleQuery)) {
        echo "<script>alert('Schedule added successfully!'); window.location.href='schedules.php';</script>";
    } else {
        echo "Error: " . $insertScheduleQuery . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<html>
<head>
    <title>Add Schedule</title>
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
            color: rgb(210, 4, 45);
            text-shadow: 2px 2px 2px white;
        }

        table {
            margin: 0 auto;
            width: 80%;
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

        input, select {
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
        <label style="font-size: 100px">Add Schedule</label>
        <br>
        <form action="add_schedule.php" method="post">
            <table>
                <th colspan="2"><label>Schedule Creation Form</label></th>
                <tr>
                    <td><label for="room">Room:</label></td>
                    <td><input type="text" id="room" name="room" required></td>
                </tr>
                <tr>
                    <td><label for="instructor">Instructor:</label></td>
                    <td><input type="text" id="instructor" name="instructor" required></td>
                </tr>
                <tr>
                    <td><label for="role">Role:</label></td>
                    <td><input type="text" id="role_instructor" name="role_instructor" required></td>
                </tr>
                <tr>
                    <td><label for="day">Day:</label></td>
                    <td>
                        <select id="day" name="day" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="time_start">Time Start:</label></td>
                    <td>
                        <select id="time_start" name="time_start" required>
                            <option value="00:00:00">00:00:00</option>
                            <option value="01:00:00">01:00:00</option>
                            <option value="02:00:00">02:00:00</option>
                            <option value="03:00:00">03:00:00</option>
                            <option value="04:00:00">04:00:00</option>
                            <option value="05:00:00">05:00:00</option>
                            <option value="06:00:00">06:00:00</option>
                            <option value="07:00:00">07:00:00</option>
                            <option value="08:00:00">08:00:00</option>
                            <option value="09:00:00">09:00:00</option>
                            <option value="10:00:00">10:00:00</option>
                            <option value="11:00:00">11:00:00</option>
                            <option value="12:00:00">12:00:00</option>
                            <option value="13:00:00">13:00:00</option>
                            <option value="14:00:00">14:00:00</option>
                            <option value="15:00:00">15:00:00</option>
                            <option value="16:00:00">16:00:00</option>
                            <option value="17:00:00">17:00:00</option>
                            <option value="18:00:00">18:00:00</option>
                            <option value="19:00:00">19:00:00</option>
                            <option value="20:00:00">20:00:00</option>
                            <option value="21:00:00">21:00:00</option>
                            <option value="22:00:00">22:00:00</option>
                            <option value="23:00:00">23:00:00</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="time_end">Time End:</label></td>
                    <td>
                        <select id="time_end" name="time_end" required>
                            <option value="00:00:00">00:00:00</option>
                            <option value="01:00:00">01:00:00</option>
                            <option value="02:00:00">02:00:00</option>
                            <option value="03:00:00">03:00:00</option>
                            <option value="04:00:00">04:00:00</option>
                            <option value="05:00:00">05:00:00</option>
                            <option value="06:00:00">06:00:00</option>
                            <option value="07:00:00">07:00:00</option>
                            <option value="08:00:00">08:00:00</option>
                            <option value="09:00:00">09:00:00</option>
                            <option value="10:00:00">10:00:00</option>
                            <option value="11:00:00">11:00:00</option>
                            <option value="12:00:00">12:00:00</option>
                            <option value="13:00:00">13:00:00</option>
                            <option value="14:00:00">14:00:00</option>
                            <option value="15:00:00">15:00:00</option>
                            <option value="16:00:00">16:00:00</option>
                            <option value="17:00:00">17:00:00</option>
                            <option value="18:00:00">18:00:00</option>
                            <option value="19:00:00">19:00:00</option>
                            <option value="20:00:00">20:00:00</option>
                            <option value="21:00:00">21:00:00</option>
                            <option value="22:00:00">22:00:00</option>
                            <option value="23:00:00">23:00:00</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Add Schedule"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
