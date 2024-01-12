<?php
    // include database connection
        $config = parse_ini_file('../config.conf', true);
        include('connection.php');
    // include database connection

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer\src\Exception.php';
    require 'phpmailer\src\PHPMailer.php';
    require 'phpmailer\src\SMTP.php';

    //GET EMAIL SETTINGS FIRST
        $settingSQL = "SELECT * FROM tbl_email_settings WHERE id = '1'";
        $settingResult = $conn->query($settingSQL);

        if ($settingResult) {
            if ($settingResult->num_rows > 0) {
                while ($row = $settingResult->fetch_assoc()) {

                    $settingUsername = $row['username'];
                    $settingPassword = $row['app_password'];

                }
            } else {
                echo "No matching rows found.";
            }
        } else {
            echo "Error executing the query: " . $conn->error;
        }
    //GET EMAIL SETTINGS FIRST


    if(isset($_GET['emailType']) && $_GET['emailType'] == "create_account") {
        
        $email = $_GET['email'];
        $type = $_GET['emailType'];

        $sql = "SELECT * FROM tbl_emailtemplates WHERE type = '$type'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $subject = $row['subject'];
                    $body = $row['body'];
                    $body = nl2br($body);

                }
            } else {
                echo "No matching rows found.";
            }
        } else {
            echo "Error executing the query: " . $conn->error;
        }

        $mail = new PHPMailer(true);

        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = $settingUsername;
        $mail -> Password = $settingPassword;
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port =  465;
    
        $mail -> setFrom($settingUsername);
    
        $mail -> addAddress($email);
    
        $mail -> isHTML(true);
    
        $mail -> Subject = $subject;
        $mail->Body = $body;
    
    
        $mail -> send();
    }
    
    if(isset($_GET['emailType']) && $_GET['emailType'] == "approve_account") {
        $email = $_GET['email'];
        $type = $_GET['emailType'];

        $sql = "SELECT * FROM tbl_emailtemplates WHERE type = '$type'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $subject = $row['subject'];
                    $body = $row['body'];
                    $body = nl2br($body);

                }
            } else {
                echo "No matching rows found.";
            }
        } else {
            echo "Error executing the query: " . $conn->error;
        }
        
        $mail = new PHPMailer(true);

        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = $settingUsername;
        $mail -> Password = $settingPassword;
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port =  465;
    
        $mail -> setFrom("webcast000@gmail.com");
    
        $mail -> addAddress($email);
    
        $mail -> isHTML(true);
    
        $mail -> Subject = $subject;
        $mail->Body = $body;
    
    
        $mail -> send();

        $state = $_GET['state'];
        header('location: ../client/admin/accounts.php?success=Account set to '.$state);
    }

    if(isset($_GET['emailType']) && $_GET['emailType'] == "deletion_account") {
        $email = $_GET['email'];
        $type = $_GET['emailType'];

        $sql = "SELECT * FROM tbl_emailtemplates WHERE type = '$type'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $subject = $row['subject'];
                    $body = $row['body'];
                    $body = nl2br($body);

                }
            } else {
                echo "No matching rows found.";
            }
        } else {
            echo "Error executing the query: " . $conn->error;
        }
        
        $mail = new PHPMailer(true);

        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = $settingUsername;
        $mail -> Password = $settingPassword;
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port =  465;
    
        $mail -> setFrom("webcast000@gmail.com");
    
        $mail -> addAddress($email);
    
        $mail -> isHTML(true);
    
        $mail -> Subject = $subject;
        $mail->Body = $body;
    
    
        $mail -> send();

        header('location: ../client/admin/accounts.php?success=Account is successfully Deleted');
    }

    if($_GET['emailType'] == "sendNotifications"){
        
        $sql = "SELECT target_department,
            CONCAT(
                (SELECT GROUP_CONCAT(CONCAT('[', number, '] ', message) ORDER BY type SEPARATOR '<br>')
                FROM tbl_email_notification_send
                WHERE target_department = 'all'),
                            '<br>',
                            GROUP_CONCAT(CONCAT('[', number, '] ', message) ORDER BY type SEPARATOR '<br>')
                        ) AS summary
                FROM tbl_email_notification_send
                WHERE target_department <> 'all'
                GROUP BY target_department;
                ";
        $result = $conn->query($sql);

        if ($result) {
        
            // Fetch the data
            while ($row = $result->fetch_assoc()) {
                $notification[] = $row;
            }

            if(!empty($notification)) {
                //send notif for employees
                foreach($notification as $notif) {
                    //notif per dept
                    if($notif['target_department'] != "all"){
                        $target = $notif['target_department'];
                        $bodyMessage = $notif['summary'];
                        $sql = "SELECT * FROM tbl_accounts WHERE account_department = '$target'";
                        $result = $conn->query($sql);

                        echo $sql . "</br>";

                        while ($row = $result->fetch_assoc()) {
                            $email = $row['account_email'];
                            $department = $row['account_department'];

                            // echo $email . "</br>";
                            // echo $bodyMessage . "</br></br>";

                            $mail = new PHPMailer(true);

                            $mail -> isSMTP();
                            $mail -> Host = 'smtp.gmail.com';
                            $mail -> SMTPAuth = true;
                            $mail -> Username = $settingUsername;
                            $mail -> Password = $settingPassword;
                            $mail -> SMTPSecure = 'ssl';
                            $mail -> Port =  465;
                        
                            $mail -> setFrom("$settingUsername");
                        
                            $mail -> addAddress($email);
                        
                            $mail -> isHTML(true);
                        
                            $mail -> Subject = "New Uploaded Content";
                            $mail->Body = $bodyMessage;

                            $mail -> send();

                        }
                    }
                }

                //send notif for Admins
                    $sql = "SELECT CONCAT('[', SUM(number), '] ', message) AS summary,
                            type
                                FROM tbl_email_notification_send
                                GROUP BY type, message;
                                ";
                    $result = $conn->query($sql);
                    $summary = "";
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            $summary = $summary . $row["summary"] . "<br>";
                        }
                        echo $summary;
                        $bodyMessage = $summary;
                        $sql = "SELECT * FROM tbl_admins";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $email = $row['email'];

                            // echo $email . "</br>";
                            // echo $bodyMessage . "</br></br>";

                            $mail = new PHPMailer(true);

                            $mail -> isSMTP();
                            $mail -> Host = 'smtp.gmail.com';
                            $mail -> SMTPAuth = true;
                            $mail -> Username = $settingUsername;
                            $mail -> Password = $settingPassword;
                            $mail -> SMTPSecure = 'ssl';
                            $mail -> Port =  465;
                        
                            $mail -> setFrom("$settingUsername");
                        
                            $mail -> addAddress($email);
                        
                            $mail -> isHTML(true);
                        
                            $mail -> Subject = "New Uploaded Content";
                            $mail->Body = $bodyMessage;

                            $mail -> send();

                        }
                    }
                //send notif for Admins

                //delete all record in tbl_email_notification_send
                $sqlDelete = "DELETE FROM tbl_email_notification_send";
                $conn->query($sqlDelete);

                header("location: ../client/admin/content-pending-notification.php?success=Email sent successfully");

            } else {
                //wala notif
                header("location: ../client/admin/content-pending-notification.php?error=no pending email notification");
            }

            
        } else {
            echo "Error executing the query: " . $conn->error;
        }

    }
    



    
?>