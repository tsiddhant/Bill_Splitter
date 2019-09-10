<?php
    session_start(); 
    require_once "GoogleAPI/vendor/autoload.php";
    
    $gClient = new Google_Client();
    $gClient->setClientId("10730487936-u2n5h6ni4qtibkqcjp0ecb4obd10vi31.apps.googleusercontent.com");
    $gClient->setClientSecret("yA5r4KmdChxVrMZ7VC9Buo-m");
    $gClient->setApplicationName("CPI Login");
    $gClient->setRedirectUri("http://localhost/bill_splitter/g-callback.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");



?>


