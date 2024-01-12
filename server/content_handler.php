<?php
    // include database connection
        $config = parse_ini_file('../config.conf', true);
        include('connection.php');
    // include database connection
    
    if(isset($_GET['addFormBTN'])){
        $formTitle = $_GET['formTitle'];
        $link = $_GET['link'];
        $dept = $_GET['department'];
        $dateNow = date("Y/m/d");

        $sql = "INSERT INTO tbl_forms (form_title, form_link, form_department, form_added) 
            VALUES ('$formTitle', '$link', '$dept', '$dateNow')";
        
        if ($conn->query($sql) === TRUE) {

            $getLatestRow = "SELECT form_id FROM tbl_forms ORDER BY form_id DESC LIMIT 1";
            $result = $conn->query($getLatestRow);
            
            if ($result) {
                $latestID = array();
            
                // Fetch the data
                while ($row = $result->fetch_assoc()) {
                    $id = $row['form_id'];

                }
            } else {
                echo "Error executing the query: " . $conn->error;
            }

            $sql2 = "INSERT INTO tbl_notification (notif_type, title, message, content_id, notif_target) 
            VALUES ('form', 'New Form Added', '$formTitle', '$id', '$dept')";
        
            if ($conn->query($sql2) === TRUE) {
                $type = "form";
                pendingNotif($dept, $type);
                header('location: ../client/admin/content-forms.php?success=New Form Added');

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;

            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

        }

        $conn->close();
    }

    if(isset($_GET['editFormBTN'])){
        $formTitle = $_GET['formTitle'];
        $link = $_GET['link'];
        $dept = $_GET['department'];
        $id = $_GET['editFormBTN'];

        $sql2 = mysqli_query($conn, "UPDATE tbl_forms SET
            form_title = '{$formTitle}',
            form_link = '{$link}',
            form_department = '{$dept}'
            WHERE form_id = {$id}");

        if ($sql2) {
            header('location: ../client/admin/content-forms.php?success=updated successfully');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    if(isset($_GET['delete-form'])){
        $id = $_GET['delete-form'];
        $sql = "DELETE FROM tbl_forms WHERE form_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                
                $deleteNotif = "DELETE FROM tbl_notification WHERE content_id = '$id'";

                if (mysqli_query($conn, $deleteNotif)) {
                    header('location: ../client/admin/content-forms.php?success=deleted successfuly');

                } else {
                    echo "Error deleting record: " . mysqli_error($conn);

                }

            } else {
                echo "No records were deleted.";
            }

            $stmt->close();

        } else {

        }


    }

    if(isset($_POST['addEventBTN'])){
        $eventTitle = $_POST['eventTitle'];
        $event_date = $_POST['eventDate'];
        $event_time = $_POST['eventTime'];
        $event_department = $_POST['department'];
        $event_summary = $_POST['eventSummary'];
        $event_description = $_POST['eventDesc'];

        if(isset($_FILES['eventImg'])){
            
            $img_name = $_FILES['eventImg']['name'];
            $img_type = $_FILES['eventImg']['type'];
            $temp_name = $_FILES['eventImg']['tmp_name'];

            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);

            $extensions = ['png', 'jpeg', 'jpg'];
            if(in_array($img_ext, $extensions) === true){
                $time = time();

                $new_image_name = $time.$img_name;
                if(move_uploaded_file($temp_name, '../client/assets/image/events/'.$new_image_name)){
                    $sql = mysqli_query($conn, "INSERT INTO tbl_events (event_title, event_img, event_date, event_time, event_department, event_summary, event_description)
                                    VALUES ('{$eventTitle}', '{$new_image_name}', '{$event_date}', '{$event_time}', '{$event_department}', '{$event_summary}', '{$event_description}')");
                    if($sql) {
                        $getLatestRow = "SELECT event_id FROM tbl_events ORDER BY event_id DESC LIMIT 1";
                        $result = $conn->query($getLatestRow);
                        
                        if ($result) {
                            $latestID = array();
                        
                            // Fetch the data
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['event_id'];
            
                            }
                        } else {
                            echo "Error executing the query: " . $conn->error;
                        }
            
                        $sql2 = "INSERT INTO tbl_notification (notif_type, title, message, content_id, notif_target) 
                        VALUES ('event', 'New Event Added', '$event_summary', '$id', '$event_department')";
                    
                        if ($conn->query($sql2) === TRUE) {

                            $type = "event";
                            pendingNotif($event_department, $type);
                            header('location: ../client/admin/content-events.php?success=New Event Added');
            
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
            
                        }

                    } else {
                        echo "failed";

                    }
                
                } else {
                    echo "ERROR uploading image";
                }
            } else{
                "invalid image format";
            }
        } else {
            echo 'no image';
        }
    }

    if(isset($_POST['editEventBTN'])){
        $event_id = $_POST['editEventBTN'];
        $eventTitle = $_POST['eventTitle'];
        $event_date = $_POST['eventDate'];
        $event_time = $_POST['eventTime'];
        $event_department = $_POST['department'];
        $event_summary = $_POST['eventSummary'];
        $event_description = $_POST['eventDesc'];
    
        // Perform the update without changing the image
        $sql = mysqli_query($conn, "UPDATE tbl_events 
            SET event_title = '{$eventTitle}', event_date = '{$event_date}', 
            event_time = '{$event_time}', event_department = '{$event_department}', 
            event_summary = '{$event_summary}', event_description = '{$event_description}' 
            WHERE event_id = $event_id");
    
        if ($sql) {
            header("location: ../client/admin/content-events.php?success=Event updated Successfully");
        } else {
            echo "Update failed";
        }
    }

    if(isset($_POST['deleteEventBTN'])) {
        $event_id = $_POST['deleteEventBTN'];
    
        // Perform the delete operation
        $sql = mysqli_query($conn, "DELETE FROM tbl_events WHERE event_id = $event_id");
    
        if ($sql) {
            
            $deleteNotif = "DELETE FROM tbl_notification WHERE content_id = '$event_id'";

            if (mysqli_query($conn, $deleteNotif)) {
                header('location: ../client/admin/content-events.php?success=deleted successfuly');

            } else {
                echo "Error deleting record: " . mysqli_error($conn);

            }
        } else {
            echo "Delete failed";
        }
    }    

    if(isset($_POST['addAnnouncementBTN'])){

        $announcementTitle = $_POST['Title'];
        $announcementdate = $_POST['Date'];
        $announcement_time = $_POST['Time'];
        $announcement_department = $_POST['department'];
        $announcement_summary = $_POST['Summary'];
        $announcement_description = $_POST['Desc'];

        if(isset($_FILES['announceIMG'])){
            
            $img_name = $_FILES['announceIMG']['name'];
            $img_type = $_FILES['announceIMG']['type'];
            $temp_name = $_FILES['announceIMG']['tmp_name'];

            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);

            $extensions = ['png', 'jpeg', 'jpg'];
            if(in_array($img_ext, $extensions) === true){
                $time = time();

                $new_image_name = $time.$img_name;
                if(move_uploaded_file($temp_name, '../client/assets/image/announcement/'.$new_image_name)){
                    $sql = mysqli_query($conn, "INSERT INTO tbl_announcement (announcement_title, announcement_img, announcement_date, announcement_time, announcement_department, announcement_summary, announcement_description)
                                    VALUES ('{$announcementTitle}', '{$new_image_name}', '{$announcementdate}', '{$announcement_time}', '{$announcement_department}', '{$announcement_summary}', '{$announcement_description}')");
                    if($sql) {
                        $getLatestRow = "SELECT announcement_id FROM tbl_announcement ORDER BY announcement_id DESC LIMIT 1";
                        $result = $conn->query($getLatestRow);
                        
                        if ($result) {
                            $latestID = array();
                        
                            // Fetch the data
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['announcement_id'];
            
                            }
                        } else {
                            echo "Error executing the query: " . $conn->error;
                        }
            
                        $sql2 = "INSERT INTO tbl_notification (notif_type, title, message, content_id, notif_target) 
                        VALUES ('announcement', 'New Announcement Added', '$announcement_summary', '$id', '$announcement_department')";
                    
                        if ($conn->query($sql2) === TRUE) {
                            // sendemails($announcement_department, "announcement", $announcement_summary);
                            $type = "announcement";
                            pendingNotif($announcement_department, $type);
                            header('location: ../client/admin/content-announcement.php?success=New Announcement Added');

                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
            
                        }

                    } else {
                        echo "failed";

                    }
                
                } else {
                    echo "image uploading image";
                }
            } else{
                echo "invalid image format";
            }
        } else {
            echo 'no image';
        }

    }

    if(isset($_POST['editAnnouncementBTN'])) {
        $announcementTitle = $_POST['Title'];
        $announcementdate = $_POST['Date'];
        $announcement_time = $_POST['Time'];
        $announcement_department = $_POST['department'];
        $announcement_summary = $_POST['Summary'];
        $announcement_description = $_POST['Desc'];
        $announcement_id = $_POST['editAnnouncementBTN']; // Add a hidden field in your form to store the announcement ID.
    
        // Perform the update without changing the image
        $sql = mysqli_query($conn, "UPDATE tbl_announcement
            SET announcement_title = '{$announcementTitle}',
                announcement_date = '{$announcementdate}',
                announcement_time = '{$announcement_time}',
                announcement_department = '{$announcement_department}',
                announcement_summary = '{$announcement_summary}',
                announcement_description = '{$announcement_description}'
            WHERE announcement_id = $announcement_id");
    
        if ($sql) {
            header("location: ../client/admin/content-announcement.php?success=Announcement updated Successfully");
        } else {
            echo "Update failed";
        }
    }
    
    if(isset($_POST['deleteAnnouncementBTN'])) {
        $announcement_id = $_POST['deleteAnnouncementBTN'];
    
        // Perform the delete operation
        $sql = mysqli_query($conn, "DELETE FROM tbl_announcement WHERE announcement_id = $announcement_id");
    
        if ($sql) {
            header("location: ../client/admin/content-announcement.php?success=Announcement deleted Successfully");
        } else {
            echo "Delete failed";
        }
    }    
    
    if(isset($_POST['addLandingPageImg'])){

        if(isset($_FILES['img'])){
            $status = "active";
            
            $img_name = $_FILES['img']['name'];
            $img_type = $_FILES['img']['type'];
            $temp_name = $_FILES['img']['tmp_name'];

            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);

            $extensions = ['png', 'jpeg', 'jpg'];
            if(in_array($img_ext, $extensions) === true){
                $time = time();

                $new_image_name = $time.$img_name;
                if(move_uploaded_file($temp_name, '../client/assets/image/banners/'.$new_image_name)){

                    $deleteQuery = "DELETE FROM tbl_general WHERE status <> 'default'";
                    $result = $conn->query($deleteQuery);

                    if ($result) {

                        $sql = mysqli_query($conn, "INSERT INTO tbl_general (img, status)
                                    VALUES ('{$new_image_name}', '{$status}')");
                        if($sql) {
                            // Select the img column from tbl_general
                            $selectQuery = "SELECT img FROM tbl_general";
                            $result = $conn->query($selectQuery);

                            // Check if the query was successful
                            if ($result) {
                                $imageArray = array();

                                // Fetch the img column values and store in the array
                                while ($row = $result->fetch_assoc()) {
                                    $imageArray[] = $row['img'];
                                }

                                // Path to the folder where images are stored (replace with your actual folder path)
                                $folderPath = '../client/assets/image/banners/';

                                // Delete files not present in the array
                                $filesInFolder = glob($folderPath . '*');
                                foreach ($filesInFolder as $file) {
                                    $filename = basename($file);

                                    if (!in_array($filename, $imageArray)) {
                                        unlink($file);
                                    }
                                }
                                header("location: ../client/admin/content.php?success=banner added Successfully");


                            } else {
                                echo "Error: " . $conn->error;
                            }


                        } else {
                            echo "failed";

                        }

                    } else {
                        echo "Error: " . $conn->error;
                    }
                
                } else {
                    echo "ERROR uploading image";
                }
            } else{
                header("location: ../client/admin/content.php?error=invalid image format");
            }
        } else {
            echo 'no image';
        }
    }
    
    if(isset($_POST['bannerSetActive'])){
        $id = $_POST['bannerSetActive'];
        $status = "active";
    
        // Set status to 'inactive' for all records except the specified ID
        $sqlUpdateInactive = "UPDATE tbl_general SET status = 'inactive' WHERE id != $id AND status != 'default'";
        $resultUpdateInactive = mysqli_query($conn, $sqlUpdateInactive);
    
        if ($resultUpdateInactive) {
            // Now, update the specified record to 'active'
            $sqlUpdateActive = "UPDATE tbl_general SET status = '$status' WHERE id = $id";
            $resultUpdateActive = mysqli_query($conn, $sqlUpdateActive);
    
            if ($resultUpdateActive) {
                header("location: ../client/admin/content.php?success=Banner updated Successfully");
            } else {
                echo "Update failed";
            }
        } else {
            echo "Update failed";
        }
    }

    if(isset($_POST['bannerSetDefault'])){
        $id = $_POST['bannerSetDefault'];
        $status = "default";
    
        // Set status to 'inactive' for all records except the specified ID
        $sqlUpdateInactive = "UPDATE tbl_general SET status = 'active' WHERE id != $id";
        $resultUpdateInactive = mysqli_query($conn, $sqlUpdateInactive);
    
        if ($resultUpdateInactive) {
            // Now, update the specified record to 'active'
            $sqlUpdateActive = "UPDATE tbl_general SET status = '$status' WHERE id = $id";
            $resultUpdateActive = mysqli_query($conn, $sqlUpdateActive);
    
            if ($resultUpdateActive) {
                header("location: ../client/admin/content.php?success=Banner updated Successfully");
            } else {
                echo "Update failed";
            }
        } else {
            echo "Update failed";
        }
    }
    
    if(isset($_POST['bannerDelete'])){
        $id = $_POST['bannerDelete'];
    
        $id = intval($id);
    
        $sqlDeleteRecord = "DELETE FROM tbl_general WHERE id = $id";
        
        if (mysqli_query($conn, $sqlDeleteRecord)) {
            header("location: ../client/admin/content.php?success=Banner deleted Successfully");
            exit; // Exit to prevent further execution of the script
        } else {
            echo "Deletion failed: " . mysqli_error($conn);
        }
    }

    if(isset($_GET['addLinkVideo'])){
        $driveLink = $_GET['link'];
        $fileId = getDriveFileId($driveLink);
        $category = $_GET['category'];
        $dept = "all";
        $type = "video";

        $sql = "INSERT INTO tbl_videoGallery (link, category) 
                VALUES ('$fileId', '$category')";

        if ($conn->query($sql) === TRUE) {
            pendingNotif($dept, $type);
            header("location: ../client/admin/content-videoGallery.php?success=video added");

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

        }

        // $parts = explode('=', $url);
        // $link = end($parts);
        // $category = $_GET['category'];

        // $sql = "INSERT INTO tbl_videoGallery (link, category) 
        //     VALUES ('$link', '$category')";
        
        // if ($conn->query($sql) === TRUE) {
        //     header("location: ../client/admin/content-videoGallery.php?success=video added");

        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;

        // }

        // $conn->close();
    }

    if(isset($_GET['addShownVideo'])){
        $state = $_GET['state'];
        $id = $_GET['addShownVideo'];

        $sql = "SELECT * FROM tbl_videogallery WHERE isShown = 'true'";
        $result = mysqli_query($conn, $sql); 

        if($state == "false") {
            $state = "true";
        } else {
            $state = "false";
        }

        if ($result) 
        { 
            $row = mysqli_num_rows($result); 
            
            if ($row >= 6) { 
                
                if($state == "false"){
                    $sql2 = mysqli_query($conn, "UPDATE tbl_videogallery SET
                    isShown = '{$state}'
                    WHERE id = {$id}");
        
                    if ($sql2) {
                        header('location: ../client/admin/content-videoGallery.php?success=updated successfully');
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }

                } else {
                    header('location: ../client/admin/content-videoGallery.php?success=max video to show is reached');
                }

            } else {

                $sql2 = mysqli_query($conn, "UPDATE tbl_videogallery SET
                    isShown = '{$state}'
                    WHERE id = {$id}");
        
                if ($sql2) {
                    header('location: ../client/admin/content-videoGallery.php?success=updated successfully');
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

            }
            mysqli_free_result($result); 
        } 

    }

    if(isset($_GET['deleteVideo'])){
        $id = $_GET['deleteVideo'];

        $sqlDeleteRecord = "DELETE FROM tbl_videogallery WHERE id = $id";
        
        if (mysqli_query($conn, $sqlDeleteRecord)) {
            header("location: ../client/admin/content-videoGallery.php?success=Banner deleted Successfully");
            exit; // Exit to prevent further execution of the script
        } else {
            echo "Deletion failed: " . mysqli_error($conn);
        }
    }
    
    if(isset($_GET['deletePendingNotif'])){
        $id = $_GET['deletePendingNotif'];

        $sqlDeleteNOtif = "DELETE FROM tbl_email_notification_send WHERE id = $id";
        
        if (mysqli_query($conn, $sqlDeleteNOtif)) {
            header("location: ../client/admin/content-pending-notification.php?success=Notification deleted Successfully");
            exit; // Exit to prevent further execution of the script
        } else {
            echo "Deletion failed: " . mysqli_error($conn);
        }
    }

    //FUNCTIONS
        function pendingNotif($dept, $type) {
            include('connection.php');

            $checkSql = "SELECT * FROM tbl_email_notification_send WHERE target_department = '$dept' AND type = '$type'";
            $result = $conn->query($checkSql);

            $message = "new $type has been uploaded";

            if ($result->num_rows > 0) {
                // If a notification exists, update the 'number' column
                $updateSql = "UPDATE tbl_email_notification_send SET number = number + 1 WHERE target_department = '$dept' AND type = '$type'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "Notification updated successfully";
                } else {
                    echo "Error updating notification: " . $conn->error;
                }
            } else {
                // If no notification exists, insert a new one
                $insertSql = "INSERT INTO tbl_email_notification_send (target_department, type, number, isSent, message) VALUES ('$dept', '$type', 1, 0, '$message')";
                if ($conn->query($insertSql) === TRUE) {
                    echo "Notification inserted successfully";
                } else {
                    echo "Error inserting notification: " . $conn->error;
                }
            }

        }

        function getDriveFileId($driveLink) {
            $urlParts = parse_url($driveLink);
        
            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $query);
                if (isset($query['id'])) {
                    return $query['id'];
                }
            }
        
            // If the direct file ID is not found in the query parameters,
            // attempt to extract it from the path
            if (isset($urlParts['path'])) {
                $pathParts = explode('/', trim($urlParts['path'], '/'));
        
                foreach ($pathParts as $part) {
                    if (strlen($part) === 33 && preg_match('/^[a-zA-Z0-9_-]+$/', $part)) {
                        // Assuming that Google Drive file IDs are always 33 characters long
                        return $part;
                    }
                }
            }
        
            // If the file ID cannot be extracted, return false or handle accordingly
            return false;
        }
    //FUNCTIONS
?>  