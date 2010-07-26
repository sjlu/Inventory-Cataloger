<?php
include 'include/database.php'; // Burst MySQL script.
include 'include/messages.php'; // Facebook style header messages.

//Database configuration, edit with care.
//Please remember to install the database.sql into your database.
$config['db']['host'] = '';
$config['db']['username'] = '';
$config['db']['password'] = '';
$config['db']['table'] = '';

$db = new BurstMySQL ($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['table']);	
?>