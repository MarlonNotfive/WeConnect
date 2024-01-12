<?php 
    // CONNECTION
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
        session_start();
    // CONNECTION

    //CHECK IF USERLOGIN
        if (!isset($_SESSION['user_token'])) {
            header("Location: ../login.php?error=no account is logged in");
            exit();
        }
    //CHECK IF USERLOGIN

    // SELECT ALL ANNOUNCEMENT
        $query = "SELECT * FROM tbl_announcement WHERE announcement_department = 'all'";
        $result = $conn->query($query);

        if ($result) {
            $announcement = array();
            // Fetch and display the data
            while ($row = $result->fetch_assoc()) {
                $announcement[] = $row;

            }
        
        } else {
            echo "Error: " . $mysqli->error;
        }

        $carouselData = [];

        foreach ($announcement as $key => $row) {
            $active = $key === 0 ? 'active' : '';
            $ariaCurrent = $key === 0 ? 'true' : 'false';
            $label = 'Slide ' . ($key + 1);
            
            $carouselData[] = [
                'slideNumber' => $key,
                'active' => $active,
                'ariaCurrent' => $ariaCurrent,
                'label' => $label,
            ];
        }
    // SELECT ALL ANNOUNCEMENT

    // SELECT VIDEO CONTENTS
        //CORPORATE
        $sql = "SELECT * FROM tbl_videogallery WHERE category = 'corporates'";

        $result = $conn->query($sql);

        $corporateVideo = array(); // Initialize an empty array

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $corporateVideo[] = $row; // Append each row to the array
            }
        
        } else {
            echo "Error: " . $conn->error;
        }

        //EVENTS
        $sql2 = "SELECT * FROM tbl_videogallery WHERE category = 'events'";

        $result = $conn->query($sql2);

        $eventsVideo = array(); // Initialize an empty array

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $eventsVideo[] = $row; // Append each row to the array
            }
        
        } else {
            echo "Error: " . $conn->error;
        }

        //PRODUCTS
        $sql3 = "SELECT * FROM tbl_videogallery WHERE category = 'products'";

        $result = $conn->query($sql3);

        $productsVideo = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productsVideo[] = $row;
            }
        
        } else {
            echo "Error: " . $conn->error;
        }

    // SELECT VIDEO CONTENTS

    //SELECT ACTIVE BANNER
        $sqlActiveBanner = "SELECT * FROM tbl_general";
        $result = $conn->query($sqlActiveBanner);

        $banner = '';

        $banners = array(); // Initialize an empty array
        $checker = false;

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $banners[] = $row;

                if($row['status'] == "active"){
                    $checker = true;
                    $banner = $row['img'];
                }
            }
        }

        if(!$checker){
            foreach ($banners as $row){
                if($row['status'] == 'default'){
                    $banner = $row['img'];
                }
            }
        }


    //SELECT ACTIVE BANNER

    //SELECT EMPLOYEE DATA
        $token = $_SESSION['user_token'];
        if($_SESSION['type'] == "employee"){
            $sqlEmpDetail = "SELECT * FROM tbl_accounts WHERE token=?";
        } else {
            $sqlEmpDetail = "SELECT * FROM tbl_admins WHERE token=?";
        }
        $stmt = $conn->prepare($sqlEmpDetail);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Fetch the data
            $employeeData = $result->fetch_assoc();
            $nickname = $employeeData['account_nickname'];
            $profileImage = $employeeData['account_img'];

            if($_SESSION['type'] == "employee"){
                if($employeeData['account_state'] == "pending"){
                    header("Location: ../login.php?error=your account is currently under review please wait for approval");
                }else{

                }
            }

        } else {
            echo "No employee data found.";
        }
    //SELECT EMPLOYEE DATA

    //SELECT FORMS
        $query = "SELECT * FROM tbl_forms";
        $result = $conn->query($query);

        if ($result) {
            $forms = array();
            // Fetch and display the data
            while ($row = $result->fetch_assoc()) {
                $forms[] = $row;

            }
        
        } else {
            echo "Error: " . $conn->error;
        }
    //SELECT FORMS

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>Welcome to WeConnect</title>

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
        <link rel="stylesheet" href="../style/employee-css/navigation.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/whatsNew.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/quicklinks.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/groups.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/missionVision.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/videosFolder.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/footer.css">
        <link rel="stylesheet" href="../style/logout.css">
    <!-- css links -->
    
