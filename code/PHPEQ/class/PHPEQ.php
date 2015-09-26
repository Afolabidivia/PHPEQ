<?php
/**
 * @author Ovunc Tukenmez <ovunct@live.com>
 *
 * This class is used to save "emails to send" to the MYSQL database.
 * To get emails from the queue, getEmails() method can be used. This method will return an array of PHPEQMessage objects. (please check PHPEQMessage class to see its methods)
 * After the email sent, setMessageIsSent() method should be called to remove email from the queue.
 */
require_once(dirname(__FILE__) . '/config-emailqueue.php');
require_once(dirname(__FILE__) . "/PHPEQMessage.php");

class PHPEQ
{
    private $_conn;
    private $_db_host;
    private $_db_name;
    private $_db_username;
    private $_db_password;
    private $_driver_options;
    private $_last_error_msg;
    private $_table_name = 'email_queue_emails';

    /**
     * @param       $db_host database host
     * @param       $db_name database name
     * @param       $db_username database user name
     * @param       $db_password database user password
     * @param array $driver_options PDO driver options
     */
    public function __construct(
        $db_host = CONN_HOST,
        $db_name = CONN_DATABASE,
        $db_username = CONN_USER,
        $db_password = CONN_PASSWORD,
        $driver_options = array()
    ) {
        $this->setConnectionDetails($db_host, $db_name, $db_username, $db_password, $driver_options);
    }

    /**
     * Sets connection details
     * @param       $db_host database host
     * @param       $db_name database name
     * @param       $db_username database user name
     * @param       $db_password database user password
     * @param array $driver_options PDO driver options
     */
    public function setConnectionDetails($db_host, $db_name, $db_username, $db_password, $driver_options = array())
    {
        $this->_db_host        = $db_host;
        $this->_db_name        = $db_name;
        $this->_db_username    = $db_username;
        $this->_db_password    = $db_password;
        $this->_driver_options = $driver_options;
        $this->_conn           = null;
        $this->_last_error_msg = '';
    }

    private function getDBConn()
    {
        if (!is_a($this->_conn, 'PDO')) {
            $dsn = 'mysql:dbname=' . $this->_db_name . ';charset=utf8;host=' . $this->_db_host;

            try {
                $this->_conn = new PDO($dsn, $this->_db_username, $this->_db_password, $this->_driver_options);
                $this->_conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
                return $this->_conn;
            } catch (PDOException $e) {
                $this->_last_error_msg = 'Connection failed: ' . $e->getMessage();
                return false;
            }
        } else {
            return $this->_conn;
        }
    }

    /**
     * returns last error messages
     *
     */
    public function getLastErrorMessage()
    {
        return $this->_last_error_msg;
    }
    
    /**
     * sets table name
     *
     * @param string $prefix table name
     * @return bool
     */
    public function setTableName($name)
    {
        $this->_table_name = $name;
        return true;
    }

    /**
     * returns table name
     *
     */
    public function getTableName()
    {
        return $this->_table_name;
    }
    
    /**
     * returns email count
     *
     * @param string $category (optional) category of the emails to fetch, * for all
     * 
     * @return int email count
     */
    public function getEmailCount($category = '*')
    {
        $q = <<<EOF
SELECT
COUNT(1)
FROM {$this->getTableName()} t1
WHERE
t1.is_sent = 0
EOF;
        if ($category != '*'){
            $q .=<<<EOF

AND t1.category = :category
EOF;
        }
        
        $stmt = $this->getDBConn()->prepare($q);
        
        if (!$stmt) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return 0;
        }
        
        if ($category != '*'){
            $query_result = $stmt->execute(array(':category' => $category));
        }
        else{
            $query_result = $stmt->execute();
        }

