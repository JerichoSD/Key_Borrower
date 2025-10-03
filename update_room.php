<?php
include 'dbconnect.php';
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    $sql = "SELECT * FROM Rooms WHERE Room_id = '$room_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $room = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Room not found.'); window.location.href='rooms.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No room selected.'); window.location.href='rooms.php';</script>";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['room_name'];

    $update_sql = "UPDATE Rooms SET Name = '$new_name' WHERE Room_id = '$room_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Room updated successfully!'); window.location.href='rooms.php';</script>";
    } else {
        echo "<script>alert('Error updating room: " . mysqli_error($conn) . "');</script>";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Room</title>
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

        table {
            margin: 0 auto;
            width: 60%;
            border-collapse: collapse;
            background-color: antiquewhite;
            padding: 20px;
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
            font-size: 25px;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        input[type="text"] {
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
            font-size: 25px;
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
        <label style="font-size: 60px;">Edit Room</label>
        <form action="update_room.php?room_id=<?php echo $room_id; ?>" method="post">
            <table>
                <th colspan="2">Edit Room: <?php echo $room['Room_id']; ?></th>
                <tr>
                    <td><label for="room_name">New Room Name:</label></td>
                    <td><input type="text" id="room_name" name="room_name" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="Update Room"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
