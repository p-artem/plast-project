<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
phpinfo();