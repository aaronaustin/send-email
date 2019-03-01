<?php
/*Plugin Name: Send Email
Description: Send email from api.
Version: 1.2.0
License: GPLv2
GitHub Plugin URI: https://github.com/aaronaustin/send-email
*/

function sendMailWithWP (WP_REST_Request $request) {
    $to = get_field('contact_form_to', 'option');
    $name = $request['name'];
    $email = $request['email'];
    $subject = $request['subject'];
    $headers = 'From: '. 'info@lexcentral.com' . "\r\n" . 'Reply-To: ' . $email . "\r\n";
    $message = $request['message'] . "\r\n" . "Message From: " . $name . "<" . $email . ">";
    
    $sent = wp_mail($to, $subject, strip_tags($message));
    
    $status = $sent ? 200 : 404;
    $response_message = $sent ? 'Success' : 'Message did not send';

    $response = array(
        'status' => $status, 
        'message' => $response_message, 
        'request' => $sent,
        'details' => $to
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