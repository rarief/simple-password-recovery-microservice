<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Sets the deposit owner.
 *
 * @param array $user The 'user object' array.
 */
$sendPasswordRecoveryMail = function ($userJson) {
  // decode user data
  $user = json_decode($userJson->body, TRUE);

  // populate email parameter
  $to      = $user['email'];
  $subject = 'Password Recovery';
  $message = "Hi " . $user['username'] . ",\r\nThe following is the password for your account:\r\n" . $user['password'] . "\n";
  $headers = 'From: webmaster@example.com' . "\r\n" .
      'Reply-To: webmaster@example.com' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
  
  // send mail
  mail($to, $subject, $message, $headers);

  // debug
  // echo "Hi " . $userJson;
  // echo "Hi ", $user['username'], ",\r\nThe following is the password for your account:\r\n", $user['password'], "\n";
  // sleep(2);
};

// create a connection and a channel
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// declare a queue
$channel->queue_declare('email_recovery', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$channel->basic_consume('email_recovery', '', false, true, false, false, $sendPasswordRecoveryMail);

while (count($channel->callbacks)) {
    $channel->wait();
}

// close channel
$channel->close();
$connection->close();

?>