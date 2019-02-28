<?php
/*Plugin Name: Send Email
Description: Send email from api.
Version: 1.1.4
License: GPLv2
GitHub Plugin URI: https://github.com/aaronaustin/send-email
*/

// function sendWithPhpMailer($subject, $body, $reply) {
//     require(ABSPATH . WPINC . '/class-phpmailer.php');
//     require(ABSPATH . WPINC . '/class-smtp.php');
//     // date_default_timezone_set( 'America/Sao_Paulo' );
//     $blogname = wp_strip_all_tags( trim( get_option( 'blogname' ) ) );
//     $smtpHost = wp_strip_all_tags( trim( get_option( 'smtp_host' ) ) );
//     $mailPort = wp_strip_all_tags( trim( get_option( 'smtp_port' ) ) );
//     $smtpUser = wp_strip_all_tags( trim( get_option( 'smtp_user' ) ) );
//     $smtpPass = wp_strip_all_tags( trim( get_option( 'smtp_pass' ) ) );
//     $mailTo = wp_strip_all_tags( trim( get_option( 'mail_to' ) ) );
//     $send = false;
//     $mail = new PHPMailer;
//     try {
//         $mail->IsSMTP();
//         $mail->SMTPDebug = 0;
//         $mail->Sender = $smtpUser;
//         $mail->CharSet = 'utf-8';
//         $mail->SMTPSecure = 'tls';
//         $mail->SMTPAuth = true;
//         $mail->Port = $mailPort;
//         $mail->Host = $smtpHost;
//         $mail->Username = $smtpUser;
//         $mail->Password = $smtpPass;
//         $mail->Subject = $subject;
//         $mail->From = $smtpUser;
//         $mail->setFrom($smtpUser, $blogname);
//         $mail->addReplyTo($reply);
//         $mail->addAddress($mailTo);
//         // Attachments
//         // $mail->addAttachment('/var/tmp/file.tar.gz');
//         $mail->isHTML(true);
//         $mail->Body = $body;
//         $send = $mail->Send();
//         $mail->ClearAllRecipients();
//     } catch (Exception $e) {
//         echo "Message could not be sent. Mailer Error: $mail->ErrorInfo \n";
//         echo "Error: $e";
//         return false;
//     }
//     return $send;
// }
// function sendContactMail() {
//     $response = array(
//         'status' => 304,
//         'message' => 'There was an error sending the form.'
//     );
//     $parameters = $request->get_json_params();
//     if ( count($_POST) > 0 ) {
//         $parameters = $_POST;
//     }
//     $contactName = wp_strip_all_tags( trim( $parameters['contact_name'] ) );
//     $contactEmail = wp_strip_all_tags( trim( $parameters['contact_email'] ) );
//     $contactMessage = wp_strip_all_tags( trim( $parameters['contact_message'] ) );
//     if ( !empty($contactName) && !empty($contactEmail) && !empty($contactMessage) ) {
//         $subject = "(New message sent from site $blogname) $contactName <$contactEmail>";
//         $body = "<h3>$subject</h3><br/>";
//         $body .= "<p><b>Name:</b> $contactName</p>";
//         $body .= "<p><b>Email:</b> $contactEmail</p>";
//         $body .= "<p><b>Message:</b> $contactMessage</p>";
//         if ( sendWithPhpMailer( $subject, $body, $contactEmail ) ) {
//             $response['status'] = 200;
//             $response['message'] = 'Form sent successfully.';
//         }
//     }
//     return json_decode( json_encode( $response ) );
//     exit();
// }
function sendMailWithWP (WP_REST_Request $request) {
    // $request;
    $sent = wp_mail($request['to'], $request['subject'], strip_tags($request['message']));
    // // if($sent) echo 'success'; //message sent!
    // // else echo 'failed'; //message wasn't sent
    $response = array(
        'status' => 200, 
        'message' => 'working', 
        'request' => $request['message'],
    );
    return json_encode($response);
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'sendform/v1', '/send', array(
        'methods' => 'POST',
        'callback' => 'sendMailWithWP'
    ));
});

?>