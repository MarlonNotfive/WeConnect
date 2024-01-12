<?php
    // include database connection
        $config = parse_ini_file('../../config.conf', true);
        include('../../server/connection.php');
    // include database connection

    // START SESSION
        session_start();
    // START SESSION

    // TBL FORM = id REQUEST
        if(isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $sql = "SELECT * FROM tbl_forms WHERE form_id = $id";

            $result = $conn->query($sql);

            if ($result) {
                // Fetch the single result
                $row = $result->fetch_assoc();
            
                if ($row) {
                    $formTitle = $row['form_title'];
                    $formLink = $row['form_link'];
                    $department = $row['form_department'];

                } else {
                    echo "No data found for id = 1";
                }
            } else {
                echo "Error executing the query: " . $conn->error;
            }
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
        <link rel="stylesheet" href="../style/admin-css/content-edit.css">
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
            <h1>MANAGE CONTENT / EDIT FORM</h1>
            <a href="../employee/landingPage.php" id="loggedInAcc">
                <div id="online"></div>
                <p><?php echo $_SESSION["username"]?></p>
                <i class="bi bi-back"></i>
            </a>
        </div>

        <div class="content-holder">
            <a href="content-forms.php" class="backBTN">
                <i class="bi bi-arrow-left-circle"></i>
                <p>BACK</p>
            </a>
        </div>

        <div class="content-holder">
            <form action="../../server/content_handler.php" method="get" class="animation-fadeIn">
                <div class="input-holder">
                    <label for="">Form Title:</label>
                    <input type="text" name="formTitle" value="<?php echo $formTitle?>">
                </div>
                <div class="input-holder">
                    <label for="">Form Link:</label>
                    <input type="text" name="link" value="<?php echo $formLink?>">
                </div>
                <div class="input-holder">
                    <label for="">Form Group:</label>
                    <select name="department" id="">
                        <option value="it_ops" <?php echo ($department === "it_ops" ? 'selected' : '') ?>>IT & OPS</option>
                        <option value="bdg" <?php echo ($department === "bdg" ? 'selected' : '') ?>>BDG</option>
                        <option value="marketing" <?php echo ($department === "marketing" ? 'selected' : '') ?>>MARKETING</option>
                        <option value="finance" <?php echo ($department === "finance" ? 'selected' : '') ?>>FINANCE</option>
                        <option value="admin" <?php echo ($department === "admin" ? 'selected' : '') ?>>ADMIN</option>
                        <option value="hr" <?php echo ($department === "hr" ? 'selected' : '') ?>>HR</option>
                        <option value="amg" <?php echo ($department === "amg" ? 'selected' : '') ?>>AMG</option>
                        <option value="cs" <?php echo ($department === "cs" ? 'selected' : '') ?>>CS</option>
                        <option value="sdg" <?php echo ($department === "sdg" ? 'selected' : '') ?>>SDG</option>
                        <option value="corp" <?php echo ($department === "corp" ? 'selected' : '') ?>>CORP</option>
                    </select>
                </div>
                <div class="button-holder">
                    <button name="editFormBTN" value="<?php echo $id?>" ><i class="bi bi-floppy"></i></button>
                    <a href="content-forms.php">BACK</a>
                </div>
            </form>
        </div>
    </section>   

    <div id="popups"></div>
</body>


<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
    function cancel() {
        window.location.href = 'content-forms.php';
    }
</script>


</html>