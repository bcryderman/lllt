<?php


/**
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// 
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

// 
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . 'C:/Users/Brian/workspace/quickbooks/v153');

/**
 * 
 */
require_once 'QuickBooks.php';

$user = 'api';
$source_type = QUICKBOOKS_API_SOURCE_WEB;
$api_driver_dsn = 'mysql://lllt:21dive@localhost/qb_lllt';
//$api_driver_dsn = 'pgsql://pgsql@localhost/quickbooks';
//$source_dsn = 'http://quickbooks:test@localhost/path/to/server.php';
$source_dsn = 'http://qbtest.localhost:test@localhostQuickBooks/server.php';
$api_options = array();
$source_options = array();
$driver_options = array();


	
	QuickBooks_Utilities::createUser($api_driver_dsn, 'brian', 'kcbc6571');
