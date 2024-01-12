<?php
    // SESSION START
        session_start();
    // SESSION START
    // include database connection
        $config = parse_ini_file('../config.conf', true);
        include('connection.php');
    // include database connection
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $token = $_SESSION['user_token'];

        if($_SESSION['type'] == 'employee'){
            $sql = "SELECT * FROM tbl_accounts WHERE token = '$token'";
            $table = "tbl_accounts";
        } else {
            $sql = "SELECT * FROM tbl_admins WHERE token = '$token'";
            $table = "tbl_admins";
        }
        
        $result = $conn->query($sql);

        if($result) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
        } else {

        }

        if(isset($_POST['nickname']) && strlen($_POST['nickname']) > 0){
            $nickname = $_POST['nickname'];

            $sqlUpdate = "UPDATE ". $table ." SET account_nickname = '$nickname' WHERE id = '$id'";

            if ($conn->query($sqlUpdate) === TRUE) {
                $_SESSION['username'] = $nickname;
                echo "SUCCESS: Nickname change successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }

        } else {    
            echo "ERROR: Nickname Field is Required";
        }
        
    } else {
        http_response_code(405); // Method Not Allowed
        echo "Invalid request method.";
    }
?>



<?php
    
?>