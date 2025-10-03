<?php
    include 'dbconnect.php';
    session_start();
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
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
                font-size: 25px;
                text-allign: center;
                padding: 10px;
            }
            th{
                font-size: 36px;
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
                font-size: 20px;
            }
            table, th, tr, td{
                border: solid 5px;
                border-collapse: collapse;
            }
        </style>
    </head>

    <body>
        <?php
            $sql="SELECT * FROM Users";
            
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

                <label style="font-size: 100px" >Users</label>
                <br><br><br>

                <table>
                        <th><label style = "color: white;">User ID</label></th>
                        <th><label style = "color: white;">Name</label></th>
                        <th><label style = "color: white;">Email</label></th>
                        <th><label style = "color: white;">Password</label></th>
                        <th><label style = "color: white;">User Type</label></th>
                        <th><label style = "color: white;">Actions</label></th>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $row["User_id"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["Email"]; ?></td>
                        <td><?php echo $row["Password"]; ?></td>
                        <td><?php echo $row["User_type"]; ?></td>
                        <td><a href="update_user.php?user_id=<?php echo $row['User_id']; ?>"><button>Edit</button></a><label>  </label><a href="delete_user.php?user_id=<?php echo $row['User_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');"><button>Delete</button></a></td>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>
                    <tr>
                        <td style="text-align: center;"><a href="add_account.php"><button>Add New</button></a></td>
                    </tr>
                </table>
                <?php
                    }
                    else{
                        echo "No result found";
                    }
                ?>
            </div>
    </body>

</html>