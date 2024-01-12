<?php
    // EDIT/VIEW EMPLOYEE APPLICATION
        if(isset($_GET['empEdit'])) {
            $sql2 = "SELECT * FROM tbl_accounts WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt, "i", $_GET['empEdit']);
            mysqli_stmt_execute($stmt);
            $result2 = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result2) === 1) {
                $employee = mysqli_fetch_assoc($result2);

            } else {
                echo "error";
            }
        }
    // EDIT/VIEW EMPLOYEE APPLICATION   

    if(isset($_GET['empEdit'])){
        $firstName = strtoupper($employee['account_firstName']);
        $lastName = strtoupper($employee['account_lastName']);
        $finitial = substr($firstName, 0, 1);
        $linitial = substr($lastName, 0, 1);

        $initials = $finitial.$linitial;

        echo '
                <form action="../../server/account_manipulation.php" method="GET" class="backdrop">
                    <div class="empEdit-form-holder animation-fadeIn">
                        <div class="empEdit-form-title"><i class="bi bi-pencil"></i> EDIT EMPLOYEE INFORMATION</div>
                        <img src="'.$employee['account_img'].'" alt="'.$initials.'">
                        <div class="empEdit-form-inputs">
                            <div class="empEdit-form-inputs-cols">
                                <div class="empEdit-form-input-holder">
                                    <label for="">FIRST NAME:</label>
                                    <input type="text" name="" value="'.$employee['account_firstName'].'" disabled>
                                    <input type="hidden" name="fname" value="'.$employee['account_firstName'].'">
                                </div>
                                <div class="empEdit-form-input-holder">
                                    <label for="">LAST NAME:</label>
                                    <input type="text" name="" value="'.$employee['account_lastName'].'" disabled>
                                    <input type="hidden" name="lname" value="'.$employee['account_lastName'].'">
                                </div>
                                <div class="empEdit-form-input-holder">
                                    <label for="">NICKNAME:</label>
                                    <input type="text" name="nickname" value="'.$employee['account_nickname'].'">
                                </div>
                            </div>
                            <div class="empEdit-form-inputs-cols">
                                <div class="empEdit-form-input-holder">
                                    <label for="">HIRE DATE:</label>
                                    <input type="date" name="hireDate" value="'.$employee['account_hireDate'].'">
                                </div>
                                <div class="empEdit-form-input-holder">
                                    <label for="">GROUP:</label>
                                    <select name="group" id="">
                                        <option value="unset" ' . ($employee['account_department'] === "unset" ? 'selected' : '') . '>NOT SET</option>
                                        <option value="it_ops" ' . ($employee['account_department'] === "it_ops" ? 'selected' : '') . '>IT & OPS</option>
                                        <option value="bdg" ' . ($employee['account_department'] === "bdg" ? 'selected' : '') . '>BDG</option>
                                        <option value="marketing" ' . ($employee['account_department'] === "marketing" ? 'selected' : '') . '>MARKETING</option>
                                        <option value="finance" ' . ($employee['account_department'] === "finance" ? 'selected' : '') . '>FINANCE</option>
                                        <option value="admin" ' . ($employee['account_department'] === "admin" ? 'selected' : '') . '>ADMIN</option>
                                        <option value="hr" ' . ($employee['account_department'] === "hr" ? 'selected' : '') . '>HR</option>
                                        <option value="amg" ' . ($employee['account_department'] === "amg" ? 'selected' : '') . '>AMG</option>
                                        <option value="cs" ' . ($employee['account_department'] === "cs" ? 'selected' : '') . '>CS</option>
                                        <option value="sdg" ' . ($employee['account_department'] === "sdg" ? 'selected' : '') . '>SDG</option>
                                        <option value="corp" ' . ($employee['account_department'] === "corp" ? 'selected' : '') . '>CORP</option>
                                    </select>
                                </div>
                                <div class="empEdit-form-input-holder">
                                    <label for="">TYPE:</label>
                                    <input type="hidden" name="state" value="'.$employee['account_state'].'">
                                    <input type="hidden" name="email" value="'.$employee['account_email'].'">
                                    <input type="hidden" name="token" value="'.$employee['token'].'">
                                    <input type="hidden" name="account_img" value="'.$employee['account_img'].'">
                                    <select name="type" id="">
                                        <option value="employee" selected>Employee</option>
                                        <option value="co-admin">Co-admin</option>
                                        <option value="super-admin">Super-admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="empEdit-form-footer">
                            <button class="saveBTN" name="saveEditBTN" value="'.$employee["id"].'">SAVE</button>
                            <button class="cancelBTN" name="cancel">CANCEL</button>
                        </div>
                    </div>
                </form>
            ';
    }

?>
