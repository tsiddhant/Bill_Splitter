<?php
function sendmail($emailid, $username, $subject, $text)
{
    require 'vendor/autoload.php';
    $API_KEY = "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";
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("test@test.com", "Admin");
    $email->setSubject($subject);
    $email->addTo($emailid, $username);
    $email->addContent("text/html", $text);


    //$proxy = new WebProxy("http://edcguest:3128");
    $sendgrid = new \SendGrid($API_KEY);
    return $sendgrid->send($email);


    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: ' .  $e->getMessage() . "\n";
    }
}
?>