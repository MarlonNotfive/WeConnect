<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <!-- css links -->
        <link rel="stylesheet" href="style/root.css">
        <link rel="stylesheet" href="style/registration.css">
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
            <h1><i class="fa-solid fa-user-plus" id="header-icon"></i> REGISTRATION</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="error-box">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p class="error-text"></p>
                </div>
                <div class="input-holder-double">
                    <input type="text" name="fname" placeholder="Firstname" required>
                    <input type="text" name="lname" placeholder="Lastname" required>
                </div>
                <div class="input-holder">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-holder-double">
                    <input type="text" name="nickname" placeholder="Nickname" required>
                    <input 
                        type="hidden" 
                        name="bday" 
                        placeholder="Birthdate" 
                        onfocus="this.type='date'" 
                        onblur="this.type='text'"
                        value = " "; 
                        required>
                </div>
                <div class="input-holder-double">
                    <input type="text" name="email" placeholder="Email" required>
                    <input 
                        type="hidden" 
                        name="hireDate" 
                        placeholder="Hired Date" 
                        onfocus="this.type='date'" 
                        onblur="this.type='text'"
                        value=" ";
                        required>
                </div>
                <div class="input-holder">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-holder department">
                    <div class="col">
                        <label for="">GROUP</label>
                        <select name="department" id="">
                            <option value="it_ops">IT AND OPS</option>
                            <option value="bdg">BDG</option>
                            <option value="marketing">MARKETING</option>
                            <option value="finance">FINANCE</option>
                            <option value="admin">ADMIN</option>
                            <option value="hr">HR</option>
                            <option value="amg">AMG</option>
                            <option value="cs">CS</option>
                            <option value="sdg">SDG</option>
                            <option value="corp">CORP</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="">Profile Picture</label>
                        <input type="file" name="img">
                    </div>
                </div>
                <div class="button-holder">
                    <button type="submit" class="btn-register">REGISTER</button>
                    <a href="login.php">SIGN IN</a>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="javascript/signup.js"></script>

</html>