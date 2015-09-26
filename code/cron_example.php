<?php
require_once("PHPEQ/class/PHPEQ.php");

// instantiate the message queue
$queue = new PHPEQ();

// get messages from the queue
$messages = $queue->getEmails();

// iterate messages
foreach ($messages as $message){
    // send email
    mail($message->getToEmail()
        ,$message->getSubject()
        ,$message->getMessagePlainText()
        );
    
    // remove message from the queue by updating is_sent value
    $queue->setMessageIsSent($message);
}