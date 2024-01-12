<?php
    // include database connection
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
    // include database connection

    // START SESSION
        session_start();
    // START SESSION

    // TBL FORMS REQUEST
        if($_SESSION['type']=='co-admin' && isset($_SESSION['dept'])){
            $coadmindept = $_SESSION['dept'];
            $sql = "SELECT * FROM tbl_announcement WHERE announcement_department = '$coadmindept'";

            $result = $conn->query($sql);

            if ($result) {
                $announcementData = array();
            
                // Fetch the data
                while ($row = $result->fetch_assoc()) {
                    $announcementData[] = $row;
                }
                
            } else {
                echo "Error executing the query: " . $conn->error;
            }
        } else {
            $sql = "SELECT * FROM tbl_announcement";

            $result = $conn->query($sql);

            if ($result) {
                $announcementData = array();
            
                // Fetch the data
                while ($row = $result->fetch_assoc()) {
                    $announcementData[] = $row;
                }
                
            } else {
                echo "Error executing the query: " . $conn->error;
            }
        }
    // TBL FORMS REQUEST

    //REDIRECTION
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];

            header('location: content-announcement-edit.php?edit='.$id);
        }

        if(isset($_GET['delete'])){
            $id = $_GET['delete'];

            header('location: content-announcement-delete.php?delete='.$id);
        }
    //REDIRECTION
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>content</title>
    <!-- dataTable links-->
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- dataTable links-->

    <!-- Bootstrap links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap links -->

    <!-- css links -->
        <link rel="stylesheet" href="../style/root.css">
        <link rel="stylesheet" href="../style/admin-css/content.css">
        <link rel="stylesheet" href="../style/admin-css/navigation.css">
        <link rel="stylesheet" href="../style/template/template-admin.css">
        <link rel="stylesheet" href="../style/admin-css/popups.css">
        <link rel="stylesheet" href="../style/logout.css">
        <link rel="stylesheet" href="../style/animation.css">
    <!-- css links -->

    <!-- script links -->
        <script src="../javascript/tableConfig.js" defer></script>
    <!-- script links -->
</head>
<body>
    <nav>
        <div class="logo-holder">
            <img src="https://webcast-inc.com.ph/wp-content/uploads/elementor/thumbs/Copy-of-WTI-New-Logo-2-white-1-q6c2olc6f6r26f1k4yk8vi20gho5t7aumujzw9nqps.png" alt="">
        </div>
        <div class="link-holder">
            <a href="dashboard.php" class="">
                <i class="bi bi-speedometer"></i>
                <p>DASHBOARD</p>
            </a>
            <a href="accounts.php" class="">
                <i class="bi bi-person-gear"></i>
                <p>MANAGE ACCOUNTS</p>
            </a>
            <a href="content.php" class="selected">
                <i class="bi bi-images"></i>
                <p>MANAGE CONTENTS</p>
            </a>
            <a href="emailTemplates.php" class="">
                <i class="bi bi-envelope-plus"></i>
                <p>EMAIL TEMPLATES</p>
            </a>
        </div>
    </nav>
    <section id="scroll-listener">
        <div class="title">
            <h1>MANAGE CONTENT</h1>
            <a href="../employee/landingPage.php" id="loggedInAcc">
                <div id="online"></div>
                <p><?php echo $_SESSION["username"]?></p>
                <i class="bi bi-back"></i>
            </a>
        </div>

        <div class="content-holder">
            <div class="action-buttons">
                <a href="content.php" name=generalBTN>
                    <i class="bi bi-gear"></i>
                    <p>General</p>
                </a>
                <a href="content-forms.php" name="formsBTN">
                    <i class="bi bi-file-earmark-text"></i>
                    <p>Forms</p>
                </a>
                <a href="content-events.php" name="newsBTN">
                    <i class="bi bi-calendar2-event"></i>
                    <p>Events</p>
                </a>
                <a href="content-announcement.php" name="announcementBTN" class="selected">
                    <i class="bi bi-megaphone"></i>
                    <p>Announcements</p>
                </a>
                <a href="content-videoGallery.php">
                    <i class="bi bi-camera-reels"></i>
                    <p>Video Gallery</p>
                </a>
                <a href="content-pending-notification.php">
                    <i class="bi bi-bell"></i>
                    <p>Notification</p>
                </a>
            </div>
        </div>

        <div class="content-holder">
            <div class="general-forms">
                <form action="" class="addnew" id="addnewBTN">
                    <button class="addnewBTN" onclick=""><i class="bi bi-plus-circle"></i> Add new Announcement</button>
                </form>

                <table id="tableForms" class="display">
                    <thead>
                        <tr>
                            <th>img</th>  
                            <th>Announcement Title</th>
                            <th>date</th>
                            <th>time</th>
                            <th>Group</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                            foreach ($announcementData as $data) {
                                echo '
                                    <tr>
                                        <td><a href="../assets/image/announcement/'.$data['announcement_img'].'" target="_blank">
                                                <img src="../assets/image/announcement/'.$data['announcement_img'].'" alt="">
                                            </a>
                                        </td>
                                        <td>'.$data['announcement_title'].'</td>
                                        <td>'.$data['announcement_date'].'</td>
                                        <td>'.$data['announcement_time'].'</td>
                                        <td>'.$data['announcement_department'].'</td>
                                        <td>
                                            <form action="content-announcement.php">
                                                <button class="editBTN btn btn-dark" name="edit" value="'.$data['announcement_id'].'"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-danger btn-sm" name="delete" value="'.$data['announcement_id'].'"><i class="bi bi-trash3"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                ';
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>  

    <div id="popups"></div>
</body>


<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
    function cancel() {
        window.location.href = 'content-announcement.php';
    }
</script>

<script>
    const form = document.querySelector("form.addnew");
    const addBtn = form.querySelector("button.addnewBTN");
    
    form.onsubmit = (e)=>{
        e.preventDefault();
    }

    addBtn.onclick = () =>{
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../PHP/ManageContents/addAnnouncement-popup.php?addAnnouncementBTN=", true);
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if(data == "success"){

                    } else {
                        let responseElement = document.getElementById("popups");
                        responseElement.innerHTML = data;
                    }
                }
            }
        }
        xhr.send();
    }
</script>

<?php
    include('../PHP/popups.php');
?>


</html>