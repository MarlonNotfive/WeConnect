<?php
    require_once '../server/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://webcast-inc.com.ph/wp-content/uploads/2023/03/WTI-Favicon-1-150x150.png">
    <title>Login Page</title>

    <!-- css links -->
        <link rel="stylesheet" href="style/root.css">
        <link rel="stylesheet" href="style/login.css">
        <link rel="stylesheet" href="style/animation.css">
    <!-- css links -->

    <!-- Bootstrap links -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap links -->

    <!-- Bootstrap links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap links -->

    <!-- SCRIPTS -->
        <script src="javascript/transitions.js" defer></script>
    <!-- SCRIPTS -->

</head>
<body>
    <div class="holder">
        <div class="wallpaper">
        </div>
        <div class="login-holder animation-fadeIn">
        
        <?php 
            if(isset($_GET['error'])){
                echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>WARNING: </strong> '.$_GET['error'].'
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

            <h1>WELCOME BACK</h1>
            <form action="../server/account_checker.php" method="post">
                <img class="logo" src="https://webcast-inc.com.ph/wp-content/uploads/elementor/thumbs/WTI-Logo-Big-2-q6c2ojgi1iohj74afxqzqij39pxfdt3dyl90xpqj28.png" alt="">
                <div class="seperator">
                    <div class="line"></div>
                    <p>SIGN IN TO WECONNECT</p>
                    <div class="line"></div>
                </div>
                <?php
                  echo "<a class='google-signin-btn' href='" . $client->createAuthUrl() . "'>
                            <img src='assets/google.png' alt=''>
                            <p>Google Login</p>
                        </a>";
                ?>
                <div class="seperator">
                    <div class="line"></div>
                    <p>USE WEBCAST EMAIL</p>
                    <div class="line"></div>
                </div>

            </form>
        </div>
    </div>
</body>


</html>