<?php
    include "dbconnect.php";

    if(isset($_POST['submit']))
    {
        $currentdepartment = $_POST['current_department'];
        $newdepartment = $_POST['new_department'];
        $confirmdepartment = $_POST['confirm_department'];

        if (isset($_GET['vis_id'])) {
            $vis_id = $_GET['vis_id'];
        } else {
            echo "<script>alert('Visitor ID is missing.'); window.location.href='profile_account.php';</script>";
            exit();
        }

        $empquery = "SELECT * FROM VisitorProfile WHERE Vis_id = '$vis_id'";
        $result = mysqli_query($conn, $empquery);

        if (mysqli_num_rows($result) == 0) {
            echo "<script>alert('Visitor not found.'); window.location.href='profile_account.php';</script>";
            exit();
        } else {
            $row = mysqli_fetch_assoc($result);
            $storeddepartment = $row['Department'];

            if ($currentdepartment !== $storeddepartment) {
                echo "<script>alert('Current department is incorrect.'); window.location.href='update_visitor.php?vis_id=$vis_id';</script>";
                exit();
            } 
            else {
                if ($newdepartment !== $confirmdepartment) {
                    echo "<script>alert('New departments do not match!'); window.location.href='update_visitor.php?vis_id=$vis_id';</script>";
                    exit();
                } else {
                    $updatedepartmentquery = "UPDATE VisitorProfile SET Department = '$newdepartment' WHERE Vis_id = '$vis_id'";

                    if (mysqli_query($conn, $updatedepartmentquery)) {
                        echo "<script>alert('department changed successfully!'); window.location.href='profile_account.php';</script>";
                        exit();
                    } else {
                        echo "Error: " . $updatedepartmentquery . "<br>" . mysqli_error($conn);
                    }
                }
            }
        }
        mysqli_close($conn);
    }
?>
