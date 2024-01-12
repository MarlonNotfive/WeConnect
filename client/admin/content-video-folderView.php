<?php
    // include database connection
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
    // include database connection

    // START SESSION
        session_start();
    // START SESSION

    // TBL FORMS REQUEST
        $category = $_GET["folder"];
        if($category == "corporates"){
            $title = "Corporate";
        } else if ($category == "events") {
            $title = "Events";
        } else {
            $title = "Product & Events";
        }


        $sql = "SELECT * FROM tbl_videogallery WHERE category = '$category'";

        $result = $conn->query($sql);

        if ($result) {
            $video = array();
        
            // Fetch the data
            while ($row = $result->fetch_assoc()) {
                $video[] = $row;
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
        <link rel="stylesheet" href="../style/admin-css/content-videoGallery.css">
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
            <h1>MANAGE CONTENT / <?php echo $title?></h1>
            <button onclick="logout()"href="../../server/logout_handler.php" id="loggedInAcc">
                <div id="online"></div>
                <p><?php echo $_SESSION["username"]?></p>
                <i class="bi bi-power" id="power"></i>
            </button>
        </div>

        <div class="content-holder">
            <div class="group">
                <a href="content-videoGallery.php" class="backBTN">
                    <i class="bi bi-arrow-left-circle"></i>
                    <p>BACK</p>
                </a>
                <div class="folderNav">
                    <i class="bi bi-folder-fill"></i>
                    <div class="folder-title">
                        <p><?php echo $title?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-holder">
            <div class="videoCard-holder">
                <?php
                    if(!empty($video)){
                        foreach($video as $data){
                            if($data['isShown']=="true"){
                                $isShown = "bi bi-eye";
                                $videoSelected = "videoSelected";
                            } else {
                                $isShown = "bi bi-eye-slash";
                                $videoSelected = "";
                            }
    
                            echo '
                                <div class="videoCard '.$videoSelected.'">
                                    <div class="videoCard-play">
                                        <iframe 
                                            src="https://drive.google.com/file/d/'.$data['link'].'/preview" 
                                            width="100%" 
                                            height="100%" 
                                            allow="autoplay"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <form action="../../server/content_handler.php" method="get" class="video-control">
                                        <button class="btn btn-danger btn-sm" name="deleteVideo" value="'.$data['id'].'">REMOVE VIDEO</button>
                                    </form>
                                </div>
                            ';
                        }
                    } else {
                        echo "<p>No Video is Available</p>"; 
                    }
                    
                ?>
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
        window.location.href = 'content-videoGallery.php';
    }
</script>

<?php
    include('../PHP/popups.php');
?>


</html>