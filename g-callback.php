<?php include "db.php"; ?>
<?php session_start(); ?>
<?php
    require_once "config.php";
    
    if(isset($_SESSION['access_token']))
    $gClient->setAccessToken($_SESSION['access_token']);

   else if(isset($_GET['code'])){
   $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
   $_SESSION['access_token'] = $token;

}

else{
    header('Location: login.php');
}


   

    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();

    $email = $userData['email'];
    $name = $userData['name'];

    // echo "<pre>";
    // var_dump($userData);

   

?>


