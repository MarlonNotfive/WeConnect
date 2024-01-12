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

    //SELECT EMAIL AUTOMATION
        $sql = "SELECT * FROM tbl_emailtemplates WHERE type = 'create_account' LIMIT 1";

        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $id = $row['id'];
                $subject = $row['subject'];
                $body = $row['body'];

            } else {
                echo "No matching row found.";
            }
        } else {
            echo "Error executing the query: " . $conn->error;
        }

        $conn->close();
    //SELECT EMAIL AUTOMATION
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>Email</title>

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
        <link rel="stylesheet" href="../style/admin-css/navigation.css">
        <link rel="stylesheet" href="../style/admin-css/content.css">
        <link rel="stylesheet" href="../style/admin-css/emailTemplates.css">
        <link rel="stylesheet" href="../style/admin-css/dashboard.css">
        <link rel="stylesheet" href="../style/template/template-admin.css">
        <link rel="stylesheet" href="../style/logout.css">
    <!-- css links -->
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
            <a href="content.php" class="">
                <i class="bi bi-images"></i>
                <p>MANAGE CONTENTS</p>
            </a>
            <a href="emailTemplates.php" class="selected">
                <i class="bi bi-envelope-plus"></i>
                <p>EMAIL TEMPLATES</p>
            </a>
        </div>
    </nav>
    <section>
        <div class="title">
            <h1>EMAIL TEMPLATES</h1>
            <a href="../employee/landingPage.php" id="loggedInAcc">
                <div id="online"></div>
                <p><?php echo $_SESSION["username"]?></p>
                <i class="bi bi-back"></i>
            </a>
        </div>
        <div class="content-holder">
            <div class="action-buttons">
            <a href="emailTemplates.php" name=generalBTN class="selected">
                    <i class="bi bi-envelope-arrow-up-fill"></i>
                    <p>Account Creation</p>
                </a>
                <a href="emailTemplates-approval.php" name="formsBTN" class="">
                    <i class="bi bi-envelope-arrow-up-fill"></i>
                    <p>Account Approval</p>
                </a>
                <a href="emailTemplates-deletion.php" name="formsBTN">
                    <i class="bi bi-envelope-arrow-up-fill"></i>
                    <p>Account Deletion</p>
                </a>
                <a href="emailTemplates-settings.php" name="formsBTN">
                    <i class="bi bi-gear-fill"></i>
                    <p>Email Account Settings</p>
                </a>
            </div>
        </div>

        <div class="content-holder">
            <form action="../../server/email_manipulation.php" method="get">
                <div class="input-holder">
                    <p>SUBJECT:</p>
                    <input type="text" name="subject" value="<?php echo $subject?>">
                </div>
                <div class="input-holder">
                    <p>BODY:</p>
                    <textarea name="body" id=""><?php echo $body?></textarea>
                </div>
                <div class="button-holder">
                    <button name="create_account" value="<?php echo $id?>"><i class="bi bi-floppy"></i> SAVE</button>
                </div>
            </form>
        </div>
    </section>
</body>

<script>
    function logout() {
        window.location.href = '../../server/logout_handler.php';
    }
</script>

<?php
    if(isset($_GET['success'])) {
        echo '<script>alert("'.$_GET['success'].'")</script>';
    }
?>

</html>