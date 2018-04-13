<?php
/**
 * Created by PhpStorm.
 * User: tracy
 * Date: 4/10/2018
 * Time: 10:06 AM
 */
include 'includes/header.php';
#ini_set("error_reporting", E_ALL);
#ini_set("display_errors", 1);

$email = $subject= $message= "";
$emailErr= $subjectErr= $messageErr= "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
    }
    if (empty($_POST["subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $subject = test_input($_POST["subject"]);
    }
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }
    $body = array('email' => $email, 'subject' => $subject, 'message' => $message);

}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

#print_r($body['message']);
?>

<section>
    <h3>Contact Me</h3>
    <p>I'd love to discuss my current projects and what I am learning about now.  Please feel free to reach out.<br>
        <span class="error">* All fields required</span></p>

    <form id="contactForm" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        Email: <input type="email" name="email">
        <span class="error">*<?= $emailErr ?></span>
        <br><br>
        Subject: <input type="text" name="subject">
        <span class="error">*<?= $subjectErr ?></span>
        <br><br>
        Message:<br> <textarea rows="10" cols="100" name="message" form="contactForm"></textarea>
        <span class="error">*<?= $messageErr ?></span>
        <br><br>
        <input type="submit" value="send">
    </form></section>
<?php
include 'includes/connecttoaws.php';

// Aws sdk parameter
$result = $client->sendEmail([
    'Destination' => [
        'ToAddresses' =>['traymarkthompson@gmail.com']
    ],
    'Message' => [
        'Body'=>[
            'Text' =>[
                'Charset' =>'UTF-8',
                'Data' => $body['message']
            ],
        ],
        'Subject' =>[
            'Charset' =>'UTF-8',
            'Data' => $body['subject']
        ],
    ],
    'Source' => 'traymarkthompson@gmail.com'
]);


include 'includes/footer.php' ?>
