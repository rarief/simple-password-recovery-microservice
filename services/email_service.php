<?php
/**
 * An email microservice (consumer).
 *
 * This file can be executed individualy, and it will listen to the message queue
 * via the RabbitMQ message broker. Once it retrieved a message, it will send 
 * a recovery email using the sendPasswordRecoveryMail callback.
 *
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


/**
 * Send a recovery email to the user using standard PHP mail() function.
 *
 * @param string $userJson The 'user object' array in a JSON format.
 */
$sendPasswordRecoveryMail = function ($userJson) {
  // decode user data
  $user = json_decode($userJson->body, TRUE);

  // populate email parameter
  $to = $user['email'];
  $subject = 'Password Recovery';
  $message = "Hi " . $user['username'] . ",\r\nThe following is the password for your account:\r\n" . $user['password'] . "\n";
  $headers = 'From: webmaster@example.com' . "\r\n" .
      'Reply-To: webmaster@example.com' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
  
  // send mail
  mail($to, $subject, $message, $headers);
};


/**
 * The 'listening to message broker' part starts here.
 */

// create a connection and a channel
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// declare a queue; queue will only be created if not already
$channel->queue_declare('email_recovery', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

// read message from queue; last parameter is a callback 'sendPasswordRecoveryMail'
$channel->basic_consume('email_recovery', '', false, true, false, false, $sendPasswordRecoveryMail);

while (count($channel->callbacks)) {
    $channel->wait();
}

// close channel
$channel->close();
$connection->close();

?>