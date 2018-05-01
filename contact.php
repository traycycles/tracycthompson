<?php
$pageTitle = 'Tracy C. Thompson | Contact';
$section = 'contact';
include 'includes/header.php';
#ini_set("error_reporting", E_ALL);
#ini_set("display_errors", 1);


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $subject = trim(filter_input(INPUT_POST, "subject", FILTER_SANITIZE_SPECIAL_CHARS));
    $message = trim(filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS));

    if($email == "" || $subject == "" || $message == ""){
        $error_message = "Please fill in the required fields: Email, Subject, and Message";
    }
    if(!isset($error_message) && $_POST["contact_me_by_fax_only"] != FALSE){
        header("Location:http://www.google.com");
        exit();
    }
    if(!isset($error_message) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_message = "Invalid Email Address";
    }
    if(!isset($error_message)){
        $body = array('email' => $email, 'subject' => $subject, 'message' => $message);

        header("Location:contact.php?status=thanks");
    }
}
?>
<section>
    <h3>Contact Me</h3>
    <?php if(isset($_GET["status"]) && $_GET["status"] == "thanks"){
        echo"<p>Thanks for the email! I&rsquo;ll get back with you shortly</p>";
        echo  $body;

    }else{
    if(isset($error_message)){
        echo '<p class="error">' . $error_message . '</p>';
    }else{
        echo '<p>I would love to discuss my current projects and what I am learning about now. Please feel free to reach out.  All fields required.</p>';
    }
    ?>
    <form method="post" action="contact.php">
        <table>
            <tr>
                <th><label for="email">Email</label></th>
                <td><input type="text" id="email" name="email" value="<?php if(isset($email)) echo $email;?>"></td>
            </tr>
            <tr>
                <th><label for="subject">Subject</label></th>
                <td><input type="text" id="subject" name="subject" value="<?php if(isset($subject)) echo htmlspecialchars($_POST["subject"]);?>"></td>
            </tr>
            <tr>
                <th><label for="message">Message</label></th>
                <td><textarea id="message" name="message" value="<?php if(isset($message)) echo htmlspecialchars($_POST["message"]);?>"></textarea></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="contact_me_by_fax_only" value="1" style="display: none !important" tabindex="-1" autocomplete="nah" /></td>
            </tr>
        </table>
        <input type="submit" value="send"/>
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
