<?php
/**
 * The event producer for authentication.
 *
 * It receives a POST command and a POST user data. The database is accessed 
 * in this file. Based on the command, it decides what to do. There are two 
 * commands: login and password recovery.
 * 
 * The 'login' command simply validate the username and the password.
 * 
 * The 'password_recovery' command will be executed asyncronously using the
 * RabbitMQ message queue. 
 *
 */

require_once '../vendor/autoload.php';

include('../config.php');
include('../database.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


/**
 * Search for username.
 *
 * @param array $database The mock database array.
 * @param string $username The username of the user.
 * 
 * @return array|null an array of user data. It returns null if 
*                     no matcing username is found.
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
 * 
 * @return int return '1' if the process is finished.
 */
function sendToMessageQueue($user) {
  // create a connection and a channel
  $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
  $channel = $connection->channel();

  // declare a queue; queue will only be created if not already
  $channel->queue_declare('email_recovery', false, false, false, false);

  // publish message to queue
  $msg = new AMQPMessage(json_encode($user));
  $channel->basic_publish($msg, '', 'email_recovery');

  // close channel
  $channel->close();
  $connection->close();

  return 1;
}


/**
 * The 'listening for the command' part starts here.
 */
switch ($_POST['command']) {
  // Login command
  case 'login':
    // execute password recovery here
    $user = findUserByUsername($db_user_table, $_POST['username']);

    if(is_null($user)) {      
      // user does not exists, return '0'
      echo 0;

    } else {
      // user does exists, check password
      if(!empty($_POST['password']) && $user['password'] == $_POST['password']) {
        // password match
        echo 1;

      } else {
        // password does not match
        echo 0;

      }
    }
    break;

  // Password recovery command
  case 'password_recovery':
    // execute password recovery here
    $user = findUserByUsername($db_user_table, $_POST['username']);

    if(is_null($user)) {
      // user does not exists, return '0'
      echo 0;

    } else {
      // user does exists, send message to broker
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