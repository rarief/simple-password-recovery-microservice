<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 */

include('../config.php');

function sendCurl($url, $post) {
  // create curl resource 
  $ch = curl_init(); 

  // set url 
  curl_setopt($ch, CURLOPT_URL, $url); 

  //return the transfer as a string 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

  // curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  // $output contains the output string 
  $output = curl_exec($ch); 

  // close curl resource to free up system resources 
  curl_close($ch);

  return $output;
}

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'POST':

    // populate data for password recovery
    $post = array(
      'command' => 'password_recovery', 
      'username' => $_POST['username'],
      'password' => $_POST['password']
    );

    $response = sendCurl(AUTH_SERVICE_URL, $post);

    // var_dump($response);
    if($response == 0) {

      // something goes wrong, do something here
      header('Location: ' . WEB_LOGIN_URL . '?sent=2');

    } else {

      // success, do something here
      header('Location: ' . WEB_LOGIN_URL . '?sent=1');

    }

    break;
  default:
    // refuse connection
    header("HTTP/1.0 404 Not Found");
    exit;
}

?>