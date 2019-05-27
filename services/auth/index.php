<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 */

require_once '../vendor/autoload.php';

include('../config.php');
include('../database.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Sets the deposit owner.
 *
 * @param array $database The mock database array.
 * @param string $username The username of the user.
 */
function findUserByUsername($database, $username) {
  // iterate through mock database
  foreach ($database as $row => $row_data) {
    if ($row_data['username'] === $username) {
        // user is found, return user data
        return $row_data;
    }
  }
  // user is not found, return null
  return null;
}

/**
 * Sets the deposit owner.
 *
 * @param array $database The mock database array.
 * @param string $username The username of the user.
 */
function sendToMessageQueue($user) {
  // var_dump($user);
  // create a connection and a channel
  $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
  $channel = $connection->channel();

  // declare a queue, will only be created if not already
  $channel->queue_declare('email_recovery', false, false, false, false);

  // publish message
  $msg = new AMQPMessage(json_encode($user));
  // $msg = new AMQPMessage($user['username']);
  $channel->basic_publish($msg, '', 'email_recovery');

  // echo " [x] Sent recovery request from" . $user['username'] . "\n";

  // close channel
  $channel->close();
  $connection->close();

  return 1;
}

switch ($_POST['command']) {
  case 'login':
    // execute password recovery here

    $user = findUserByUsername($db_user_table, $_POST['username']);

    if(is_null($user)) {
      // user does not exists, do something here
      echo 0;

    } else {
      // user does exists, do something here

      // check password
      if($user == $_POST['password']) {
        // password match
        echo 1;
      } else {
        // password does not match
        echo 0;
      }
    }
  
    break;
  case 'password_recovery':
    // execute password recovery here

    $user = findUserByUsername($db_user_table, $_POST['username']);

    if(is_null($user)) {
      // user does not exists, do something here
      echo 0;

    } else {
      // user does exists, do something here
      $response = sendToMessageQueue($user);
      echo $response;
    }
  
    break;
  default:
    // refuse direct access to service
    header("HTTP/1.0 404 Not Found");
    exit;
}

?>