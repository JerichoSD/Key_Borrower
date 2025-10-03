<?php
    session_start();
    include 'dbconnect.php';
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Accounts</title>
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
            table{
                margin: 0 auto;
                background-color: antiquewhite;
            }
            td{
                font-size: 30px;
                text-allign: center;
                padding: 10px;
            }
            th{
                font-size: 45px;
                text-allign: center;
                padding: 10px;
                background-color: rgb(210, 4, 45);
            }
            td button {
                background-color: rgb(210, 4, 45);
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                font-size: 30px;
            }
            table, th, tr, td{
                border: solid 5px;
                border-collapse: collapse;
            }
        </style>
    </head>

    <body>
        <?php
            $sql="SELECT * FROM Rooms Where Status = 'Available'";
            
            $result = mysqli_query($conn,$sql);
            
            if (mysqli_num_rows($result) > 0) {
        ?>

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

                <label style="font-size: 100px" >Rooms</label>
                <br><br><br>

                <table>
                        <th><label style = "color: white;">Room ID</label></th>
                        <th><label style = "color: white;">Name</label></th>
                        <th><label style = "color: white;">Activity</label></th>
                        <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                        <th><label style = "color: white;">Actions</label></th>
                        <?php } ?>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $row["Room_id"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><a href="borrow_room.php?roomname=<?php echo ($row['Name']); ?>"><button>Borrow</button></a></td>
                        <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                        <td><a href="update_room.php?room_id=<?php echo $row['Room_id']; ?>"><button>Edit</button></a><label>  </label><a href="delete_room.php?room_id=<?php echo $row['Room_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');"><button>Delete</button></a></td>
                        <?php } ?>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>
                    <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                    <tr>
                        <td style="text-align: center;"><a href="add_room.php"><button>Add New</button></a></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php
                    }
                    else{
                        echo "No result found";
                    }
                ?>

                <?php
                    $ssql="SELECT * FROM Rooms Where Status = 'Not yet returned'";
                    
                    $uresult = mysqli_query($conn,$ssql);
                    
                    if (mysqli_num_rows($uresult) > 0) {
                ?>
                <br><br><br>
                <label style="font-size: 100px">Unavailable Rooms</label>
                <br><br><br>
                <table>
                        <th><label style = "color: white;">Room ID</label></th>
                        <th><label style = "color: white;">Name</label></th>
                        <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                        <th><label style = "color: white;">Activity</label></th>
                        <th><label style = "color: white;">Actions</label></th>
                        <?php } ?>
                    <?php
                        $i = 0;
                        while ($urow = mysqli_fetch_array($uresult)){
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $urow["Room_id"]; ?></td>
                        <td><?php echo $urow["Name"]; ?></td>
                        <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                        <td><a href="return_room.php?room=<?php echo $urow['Name']; ?>";><button>Return</button></a></td>                        
                        <td><a href="update_room.php?room_id=<?php echo $urow['Room_id']; ?>"><button>Edit</button></a><label>  </label><a href="delete_room.php?room_id=<?php echo $urow['Room_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');"><button>Delete</button></a></td>
                        <?php } ?>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>
                </table>
                <?php
                    }
                    else{
                        echo "No borrowed room found";
                    }
                ?>





            </div>


    </body>

</html>


