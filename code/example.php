<?php
require_once("PHPEQ/class/PHPEQ.php");

// instantiate the message queue
$queue = new PHPEQ();

// create a new PHPEQMessage object
$new_message = new PHPEQMessage();
$new_message->setFromEmail('from@email.com');
$new_message->setFromName('SENDER NAME');
$new_message->setToEmail('to@email.com');
$new_message->setToName('RECIPIENT NAME');
$new_message->setSubject('test subject');
$new_message->setMessageHtml('<b>TEST MESSAGE</b>');
$new_message->setMessagePlainText('TEST MESSAGE');
$new_message->setHeaders(array()); // optional
$new_message->setCategory('category 1'); // optional

// add message to queue
$queue->addMessage($new_message);