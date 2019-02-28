<?php
/*Plugin Name: Send Email
Description: Send email from api.
Version: 1.1.7
License: GPLv2
GitHub Plugin URI: https://github.com/aaronaustin/send-email
*/

function sendMailWithWP (WP_REST_Request $request) {
    $sent = wp_mail($request['to'], $request['subject'], strip_tags($request['message']));

    $status = $sent ? 200 : 404;
    $response_message = $sent ? 'Success' : 'Message did not send';

    $response = array(
        'status' => $status, 
        'message' => $response_message, 
        'request' => $sent
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