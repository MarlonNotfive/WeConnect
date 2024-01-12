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

    if(isset($_GET['addEventBTN']) && $_SESSION['type']!="co-admin"){
        echo '
            <div class="backdrop">
                <form method="post" action="../../server/content_handler.php" class="form-holder animation-fadeIn" enctype="multipart/form-data">
                    <div class="form-holder-title">
                        <h2><i class="bi bi-plus-circle"></i> ADD NEW EVENT</h2>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="input-holder">
                                <label for="">Event Title:</label>
                                <input type="text" name="eventTitle" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Image:</label>
                                <input type="file" name="eventImg" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Date:</label>
                                <input type="date" name="eventDate" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Time:</label>
                                <input type="time" name="eventTime" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Department:</label>
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
                        </div>
                        <div class="form-col">
                            <div class="input-holder">
                                <label for="">Event Summary:</label>
                                <textarea name="eventSummary" id="" cols="30" rows="3"></textarea>
                            </div>
                            <div class="input-holder">
                                <label for="">Event Description:</label>
                                <textarea name="eventDesc" id="" cols="30" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-button-holder">
                        <button name="addEventBTN">ADD</button>
                        <button type="button" onclick="cancel()" name="cancelBTN">CANCEL</button>
                    </div>
                </form>
            </div>
        ';
    } else {
        echo '
            <div class="backdrop">
                <form method="post" action="../../server/content_handler.php" class="form-holder animation-fadeIn" enctype="multipart/form-data">
                    <div class="form-holder-title">
                        <h2><i class="bi bi-plus-circle"></i> ADD NEW EVENT</h2>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="input-holder">
                                <label for="">Event Title:</label>
                                <input type="text" name="eventTitle" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Image:</label>
                                <input type="file" name="eventImg" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Date:</label>
                                <input type="date" name="eventDate" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Time:</label>
                                <input type="time" name="eventTime" required>
                            </div>
                            <div class="input-holder">
                                <label for="">Department:</label>
                                <select name="department" id="">
                                    '.$permission.'
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="input-holder">
                                <label for="">Event Summary:</label>
                                <textarea name="eventSummary" id="" cols="30" rows="3"></textarea>
                            </div>
                            <div class="input-holder">
                                <label for="">Event Description:</label>
                                <textarea name="eventDesc" id="" cols="30" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-button-holder">
                        <button name="addEventBTN">ADD</button>
                        <button type="button" onclick="cancel()" name="cancelBTN">CANCEL</button>
                    </div>
                </form>
            </div>
        ';
    }
?>

