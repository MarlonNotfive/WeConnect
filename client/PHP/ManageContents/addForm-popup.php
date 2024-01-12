<?php
    // include database connection
        $config = parse_ini_file('../../../config.conf', true);
        include('../../../server/connection.php');
    // include database connection

    // START SESSION
        session_start();
    // START SESSION

    // DEPT RENDER
        if($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'it_ops'){
            $permission = '<option value="it_ops">IT AND OPS</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'bdg'){
            $permission = '<option value="bdg">BDG</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'marketing'){
            $permission = '<option value="marketing">MARKETING</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'finance'){
            $permission = '<option value="finance">FINANCE</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'admin'){
            $permission = '<option value="admin">ADMIN</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'hr'){
            $permission = '<option value="hr">HR</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'amg'){
            $permission = '<option value="amg">AMG</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'cs'){
            $permission = '<option value="cs">CS</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'sdg'){
            $permission = '<option value="sdg">SDG</option>';
        }elseif($_SESSION['type']=="co-admin" && $_SESSION['dept'] == 'corp'){
            $permission = '<option value="corp">CORP</option>';
        }
    // DEPT RENDER

    if(isset($_GET['addFormBTN']) && $_SESSION['type']!="co-admin"){
        echo '
            <div class="backdrop">
                <form method="get" action="../../server/content_handler.php" class="form-holder animation-fadeIn">
                    <div class="form-holder-title">
                        <h2><i class="bi bi-plus-circle"></i> ADD NEW FORM</h2>
                    </div>
                    <div class="input-holder">
                        <label for="">Form Title:</label>
                        <input type="text" name="formTitle" required>
                    </div>
                    <div class="input-holder">
                        <label for="">Link:</label>
                        <input type="text" name="link" required>
                    </div>
                    <div class="input-holder">
                        <label for="">Group:</label>
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
                    <div class="form-button-holder">
                        <button name="addFormBTN">ADD</button>
                        <button type="button" onclick="cancel()" name="cancelBTN">CANCEL</button>
                    </div>
                </form>
            </div>
        ';
    } else {
        echo '
            <div class="backdrop">
                <form method="get" action="../../server/content_handler.php" class="form-holder animation-fadeIn">
                    <div class="form-holder-title">
                        <h2><i class="bi bi-plus-circle"></i> ADD NEW FORM</h2>
                    </div>
                    <div class="input-holder">
                        <label for="">Form Title:</label>
                        <input type="text" name="formTitle" required>
                    </div>
                    <div class="input-holder">
                        <label for="">Link:</label>
                        <input type="text" name="link" required>
                    </div>
                    <div class="input-holder">
                        <label for="">Group:</label>
                        <select name="department" id="">
                            '.$permission.'
                        </select>
                    </div>
                    <div class="form-button-holder">
                        <button name="addFormBTN">ADD</button>
                        <button type="button" onclick="cancel()" name="cancelBTN">CANCEL</button>
                    </div>
                </form>
            </div>
        ';
    }
?>