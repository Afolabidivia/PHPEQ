<?php
/**
 * @author Ovunc Tukenmez <ovunct@live.com>
 *
 * This class defines message used by the PHPEQ class
 */

class PHPEQMessage
{
    private $_id;
    private $_from_email;
    private $_from_name;
    private $_to_email;
    private $_to_name;
    private $_subject;
    private $_message_html;
    private $_message_plain_text;
    private $_timestamp_created;
    private $_timestamp_sent;
    private $_is_sent;
    private $_headers;
    private $_category;
    
    public function __construct() {
        $this->_id = 0;
        $this->_from_email = '';
        $this->_from_name = '';
        $this->_to_email = '';
        $this->_to_name = '';
        $this->_subject = '';
        $this->_message_html = '';
        $this->_message_plain_text = '';
        $this->_timestamp_created = time();
        $this->_timestamp_sent = 0;
        $this->_is_sent = false;
        $this->_headers = array();
        $this->_category = '';
    }

    /**
     * Sets id
     * 
     * @param int $id id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Sets from-email
     * 
     * @param string $email email
     */
    public function setFromEmail($email)
    {
        $this->_from_email = $email;
    }

    /**
     * Sets from-name
     * 
     * @param string $name from-name
     */
    public function setFromName($name)
    {
        $this->_from_name = $name;
    }

    /**
     * Sets to-email
     * 
     * @param string $email email
     */
    public function setToEmail($email)
    {
        $this->_to_email = $email;
    }

    /**
     * Sets to-name
     * 
     * @param string $name to-name
     */
    public function setToName($name)
    {
        $this->_to_name = $name;
    }

    /**
     * Sets message subject
     * 
     * @param string $subject message subject
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }

    /**
     * Sets html message
     * 
     * @param string $message html message
     */
    public function setMessageHtml($message)
    {
        $this->_message_html = $message;
    }

    /**
     * Sets plain text message
     * 
     * @param string $message plain text message
     */
    public function setMessagePlainText($message)
    {
        $this->_message_plain_text = $message;
    }

    /**
     * Sets message creation timestamp
     * 
     * @param int $timestamp message creation unix timestamp
     */
    public function setTimestampCreated($timestamp)
    {
        $this->_timestamp_created = $timestamp;
    }

    /**
     * Sets message sent timestamp
     * 
     * @param int $timestamp message sent unix timestamp
     */
    public function setTimestampSent($timestamp)
    {
        $this->_timestamp_sent = $timestamp;
    }

    /**
     * Sets if the message is sent
     * 
     * @param bool $is_sent if the message is sent
     */
    public function setIsSent($is_sent)
    {
        $this->_is_sent = $is_sent;
    }

    /**
     * Sets message headers
     * 
     * @param array $headers message headers
     */
    public function setHeaders($headers)
    {
        $this->_headers = $headers;
    }

    /**
     * Sets message category
     * 
     * @param string $category message category
     */
    public function setCategory($category)
    {
        $this->_category = $category;
    }
    
    /**
     * returns id
     *
     * @return int id
     */
    public function getId()
    {
        return $this->_id;
    }
    /**
     * returns from-email
     * 
     * return string email
     */
    public function getFromEmail()
    {
        return $this->_from_email;
    }

    /**
     * returns from-name
     * 
     * return string from-name
     */
    public function getFromName()
    {
        return $this->_from_name;
    }

    /**
     * returns to-email
     * 
     * return string email
     */
    public function getToEmail()
    {
        return $this->_to_email;
    }

    /**
     * returns to-name
     * 
     * return string to-name
     */
    public function getToName()
    {
        return $this->_to_name;
    }

    /**
     * returns message subject
     * 
     * return string message subject
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * returns html message
     * 
     * return string html message
     */
    public function getMessageHtml()
    {
        return $this->_message_html;
    }

    /**
     * returns plain text message
     * 
     * return string plain text message
     */
    public function getMessagePlainText()
    {
        return $this->_message_plain_text;
    }

    /**
     * returns message creation timestamp
     * 
     * return int message creation unix timestamp
     */
    public function getTimestampCreated()
    {
        return $this->_timestamp_created;
    }

    /**
     * returns message sent timestamp
     * 
     * return int message sent unix timestamp
     */
    public function getTimestampSent()
    {
        return $this->_timestamp_sent;
    }

    /**
     * returns if the message is sent
     * 
     * return bool if the message is sent
     */
    public function getIsSent()
    {
        return $this->_is_sent;
    }

    /**
     * returns message headers
     * 
     * return array message headers
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * returns serialized message headers string
     * 
     * return string serialized message headers
     */
    public function getSerializedHeaders()
    {
        return serialize($this->_headers);
    }

    /**
     * returns message category
     * 
     * return string message category
     */
    public function getCategory()
    {
        return $this->_category;
    }
    
}
