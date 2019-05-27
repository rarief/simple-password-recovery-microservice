<?php
/**
 * An API gateway for password recovery.
 *
 * This part will receive a request for password recovery, and forward
 * the request to the respective service using cURL.
 *
 */

include('../config.php');


/**
 * Send HTTP request using cURL.
 *
 * @param string $url URL of the service.
 * @param array $post Associative array consisting command and username.
 * 
 * @return string A response from the service. 
 */
function sendCurl($url, $post) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  $output = curl_exec($ch);
  curl_close($ch);

  return $output;
}


/**
 * Basic input validation for security.
 *
 * @param string $input Input string.
 * 
 * @return string Cleansed input string. 
 */
function cleanseInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}


/**
 * The 'listening for the command' part starts here.
 * Retrieve the HTTP method and the command.
 */
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'POST':
    // populate data for password recovery
    $post = array(
      'command' => 'password_recovery', 
      'username' => cleanseInput($_POST['username'])
    );

    // send HTTP request to service
    $response = sendCurl(AUTH_SERVICE_URL, $post);

    if($response == 0) {
      // something goes wrong, send failure notification to client
      header('Location: ' . WEB_FORGOT_PASS_URL . '?sent=2');

    } else {
      // success, send success notification to client
      header('Location: ' . WEB_FORGOT_PASS_URL . '?sent=1');
    }
    break;

  default:
    // refuse direct access to the API
    header("HTTP/1.0 404 Not Found");
    exit;
}

?>