<?php

    if(isset($_GET['addAdminBTN'])){
        $firstName = strtoupper($employee['account_firstName']);
        $lastName = strtoupper($employee['account_lastName']);
        $finitial = substr($firstName, 0, 1);
        $linitial = substr($lastName, 0, 1);

        $initials = $finitial.$linitial;

        echo '
                <form action="../../server/account_manipulation.php" method="GET" class="backdrop">
                    <div class="empEdit-form-holder admin animation-fadeIn">
                        <div class="empEdit-form-title"><i class="bi bi-plus-circle"></i> ADD NEW ADMINISTRATOR</div>
                        <div class="empEdit-form-inputs">
                            <div class="empEdit-form-inputs-cols">
                                <div class="empEdit-form-input-holder">
                                    <label for="">EMAIL:</label>
                                    <input type="text" name="email" value="'.$employee['account_firstName'].'">
                                </div>
                                <div class="empEdit-form-input-holder">
                                    <label for="">NICKNAME:</label>
                                    <input type="text" name="username" value="'.$employee['username'].'">
                                </div>
                            </div>
                            <div class="empEdit-form-inputs-cols">
                                <div class="empEdit-form-input-holder">
                                    <label for="type">TYPE:</label>
                                    <select name="type" id="type">
                                        <option value="co-admin">CO-ADMIN</option>
                                        <option value="super-admin">SUPER ADMIN</option>
                                    </select>
                                </div>
                                <div class="empEdit-form-input-holder">
                                    <label for="department">Department:</label>
                                    <select name="department" id="department">
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
                        </div>
                        <div class="empEdit-form-footer">
                            <button class="saveBTN" name="addAdmin" value="'.$employee["id"].'">SAVE</button>
                            <button class="cancelBTN" type="button" onclick="cancel()">CANCEL</button>
                        </div>
                    </div>
                </form>
            ';
    }

?>
