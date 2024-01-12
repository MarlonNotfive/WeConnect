<?php
    // SESSION START
        session_start();
    // SESSION START
    
    // CONNECTION
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
    // CONNECTION
    
    //CHECK IF USERLOGIN
        if (!isset($_SESSION['user_token'])) {
            header("Location: ../login.php?error=no account is logged in");
            exit();
        }
    //CHECK IF USERLOGIN

    // SET DATA TO RENDER
        if(isset($_GET['group'])){
            $groupName = $_GET['group'];
            
            if($groupName == "IT AND OPS"){
                $renderData = 'it_ops';

            } elseif($groupName == "BD") {
                $renderData = 'bdg';

            } elseif($groupName == "MARKETING"){
                $renderData = 'marketing';

            } elseif($groupName == "FINANCE") {
                $renderData = 'finance';

            } elseif($groupName == "ADMIN") {
                $renderData = "admin";

            } elseif($groupName == "HR") {
                $renderData = "hr";

            } elseif($groupName == "AM") {
                $renderData = "amg";

            } elseif($groupName == "CS") {
                $renderData = "cs";

            } elseif($groupName == "SD") {
                $renderData = "sdg";

            } elseif($groupName == "CORP") {
                $renderData = "corp";

            }

        } else {
            header("location: landingPage.php");
        }
    // SET DATA TO RENDER

    // FORM QUERY
        $query = "SELECT * FROM tbl_forms WHERE form_department = '$renderData'";
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
    // FORM QUERY

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
        
            // Now you can use $employeeData to access individual fields
            $nickname = $employeeData['account_nickname'];
            $profileImage = $employeeData['account_img'];
            $stmt->close();
        } else {
            echo "No employee data found.";
        }
    //SELECT EMPLOYEE DATA

    // SELECT ALL ANNOUNCEMENT
        $query = "SELECT * FROM tbl_announcement WHERE announcement_department = '$renderData'";
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
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>WeConnect Group</title>
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
        <link rel="stylesheet" href="../style/employee-css/landingPage-components/footer.css">
        <link rel="stylesheet" href="../style/logout.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage.css">
        <link rel="stylesheet" href="../style/employee-css/landingPage.css">
        <link rel="stylesheet" href="../style/employee-css/groupPage-components/news-group.css">
        <link rel="stylesheet" href="../style/employee-css/groupPage-components/heroSection.css">
        <link rel="stylesheet" href="../style/employee-css/groupPage-components/procedures.css">
        <link rel="stylesheet" href="../style/employee-css/groupPage-components/formSection.css">
    <!-- css links -->

</head>
<body>
    <nav>
        <div class="logo-holder">
            <a href="landingPage.php"></a>
        </div>
        <div class="link-holder">
            <a href="./landingPage.php">HOME</a>
            <a href="#whatsNew">ANNOUNCEMENT</a>
            <a href="#procedures">POLICIES & PROCEDURES</a>
            <a href="#formSection">FORMS</a>
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
            <h1><?php echo $groupName ?> GROUP</h1>
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
                    if(!empty($announcement)){
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
                                            <p>
                                                '.$row['announcement_description'].'
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<p style="width:100%; display:flex; align-items:center; justify-content:center; height:40vh; text-align:center;">No Announcement</p>';
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

    <section id="procedures">
        <div class="procedure-holder">
            <div class="procedure-card">
                <div class="procedure-card-title">
                    <h4>DEPARTMENT POLICIES</h4>
                </div>
                <div class="procedure-card-body">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore odio possimus mollitia reprehenderit, aliquid quos, consectetur vitae sit deleniti, vero voluptate obcaecati dignissimos doloribus provident consequuntur repellat amet nihil! Maiores!</p>
                </div>
                <div class="procedure-card-footer">
                    <a href="">READ MORE</a>
                </div>
            </div>

            <div class="procedure-card">
                <div class="procedure-card-title">
                    <h4>DEPARTMENT PROCEDURES</h4>
                </div>
                <div class="procedure-card-body">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore odio possimus mollitia reprehenderit, aliquid quos, consectetur vitae sit deleniti, vero voluptate obcaecati dignissimos doloribus provident consequuntur repellat amet nihil! Maiores!</p>
                </div>
                <div class="procedure-card-footer">
                    <a href="">READ MORE</a>
                </div>
            </div>
        </div>
    </section>

    <section id="formSection">
        <div class="form-holder">
            <div class="form-title">
                <h4><?php echo $groupName ?> FORMS</h4>
            </div>
            <div class="form-button-holder">
                <?php
                    if(!empty($forms)){
                        foreach($forms as $row){
                            echo '
                                <div class="form-button">
                                    <div class="form-detail">
                                        <h4><i class="bi bi-file-earmark-text"></i> '.$row['form_title'].'</h4>
                                        <a target="_blank" href="'.$row['form_link'].'">LINK</a>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<h4 style="color: red;"><i class="bi bi-cone-striped"></i> NO FORMS AVAILABLE <i class="bi bi-cone-striped"></i></h4>';
                    }
                ?>
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
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">New Password</span>
                        <input type="password" class="form-control" value="" name="password" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Re-Password</span>
                        <input type="password" class="form-control" value="" name="re-password" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="profilepic">PROFILE PIC</label>
                        <input type="file" name="profilepic" class="form-control" id="profilepic">
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