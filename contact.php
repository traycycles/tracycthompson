<?php
$pageTitle = 'Tracy C. Thompson | Contact';
$section = 'contact';
include 'includes/header.php';
#ini_set("error_reporting", E_ALL);
#ini_set("display_errors", 1);

$email = $subject= $message= "";
$emailErr= $subjectErr= $messageErr= "";
$honey = FALSE;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        //check for email well-formed
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
        }
    }
    if (empty($_POST["subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $subject = test_input($_POST["subject"]);
        //check for letters and white spaces
        if(!preg_match("/^[a-zA-Z ]*$/",$subject)){
            $subjectErr = "Only letters and white space allowed";
        }
    }
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }
    if(!empty($_POST["contact_me_by_fax_only"]) && (bool) $_POST["contact_me_by_fax_only"] == TRUE){
        $honey = TRUE;
        header("Location:https//www.google.com");
        exit();
    }
    $body = array('email' => $email, 'subject' => $subject, 'message' => $message);
    header("Location:contact.php?status=thanks");
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
    <?php
    if(isset($_GET["status"]) && $_GET["status"]=="thanks"){
        echo "<br><br>Email sent!  Thanks and I'll get right back with you";
    }else{
        ?>
        <p>I'd love to discuss my current projects and what I am learning about now. Please feel free to reach out.<br>
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
            <input type="checkbox" name="contact_me_by_fax_only" value="1" style="display: none !important" tabindex="-1" autocomplete="nope">
            <input type="submit" value="send">
        </form>
    </section>
    <?php
    include 'includes/connecttoaws.php';

    // Aws sdk parameter
    try {
        $result = $client->sendEmail([
            'Destination' => [
                'ToAddresses' => ['traymarkthompson@gmail.com']
            ],
            'Message' => [
                'Body' => [
                    'Text' => [
                        'Charset' => 'UTF-8',
                        'Data' => $body['message']
                    ],
                ],
                'Subject' => [
                    'Charset' => 'UTF-8',
                    'Data' => $body['subject']
                ],
            ],
            'Source' => 'traymarkthompson@gmail.com'
        ]);
        $messageId = $result->get('MessageId');

    }catch (SesException $error) {
        echo("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "</br>");
    }
}
include 'includes/footer.php' ?>
