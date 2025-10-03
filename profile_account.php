<?php
    session_start();
    include 'dbconnect.php';
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PROFILES</title>
        <style>
            body{
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
            .contents{
                margin-top: 5%;
                margin-left: 150px;
            }
            table, tr, td, th{
                text-align: center;
                border: solid 5px black;
                border-collapse: collapse;
                margin: 0 auto;
                padding: 5px;
                background-color: antiquewhite;
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
            table{
                margin: 0 auto;
            }
            td{
                font-size: 40px;
                text-allign: center;
                padding: 10px;
                background-color: antiquewhite;
            }
            th{
                font-size: 30px;
                text-allign: center;
                padding: 10px;
                background-color: rgb(210, 4, 45);
                color: white;
            }
            td button {
                background-color: rgb(210, 4, 45);
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                font-size: 30px;
            }
        </style>
    </head>

    <body>
        <?php
            $sql="SELECT * FROM FacultyProfile";
            $Fresult = mysqli_query($conn,$sql);
            $sql="SELECT * FROM VisitorProfile";
            $Vresult = mysqli_query($conn,$sql);
            if (mysqli_num_rows($Fresult) > 0 && mysqli_num_rows($Vresult) > 0) {
        ?>
        <div class="topbar">
            <h2 style="text-align: left; margin-left: 8%; margin-top: 10px; color: black;">Jericho S. Dineros<br>3B-G2</h2>
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
                <br><br>
                <label style="font-size: 100px; text-shadow: 2px 2px 5px white;" >Faculty Profile</label>
                <br><br><br>

                <table>
                        <th>Picture</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Department</th>
                        <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                        <th>Actions</th>
                        <?php } ?>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($Fresult)){
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $row['Picture']; ?>" alt="Pics" width="70" height="70">
                        </td>
                        <td style="text-align: center;"><?php echo $row["Emp_id"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["College"]; ?></td>
                        <td><?php echo $row["Department"]; ?></td>
                        <?php if (isset($role) && ($role === 'Admin' || $role === 'Staff')) { ?>
                        <td><a href="update_faculty.php?emp_id=<?php echo $row['Emp_id']; ?>"><button>Edit</button></a><label>  </label><a href="delete_faculty.php?emp_id=<?php echo $row['Emp_id']; ?>" onclick="return confirm('Are you sure you want to delete this profile?');"><button>Delete</button></a></td>
                        <?php } ?>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>
                    <tr>
                        <td style="text-align: center;"><a href="add_faculty.php"><button>Add New</button></a></td>
                    </tr>
                </table>
                <br><br><br><br>
                <label style="font-size: 100px; color: black; text-shadow: 20px 20px 30px white;">Visitor Profile</label>
                <br><br><br>

                <table>
                        <th>Picture</th>
                        <th>Visitor ID</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Department By</th>
                        <th>Actions</th>
                    <?php
                        $i = 0;
                        while ($vrow = mysqli_fetch_array($Vresult)){
                    ?>
                    <tr>
                        <td style="padding: 0;"><img src="cictlogo.png" style="width: 55px; height: 55px;"></td>
                        <td style="text-align: center;"><?php echo $vrow["Vis_id"]; ?></td>
                        <td><?php echo $vrow["Name"]; ?></td>
                        <td><?php echo $vrow["College"]; ?></td>
                        <td><?php echo $vrow["Department"]; ?></td>
                        <td><a href="update_visitor.php?vis_id=<?php echo $vrow['Vis_id']; ?>"><button>Edit</button></a><label>  </label><a href="delete_visitor.php?vis_id=<?php echo $vrow['Vis_id']; ?>" onclick="return confirm('Are you sure you want to delete this profile?');"><button>Delete</button></a></td>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>
                    <tr>
                        <td style="text-align: center;"><a href="add_visitor.php"><button>Add New</button></a></td>
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