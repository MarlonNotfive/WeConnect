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
        $sql = "SELECT * FROM tbl_admins";
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
    <!-- Bootstrap links -->

    <!-- css links -->
        <link rel="stylesheet" href="../style/root.css">
        <link rel="stylesheet" href="../style/admin-css/content.css">
        <link rel="stylesheet" href="../style/admin-css/popups.css">
        <link rel="stylesheet" href="../style/admin-css/navigation.css">
        <link rel="stylesheet" href="../style/template/template-admin.css">
        <link rel="stylesheet" href="../style/logout.css">
        <link rel="stylesheet" href="../style/popup-css/popups-empEdit.css">
        <link rel="stylesheet" href="../style/animation.css">
        <link rel="stylesheet" href="../style/admin-css/accounts.css">
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
                <a href="accounts.php" name=generalBTN>
                    <i class="bi bi-person"></i>
                    <p>Employees</p>
                </a>
                <a href="accounts-admins.php" name="formsBTN" class="selected">
                    <i class="bi bi-person-check-fill"></i>
                    <p>Admins</p>
                </a>
            </div>
        </div>
        <div class="content-holder">
            <table id="accountTableEmployee" class="display" style="width:100%">
                <thead>
                    <th>Name</th>
                    <th>Nickname</th>
                    <th>Email</th>
                    <th>type</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        if(!empty($AccountData)) {
                            foreach ($AccountData as $data) {

                                if($data['type'] == "head-administrator"){
                                    echo "<tr>
                                            <td>".$data['admin_fname']." ".$data['admin_lname']."</td>
                                            <td>".$data['account_nickname']."</td>
                                            <td>".$data['email']."</td>
                                            <td>".$data['type']."</td>
                                            <td>
                                                <form action='../../server/account_manipulation.php' method='get'>
                                                    <button class='btn btn-secondary btn-sm' type='button' disabled>NO PERMISSION TO MAKE CHANGES</button>
                                                </form>
                                            </td>
                                        </tr>";

                                } else {
                                    echo "<tr>
                                        <td>".$data['admin_fname']." ".$data['admin_lname']."</td>
                                        <td>".$data['account_nickname']."</td>
                                        <td>".$data['email']."</td>
                                        <td>".$data['type']."</td>
                                        <td>
                                            <form action='../../server/account_manipulation.php' method='get'>
                                                <button class='btn btn-danger btn-sm' name='deleteAdmin' value='".$data['id']."'><i class='bi bi-trash'></i></button>
                                                <button class='btn btn-primary btn-sm' name='removeAdminPermission' value='".$data['id']."'>REMOVE PERMISSION</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            }
                        } else {
                            
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </section>
    <div id="popups"></div>
</body>

<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
    function cancel() {
        window.location.href = 'accounts-admins.php';
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
        xhr.open("GET", "../PHP/ManageAccounts/adminAdd-popup.php?addAdminBTN=", true);
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
<script>
    // JavaScript
    setInterval(function () {
        var typeSelect = document.getElementById('type');
        var departmentSelect = document.getElementById('department');

        // Check if the 'type' element exists
        if (typeSelect) {
            typeSelect.addEventListener('change', function () {
                // Check if "SUPER ADMIN" is selected
                if (this.value === 'super-admin') {
                    // Disable the department select and set its value to an empty string
                    departmentSelect.disabled = true;
                    departmentSelect.value = '';
                    console.log("changed");
                } else {
                    // Enable the department select
                    departmentSelect.disabled = false;
                }
            });
        }
        
        // Initial check for the type value when the script runs
        if (typeSelect.value === 'super-admin') {
            departmentSelect.disabled = true;
            departmentSelect.value = '';
        } else {
            departmentSelect.disabled = false;
        }
    }, 200);
</script>

<?php

    if(isset($_GET['success'])){
        echo '<script>alert("'.$_GET['success'].'")</script>';
    }

?>

</html>