<?php
    // START SESSION
        session_start();
    // START SESSION

    //CHECK ACCOUNT
        if ($_SESSION['type'] != 'head-administrator' && $_SESSION['type'] != 'super-admin') {
            echo '<script>alert("You don\'t have permission to access this page"); window.history.back();</script>';
            exit; // It's a good practice to exit after a redirect to prevent further code execution
        }
    //CHECK ACCOUNT

    // include database connection
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
    // include database connection

    // REGISTERED ACCOUNTS
        $sql = "SELECT * FROM tbl_accounts WHERE account_state = 'active'";

        $result = $conn->query($sql);

        if ($result) {
            $registeredAccount = mysqli_num_rows($result);
            
        } else {
            $registeredAccount = 0;
            echo "Error executing the query: " . $conn->error;
        }
    // REGISTERED ACCOUNTS

    // FOR APPROVAL
        $sql = "SELECT * FROM tbl_accounts WHERE account_state='pending'";

        $result = $conn->query($sql);
        $forApprovalArray = array();

        if ($result) {
            $forApprovalAccount = mysqli_num_rows($result);

            while ($row = $result->fetch_assoc()) {
                if($row['account_state'] == "pending"){
                    $forApprovalArray[] = $row;
                }
            }
            
        } else {
            $forApprovalAccount = 0;
            echo "Error executing the query: " . $conn->error;
        }
    // FOR APPROVAL

    //FORMULA
        $sql = "SELECT *, CURRENT_TIMESTAMP as currentDate FROM tbl_accounts";

        $result = $conn->query($sql);
         

        if ($result) {
            $online = array();
            $numberOfOnline = 0;

            // Fetch the data
            while ($row = $result->fetch_assoc()) {
                $datetime1 = $row['last_activity'];
                $datetime2 = $row['currentDate'];

                $start_datetime = new DateTime($datetime1); 
                $diff = $start_datetime->diff(new DateTime($datetime2)); 

                $total_minutes = ($diff->days * 24 * 60); 
                $total_minutes += ($diff->h * 60); 
                $total_minutes += $diff->i;

                if($total_minutes <= 15) {
                    
                    $numberOfOnline = $numberOfOnline + 1;

                } else {
                }

            }
            
        } else {
            $numberOfOnline = 0;
            echo "Error executing the query: " . $conn->error;
        }
    //FORMULA  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>Dashboard</title>

    <!-- Bootstrap links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Bootstrap links -->

    <!-- Bootstrap links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap links -->    

    <!-- css links -->
        <link rel="stylesheet" href="../style/root.css">
        <link rel="stylesheet" href="../style/admin-css/navigation.css">
        <link rel="stylesheet" href="../style/admin-css/dashboard.css">
        <link rel="stylesheet" href="../style/template/template-admin.css">
        <link rel="stylesheet" href="../style/logout.css">
    <!-- css links -->

    <!-- dataTable links-->
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- dataTable links-->

    <!-- script links -->
        <script src="../javascript/tableConfig.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- script links -->

</head>
<body>
    <nav>
        <div class="logo-holder">
            <img src="https://webcast-inc.com.ph/wp-content/uploads/elementor/thumbs/Copy-of-WTI-New-Logo-2-white-1-q6c2olc6f6r26f1k4yk8vi20gho5t7aumujzw9nqps.png" alt="">
        </div>
        <div class="link-holder">
            <a href="dashboard.php" class="selected">
                <i class="bi bi-speedometer"></i>
                <p>DASHBOARD</p>
            </a>
            <a href="accounts.php" class="">
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
            <h1>DASHBOARD</h1>
            <a href="../employee/landingPage.php" id="loggedInAcc">
                <div id="online"></div>
                <p><?php echo $_SESSION["username"]?></p>
                <i class="bi bi-back"></i>
            </a>
        </div>
        <div class="content-holder">
            <div class="analysisHolder">
                <div class = "chart-holder">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="firstRowColumn">
                    <div class="card">
                        <div class="card-title">
                            <p>ENROLLED USERS</p>
                        </div>
                        <div class="card-logo">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="card-data">
                            <p><?php echo $registeredAccount?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <p>ONLINE USERS</p>
                        </div>
                        <div class="card-logo">
                            <i class="bi bi-person-hearts"></i>
                        </div>
                        <div class="card-data">
                            <p><?php echo $numberOfOnline?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <p>PENDING ACCOUNTS</p>
                        </div>
                        <div class="card-logo">
                            <i class="bi bi-person-fill-gear"></i>
                        </div>
                        <div class="card-data">
                            <p><?php echo $forApprovalAccount?></p>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="content-holder">
            <div class="account-statistic-holder">
                <div class="table-holder">
                    <div class="forApproval-title">
                        <p>PENDING ACCOUNTS</p>
                    </div>
                    <div class="forApproval-holder">
                        <table id="newemp" class="display" style="width:100%">
                            <thead>
                                <th>Name</th>
                                <th>Gmail</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($forApprovalArray)){
                                        foreach($forApprovalArray as $row){
                                            echo '<tr>
                                                    <td>'.$row["account_firstName"]." ".$row['account_lastName'].'</td>
                                                    <td>'.$row['account_email'].'</td>
                                                    <td>'.$row['account_state'].'</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" href="accounts.php" class>TAKE ACTION</a>
                                                    </td>
                                                </tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="LogFrequency-holder">
                    <div class="logFrequency-title">
                        <p>USER LOGIN STATISTICS</p>
                    </div>
                    <div class="logFrequency-table">
                        <table id="logins" class="display" style="width:100%">
                            <thead>
                                <th>Name</th>
                                <th>Last Activity</th>
                                <th>Frequency</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Delima</td>
                                    <td>10/23/23</td>
                                    <td>26</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
</script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ['ENROLLED', 'ONLINE', 'PENDING'],
      datasets: [{
        label: 'Data',
        data: [<?php echo $registeredAccount?>, <?php echo $numberOfOnline?>, <?php echo $forApprovalAccount?>],
      }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                display: true
            },
            title: {
                display: true,
                text: 'DATA FOR USERS'
            }
        }
    }
  });

</script>




</html>