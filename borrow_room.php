<?php
session_start();
include 'dbconnect.php';

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

ini_set('display_errors', 1);
error_reporting(E_ALL);


$sql = "SELECT Transaction_id FROM `Borrowers_Record` ORDER BY Transaction_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['Transaction_id'];
    $numPart = (int)substr($lastId, 5);
    $numPart += 1;
    $newId = "trans" . str_pad($numPart, 1, "0", STR_PAD_LEFT);
} else {
    $newId = "trans1";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrower = $_POST['borrower'] ?? '';
    $position = $_POST['position'] ?? '';
    $roomname = $_POST['roomname'] ?? '';
    $datetime = date('Y-m-d H:i:s');

    if (empty($borrower) || empty($position)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href = 'rooms.php';</script>";
        exit;
    }

    $checkBorrowerStatus = "SELECT * FROM Borrowers_Record WHERE Borrower = '$borrower' AND Status = 'Not yet returned' LIMIT 1";
    $checkStatusResult = mysqli_query($conn, $checkBorrowerStatus);

    if (mysqli_num_rows($checkStatusResult) > 0) {
        echo "<script>alert('You already have an unavailable room. Please return it first.'); window.location.href = 'rooms.php';</script>";
        exit;
    }

    if ($position == "Visitor") {
        $checkBorrower = "SELECT * FROM VisitorProfile WHERE Name = '$borrower'";
    } else {
        $checkBorrower = "SELECT * FROM FacultyProfile WHERE Name = '$borrower'";
    }

    $checkResult = mysqli_query($conn, $checkBorrower);

    if (mysqli_num_rows($checkResult) > 0) {

        $insertborrower = "INSERT INTO Borrowers (Name, Room, Position) VALUES ('$borrower', '$roomname', '$position')";
        $insertborrowerResult = mysqli_query($conn, $insertborrower);
        if ($insertborrowerResult) {
        } 
        else {
            echo "<script>alert('Error inserting borrower record.'); window.location.href = 'rooms.php';</script>";
        }


        $insertSql = "INSERT INTO Borrowers_Record (Transaction_id, Borrower, Room, Position, Time_borrowed, Status) VALUES ('$newId', '$borrower', '$roomname', '$position', '$datetime', 'Not yet returned')";
        if (mysqli_query($conn, $insertSql)) {
            $updateSql = "UPDATE Rooms SET Status = 'Not yet returned' WHERE Name = '$roomname'";

            if (mysqli_query($conn, $updateSql)) {
                echo "<script>alert('Room successfully borrowed!'); window.location.href = 'rooms.php';</script>";
            } else {
                echo "<script>alert('Error updating room status.'); window.location.href = 'rooms.php';</script>";
            }
        } else {
            echo "<script>alert('Error borrowing room.'); window.location.href = 'rooms.php';</script>";
        }
    } else {
        echo "<script>alert('Borrower not found in the appropriate profile table.'); window.location.href = 'rooms.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Borrow Room</title>
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
            height: 50px;
            width: 50px;
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

        input[type="text"], select {
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
        <label style="font-size: 100px">Borrow Room</label>
        <br>
        <form action="borrow_room.php" method="post">
            <table>
                <th colspan="2"><label>Room Borrowing Form</label></th>
                <tr>
                    <td><label for="borrower_name">Borrower Name:</label></td>
                    <td><input type="text" id="borrower_name" name="borrower" required></td>
                </tr>
                <tr>
                    <td>Position:</td>
                    <td><select name="position" required>
                        <option value="">Select Position</option>
                        <option value="Visitor">Visitor</option>
                        <option value="Faculty">Faculty</option></select>
                    </td>
                <input type="hidden" name="roomname" value="<?php echo isset($_GET['roomname']) ? $_GET['roomname'] : ''; ?>">
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Borrow" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
