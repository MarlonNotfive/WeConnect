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

    // data request
        $sql = "SELECT * FROM tbl_accounts ";

        $result = $conn->query($sql);

        if ($result) {
            $AccountData = array();
        
            // Fetch the data
            while ($row = $result->fetch_assoc()) {
                $AccountData[] = $row;
            }
            
        } else {
            echo "Error executing the query: " . $conn->error;
        }
    // data request
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>Accounts</title>
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
        <link rel="stylesheet" href="../style/admin-css/accounts.css">
        <link rel="stylesheet" href="../style/admin-css/content.css">
        <link rel="stylesheet" href="../style/admin-css/navigation.css">
        <link rel="stylesheet" href="../style/template/template-admin.css">
        <link rel="stylesheet" href="../style/logout.css">
        <link rel="stylesheet" href="../style/popup-css/popups-empEdit.css">
        <link rel="stylesheet" href="../style/animation.css">
    <!-- css links -->

    <!-- Bootstrap links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Bootstrap links -->

    <!-- script links -->
        <script src="../javascript/tableConfig.js" defer></script>
        <script src="../javascript/transitions.js" defer></script>
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
            <a href="accounts.php" class="selected">
                <i class="bi bi-person-gear"></i>
                <p>MANAGE ACCOUNTS</p>
            </a>
            <a href="content.php" class="">
                <i class="bi bi-images"></i>
                <p>MANAGE CONTENTS</p>
            </a>
            <a href="emailTemplates.php" class="">
                <i class="bi bi-envelope-plus"></i>
                <p>EMAIL TEMPLATES</p>
            </a>
        </div>
    </nav>
    <section>
        <div class="title">
            <h1>MANAGE ACCOUNTS</h1>
            <a href="../employee/landingPage.php" id="loggedInAcc">
                <div id="online"></div>
                <p><?php echo $_SESSION["username"]?></p>
                <i class="bi bi-back"></i>
            </a>
        </div>
        <div class="content-holder">
            <div class="action-buttons">
                <a href="accounts.php" name=generalBTN class="selected">
                    <i class="bi bi-person"></i>
                    <p>Employees</p>
                </a>
                <a href="accounts-admins.php" name="formsBTN">
                    <i class="bi bi-person-check-fill"></i>
                    <p>Admins</p>
                </a>
            </div>
        </div>
        <div class="content-holder">
            <?php
                if(isset($_GET['success'])){
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>SUCCESS: </strong> '.$_GET['success'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
                if(isset($_GET['error'])){
                    echo '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>WARNING: </strong> '.$_GET['error'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
            ?>
            <table id="accountTableEmployee" class="display" style="width:100%">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Group</th>
                    <th>State</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        if(!empty($AccountData)) {
                            foreach ($AccountData as $data) {

                                if($data['account_state'] === "pending"){
                                    $isApproved = "<button class='btn btn-primary btn-sm' name='empApprove' value='".$data['id']."'>APPROVED</button>";
                                } else {
                                    $isApproved = "";
                                }

                                echo "<tr>
                                        <td>".$data['account_firstName']." ".$data['account_lastName']."</td>
                                        <td>".$data['account_email']."</td>
                                        <td>".$data['account_department']."</td>
                                        <td>".$data['account_state']."</td>
                                        <td>
                                            <form action='../../server/account_manipulation.php' method='get'>
                                                <button class='btn btn-dark btn-sm' name='empEdit' value='".$data['id']."'><i class='bi bi-pencil'></i></i></button>
                                                <button class='btn btn-danger btn-sm' name='empDelete' value='".$data['id']."'><i class='bi bi-trash'></i></button>
                                                ".$isApproved."
                                            </form>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </section>

</body>




<?php
    
    include '../PHP/ManageAccounts/empEdit-popup.php';
?>

</html>