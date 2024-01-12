<?php

    // include database connection
        include('connection.php');
    // include database connection

    if(isset($_GET['create_account'])){
        $subject = isset($_GET['subject']) ? $_GET['subject'] : '';
        $body = isset($_GET['body']) ? $_GET['body'] : '';
        $createAccount = isset($_GET['create_account']) ? $_GET['create_account'] : '';

        $sql = "UPDATE tbl_emailTemplates 
                SET subject = '$subject', body = '$body' 
                WHERE id = '$createAccount'";

        if ($conn->query($sql) === TRUE) {
            header('location: ../client/admin/emailTemplates.php?success=Template updated');
        } else {
            echo "Error updating fields: " . $conn->error;
        }

    }

    if(isset($_GET['approve_account'])){
        $subject = isset($_GET['subject']) ? $_GET['subject'] : '';
        $body = isset($_GET['body']) ? $_GET['body'] : '';
        $createAccount = isset($_GET['approve_account']) ? $_GET['approve_account'] : '';

        $sql = "UPDATE tbl_emailTemplates 
                SET subject = '$subject', body = '$body' 
                WHERE id = '$createAccount'";

        if ($conn->query($sql) === TRUE) {
            header('location: ../client/admin/emailTemplates-approval.php?success=Template updated');
        } else {
            echo "Error updating fields: " . $conn->error;
        }

    }

    if(isset($_GET['emailSettingSave'])) {
        $email = isset($_GET['email']) ? $_GET['email'] : '';
        $appPassword = isset($_GET['appPassword']) ? $_GET['appPassword'] : '';
        $id = $_GET['emailSettingSave'];

        $sql = "UPDATE tbl_email_settings 
                SET username = '$email', app_password = '$appPassword'  
                WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            header('location: ../client/admin/emailTemplates-settings.php?success=Email info updated');
        } else {
            echo "Error updating fields: " . $conn->error;
        }
    }

    
    

?>