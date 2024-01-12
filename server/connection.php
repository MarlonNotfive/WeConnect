<?php  
    require_once 'googleAuth/vendor/autoload.php';
    
    // init configuration
    $clientID = '612864481294-vs1n9j30pbqgu3omrq6dlps2s4d1m1js.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri = 'https://localhost/project/server/gmailAuthProcess.php';
    //$redirectUri = 'http://wtiportal.webcast-inc.com.ph/project/server/gmailAuthProcess.php';
    
    // create Client Request to access Google API
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else
?>
