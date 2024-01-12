<?php
    // include database connection
        $config = parse_ini_file('../config.conf', true);
        include('connection.php');
    // include database connection

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $accountState = "pending";
    $type = "employee";


    if(!empty($fname) && !empty($lname) && !empty($username) && !empty($nickname) && !empty($department) && !empty($password) && !empty($password)) {
    //check if all input is not empty
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strpos($email, "@findme.com.ph") !== false){
        //check if email is valid
            $sql = mysqli_query($conn, "SELECT account_email FROM tbl_accounts WHERE account_email = '{$email}'");
            
            if(mysqli_num_rows($sql) > 0){
            //check if email is already exist
                echo "$email - this email already exist";
            } else {
                $check1 = "WTI-";

                if(str_contains($username, $check1) && strlen($username) == 8){
                    if(isset($_FILES['img'])){
                        $img_name = $_FILES['img']['name'];
                        $img_type = $_FILES['img']['type'];
                        $temp_name = $_FILES['img']['tmp_name'];
    
                        $img_explode = explode('.', $img_name);
                        $img_ext = end($img_explode);
    
                        $extensions = ['png', 'jpeg', 'jpg'];
                        if(in_array($img_ext, $extensions) === true){
                        //if image type is avilable
                            $time = time();
    
                            $new_image_name = $time.$img_name;
                            if(move_uploaded_file($temp_name, '../client/assets/image/profile/'.$new_image_name)){
                            //IF THE IMAGE IS SUCCESSFULY UPLOADED
                                $sql2 = mysqli_query($conn, "INSERT INTO tbl_accounts (username, password, account_firstName, account_lastName, account_email, account_nickname, account_department, account_state, account_img, type)
                                        VALUES ('{$username}', '{$password}', '{$fname}', '{$lname}', '{$email}', '{$nickname}', '{$department}', '{$accountState}', '{$new_image_name}', '{$type}')");
                                if($sql2) {
                                    $sql3 = mysqli_query($conn, "SELECT * FROM tbl_accounts WHERE account_email = '{$email}'");
                                    $row = mysqli_fetch_assoc($sql3);
                                    
                                    $_SESSION['id'] = $row['id'];
                                    
                                    header('location: send.php?emailType=create_account&email='.$email);
                                    exit();
                                }
                            } else {
                                echo "unsuccessful";
                            }
    
                        } else {
                            echo "please upload image file - png, jpeg, jpg";
                        }
    
                    } else {
                        echo "please upload image file ";
                    }

                } else {
                    echo "invalid username format";

                }
            }

        } else {
            echo "invalid email";
        }

    } else {
        echo "All input field are required!";
    }
?>