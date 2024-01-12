<?php
require_once 'connection.php';
session_start();

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo = [
  'email' => $google_account_info['email'],
  'first_name' => $google_account_info['givenName'],
  'last_name' => $google_account_info['familyName'],
  'gender' => $google_account_info['gender'],
  'full_name' => $google_account_info['name'],
  'picture' => $google_account_info['picture'],
  'verifiedEmail' => $google_account_info['verifiedEmail'],
  'token' => $google_account_info['id'],
  ];

  //get admin emails
  $sqlAdmin = "SELECT * FROM tbl_admins";
  $resultAdmin = mysqli_query($conn, $sqlAdmin);

  $emailIsAdmin = false;

  if ($resultAdmin) {

    // Fetch the data
    while ($row = $resultAdmin->fetch_assoc()) {
        $admins[] = $row;

        if($row['email'] == $userinfo['email']){
          $emailIsAdmin = true;
        }
    }
    
  } else {
      echo "Error executing the query: " . $conn->error;
  }

  // checking if user is already exists in database


  if($emailIsAdmin){
    $sqlCheckUser = "SELECT * FROM tbl_admins WHERE email ='{$userinfo['email']}'";
    $resultCheckUser = mysqli_query($conn, $sqlCheckUser);

    if (mysqli_num_rows($resultCheckUser) > 0) {
        while ($row = $resultCheckUser->fetch_assoc()) {
          $type = $row['type'];
          
          if(strlen($row['account_nickname'])<1){
            $username = $userinfo['first_name'];
          } else {
            $username = $row['account_nickname'];
          }

        }

        // User exists, update the record
        $sqlUpdate = "UPDATE tbl_admins SET
                      admin_fname = '{$userinfo['first_name']}',
                      admin_lname = '{$userinfo['last_name']}',
                      account_nickname = '{$username}',
                      account_img = '{$userinfo['picture']}',
                      token = '{$userinfo['token']}'
                      WHERE email = '{$userinfo['email']}'";
    
        $resultUpdate = mysqli_query($conn, $sqlUpdate);
    
        if ($resultUpdate) {
            $_SESSION['user_token'] = $userinfo['token'];
            $_SESSION['type'] = $type;
            $_SESSION['username'] = $username;

        } else {
            echo "Failed to update user.";

        }
    }
    

  } else if(strpos($userinfo['email'], "@findme.com.ph") != false) { // checking if user is webcast
      $sql = "SELECT * FROM tbl_accounts WHERE account_email ='{$userinfo['email']}'";
      $result = mysqli_query($conn, $sql);
      
      if (mysqli_num_rows($result) > 0) {
          // user is exists
          $employeeData = $result->fetch_assoc();
          $state = $employeeData['account_state'];

          $sqlUpdate = "UPDATE tbl_accounts SET
                        account_firstName = '{$userinfo['first_name']}',
                        account_lastName = '{$userinfo['last_name']}',
                        account_img = '{$userinfo['picture']}',
                        token = '{$userinfo['token']}'
                        WHERE account_email = '{$userinfo['email']}'";

          $resultUpdate = mysqli_query($conn, $sqlUpdate);

          if ($resultUpdate) {
              $_SESSION['user_token'] = $userinfo['token'];
              $_SESSION['type'] = "employee";
              $_SESSION['state'] = $state;
          } else {

          }
      } else {
          $accountState = "pending";
          // user is not exists
          $sql = "INSERT INTO tbl_accounts (account_email, account_firstName, account_lastName , account_nickname, account_img, token, account_state) 
                  VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['first_name']}', '{$userinfo['picture']}', '{$userinfo['token']}', '{$accountState}')";
          $result = mysqli_query($conn, $sql);

          if ($result) {
            header("location: ../client/login.php?success=Your request has been submitted successfully. Kindly await approval. Thank you for your patience.");
            die();
            $_SESSION['user_token'] = $userinfo['token'];
            $_SESSION['type'] = "employee";
            $_SESSION['state'] = $accountState;
          } else {
            
          }
      }
  } else {
    header("location: ../client/login.php?error=You're outside this organization!");
    die();
  }


  //SUCCESSFUL LOGIN
  if( isset($_SESSION['user_token']) && isset($_SESSION['type']) ){
    header('location: ../client/employee/landingPage.php');
    // echo $_SESSION['user_token'] ."</br>";
    // echo $_SESSION['type'] ."</br>";
    // if($emailIsAdmin){
    //   echo "true";
    // } else {
    //   echo "false";
    // }

  }

} else {
    if (!isset($_SESSION['user_token'])) {
        header("Location: index.php");
        die();
    }

    // checking if user is already exists in database
    $sql = "SELECT * FROM tbl_accounts WHERE token ='{$_SESSION['user_token']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // user is exists
        $userinfo = mysqli_fetch_assoc($result);
    }
}

?>
