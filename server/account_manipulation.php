<?php
    // include database connection
        $config = parse_ini_file('../config.conf', true);
        include('connection.php');
    // include database connection


    if(isset($_GET['cancel'])) {
        header('location: ../client/admin/accounts.php');

    } else if (isset($_GET['saveEditBTN'])){
        $fname = $_GET['fname'];
        $lname = $_GET['lname'];
        $nickname = $_GET['nickname'];
        $hireDate = $_GET['hireDate'];
        $group = $_GET['group'];
        $id = $_GET['saveEditBTN'];
        $email = $_GET['email'];
        $type = $_GET['type'];
        $token = $_GET['token'];
        $img = $_GET['account_img'];

        $formattedHireDate = date("Y-m-d", strtotime($hireDate));

        if($_GET['type'] != "unset" && $_GET['type'] != "employee"){
            //IF TREU CHECK IF ACCOUNT IS ACTIVE
            if($_GET['state'] != 'active'){
                echo "error=account must be active before making it admin";
                header('location: ../client/admin/accounts.php?error=account must be active before making it admin');

            }else {
                //CHECK IF GROUP IS ALREADY SET
                if($group == "unset"){
                    header('location: ../client/admin/accounts.php?error=Set Accounts group first before making it admin');

                } else {
                    $sql = "INSERT INTO tbl_admins (admin_fname, admin_lname, account_nickname, hiredate, dept, email, type, token, account_img)
                            VALUES ('$fname', '$lname', '$nickname', '$hireDate', '$group', '$email', '$type', '$token', '$img')";

                    // Execute the query
                    if ($conn->query($sql) === TRUE) {
                        // SQL query to delete a record from tbl_admins based on ID
                        $sql = "DELETE FROM tbl_accounts WHERE id = '$id'";

                        // Execute the query
                        if ($conn->query($sql) === TRUE) {
                            header('location: ../client/admin/accounts.php?success=the account is set as admin successfully');


                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                        
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                }

            }

        } else {
            $sql2 = mysqli_query($conn, "UPDATE tbl_accounts SET        
            account_firstName = '{$fname}',
            account_lastName = '{$lname}',
            account_nickname = '{$nickname}',
            account_hiredate = '{$hireDate}',
            account_department = '{$group}'
            WHERE id = {$id}");

            if ($sql2) {
                header('location: ../client/admin/accounts.php?success=updated successfully');
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            
        }
        
        

        
    }

    if(isset($_GET['empEdit'])){
        header('location: ../client/admin/accounts.php?empEdit='.$_GET['empEdit']);
    }

    if(isset($_GET['empApprove'])) {
        $id = $_GET['empApprove'];
        $state = "active";

        $sql = mysqli_query($conn, "UPDATE tbl_accounts SET
                    account_state = '{$state}'
                    WHERE id = {$id}");

        if ($sql) {
            $emailQuery = mysqli_query($conn, "SELECT account_email FROM tbl_accounts WHERE id = {$id}");

            if ($emailQuery) {
                $row = mysqli_fetch_assoc($emailQuery);
                $email = $row['account_email'];
                
                header('location: send.php?emailType=approve_account&state='.$state.'&email='.$email);
            } else {
                echo "Error retrieving email: " . mysqli_error($conn);
            }
            
            

        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    if (isset($_GET['empDelete'])) {
        $id = $_GET['empDelete'];
    
        // Retrieve the email before deleting the account
        $emailQuery = mysqli_query($conn, "SELECT account_email FROM tbl_accounts WHERE id = {$id}");
    
        if ($emailQuery) {
            if ($emailQuery->num_rows > 0) {
                $row = mysqli_fetch_assoc($emailQuery);
                $email = $row['account_email'];
    
                $sql = mysqli_query($conn, "DELETE FROM tbl_accounts WHERE id = {$id}");
    
                if ($sql) {
                    echo $email;
                    header('location: send.php?emailType=deletion_account&email='.$email);
                } else {
                    echo "Error deleting account: " . mysqli_error($conn);
                }
            } else {
                echo "No matching email found for this account.";
            }
        } else {
            echo "Error retrieving email: " . mysqli_error($conn);
        }
    }
    
    if(isset($_GET['addAdmin'])) {
        $username = $_GET['username'];
        $password = $_GET['password'];
        $lname = $_GET['lname'];
        $fname = $_GET['fname'];
        $type = $_GET['type'];

        if(isset($_GET['department'])){
            $dept = $_GET['department'];
        } else {
            $dept = null;
        }


        // Prepare and execute the SQL INSERT query
        $sql = "INSERT INTO tbl_admins (username, password, admin_lname, admin_fname, type, dept) 
        VALUES ('$username', '$password', '$lname', '$fname', '$type', '$dept')";

        if (mysqli_query($conn, $sql)) {

            header('location: ../client/admin/accounts-admins.php?success=Account added');

        } else {

            echo "Error: " . $sql . "<br>" . mysqli_error($conn);

        }

        // Close the database connection
        mysqli_close($conn);

    }

    if(isset($_GET['deleteAdmin'])) {
        $id = $_GET['deleteAdmin'];


        // Prepare and execute the SQL DELETE query
        $sql = "DELETE FROM tbl_admins WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            header('location: ../client/admin/accounts-admins.php?success=Account deleted');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);

    }

    if(isset($_GET['removeAdminPermission'])) {

        $id = mysqli_real_escape_string($conn, $_GET['removeAdminPermission']);
        // SQL query to select data from tbl_admin based on ID
        $sql = "SELECT * FROM tbl_admins WHERE id = '$id'";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            $accountArray = $result->fetch_assoc();

            $fname = $accountArray['admin_fname'];
            $lname = $accountArray['admin_lname'];
            $email = $accountArray['email'];
            $nickname = $accountArray['account_nickname'];
            $dept = $accountArray['dept'];
            $img = $accountArray['account_img'];
            $hiredate = $accountArray['hiredate'];
            $state = "active";
            $token = $accountArray['token'];

            $sql = "INSERT INTO tbl_accounts (account_firstName, account_lastName, account_email, account_nickname, account_department, account_img, account_hireDate, account_state, token)
                    VALUES ('$fname', '$lname', '$email', '$nickname', '$dept', '$img', '$hiredate', '$state', '$token')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                // SQL query to delete a record from tbl_admins based on ID
                $sql = "DELETE FROM tbl_admins WHERE id = '$id'";

                // Execute the query
                if ($conn->query($sql) === TRUE) {
                    header('location: ../client/admin/accounts-admins.php?success=the account permission has been removed');


                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }


        } else {

        }
    }
?>