        if (!$query_result) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return 0;
        }
        
        $count = 0;
        while ($row_value = $stmt->fetch(PDO::FETCH_NUM))
        {
            $count = $row_value[0];
        }
        $stmt->closeCursor();

        return $count;
    }
    
    /**
     * returns emails
     *
     * @param string $category (optional) category of the emails to fetch, * for all
     * @param int $count (optional) max number of emails to fetch, -1 for all
     * 
     * @return PHPEQMessage[]
     */
    public function getEmails($category = '*', $count = -1)
    {
        $count = intval($count);
        
        $q = <<<EOF
SELECT
t1.id,
t1.from_email,
t1.from_name,
t1.to_email,
t1.to_name,
t1.subject,
t1.message_html,
t1.message_plain_text,
t1.timestamp_created,
t1.timestamp_sent,
t1.is_sent,
t1.headers,
t1.category
FROM {$this->getTableName()} t1
WHERE
t1.is_sent = 0
EOF;
        if ($category != '*'){
            $q .=<<<EOF

AND t1.category = :category
EOF;
        }
        
        if ($count != -1){
            $q .=<<<EOF

LIMIT $count
EOF;
        }
        
        $stmt = $this->getDBConn()->prepare($q);
        
        if (!$stmt) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return array();
        }
        
        if ($category != '*'){
            $query_result = $stmt->execute(array(':category' => $category));
        }
        else{
            $query_result = $stmt->execute();
        }

        if (!$query_result) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return array();
        }
        
        $result_array = array();
        while ($row_value = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $message = new PHPEQMessage();
            $message->setId($row_value['id']);
            $message->setFromEmail($row_value['from_email']);
            $message->setFromName($row_value['from_name']);
            $message->setToEmail($row_value['to_email']);
            $message->setToName($row_value['to_name']);
            $message->setSubject($row_value['subject']);
            $message->setMessageHtml($row_value['message_html']);
            $message->setMessagePlainText($row_value['message_plain_text']);
            $message->setTimestampCreated($row_value['timestamp_created']);
            $message->setTimestampSent($row_value['timestamp_sent']);
            $message->setIsSent(($row_value['is_sent'] ? true : false));
            $message->setHeaders(unserialize($row_value['headers']));
            $message->setCategory($row_value['category']);
            
            $result_array[] = $message;
        }
        $stmt->closeCursor();

        return $result_array;
    }
    
    /**
     * sets is_sent value of the message record to true
     *
     * @param PHPEQMessage $message message to update
     * 
     * @return bool
     */
    public function setMessageIsSent($message)
    {
        if (!is_a($message, 'PHPEQMessage')){
            return false;
        }
        
        $id = $message->getId();
        $time = time();
        
        $q = <<<EOF
UPDATE {$this->getTableName()}
SET
is_sent = 1,
timestamp_sent = :time
WHERE
id = :id
EOF;
        
        $stmt = $this->getDBConn()->prepare($q);
        
        if (!$stmt) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return false;
        }
        
        // Bind values
        $stmt->bindParam(':time', $time, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $query_result = $stmt->execute();

        if (!$query_result) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return false;
        }
        
        return true;
    }
    

    /**
     * saves the message record to database
     *
     * @param PHPEQMessage $message message to save
     * 
     * @return bool
     */
    public function addMessage($message)
    {
        if (!is_a($message, 'PHPEQMessage')){
            return false;
        }
        
        $from_email = $message->getFromEmail();
        $from_name = $message->getFromName();
        $to_email = $message->getToEmail();
        $to_name = $message->getToName();
        $subject = $message->getSubject();
        $message_html = $message->getMessageHtml();
        $message_plain_text = $message->getMessagePlainText();
        $timestamp_created = $message->getTimestampCreated();
        $timestamp_sent = $message->getTimestampSent();
        $is_sent = $message->getIsSent();
        $serialized_headers = $message->getSerializedHeaders();
        $category = $message->getCategory();
        
        $q = <<<EOF
INSERT INTO {$this->getTableName()}
(
from_email,
from_name,
to_email,
to_name,
subject,
message_html,
message_plain_text,
timestamp_created,
timestamp_sent,
is_sent,
headers,
category
)
VALUES
(
:from_email,
:from_name,
:to_email,
:to_name,
:subject,
:message_html,
:message_plain_text,
:timestamp_created,
:timestamp_sent,
:is_sent,
:headers,
:category
)
EOF;
        
        $stmt = $this->getDBConn()->prepare($q);
        
        if (!$stmt) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return false;
        }
        
        // Bind values
        $stmt->bindParam(':from_email', $from_email, PDO::PARAM_STR);
        $stmt->bindParam(':from_name', $from_name, PDO::PARAM_STR);
        $stmt->bindParam(':to_email', $to_email, PDO::PARAM_STR);
        $stmt->bindParam(':to_name', $to_name, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':message_html', $message_html, PDO::PARAM_STR);
        $stmt->bindParam(':message_plain_text', $message_plain_text, PDO::PARAM_STR);
        $stmt->bindParam(':timestamp_created', $timestamp_created, PDO::PARAM_INT);
        $stmt->bindParam(':timestamp_sent', $timestamp_sent, PDO::PARAM_INT);
        $stmt->bindParam(':is_sent', $is_sent, PDO::PARAM_BOOL);
        $stmt->bindParam(':headers', $serialized_headers, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        
        $query_result = $stmt->execute();

        if (!$query_result) {
            $this->_last_error_msg = implode(' ', $this->getDBConn()->errorInfo());
            return false;
        }
        
        return true;
    }
}
