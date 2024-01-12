<?php
    // include database connection
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
    // include database connection

    // START SESSION
        session_start();
    // START SESSION

    //CHECK ACCOUNT
        if ($_SESSION['type'] != 'head-administrator' && $_SESSION['type'] != 'super-admin') {
            echo '<script>alert("You don\'t have permission to access this page"); window.history.back();</script>';
            exit; // It's a good practice to exit after a redirect to prevent further code execution
        }
    //CHECK ACCOUNT

    // TBL FORMS REQUEST
        $sql = "SELECT * FROM tbl_general ORDER BY status='default' DESC, status";

        $result = $conn->query($sql);

        if ($result) {
            $banners = array();
        
            // Fetch the data
            while ($row = $result->fetch_assoc()) {
                $banners[] = $row;
            }
            
        } else {
            echo "Error executing the query: " . $conn->error;
        }
    // TBL FORMS REQUEST

    
    
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
        <link rel="stylesheet" href="../style/admin-css/popups.css">
        <link rel="stylesheet" href="../style/template/template-admin.css">
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
                <a href="content-forms.php" name=generalBTN class="selected">
                    <i class="bi bi-gear"></i>
                    <p>General</p>
                </a>
                <a href="content-forms.php">
                    <i class="bi bi-file-earmark-text"></i>
                    <p>Forms</p>
                </a>
                <a href="content-events.php">
                    <i class="bi bi-calendar2-event"></i>
                    <p>Events</p>
                </a>
                <a href="content-announcement.php">
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

        <div class="content-holder" id="bannerInputs">
            <form action="../../server/content_handler.php" method="post" class="general-landingpage" enctype="multipart/form-data">
                <label for="">LANDING PAGE BANNER: </label>
                <input type="file" name="img" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                <button class="btn btn-primary" name="addLandingPageImg"><i class="bi bi-floppy"></i> Save</button>
            </form>
        </div>

        <div class="content-holder banner">
            <?php 
                if(isset($_GET['error'])){
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>error: </strong> '.$_GET['error'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                } else if(isset($_GET['success'])) {
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>SUCCESS: </strong> '.$_GET['success'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
            ?>
            <?php
                foreach($banners as $data){
                    if($data['status']=="default"){
                        echo '
                            <form action="../../server/content_handler.php" method="POST" class="banner-holder '.$data['status'].'" style="background-image: url(../assets/image/banners/'.$data['img'].');">
                                <div class="banner-control">        
                                    <p class="defaultSet">DEFAULT</p>
                                </div>
                            </form>
                        ';
                    } else {
                        echo '
                            <form action="../../server/content_handler.php" method="POST" class="banner-holder '.$data['status'].'" style="background-image: url(../assets/image/banners/'.$data['img'].');">
                                <div class="banner-control">  
                                    <button name="bannerDelete" value="'.$data['id'].'" class="custom-button"><i class="bi bi-trash"></i></button>
                                    <button name="bannerSetDefault" value="'.$data['id'].'" class="custom-button">SET DEFAULT</button>
                                    <p class="selectedSign">SELECTED</p>      
                                </div>
                            </form>
                        ';
                    }
                    
                }
            ?>
        </div>
    </section>   
</body>


<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
    function cancel() {
        window.location.href = 'content.php';
    }

    

</script>


</html>