</head>
<body>
    <nav>
        <div class="logo-holder">
            <a href="landingPage.php"></a>
        </div>
        <div class="link-holder">
            <a href="#whatsNew">HOME</a>
            <a href="#groups">TOPICS</a>
            <a href="#missionVision">MISSION & VISION</a>
            <a href="#folder-videos">VIDEO GALLERY</a>
        </div>
        <div class="account-info">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $employeeData['account_img'] ?>" id="profilePic" alt="">
                    <?php echo $employeeData['account_nickname'] ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" ><i class="bi bi-bell"></i> Notification <span class="badge badge-danger">4</span></a>
                    <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#accountSettings"><i class="bi bi-gear"></i> Settings</a>
                    <li><hr class="dropdown-divider"></li>
                    <?php
                        if(isset($_SESSION['type'])&&$_SESSION['type']!="employee"){
                            if($_SESSION['type'] == "head-administrator"){
                                echo '<a href="../admin/dashboard.php" class="dropdown-item"><i class="bi bi-folder2-open"></i> Manage</a>';
                            }else {
                                echo '<a href="../admin/content-forms.php" class="dropdown-item"><i class="bi bi-folder2-open"></i> Manage</a>';
                            }
                        } else {

                        }
                    ?>
                    <a class="dropdown-item" href="../../server/logout_handler.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="heroSection">
        <div class="banner" style="background-image: url('../assets/image/banners/<?php echo $banner?>')">
            <div class="left-side-banner">
                <div class="textbanner">
                    <div class="text-row-1">
                        <p>HELLO</p>
                        <h1><?php echo strtoupper($nickname)?></h1>
                    </div>
                    <div class="text-row-2">
                        <p>WELCOME TO WTI</p>
                        <h1>WE CONNECT</h1>
                    </div>
                </div>
                <div class="search-holder">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
            <div class="right-side-banner">
            </div>
        </div>
    </section>

    <section id="whatsNew">
        <div class="whatsNew-title">
            <h2>WHATS NEW?</h2>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                    foreach ($carouselData as $data) {
                        echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $data['slideNumber'] . '" class="' . $data['active'] . '" aria-current="' . $data['ariaCurrent'] . '" aria-label="' . $data['label'] . '"></button>';
                    }
                ?>
            </div>
            <div class="carousel-inner">
                <?php
                    $first = true;
                    foreach ($announcement as $row) {
                        $activeClass = $first ? 'active' : '';
                        $first = false;

                        echo '
                            <div class="carousel-item '.$activeClass.'">
                                <div class="d-block custom-itemHolder">
                                    <div class="itemHolder-imgHolder">
                                        <div class="img-content" style="background-image: url('.'../assets/image/announcement/'.$row['announcement_img'].'.'.')"></div> 
                                    </div>  
                                    <div class="itemHolder-textHolder">
                                        <h2>'.$row['announcement_title'].'</h2>
                                        <p>
                                            '.$row['announcement_description'].'
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section id="groups">
        <div class="groups-title">
            <h2>TOPICS</h2>
        </div>
        <div id="carouseldepartment" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouseldepartment" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouseldepartment" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouseldepartment" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="group-card-holder">
                        <div class="groups-card hr">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>HR</h3>
                                <p>
                                    HR responsibilities </br> 
                                    Recruitment. Recruitment </br>
                                    includes all aspects of hiring, </br>
                                    from sourcing candidates to </br>
                                    onboarding
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=HR">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card itOps">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>IT & OPS </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=IT AND OPS">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card marketing">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>MARKETING </h3>
                                <p>
                                    HR responsibilities </br> 
                                    Recruitment. Recruitment </br>
                                    includes all aspects of hiring, </br>
                                    from sourcing candidates to </br>
                                    onboarding
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=MARKETING">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card finance">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>FINANCE </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=FINANCE">VIEW MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="group-card-holder">
                        <div class="groups-card admin">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>ADMIN </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=ADMIN">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card amg">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>AMG </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=AM">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card cs">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>CS </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=CS">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card sdg">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>SDG </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=SD">VIEW MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="group-card-holder">
                        <div class="groups-card bdg">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>BDG </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=BD">VIEW MORE</a>
                            </div>
                        </div>
                        <div class="groups-card corp">
                            <div class="group-card-logo">
                                <div class="card-group-image"></div>
                            </div>
                            <div class="group-card-text">
                                <h3>CORP </h3>
                                <p>
                                    Has three major areas of</br> 
                                    concern. Governance of the </br>
                                    conpany's technological </br>
                                    system and functionality of </br>
                                    the system overall.
                                </p>
                            </div>
                            <div class="group-card-button">
                                <a href="groupPage.php?group=CORP">VIEW MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouseldepartment" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouseldepartment" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="groups-card-holder">

            
            
            
            
            
        </div>
    </section>

    <section id="quicklinks">
        <div class="quicklinks-title">
            <h2>QUICKLINKS</h2>
        </div>
        <div class="button-holder">
            <button data-bs-toggle="modal" data-bs-target="#formsModal">
                <i class="bi bi-file-earmark-text"></i>
                <p>forms</p>
            </button>

            <button data-bs-toggle="modal" data-bs-target="#directory">
                <i class="bi bi-journal-bookmark"></i>
                <p>Directory</p>
            </button>
            <button data-bs-toggle="modal" data-bs-target="#calendar">
                <i class="bi bi-calendar-week"></i>
                <p>Calendar of </br> Activities</p>
            </button>
        </div>

        <div class="modal fade" id="formsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">FORMS</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        HUMAN RESOURCE
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse show" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'hr')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        IT AND OPS
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'it_ops')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        MARKETING
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'marketing')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        FINANCE
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'finance')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        ADMIN
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'admin')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        ACCOUNTING MANAGEMENT
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'amg')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        CLIENT SUPPORT
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'cs')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                        SOLUTION DEVELOPMENT
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'sdg')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                        CORP
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'corp')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                        BUSINESS DEVELOPMENT
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php 
                                            if(!empty($forms)){
                                                $noForms = true;
                                                foreach($forms as $row) {
                                                    if($row['form_department'] == 'corp')  {
                                                        echo '
                                                            <div class="form-card">
                                                                <div class="form-title"><h5>'.$row['form_title'].'</h5></div>
                                                                <a target="_blank" href="'.$row['form_link'].'" class="btn btn-danger btn-sm">LINK</a>
                                                            </div>
                                                        ';

                                                        $noForms = false;
                                                    } 
                                                }
                                                if($noForms){
                                                    echo 'no form available';
                                                }
                                            } else {
                                                echo 'no form available';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="calendar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Calendar of Activities</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="calendar-holder">
                        <iframe 
                            src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FManila&src=dGVzdEBmaW5kbWUuY29tLnBo&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4ucGhpbGlwcGluZXMjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%2333B679&color=%230B8043" 
                            style="border-width:0" 
                            width="100%"
                            height="600" 
                            frameborder="0" 
                            scrolling="no">
                        </iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="directory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">DIRECTORY</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a target="_blank" href="https://docs.google.com/spreadsheets/d/1v1QFI1IGceWFigIXyQj5VtyUiZzd1YyQpU6k4fgqWL4/edit#gid=822156740">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Microsoft_Office_Excel_%282019%E2%80%93present%29.svg/826px-Microsoft_Office_Excel_%282019%E2%80%93present%29.svg.png" 
                                alt=""
                                style="width: 100px; margin:auto;">
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </section>

    <section id="missionVision">
        <div class="missionVision-holder">
            <div class="mission-Title">
                <svg id="missionLogo" height="800px" width="800px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                    viewBox="0 0 512 512"  xml:space="preserve">
                    <g>
                        <path class="st0" d="M204.762,254.456l34.212-34.204c-39.807-18.293-88.544-11.079-121.29,21.675
                            c-42.013,42.006-42.013,110.372,0,152.393c42.005,42.014,110.38,42.014,152.386,0c32.746-32.745,39.968-81.49,21.675-121.298
                            l-34.211,34.211c3.381,19.976-2.553,41.224-17.939,56.604c-25.21,25.218-66.225,25.218-91.434,0
                            c-25.21-25.21-25.21-66.224,0-91.427C163.546,257.016,184.794,251.074,204.762,254.456z"/>
                        <path class="st0" d="M323.628,241.146c34.324,57.876,26.642,133.939-23.076,183.65c-58.826,58.826-154.527,58.826-213.345,0
                            c-58.826-58.817-58.826-154.527,0-213.352c49.703-49.711,125.775-57.393,183.65-23.076l31.216-31.225
                            c-75.387-50.693-178.754-42.77-245.35,23.817c-75.629,75.621-75.629,198.69,0,274.311c75.63,75.638,198.683,75.638,274.312,0
                            c66.603-66.595,74.518-169.962,23.809-245.358L323.628,241.146z"/>
                        <path class="st0" d="M511.279,84.84c-1.61-4.195-5.684-6.78-10.298-6.57l-70.565,3.31l3.318-70.556
                            c0.201-4.622-2.384-8.68-6.578-10.306c-4.17-1.61-9.122-0.451-12.52,2.931l-75.299,75.306l-3.809,81.322L198.634,297.162
                            c-6.964-1.578-14.565,0.29-19.992,5.716c-8.422,8.422-8.422,22.062,0,30.484c8.414,8.422,22.062,8.422,30.484,0
                            c5.418-5.427,7.295-13.028,5.716-20l136.886-136.894l81.314-3.8l75.307-75.316C511.739,93.963,512.89,89.026,511.279,84.84z"/>
                    </g>
                </svg>
                <h1>MISSION</h1>
            </div>
            <div class="mission-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Rerum quis, voluptas neque ex placeat excepturi rem saepe 
                    praesentium nihil sit dicta iste explicabo voluptatem expedita 
                    minus incidunt, veritatis numquam odit.
                </p>
            </div>
        </div>
        <div class="seperator">
            <h1>&</h1>
        </div>
        <div class="missionVision-holder">
            <div class="vision-Title">
                <h1>VISION</h1>
                <svg id="#visionLogo" width="100px" height="100px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
                    <path stroke="#ffd700" stroke-linejoin="round" stroke-width="2" d="M3 12c5.4-8 12.6-8 18 0-5.4 8-12.6 8-18 0z"/>
                    <path stroke="#ffd700" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="vision-content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Rerum quis, voluptas neque ex placeat excepturi rem saepe 
                    praesentium nihil sit dicta iste explicabo voluptatem expedita 
                    minus incidunt, veritatis numquam odit.
                </p>
            </div>
        </div>
    </section>

    <section id="folder-videos">
        <div class="video-title">
            <h2>VIDEO GALLERY</h2>
            <div class="backgroundVideo"></div>
        </div>
        <div class="video-holder">
            <button class="video-button" data-bs-toggle="modal" data-bs-target="#corporateModal">
                <i class="bi bi-folder-fill"></i>
                <p>Corporate</p>
            </button>
            <button class="video-button" data-bs-toggle="modal" data-bs-target="#eventsModal">
                <i class="bi bi-folder-fill"></i>
                <p>Events</p>
            </button>
            <button class="video-button" data-bs-toggle="modal" data-bs-target="#productsModal">
                <i class="bi bi-folder-fill"></i>
                <p>Product & Marketing</p>
            </button>

            <div class="modal fade" id="corporateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Corporate Show Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-video-holder">
                            <?php
                                if(!empty($corporateVideo)){
                                    foreach($corporateVideo as $row) {
                                        echo '
                                            <iframe 
                                                src="https://drive.google.com/file/d/'.$row['link'].'/preview" 
                                                width="100%" 
                                                height="100%" 
                                                allow="autoplay"
                                                allowfullscreen>
                                            </iframe>
                                        ';
                                    }
                                } else {
                                    echo 'No video available';
                                }
                                
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="eventsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Events Show Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-video-holder">
                            <?php
                                if(!empty($eventsVideo)){
                                    foreach($eventsVideo as $row) {
                                        echo '
                                            <iframe 
                                                src="https://drive.google.com/file/d/'.$row['link'].'/preview" 
                                                width="100%" 
                                                height="100%" 
                                                allow="autoplay"
                                                allowfullscreen>
                                            </iframe>
                                        ';
                                    }
                                } else {
                                    echo 'No video available';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="productsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Product & Marketing Show Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-video-holder">
                            <?php
                                if(!empty($productsVideo)){
                                    foreach($productsVideo as $row) {
                                        echo '
                                            <iframe 
                                                src="https://drive.google.com/file/d/'.$row['link'].'/preview" 
                                                width="100%" 
                                                height="100%" 
                                                allow="autoplay"
                                                allowfullscreen>
                                            </iframe>
                                        ';
                                    }
                                } else {
                                    echo 'No video available';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <img src="https://webcast-inc.com.ph/wp-content/uploads/elementor/thumbs/WTI-Logo-Big-2-q6c2ojgi1iohj74afxqzqij39pxfdt3dyl90xpqj28.png" alt="">
        </div>
        <div class="quickLink">
            <h2>SITE MAP</h2>
            <a href="#">HOME</a>
            <a href="#missionVision">MISSION/VISSION</a>
            <a href="#guidingPrinciple">GUIDE/PRINCIPLES</a>
            <a href="#productSection">PRODUCT</a>
        </div>
        <div class="contact-info">
            <h2>CONTACT US</h2>
            <p><i class="bi bi-house"></i> 154 Panay Avenue, Brgy. South Triangle, Diliman Quezon City, 1103</p>
            <p><i class="bi bi-envelope"></i> marketing@findme.com.ph</p>
            <p><i class="bi bi-telephone"></i> (+632) 8441 0016 / (+63) 917 559 8050</p>
        </div>
    </footer>

    <div class="modal fade" id="accountSettings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class= "modal-dialog">
            <form id="accountSettingsForm" class="modal-content" enctype="multipart/form-data" method>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ACCOUNT SETTINGS</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="popupDiv" style="width: 100%;"></div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Nickname</span>
                        <input type="text" class="form-control" value="<?php echo $nickname?>" name="nickname" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-changeInfo" id="saveChangesBtn">Save changes</button>
                </div>
            </form>
        </div>
    </div>

</body>
<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
</script>

<script>
    const form = document.querySelector("form");
    const continueBtn = form.querySelector("button.btn-changeInfo");

    continueBtn.onclick = () => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../../server/account_edit_emp.php", true);
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data)

                    var myDiv = document.getElementById("popupDiv");
                    myDiv.innerHTML = "";

                    if(data.includes("SUCCESS")){
                        var alertDiv = document.createElement("div");
                        alertDiv.className = "alert alert-success alert-dismissible fade show";
                        alertDiv.role = "alert";
                        
                        alertDiv.innerHTML = data +
                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                        myDiv.appendChild(alertDiv);
                    } else {
                        var alertDiv = document.createElement("div");
                        alertDiv.className = "alert alert-danger alert-dismissible fade show";
                        alertDiv.role = "alert";
                        
                        alertDiv.innerHTML = data +
                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                        myDiv.appendChild(alertDiv);
                    }
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
</script>
</html>