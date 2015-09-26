# PHP EMAIL QUEUE CLASS (PHPEQ)
<strong>PHP Email Queue Class (PHPEQ)</strong> is a <strong>PHP</strong> class that is used to create and manage email queue using MYSQL database.

- Add emails to databased queue.
- Get emails from queue optionally filtered by category.
- It uses MYSQL database for storage.
- Easy to implement and all methods are commented.
- It decreases page load time by eliminating real time email sending.

Instead of directly sending emails on the transactions, it is possible to insert email message to database using this class.<br />
Emails can be processed later by setting up a cron job.<br />
Example scripts are supplied.<br />
<h2>Public Methods of the Queue Class</h2>
<ul>
<li>addMessage()</li>
<li>getEmailCount()</li>
<li>getEmails()</li>
<li>getTableName()</li>
<li>setConnectionDetails()</li>
<li>setMessageIsSent()</li>
<li>setTableName()</li>
<li><strong>All class methods are commented.</strong></li>
</ul>
<h2>Public Methods of the Message Class</h2>
<ul>
<li>getCategory()</li>
<li>getFromEmail()</li>
<li>getFromName()</li>
<li>getHeaders()</li>
<li>getId()</li>
<li>getIsSent()</li>
<li>getMessageHtml()</li>
<li>getMessagePlainText()</li>
<li>getSerializedHeaders()</li>
<li>getSubject()</li>
<li>getTimestampCreated()</li>
<li>getTimestampSent()</li>
<li>getToEmail()</li>
<li>getToName()</li>
<li>setCategory()</li>
<li>setFromEmail()</li>
<li>setFromName()</li>
<li>setHeaders()</li>
<li>setId()</li>
<li>setIsSent()</li>
<li>setMessageHtml()</li>
<li>setMessagePlainText()</li>
<li>setSubject()</li>
<li>setTimestampCreated()</li>
<li>setTimestampSent()</li>
<li>setToEmail()</li>
<li><strong>All class methods are commented.</strong></li>
</ul>
<h2>Documentation</h2>
<strong>PHP Email Queue Class (PHPEQ)</strong> comes with full documentation.<br />
From the installation to the usage you will feel like home.<br />
<h2>Class Requirements</h2>
<ul>
<li>PHP 5.2 and above</li>
<li>MySQL 5.0 and above</li>
</ul>
<h2>Folder Structure</h2>
All the class files exist in code folder.
To get more information about class installation process and usage help, open index.html file from "installation and documentation" folder.
"installation and documentation" folder also contains a text file ("database.txt") that contains sql statements in order to create database table structure on your mysql server.

Thanks for downloading this class! If you have improvement idea or bug fix, please feel free to contribute this class.<br />
<br />
<br />
Ovunc Tukenmez
ovunct@live.com
